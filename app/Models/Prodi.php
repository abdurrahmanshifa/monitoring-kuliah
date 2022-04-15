<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Semester;
use DB;

class Prodi extends Model
{
     use SoftDeletes;
     protected $table = 'prodi';

     protected $fillable = [
          'id','nama','keterangan'
      ];

     function monitoring()
     {
          $semester = Semester::where('status','aktif')->first();
          return $this->hasMany('App\Models\Monitoring','prodi_id','id')->where('semester_id',$semester->id)
          ->orderBy('tgl_perkuliahan','ASC');
     }

     function matakuliah()
     {
          return $this->hasMany('App\Models\Monitoring')->belongsTo('mata_kuliah_id');
     }

     function dosen()
     {
          return $this->hasMany('App\Models\Dosen')->belongsTo('dosen_id');
     }
}