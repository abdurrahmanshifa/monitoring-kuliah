<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mahasiswa extends Model
{
     use SoftDeletes;
     protected $table = 'mahasiswa';

     protected $fillable = [
          'id','prodi_id','nim','nama','email','jenis_kelamin','status_ketua','tahun_angkatan'
      ];
      
     function prodi()
     {
          return $this->BelongsTo('App\Models\Prodi','prodi_id');
     }
}