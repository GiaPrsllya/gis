<?php

namespace App\Imports;

use App\Models\Kecelakaan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KecelakaansImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // check if array only has 10 elements
        if(count($row) != 10) {
            throw new \Exception('Invalid data');
        }
                
        return new Kecelakaan([
            //
            'tahun' => $row['tahun'],
            'bulan' => $row['bulan'],
            'jumlah_kecelakaan' => $row['jk'],
            'meninggal_dunia' => $row['md'],
            'luka_berat' => $row['lb'],
            'luka_ringan' => $row['lr'],
            'rugi_materi' => $row['rugi'],
            'r2' => $row['r2'],
            'r4' => $row['r4'],
            'r6' => $row['r6'],
        ]);
    }
}
