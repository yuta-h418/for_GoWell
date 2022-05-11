<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_details extends Model
{
    use HasFactory;

    /**
     * データ登録日.
     */
    const CREATED_AT = null;

    /**
     * データ更新日.
     */
    const UPDATED_AT = null;

    /**
     * 許可カラム.
     */
    protected $fillable = [
        'product_no',
        'product_kind',
    ];

}
