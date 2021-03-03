<?php


namespace App\Repository\Impl;


use App\Models\Brand;
use App\Models\BrandCategory;
use App\Models\Category;
use App\Repository\BaseRepositoryImpl;
use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class BrandRepositoryImpl extends BaseRepositoryImpl implements BrandRepository
{
    /**
     * CategoryRepositoryImpl constructor.
     *
     * @param Brand $model
     */
    public function __construct(Brand $model)
    {
        parent::__construct($model);
    }

    public function brandCategoriesShowHome()
    {
        return BrandCategory::with('brand', 'category')
            ->where('show_home', true)->get();
    }
}
