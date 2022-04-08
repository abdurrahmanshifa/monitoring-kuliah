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

class InputController extends Controller
{
     public function index(Request $request)
     {
          if ($request->ajax()) {
               $data = Monitoring::with(['prodi','semester','user','matakuliah','dosen','ruang']);
               if (Auth::user()->roles == 'admin') {
                   $data = $data->orderBy('created_at', 'desc')->get();
               }else if(Auth::user()->roles == 'prodi'){
                    $data = $data->where('prodi_id',Auth::user()->prodi_id)->orderBy('created_at', 'desc')->get();
               }else{
                    $data = $data->where('user_id',Auth::user()->id)->orderBy('created_at', 'desc')->get();
               }
               return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('aksi', function($row) {
                         if (Auth::user()->roles == 'mahasiswa') {
                             $data = '
                                   <a title="Ubah Data" class="btn btn-success btn-icon" onclick="ubah(\''.$row->id.'\')"> <i class="fas fa-edit text-white"></i></a>
                              ';
                         }else{
                              $data = '
                                   <a title="Lihat Data" class="btn btn-info btn-icon" onclick="ubah(\''.$row->id.'\')"> <i class="fas fa-eye text-white"></i></a>
                              ';
                         }

                         return $data;
                    })
                    ->editColumn('tgl_perkuliahan', function($row) {
                         
                         $data = date('d F Y',strtotime($row->tgl_perkuliahan));
                         return $data;
                    })
                    ->editColumn('mata_kuliah', function($row) {
                         
                         $data = $row->matakuliah->nama.'<br><label class="badge badge-info">'.ucwords($row->pokok_bahasan).'</label>';
                         return $data;
                    })
                    ->editColumn('dosen', function($row) {
                         
                         $data = $row->dosen->nama.'<br><label class="badge badge-primary">'.ucwords($row->hadir_dosen).'</label>';
                         return $data;
                    })
                    ->editColumn('ruang', function($row) {
                         
                         $data = $row->ruang->nama;
                         return $data;
                    })
                    ->editColumn('semester', function($row) {
                         
                         $data = $row->semester->nama.' Tahun '.$row->semester->tahun;
                         return $data;
                    })
                    ->escapeColumns([])
                    ->make(true);
          }
          $prodi = Prodi::get();
          $ruang = Ruang::get();

          $mata_kuliah = new MataKuliah;
          $dosen = new Dosen;

          if (Auth::user()->roles == 'admin') {
               $mata_kuliah = $mata_kuliah->orderBy('created_at', 'desc')->get();
               $dosen = $dosen->get();

          }else if(Auth::user()->roles == 'prodi'){
               $mata_kuliah = $mata_kuliah->where('prodi_id',Auth::user()->prodi_id)->orderBy('created_at', 'desc')->get();
               $dosen = $dosen->where('prodi_id',Auth::user()->prodi_id)->get();
          }else{
               $mata_kuliah = $mata_kuliah->where('prodi_id',Auth::user()->prodi_id)->orderBy('created_at', 'desc')->get();
               $dosen = $dosen->where('prodi_id',Auth::user()->prodi_id)->get();
          }
          
          
          
          
          return view('pages.monitoring.index')
          ->with('mata_kuliah',$mata_kuliah)
          ->with('dosen',$dosen)
          ->with('ruang',$ruang)
          ->with('prodi',$prodi);
     }

     public function simpan(Request $request)
     {
          if($request->input())
          {
               $validator = Validator::make($request->all(), [
                         'tgl_perkuliahan'   => 'required',
                         'pokok_bahasan'     => 'required',
                         'jumlah_mahasiswa'  => 'required|numeric',
                         'foto_absensi'      => 'mimes:jpeg,jpg,png|max:2048',
                         'foto_mahasiswa'    => 'mimes:jpeg,jpg,png|max:2048',
                    ],
                    [
                         'required'     => 'Tidak boleh kosong',
                         'numeric'      => 'Hanyak boleh angka',
                    ]
               );
               
          
               if ($validator->passes()) {
                    $semester = Semester::where('status','aktif')->first();
                    if(isset($semester->id))
                    {
                         $semester_id = $semester->id;
                    }else{
                         $msg = array(
                              'success' => false, 
                              'message' => 'Data semester belum diset!',
                              'status' => TRUE
                         );
                         return response()->json($msg);
                         exit();
                    }

                    $data = new Monitoring();
                    $data->semester_id = $semester_id;
                    $data->user_id = Auth::user()->id;
                    $data->prodi_id = Auth::user()->prodi_id;
                    $data->tgl_perkuliahan = $request->input('tgl_perkuliahan');
                    $data->mata_kuliah_id = $request->input('mata_kuliah_id');
                    $data->pokok_bahasan = $request->input('pokok_bahasan');
                    $data->dosen_id = $request->input('dosen_id');
                    $data->ruang_id = $request->input('ruang_id');
                    $data->hadir_dosen = $request->input('hadir_dosen');
                    $data->ket_hadir_dosen = $request->input('ket_hadir_dosen');
                    $data->jumlah_mahasiswa = $request->input('jumlah_mahasiswa');

                    if($request->hasFile('foto_absensi'))
                    {
                         $file = $request->file('foto_absensi');
                         $file_ext = $file->getClientOriginalExtension();
                         $filename = Auth::user()->id.'/absen_'.time().'.'.$file_ext;
                         $file->storeAs('public/', $filename);
                         $data->foto_absensi    = $filename;
                    }

                    if($request->hasFile('foto_mahasiswa'))
                    {
                         $file = $request->file('foto_mahasiswa');
                         $file_ext = $file->getClientOriginalExtension();
                         $filename = Auth::user()->id.'/mahasiswa_'.time().'.'.$file_ext;
                         $file->storeAs('public/', $filename);
                         $data->foto_mahasiswa    = $filename;
                    }
                    
                    $data->created_at = now();
                    
                    
                    if($data->save()){
                         $msg = array(
                              'success' => true, 
                              'message' => 'Data berhasil disimpan!',
                              'status' => TRUE
                         );
                         return response()->json($msg);
                    }else{
                         $msg = array(
                              'success' => false, 
                              'message' => 'Data gagal disimpan!',
                              'status' => TRUE
                         );
                         return response()->json($msg);
                    }

               }

               $data = $this->_validate($validator);
               return response()->json($data);

          }
     }

     public function ubah(Request $request)
     {
          if($request->input())
          {
               $validator = Validator::make($request->all(), [
                         'tgl_perkuliahan'   => 'required',
                         'pokok_bahasan'     => 'required',
                         'jumlah_mahasiswa'  => 'required|numeric',
                         'foto_absensi'      => 'mimes:jpeg,jpg,png|max:2048',
                         'foto_mahasiswa'    => 'mimes:jpeg,jpg,png|max:2048',
                    ],
                    [
                         'required'     => 'Tidak boleh kosong',
                         'numeric'      => 'Hanyak boleh angka',
                    ]
               );
          
               if ($validator->passes()) {
                    $data = Monitoring::find($request->input('id'));
                    $data->tgl_perkuliahan = $request->input('tgl_perkuliahan');
                    $data->mata_kuliah_id = $request->input('mata_kuliah_id');
                    $data->pokok_bahasan = $request->input('pokok_bahasan');
                    $data->dosen_id = $request->input('dosen_id');
                    $data->ruang_id = $request->input('ruang_id');
                    $data->hadir_dosen = $request->input('hadir_dosen');
                    $data->ket_hadir_dosen = $request->input('ket_hadir_dosen');
                    $data->jumlah_mahasiswa = $request->input('jumlah_mahasiswa');

                    if($request->hasFile('foto_absensi'))
                    {
                         $file = $request->file('foto_absensi');
                         $file_ext = $file->getClientOriginalExtension();
                         $filename = Auth::user()->id.'/absen_'.time().'.'.$file_ext;
                         $file->storeAs('public/', $filename);
                         $data->foto_absensi    = $filename;
                    }

                    if($request->hasFile('foto_mahasiswa'))
                    {
                         $file = $request->file('foto_mahasiswa');
                         $file_ext = $file->getClientOriginalExtension();
                         $filename = Auth::user()->id.'/mahasiswa_'.time().'.'.$file_ext;
                         $file->storeAs('public/', $filename);
                         $data->foto_mahasiswa    = $filename;
                    }

                    $data->updated_at = now();
                    

                    if($data->save()){
                         $msg = array(
                              'success' => true, 
                              'message' => 'Data berhasil diubah!',
                              'status' => TRUE
                         );
                         return response()->json($msg);
                    }else{
                         $msg = array(
                              'success' => false, 
                              'message' => 'Data gagal diubah!',
                              'status' => TRUE
                         );
                         return response()->json($msg);
                    }

               }

               $data = $this->_validate($validator);
               return response()->json($data);

          }
     }

     public function data($id)
     {
          $data = Monitoring::where('id', $id)->first();
          $data->foto_absensi = url('file-view/'.$data->foto_absensi);
          $data->foto_mahasiswa = url('file-view/'.$data->foto_mahasiswa);
          return response()->json($data);
     }

     public function hapus(Request $request , $id)
     {
          $data = Monitoring::find($id);
          if($data->delete()){
               $msg = array(
                    'success' => true, 
                    'message' => 'Data berhasil dihapus!',
                    'status' => TRUE
               );
               return response()->json($msg);
          }else{
               $msg = array(
                    'success' => false, 
                    'message' => 'Data gagal dihapus!',
                    'status' => TRUE
               );
               return response()->json($msg);
          }
     }

     private function _validate($validator){
          $data = array();
          $data['error_string'] = array();
          $data['input_error'] = array();

          if ($validator->errors()->has('tgl_perkuliahan')):
               $data['input_error'][] = 'tgl_perkuliahan';
               $data['error_string'][] = $validator->errors()->first('tgl_perkuliahan');
               $data['status'] = false;
               $data['class_string'][] = 'is-invalid';
          else:
               $data['input_error'][] = 'tgl_perkuliahan';
               $data['error_string'][] = '';
               $data['class_string'][] = 'is-valid';
               $data['status'] = false;
          endif;

          if ($validator->errors()->has('pokok_bahasan')):
               $data['input_error'][] = 'pokok_bahasan';
               $data['error_string'][] = $validator->errors()->first('pokok_bahasan');
               $data['status'] = false;
               $data['class_string'][] = 'is-invalid';
          else:
               $data['input_error'][] = 'pokok_bahasan';
               $data['error_string'][] = '';
               $data['class_string'][] = 'is-valid';
               $data['status'] = false;
          endif;

          if ($validator->errors()->has('jumlah_mahasiswa')):
               $data['input_error'][] = 'jumlah_mahasiswa';
               $data['error_string'][] = $validator->errors()->first('jumlah_mahasiswa');
               $data['status'] = false;
               $data['class_string'][] = 'is-invalid';
          else:
               $data['input_error'][] = 'jumlah_mahasiswa';
               $data['error_string'][] = '';
               $data['class_string'][] = 'is-valid';
               $data['status'] = false;
          endif;

          if ($validator->errors()->has('foto_absensi')):
               $data['input_error'][] = 'foto_absensi';
               $data['error_string'][] = $validator->errors()->first('foto_absensi');
               $data['status'] = false;
               $data['class_string'][] = 'is-invalid';
          else:
               $data['input_error'][] = 'foto_absensi';
               $data['error_string'][] = '';
               $data['class_string'][] = 'is-valid';
               $data['status'] = false;
          endif;

          if ($validator->errors()->has('foto_mahasiswa')):
               $data['input_error'][] = 'foto_mahasiswa';
               $data['error_string'][] = $validator->errors()->first('foto_mahasiswa');
               $data['status'] = false;
               $data['class_string'][] = 'is-invalid';
          else:
               $data['input_error'][] = 'foto_mahasiswa';
               $data['error_string'][] = '';
               $data['class_string'][] = 'is-valid';
               $data['status'] = false;
          endif;


          return $data;
     }


    
}