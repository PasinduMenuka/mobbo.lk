<?php


namespace App\Http\ViewComposer;


use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\ShopSettingsRepository;
use Illuminate\View\View;

class HeadViewComposer
{

    private $categoryRepository;
    private $brandRepository;
    private $shopSettingsRepository;

    public function __construct(CategoryRepository $categoryRepository,
                                BrandRepository $brandRepository,
                                ShopSettingsRepository $shopSettingsRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
        $this->shopSettingsRepository = $shopSettingsRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {

        $categories = $this->categoryRepository->categoryWithBrands();

        foreach ($categories as $category) {
            $categoryBrands = $category->categoryBrands;
            $brandChunks = $categoryBrands->chunk(3);
            $category->categoryBrands->brandChunks = $brandChunks;
        }

        $brands = $this->brandRepository->all();

        $brandChunks = $brands->chunk(3);

        $data = [
            'categories' => $categories,
            'brands' => $brandChunks,
            'settings' => $this->shopSettingsRepository->shopSettings()
        ];
        $view->with('data', $data);
    }
}
