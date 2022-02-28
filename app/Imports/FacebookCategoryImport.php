<?php

namespace App\Imports;

use App\Models\FacebookCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class FacebookCategoryImport implements ToModel, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
     public function model(array $row)
    {
        return new FacebookCategory([
            'category_id' => $row['category_id'],
            'category_name' => $row['category_name'],
        ]);
    }
}
