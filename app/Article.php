<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'article_code', 'category', 'group', 'family', 'fam_desc', 'price', 'valid', 'unit', 'sud', 'weight', 'volume', 'stock', 'lead_time', 'donate', 'desc_eng', 'desc_fra', 'desc_spa', 'details',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'fam_desc'
    ];

    public function pic(){
        return $this->hasMany('App\Pic', 'article_code', 'article_code');
    }

    // public function popular(){
    //     return $this->hasMany('App\Popular', 'article_code', 'article_code');
    // }
}
