<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Monitoring extends Model
{
     use SoftDeletes;
     protected $table = 'monitoring';

     function prodi()
     {
          return $this->BelongsTo('App\Models\Prodi','prodi_id');
     }

     function semester()
     {
          return $this->BelongsTo('App\Models\Semester','semester_id');
     }

     function user()
     {
          return $this->BelongsTo('App\Models\User','user_id');
     }

     function matakuliah()
     {
          return $this->BelongsTo('App\Models\MataKuliah','mata_kuliah_id');
     }

     function dosen()
     {
          return $this->BelongsTo('App\Models\Dosen','dosen_id');
     }
     
     function ruang()
     {
          return $this->BelongsTo('App\Models\Ruang','ruang_id');
     }
}