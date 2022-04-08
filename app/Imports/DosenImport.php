<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\Prodi;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class DosenImport implements ToCollection
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

                    $prodi = Prodi::where('nama',$row[2])->first();
                    Dosen::create([
                        'nidn'              => $row[0],
                        'prodi_id'          => (isset($prodi->id)?$prodi->id:null),
                        'nama'              => $row[1],
                        'keterangan'        => $row[3],
                    ]);
                }else{
                    break;
                }
                
            }
        }
        
    }
}
