<?php


namespace App\Repository;


interface ProductVersionRepository extends BaseRepository
{
    public function productVersionWithEverythingBySlug($slug);
    public function productVersionWithEverythingById($versionId);
}
