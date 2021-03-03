<?php


namespace App\Repository;


interface ProductFeatureRepository extends BaseRepository
{

    public function productFeatureByVersions($versionIds);

    public function productVersionByFeaturesNotIn($features, $isVersion);
}
