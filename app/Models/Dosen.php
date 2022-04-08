<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dosen extends Model
{
     use SoftDeletes;
     protected $table = 'dosen';

     protected $fillable = [
          'id','nidn','nama','keterangan'
      ];

     function prodi()
     {
          return $this->BelongsTo('App\Models\Prodi','prodi_id');
     }
}