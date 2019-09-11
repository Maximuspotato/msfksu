<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Popular extends Model
{
    public function article(){
        return $this->hasMany('App\Article', 'article_code', 'article_code');
    }
}
