<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    protected $table = 'brands';
    protected $primaryKey = 'id';

    public function brandCategories()
    {
        return $this->hasMany(BrandCategory::class);
    }
}
