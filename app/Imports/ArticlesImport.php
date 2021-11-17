<?php

namespace App\Imports;

use App\Pic;
use App\Unicode;
use App\Article;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ArticlesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $groupFam = substr($row['article_code'],0,4);
        $group = substr($groupFam,0,1);
        $fam = substr($groupFam, 1, 3);
        $unicode = Unicode::where('group', $group)->where('family', $fam)->first();

        $det = $row['pic'];

        if ($det == "") {
            $pic = new Pic;
            $pic->article_code = $row['article_code'];
            $pic->pic = "default";
            $pic->save();
        } else {
            if (strpos($det, "_") !== false) {
                for($i = 1; $i < 3; $i++){
                    $pic = new Pic;
                    $pic->article_code = $row['article_code'];
                    $pic->pic = str_replace("_", "", $row['pic'])."_".$i;
                    $pic->save();
                }
            }
            elseif (strpos($det, "__") !== false) {
                for($i = 1; $i < 4; $i++){
                    $pic = new Pic;
                    $pic->article_code = $row['article_code'];
                    $pic->pic = str_replace("__", "", $row['pic'])."_".$i;
                    $pic->save();
                }
            } else {
                $pic = new Pic;
                $pic->article_code = $row['article_code'];
                $pic->pic = $row['pic'];
                $pic->save();
            }
        }

        if($row['category'] == null){
            $category = "undefined";
        }
        else {
            $category = $row['category'];
        }

        if($row['lead_time'] == null){
            $lead_time = "undefined";
        }
        else {
            $lead_time = $row['lead_time'];
        }

        if($row['price'] == null){
            $price = 0;
        }
        else {
            $price = $row['price'];
        }

        if($row['stock'] == null){
            $stock = "undefined";
        }
        else {
            $stock = $row['stock'];
        }

        if($row['valid'] == null){
            $valid = "undefined";
        }
        else {
            $valid = $row['valid'];
        }

        if($row['desc_eng'] == null){
            $desc_eng = "undefined";
        }
        else {
            $desc_eng = $row['desc_eng'];
        }


        return new Article([
            'article_code' => $row['article_code'],
            'category' => $category,
            'group' => $unicode['group'],
            'family' => $unicode['family'],
            'fam_desc' => $unicode['desc'],
            'price' => $price,
            'valid' => $valid,
            'unit' => $row['unit'],
            'sud' => $row['sud'],
            'weight' => $row['weight'],
            'volume' => $row['volume'],
            'stock' => $stock,
            'lead_time' => $lead_time,
            'desc_eng' => $desc_eng,
            'desc_fra' => $row['desc_fra'],
            'desc_spa' => $row['desc_spa'],
            'details' => $row['details'],
        ]);
    }
}
