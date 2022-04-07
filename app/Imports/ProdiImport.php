<?php

namespace App\Imports;

use App\Models\Prodi;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ProdiImport implements ToCollection
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        $data= array();
        foreach ($rows as $key => $row) {
            if ($key != 0) {
                if($row[0] != null){

                    Prodi::create([
                        'nama'              => strtoupper($row[0]),
                        'keterangan'        => $row[1],
                    ]);
                }else{
                    break;
                }
                
            }
        }
        
    }
}
