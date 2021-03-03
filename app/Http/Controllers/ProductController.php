<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repository\ProductFeatureRepository;
use App\Repository\ProductRepository;
use App\Repository\ProductVersionRepository;
use Illuminate\Http\Request;
use Psy\Exception\Exception;
use Shakee93\FonoApi\FonoApi;
use function Sodium\add;

class ProductController extends Controller
{
    private $productRepository;
    private $productVersionRepository;
    private $productFeatureRepository;
    private $phonoKey = '07098efc8fc0637d5221f2c41b665331f1779a55ac7b6cf6';
    private $fonoapi;

    public function __construct(ProductRepository $productRepository,
                                ProductVersionRepository $productVersionRepository,
                                ProductFeatureRepository $productFeatureRepository)
    {
        $this->productRepository = $productRepository;
        $this->productVersionRepository = $productVersionRepository;
        $this->productFeatureRepository = $productFeatureRepository;
        $this->fonoapi = FonoApi::init($this->phonoKey);
    }

    public function index(Request $request)
    {
        $isVersion = false;
        $fullSlug = $request->slug;
        $slug = $request->slug;
//        $specifications = [];
        $categories = [];
        $versionProduct = null;


        if (strpos($request->slug, '_')) {
            $slug = explode('_', $request->slug)[0];
            $isVersion = true;
        }
        $product = $this->productRepository->productWithEverythingBySlug($slug);
//        try {
//            $fonoResults = $this->fonoapi::getDevice($product->name, 0, $product->brand->slug);
//
//            if (count($fonoResults) > 0) {
//                $specifications = (array)$fonoResults[0];
//                $product->specifications = $specifications;
//            } else {
//                $product->specifications = [];
//            }
//
//        } catch (\Exception $e) {
//            dd($e);
//        }

        if ($isVersion) {

            $verProduct = $this->productVersionRepository->productVersionWithEverythingBySlug($fullSlug);

            $versionProduct = new Product(
                [
                    "id" => $verProduct->id,
                    "unique_id" => $verProduct->unique_id,
                    "name" => $product->name,
                    "slug" => $verProduct->slug,
                    "short_desc" => $product->short_desc,
                    "long_desc" => $product->long_desc,
                    "price" => $verProduct->price,
                    "off_price" => $verProduct->off_price,
                    "in_stock" => $verProduct->in_stock,
                    "category_id" => $product->category_id,
                    "brand_id" => $product->brand_id,
                    "default_image" => $product->default_image,
                    "keywords" => $product->keywords
                ]
            );
//            $versionProduct->specifications = $specifications;
            $versionProduct->product_id = $product->id;
            $versionProduct->productFeatures = $verProduct->productFeatures;
            $versionProduct->productImages = $verProduct->productImages;

            $versionIds = $product->productVersions->map(function ($query) {
                return $query->id;
            });

            $productFeatures = $this->productFeatureRepository->productFeatureByVersions($versionIds);
            $categories = $productFeatures->map(function ($query) {
                return $query->feature->featureCategory;
            });
            $categories = $categories->unique();

//            dd($categories);

            foreach ($categories as $category) {
                $featuresArray = collect();
                foreach ($productFeatures as $productFeature) {
                    if ($productFeature->feature->feature_category_id == $category->id) {
                        $featuresArray->add($productFeature->feature);
                    }
                }
                $category->features = $featuresArray->unique();

                foreach ($category->features as $catFeature) {
                    $catFeature->selected = false;
                    foreach ($versionProduct->productFeatures as $productFeature) {
                        if ($productFeature->feature) {
                            if ($productFeature->feature->id == $catFeature->id) {
                                $catFeature->selected = true;
                            }
                        }


                    }
                }
            }
        }
        if ($product) {
            $relatedProducts = $this->productRepository->relatedProductsByProduct($product);
//            dd($relatedProducts);

            if ($isVersion) {

                return view('product')->with(['product' => $versionProduct,
                    'relatedProducts' => $relatedProducts,
                    'featureCategories' => $categories]);
            } else {
                return view('product')->with(['product' => $product,
                    'relatedProducts' => $relatedProducts]);
            }
        }
        return view('home'); // 404 page needed

    }

    public function lazyProduct(Request $request)
    {
        $fullSlug = $request->slug;
        $features = json_decode($request->features, true);

        $productCounts = $this->productFeatureRepository->productVersionByFeaturesNotIn($features, true);
        $newProduct = null;
        foreach ($productCounts as $productCount) {
            if ($productCount->feature_count == count($features)) {

                $newProduct = $this->productVersionRepository->productVersionWithEverythingById($productCount->product_id);
            }
        }
        return response()->json($newProduct);

    }
}
