<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Semester;

class Dosen extends Model
{
     use SoftDeletes;
     protected $table = 'dosen';

     protected $fillable = [
          'id','nidn','nama','keterangan','jenis_kelamin','prodi_id'
      ];

     function prodi()
     {
          return $this->BelongsTo('App\Models\Prodi','prodi_id');
     }

     function survey()
     {
          $semester = Semester::where('status','aktif')->first();
          return $this->HasMany('App\Models\Survey','dosen_id','id')->where('semester_id',$semester->id);
     }
}