<?php


namespace App\Repository;


interface ProductRepository extends BaseRepository
{
    public function productsWithCategoriesOffset($offset);

    public function productsWithCategoriesAndFiltersOffset($limit, $offset, $filters);

    public function totalProductsCount();

    public function productWithEverythingBySlug($slug);

    public function relatedProductsByProduct($product);

    public function productsByBrandCategory($category, $categoryId);
}
