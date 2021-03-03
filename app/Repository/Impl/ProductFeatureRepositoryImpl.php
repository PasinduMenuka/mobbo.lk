<?php


namespace App\Repository\Impl;


use App\Models\ProductFeature;
use App\Models\ProductVersion;
use App\Repository\BaseRepositoryImpl;
use App\Repository\ProductFeatureRepository;
use App\Repository\ProductVersionRepository;
use Illuminate\Support\Facades\DB;

class ProductFeatureRepositoryImpl extends BaseRepositoryImpl implements ProductFeatureRepository
{

    /**
     * ProductVersionRepositoryImpl constructor.
     *
     * @param ProductFeature $model
     */
    public function __construct(ProductFeature $model)
    {
        parent::__construct($model);
    }

    public function updateOrCreate($productFeature)
    {
        return ProductFeature::updateOrCreate($productFeature);
    }

    public function productFeatureByVersions($versionIds)
    {
        return ProductFeature::with('version', 'feature.featureCategory')
            ->where('is_version', true)
            ->whereIn('product_id', $versionIds)->get();
    }

    public function productVersionByFeaturesNotIn($features, $isVersion)
    {
        return ProductFeature::where('is_version', $isVersion)->whereIn('feature_id', $features)
            ->groupBy('product_id')
            ->select('product_id', DB::raw('count(*) as feature_count'))->get();
    }
}
