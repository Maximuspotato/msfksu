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
        
        $links = explode(',', $row['pic']);
        foreach ($links as $link) {
            $pic = new Pic;
            $pic->article_code = $row['article_code'];
            if ($link == "") {
                $pic->pic = "https://res.cloudinary.com/ksucatalog/image/upload/v1565681241/media/camp_gzviph.png";
            } else {
                $pic->pic = $link;
            }
            $pic->save();
        }

        return new Article([
            'article_code' => $row['article_code'],
            'category' => $row['category'],
            'group' => $unicode['group'],
            'family' => $unicode['family'],
            'fam_desc' => $unicode['desc'],
            'price' => $row['price'],
            'valid' => $row['valid'],
            'unit' => $row['unit'],
            'sud' => $row['sud'],
            'weight' => $row['weight'],
            'volume' => $row['volume'],
            'stock' => $row['stock'],
            'lead_time' => $row['lead_time'],
            'desc_eng' => $row['desc_eng'],
            'desc_fra' => $row['desc_fra'],
            'desc_spa' => $row['desc_spa'],
            'details' => $row['details'],
        ]);
    }
}
