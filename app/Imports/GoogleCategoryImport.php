<?php

namespace App\Imports;

use App\Models\GoogleCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GoogleCategoryImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $category_name = $row['category_name_1'];
        for($i=2;$i<8;$i++)
        {
            if($row['category_name_'.$i] != '')
            {
                $category_name .= ' > '.$row['category_name_'.$i] ;
            }
        }
        return new GoogleCategory([
            'category_id' => $row['category_id'],
            'category_name' => $category_name,
        ]);
    }
}
