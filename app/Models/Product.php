<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'origin_id',
        'name',
        'gtin',
        'quantity',
    ];

    protected $casts = [
        'origin_id' => 'string',
        'name'      => 'string',
        'gtin'      => 'string',
        'quantity'  => 'integer',
    ];
}
