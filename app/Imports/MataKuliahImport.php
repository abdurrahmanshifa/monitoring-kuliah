<?php

namespace App\Imports;

use App\Models\Prodi;
use App\Models\MataKuliah;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class MataKuliahImport implements ToCollection
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

                    $prodi = Prodi::where('nama',$row[0])->first();

                    MataKuliah::create([
                        'prodi_id'          => (isset($prodi->id)?$prodi->id:null),
                        'nama'              => $row[1],
                        'keterangan'        => $row[2],
                    ]);
                }else{
                    break;
                }
                
            }
        }
        
    }
}
