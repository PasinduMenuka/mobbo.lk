<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Repository\BannerImageRepository;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\HotDealRepository;
use App\Repository\ProductRepository;
use App\Repository\TopSellingRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $productRepository;
    private $brandRepository;
    private $categoryRepository;
    private $topSellingRepository;
    private $bannerImageRepository;
    private $hotDealRepository;

    public function __construct(ProductRepository $productRepository,
                                BrandRepository $brandRepository,
                                CategoryRepository $categoryRepository,
                                TopSellingRepository $topSellingRepository,
                                HotDealRepository $hotDealRepository,
                                BannerImageRepository $bannerImageRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
        $this->topSellingRepository = $topSellingRepository;
        $this->bannerImageRepository = $bannerImageRepository;
        $this->hotDealRepository = $hotDealRepository;
    }

    function index(Request $request)
    {
        $brandCategories = $this->brandRepository->brandCategoriesShowHome();
        foreach ($brandCategories as $brandCategory) {
            $brandCategory->products = $this->productRepository->productsByBrandCategory($brandCategory->brand_id, $brandCategory->category_id);
        }

        $categories = $this->categoryRepository->all();
        $topSellings = $this->topSellingRepository->topSellingWithEverything();

        $i = 0;
        foreach ($categories as $category) {
            $category->key = $i;
            $topSellingArray = collect();
            $category->items = [];
            foreach ($topSellings as $topSelling) {
                if ($category->id == $topSelling->category->id) {
                    $topSellingArray->add($topSelling->product);
                    $category->items = $topSellingArray;
                } else {
                    $category->items = [];
                }
            }
            $i++;
        }

//        dd($categories);
        $bannerImages = $this->bannerImageRepository->all();

        $hotDeals = $this->hotDealRepository->all();

        return view('home')
            ->with('brandCategories', $brandCategories)
            ->with('topSellings', $categories)
            ->with('hotDeals', $hotDeals)
            ->with('bannerImages', $bannerImages);
    }
}
