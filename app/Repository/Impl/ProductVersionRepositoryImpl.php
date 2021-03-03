<?php


namespace App\Repository\Impl;


use App\Models\Product;
use App\Models\ProductVersion;
use App\Repository\BaseRepositoryImpl;
use App\Repository\ProductVersionRepository;

class ProductVersionRepositoryImpl extends BaseRepositoryImpl implements ProductVersionRepository
{

    /**
     * ProductVersionRepositoryImpl constructor.
     *
     * @param ProductVersion $model
     */
    public function __construct(ProductVersion $model)
    {
        parent::__construct($model);
    }

    public function productVersionWithEverythingBySlug($slug)
    {
        return ProductVersion::with('productFeatures.feature.featureCategory', 'productImages')->where('slug', $slug)->first();
    }
    public function productVersionWithEverythingById($versionId)
    {
        return ProductVersion::with('productFeatures.feature.featureCategory', 'productImages')->where('id', $versionId)->first();
    }
}
