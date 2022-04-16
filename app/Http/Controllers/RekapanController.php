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
use PDF;

class RekapanController extends Controller
{
     public function index(Request $request)
     {
          if(\Auth::user()->roles == 'prodi')
          {
               $prodi = Prodi::where('id',\Auth::user()->prodi_id)->orderBy('created_at', 'desc')->get();
          }else{
               $prodi = Prodi::orderBy('created_at', 'desc')->get();
          }
          $semester = Semester::orderBy('tahun', 'desc')->get();
          
          return view('pages.rekapan.index')
          ->with('prodi',$prodi)
          ->with('semester',$semester);
     }

     public function cetak(Request $request)
     {
          
          $data = Monitoring::with(['prodi','semester','user','matakuliah','dosen','ruang']);
          if ($request->input('prodi_id') != 0) {
               $data = $data->where('prodi_id',$request->input('prodi_id'));
               $prodi = Prodi::find($request->input('prodi_id'))->nama;
          }else{
               $prodi = 'Semua Prodi';
          }

          $data = $data->where('semester_id',$request->input('semester_id'))->orderBy('tgl_perkuliahan','asc')->get();
          $semester = Semester::find($request->input('semester_id'));
          
          if($request->input('format') == 'excel')
          {
               return view('pages.rekapan.excel')->with('prodi',$prodi)->with('data',$data)->with('semester',$semester);
          }else{
               
               $pdf = PDF::loadview('pages.rekapan.pdf',['prodi'=>$prodi,'data'=>$data,'semester'=>$semester])->setPaper('a4', 'landscape');
               return $pdf->download('laporan-rekapan-'.time().'.pdf');
          }
     }

     public function penilaian(Request $request)
     {
          if(\Auth::user()->roles == 'prodi')
          {
               $dosen = Dosen::where('id',\Auth::user()->prodi_id)->orderBy('nama', 'asc')->get();
          }else{
               $dosen = Dosen::orderBy('nama', 'asc')->get();
          }
          $semester = Semester::orderBy('tahun', 'desc')->get();
          
          return view('pages.penilaian.index')
          ->with('dosen',$dosen)
          ->with('semester',$semester);
     }

     public function penilaian_cetak(Request $request)
     {
          
          $data = Dosen::with(['prodi']);
          if ($request->input('dosen_id') != 0) {
               $data = $data->where('id',$request->input('dosen_id'));
          }

          $data = $data->orderBy('nama','asc')->orderBy('prodi_id','asc')->get();
          $semester = Semester::find($request->input('semester_id'));
          $pertanyaan = SurveyPertanyaan::get();
          $array = null;
          foreach($data as $key => $val)
          {
               $array[$key]['nama']          = $val->nama;
               $array[$key]['prodi']          = $val->prodi->nama;
               foreach ($pertanyaan as $keys => $tanya) {
                   $array[$key]['SB '.$tanya->id] = Survey::where('pertanyaan_id',$tanya->id)->where('dosen_id', $val->id)->where('nilai', 'Sangat Baik')->where('semester_id', $request->input('semester_id'))->count();
                   $array[$key]['B '.$tanya->id] = Survey::where('pertanyaan_id',$tanya->id)->where('dosen_id', $val->id)->where('nilai', 'Baik')->where('semester_id', $request->input('semester_id'))->count();
                   $array[$key]['C '.$tanya->id] = Survey::where('pertanyaan_id',$tanya->id)->where('dosen_id', $val->id)->where('nilai', 'Cukup')->where('semester_id', $request->input('semester_id'))->count();
                   $array[$key]['K '.$tanya->id] = Survey::where('pertanyaan_id',$tanya->id)->where('dosen_id', $val->id)->where('nilai', 'Kurang')->where('semester_id', $request->input('semester_id'))->count();
               }

          }
          // return $array;
          if($request->input('format') == 'excel')
          {
               return view('pages.penilaian.excel')->with('data',$array)->with('semester',$semester)->with('pertanyaan',$pertanyaan);
          }else{
               
               $pdf = PDF::loadview('pages.penilaian.pdf',['data'=>$array,'semester'=>$semester,'pertanyaan'=>$pertanyaan])->setPaper('a4', 'landscape');
    	          return $pdf->download('laporan-penilaian-'.time().'.pdf');
               //return view('pages.penilaian.pdf')->with('data',$array)->with('semester',$semester)->with('pertanyaan',$pertanyaan);
          }
     }




    
}