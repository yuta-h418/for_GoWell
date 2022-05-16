<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchasehistory extends Model
{
    use HasFactory;

    protected $table = 'purchasehistories';

    // public $incrementing = true;

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
        'purchase_no',
        'customer_id',
        'product_name',
        'product_kind',
        'price',
        'cash_kind',
        'purchase_date',
    ];

}
