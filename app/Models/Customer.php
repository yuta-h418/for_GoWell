<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // use HasFactory;

    // /**
    //  * テーブル名.
    //  * @var string
    //  */
    // protected $table = 'customer';

    // /**
    //  * Primary Key.
    //  * @var string
    //  */
    // protected $primaryKey = 'id';

    // /**
    //  * 自動採番（Auto Increment）.
    //  * @var bool
    //  */
    // public $incrementing = false;

    // /**
    //  * データ登録日.
    //  */
    // const CREATED_AT = null;

    // /**
    //  * データ更新日.
    //  */
    // const UPDATED_AT = null;


    /**
     * 許可カラム.
     */
    protected $fillable = [
        'id',
        'name',
        'tell_number',
        'birthday',
        'regist_date',
    ];
}
