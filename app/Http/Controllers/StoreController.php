<?php

namespace App\Http\Controllers;

use App\Repository\BrandRepository;
use App\Repository\CategoryRepository;
use App\Repository\FeatureCategoryRepository;
use App\Repository\ProductRepository;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    private $featureRepository;
    private $brandRepository;
    private $productRepository;

    public function __construct(FeatureCategoryRepository $featureRepository,
                                BrandRepository $brandRepository,
                                ProductRepository $productRepository)
    {
        $this->featureRepository = $featureRepository;
        $this->brandRepository = $brandRepository;
        $this->productRepository = $productRepository;
    }

    function index(Request $request)
    {
        $filtersArray = [];
        if ($request->catSlug) {
            $filtersArray["category"] = $request->catSlug;
        }

        if ($request->searchKey) {
            $filtersArray["search"] = $request->searchKey;
        }

        if ($request->brand) {
            if (strpos($request->brand, ',')) {
                $brands = explode(",", $request->brand);
                $filtersArray["brand"] = $brands;
            } else {
                $filtersArray["brand"] = [$request->brand];
            }
        }

        if ($request->features) {
            if (strpos($request->features, ',')) {
                $features = explode(",", $request->features);
                $filtersArray["features"] = $features;
            } else {
                $filtersArray["features"] = [$request->features];
            }
        }

        if ($request->price) {
            $prices = explode(",", $request->price);
            $filtersArray["price"] = [
                'min' => $prices[0],
                'max' => $prices[1]
            ];
        }
        if ($request->lazy && $request->lazy === "1") {
//            dd($filtersArray);
        }

        $offset = 0;
        $limit = 12;
        if ($request->offset) {
            $offset = $request->offset;
        }

        $products = $this->organizedProductsOutput($filtersArray, $limit, $offset);

        $storeData = [
            "featureCategories" => $this->featureRepository->getFeatureCategoriesWithFeatures(),
            "productBrands" => $this->brandRepository->all(),
        ];

        if ($request->lazy && $request->lazy === "1") {
            $response = [
                'products' => $products,
                'offset' => $offset + $limit
            ];
            return response($response);
        }

        return view('store', compact('storeData'))
            ->with('products', $products)->with('offset', ($offset + $limit));
    }

    public function lazyLoadIndex(Request $request)
    {
        $filtersArray = [];
        if ($request->brand) {
            $brands = explode(",", $request->brand);
            $filtersArray["brand"] = $brands;
        }
        if ($request->price) {
            $prices = explode(",", $request->price);
            $filtersArray["price"] = [
                'min' => $prices[0],
                'max' => $prices[1]
            ];
        }
        $products = $this->organizedProductsOutput($filtersArray);

        return response()->json($products);
    }

    private function organizedProductsOutput($filtersArray, $limit, $offset)
    {
        $products = null;

        if (empty($filtersArray)) {
            $products = $this->productRepository->productsWithCategoriesOffset($offset);
        } else {
            $products = $this->productRepository->productsWithCategoriesAndFiltersOffset($limit, $offset, $filtersArray);
        }

        return $products;
    }
}
