<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\User;
use App\Models\Monitoring;
use App\Models\Prodi;
use App\Models\MataKuliah;
use App\Models\Dosen;
use App\Models\Ruang;
use App\Models\Semester;
use App\Models\Survey;
use App\Models\SurveyPertanyaan;
use Validator;
use Auth;

class SurveyController extends Controller
{
     public function index(Request $request)
     {
          if ($request->input()) {

               $semester = Semester::where('status','aktif')->first();
               foreach($request->input('pertanyaan') as $key => $val):
                    $data = new Survey;
                    $data->semester_id = $semester->id;
                    $data->dosen_id = $request->input('dosen_id');
                    $data->pertanyaan_id = $request->input('pertanyaan')[$key];
                    $data->nilai = $request->input('nilai')[$key];
                    $data->created_at = now();
                    $data->save();
               endforeach;
               if($data->save()){
                    $msg = array(
                         'success' => true, 
                         'message' => 'Survey berhasil dikirim!',
                         'status' => TRUE
                    );
                    return response()->json($msg);
               }else{
                    $msg = array(
                         'success' => false, 
                         'message' => 'Survey gagal dikirim!',
                         'status' => TRUE
                    );
                    return response()->json($msg);
               }

          }
          $dosen = Dosen::OrderBy('nama',"asc")->get();
          $pertanyaan = SurveyPertanyaan::get();

          
          return view('pages.survey.pertanyaan')
          ->with('dosen',$dosen)
          ->with('pertanyaan',$pertanyaan);
     }
         
}