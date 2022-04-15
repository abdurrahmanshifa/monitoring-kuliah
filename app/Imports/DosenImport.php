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

                    $prodi = Prodi::where('nama',$row[3])->first();
                    Dosen::create([
                        'nidn'              => $row[0],
                        'prodi_id'          => (isset($prodi->id)?isset($prodi->id):''),
                        'nama'              => $row[1],
                        'jenis_kelamin'     => $row[2],
                        'keterangan'        => $row[4],
                    ]);
                }else{
                    break;
                }
                
            }
        }
        
    }
}
