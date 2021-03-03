<?php


namespace App\Repository\Impl;


use App\Models\Category;
use App\Models\Product;
use App\Repository\BaseRepositoryImpl;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProductRepositoryImpl extends BaseRepositoryImpl implements ProductRepository
{
    /**
     * CategoryRepositoryImpl constructor.
     *
     * @param Product $model
     */
    public function __construct(Product $model)
    {
        parent::__construct($model);
    }

    public function productsWithCategoriesOffset($offset)
    {
        return Product::with('category', 'productVersions.productFeatures.feature', 'productImages')->inRandomOrder()->paginate($offset);
    }

    public function productsWithCategoriesAndFiltersOffset($limit, $offset, $filters)
    {

        $products = Product::with('category', 'brand',
            'productVersions.productFeatures.feature', 'productImages');

        if (array_key_exists("search", $filters)) {
            $search = $filters["search"];
            $products = $products->where(function ($query) use ($search) {
                $query->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('slug', 'LIKE', '%' . $search . '%')->orWhere('keywords', 'LIKE', '%' . $search . '%');
            });
        }

        if (array_key_exists("category", $filters)) {
//            dd($filters);
            $category = $filters["category"];
            $products = $products->whereHas('category', function ($query) use ($category) {
                $query->where('slug', '=', $category);
            });
        }

        if (array_key_exists("brand", $filters)) {
            $brand = $filters["brand"];
            $products = $products->whereHas('brand', function ($query) use ($brand) {
                $query->whereIn('slug', $brand);
            });
        }

        if (array_key_exists("features", $filters)) {
            $features = $filters["features"];
            $products = $products->whereHas('productVersions.productFeatures.feature', function ($query) use ($features) {
                $query->whereIn('id', $features);
            });
        }

        if (array_key_exists("price", $filters)) {
            $minPrice = $filters["price"]['min'];
            $maxPrice = $filters["price"]['max'];
            $products = $products->whereBetween('price', [$minPrice, $maxPrice]);
        }


        $products = $products->get();
//        dd($products);

        foreach ($products as $key => $product) {
            $product->image_url = $product->productImages ? $product->productImages->first() ? $product->productImages->first()->image_url : '' : '';
            $versions = $product->productVersions;
            if ($versions->count() > 0) {

                foreach ($versions as $version) {
                    $verProduct = new Product([
                        "id" => $product->id,
                        "unique_id" => $version->unique_id,
                        "name" => $product->name,
                        "slug" => $version->slug,
                        "short_desc" => $product->short_desc,
                        "long_desc" => $product->long_desc,
                        "price" => $version->price,
                        "off_price" => $version->off_price,
                        "in_stock" => $version->in_stock,
                        "category_id" => $product->category_id,
                        "brand_id" => $product->brand_id,
                        "default_image" => $product->default_image,
                        "keywords" => $product->keywords
                    ]);

                    $featureNames = '';
                    foreach ($version->productFeatures as $feature) {
                        if ($feature->feature->featureCategory->is_filter) {
                            $featureNames .= $feature->feature->name . ' | ';
                        }
                    }
                    $featureNames = rtrim($featureNames, ' | ');

                    $verProduct->category = $product->category;
                    $verProduct->featureNames = $featureNames;
                    $verProduct->productImages = $version->productImages;
                    $verProduct->image_url = $version->productImages ? $version->productImages->first() ? $version->productImages->first()->image_url : '' : '';
                    $products->add($verProduct);
                }
                $products->forget($key);
            } else {
                $featureNames = '';
                foreach ($product->productFeatures as $feature) {
                    if ($feature->feature->featureCategory->is_filter) {
                        $featureNames .= $feature->feature->name . ' | ';
                    }
                }
                $featureNames = rtrim($featureNames, ' | ');

                $product->featureNames = $featureNames;
            }
        }

        $products = $products->slice($offset, $limit);
//        $products = $products->shuffle();
        return $products;
    }

    public function totalProductsCount()
    {
        return $this->model->all()->count();
    }

    public function productWithEverythingBySlug($slug)
    {
        return Product::with('category', 'brand', 'productVersions.productFeatures.feature', 'productImages')
            ->where('slug', $slug)->first();
    }

    public function relatedProductsByProduct($product)
    {
        $products = Product::with('category', 'productImages',
            'productVersions.productFeatures.feature')
            ->where('id', '!=', $product->id)
            ->whereHas('category', function ($query) use ($product) {
                $query->where('id', $product->category->id);
            })->inRandomOrder()->take(4)->get();

        foreach ($products as $key => $product) {
            $product->image_url = $product->productImages ? $product->productImages->first() ? $product->productImages->first()->image_url : '' : '';
            $versions = $product->productVersions;
            if ($versions->count() > 0) {

                foreach ($versions as $version) {
                    $verProduct = new Product([
                        "id" => $product->id,
                        "unique_id" => $version->unique_id,
                        "name" => $product->name,
                        "slug" => $version->slug,
                        "short_desc" => $product->short_desc,
                        "long_desc" => $product->long_desc,
                        "price" => $version->price,
                        "off_price" => $version->off_price,
                        "in_stock" => $version->in_stock,
                        "category_id" => $product->category_id,
                        "brand_id" => $product->brand_id,
                        "default_image" => $product->default_image,
                        "keywords" => $product->keywords
                    ]);

                    $featureNames = '';
                    foreach ($version->productFeatures as $feature) {
                        if ($feature->feature->featureCategory->is_filter) {
                            $featureNames .= $feature->feature->name . ' | ';
                        }
                    }
                    $featureNames = rtrim($featureNames, ' | ');
                    $verProduct->category = $product->category;
                    $verProduct->featureNames = $featureNames;
                    $verProduct->productImages = $version->productImages;
                    $verProduct->image_url = $version->productImages ? $version->productImages->first() ? $version->productImages->first()->image_url : '' : '';
                    $products->add($verProduct);
                }
                $products->forget($key);
            } else {
                $featureNames = '';
                foreach ($product->productFeatures as $feature) {
                    if ($feature->feature->featureCategory->is_filter) {
                        $featureNames .= $feature->feature->name . ' | ';
                    }
                }
                $featureNames = rtrim($featureNames, ' | ');

                $product->featureNames = $featureNames;
            }
        }

        return $products;

    }


    public function productsByBrandCategory($brandId, $categoryId)
    {
        $products = Product::where('brand_id', $brandId)->where('category_id', $categoryId)->inRandomOrder()->take(12)->get();

        foreach ($products as $key => $product) {
            $product->image_url = $product->productImages ? $product->productImages->first() ? $product->productImages->first()->image_url : '' : '';
            $versions = $product->productVersions;
            if ($versions->count() > 0) {

                foreach ($versions as $version) {
                    $verProduct = new Product([
                        "id" => $product->id,
                        "unique_id" => $version->unique_id,
                        "name" => $product->name,
                        "slug" => $version->slug,
                        "short_desc" => $product->short_desc,
                        "long_desc" => $product->long_desc,
                        "price" => $version->price,
                        "off_price" => $version->off_price,
                        "in_stock" => $version->in_stock,
                        "category_id" => $product->category_id,
                        "brand_id" => $product->brand_id,
                        "default_image" => $product->default_image,
                        "keywords" => $product->keywords
                    ]);

                    $featureNames = '';
                    foreach ($version->productFeatures as $feature) {
                        if ($feature->feature->featureCategory->is_filter) {
                            $featureNames .= $feature->feature->name . ' | ';
                        }
                    }
                    $featureNames = rtrim($featureNames, ' | ');
                    $verProduct->category = $product->category;
                    $verProduct->featureNames = $featureNames;
                    $verProduct->productImages = $version->productImages;
                    $verProduct->image_url = $version->productImages ? $version->productImages->first() ? $version->productImages->first()->image_url : '' : '';
                    $products->add($verProduct);
                }
                $products->forget($key);
            } else {
                $featureNames = '';
                foreach ($product->productFeatures as $feature) {
                    if ($feature->feature->featureCategory->is_filter) {
                        $featureNames .= $feature->feature->name . ' | ';
                    }
                }
                $featureNames = rtrim($featureNames, ' | ');

                $product->featureNames = $featureNames;
            }
        }

        return $products;

    }
}
