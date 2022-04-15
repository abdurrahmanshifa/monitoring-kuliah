<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyPertanyaan extends Model
{
     use SoftDeletes;
     protected $table = 'survey_pertanyaan';
}