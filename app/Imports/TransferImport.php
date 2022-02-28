<?php

namespace App\Imports;

use App\Models\Transfer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TransferImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Transfer([
            'title' => $row['title'],
            'sale_id' => $row['sale_id'],
            'product_id' => $row['product_id'],
            'quantity' => $row['quantity'],
            'description' => $row['description'],
        ]);
    }
}
