<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'article_code', 'desc_eng', 'purchase_price', 'currency', 'quantity', 'batch', 'expiry_date', 'stock_owner', 'comments', 'pics'
    ];
}
