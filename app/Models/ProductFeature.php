<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductFeature extends Model
{
    protected $table = 'product_features';
    protected $primaryKey = 'id';

    protected $fillable = ['product_id', 'feature_id', 'is_version'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function version()
    {
        return $this->belongsTo(ProductVersion::class, 'product_id');
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }

}
