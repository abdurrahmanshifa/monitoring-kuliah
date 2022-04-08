<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MataKuliah extends Model
{
     use SoftDeletes;
     protected $table = 'mata_kuliah';

     protected $fillable = [
          'id','prodi_id','nama','keterangan'
      ];

      function prodi()
     {
          return $this->BelongsTo('App\Models\Prodi','prodi_id');
     }
}