<?php

namespace App\Imports;

use App\Models\Client;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ClientImport implements ToModel , WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Client([
            'company' => $row["company"],
            'email' => $row['email'],
            'account_number' => $row['account_number'],
            'contract_number' => $row['contract_number'],
            'name' => $row['company'],
            'contact' => null,
        ]);
    }
}
