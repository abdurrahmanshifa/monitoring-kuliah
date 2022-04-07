<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class MahasiswaImport implements ToCollection
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

                    $prodi = Prodi::where('nama',$row[1])->first();
                    
                    Mahasiswa::create([
                        'nim'               => $row[0],
                        'prodi_id'          => (isset($prodi->id)?$prodi->id:null),
                        'nama'              => $row[2],
                        'email'             => $row[3],
                        'jenis_kelamin'     => $row[4],
                        'tahun_angkatan'    => $row[5],
                    ]);
                }else{
                    break;
                }
                
            }
        }
        
    }
}
