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
    	          return $pdf->download('laporan-rekapan-pdf');
          }
     }


    
}