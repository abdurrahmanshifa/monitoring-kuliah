<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ruang extends Model
{
     use SoftDeletes;
     protected $table = 'ruang';

     protected $fillable = [
          'id','nama','keterangan'
      ];
}