<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Prodi;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MahasiswaImport;
use Validator;

class MahasiswaController extends Controller
{
     public function index(Request $request)
     {
          if ($request->ajax()) {
               if(\Auth::user()->roles == 'prodi')
               {
                   $data = Mahasiswa::with('prodi')->where('prodi_id',\Auth::user()->prodi_id)->orderBy('created_at', 'desc')->get();
               }else{
                    $data = Mahasiswa::with('prodi')->orderBy('created_at','desc')->get();
               }
               
               return Datatables::of($data)
                    ->addIndexColumn()
                    ->editColumn('aksi', function($row) {
                         if(\Auth::user()->roles == 'prodi'){
                              $data = '
                                   <a title="Lihat Data" class="btn btn-success btn-icon" onclick="ubah(\''.$row->id.'\')"> <i class="fas fa-eye text-white"></i></a>
                              ';
                         }else{
                              $data = '
                                   <a title="Ubah Data" class="btn btn-success btn-icon" onclick="ubah(\''.$row->id.'\')"> <i class="fas fa-edit text-white"></i></a>
                                   <a title="Hapus Data" class="btn btn-danger btn-icon" onclick="hapus(\''.$row->id.'\')"> <i class="fas fa-trash-alt text-white"></i></a>
                              ';
                         }

                         return $data;
                    })
                    ->editColumn('jenis_kelamin', function($row) {
                         return ucwords($row->jenis_kelamin);
                    })
                    ->editColumn('nama', function($row) {
                         if($row->status_ketua == 'ya'){
                              return $row->nama.' <br><span class="badge badge-primary">Ketua Tingkat</span>';
                         }else{
                              return $row->nama;
                         }
                    })
                    ->editColumn('email', function($row) {
                         if($row->email == null)
                         {
                              return '-';
                         }else{
                              return $row->email;
                         }
                    })
                    ->editColumn('prodi', function($row) {
                         if(isset($row->prodi->nama))
                         {
                              return $row->prodi->nama;
                         }else{
                              return '-';
                         }
                    })
                    ->escapeColumns([])
                    ->make(true);
          }
          if(\Auth::user()->roles == 'prodi')
          {
              $prodi = Prodi::where('id',\Auth::user()->prodi_id)->orderBy('created_at', 'desc')->get();
          }else{
              $prodi = Prodi::orderBy('created_at', 'desc')->get();
          }
          return view('pages.mahasiswa.index')->with('prodi',$prodi);
     }

     public function simpan(Request $request)
     {
          if($request->input())
          {
               $validator = Validator::make($request->all(), [
                         'nama'         => 'required',
                         'email'        => 'required|email|unique:mahasiswa,email',
                         'nim'          => 'required|numeric'
                    ],
                    [
                         'unique'       => 'Data sudah tersimpan didatabase',
                         'required'     => 'Tidak boleh kosong',
                         'email'        => 'Alamat email tidak valid',
                         'numeric'      => 'Hanya boleh menginput angka',
                    ]
               );
               
          
               if ($validator->passes()) {
                    $data = new Mahasiswa();
                    $data->nama = $request->input('nama');
                    $data->email = $request->input('email');
                    $data->prodi_id = $request->input('prodi_id');
                    $data->nim = $request->input('nim');
                    $data->jenis_kelamin = $request->input('jenis_kelamin');
                    $data->status_ketua = $request->input('status_ketua');
                    $data->tahun_angkatan = $request->input('tahun_angkatan');
                    $data->created_at = now();
                    
                    if($data->status_ketua == 'ya')
                    {
                         $user = new User();
                         $user->name = $request->input('nama');
                         $user->email = $request->input('email');
                         $user->password = bcrypt($request->input('email'));
                         $user->prodi_id = $request->input('prodi_id');
                         $user->roles = 'mahasiswa';
                         $user->status = 'aktif';
                         $user->save();
                    }
                    
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
                    'nama'         => 'required',
                    'email'        => 'required|email|unique:mahasiswa,email,'.$request->input('id'),
                    'nim'          => 'required|numeric'
               ],
               [
                    'unique'       => 'Data sudah tersimpan didatabase',
                    'required'     => 'Tidak boleh kosong',
                    'email'        => 'Alamat email tidak valid',
                    'numeric'      => 'Hanya boleh menginput angka',
               ]
          );
          
               if ($validator->passes()) {
                    $data = Mahasiswa::find($request->input('id'));
                    $data->nama = $request->input('nama');
                    $data->email = $request->input('email');
                    $data->prodi_id = $request->input('prodi_id');
                    $data->nim = $request->input('nim');
                    $data->jenis_kelamin = $request->input('jenis_kelamin');
                    $data->status_ketua = $request->input('status_ketua');
                    $data->tahun_angkatan = $request->input('tahun_angkatan');

                    $data->updated_at = now();
                    
                    $user = User::where('email',$request->input('email'))->first();
                    if(isset($user->status))
                    {
                         if($data->status_ketua == 'tidak')
                         {
                              $user->delete();
                         }
                    }else{
                         if($data->status_ketua == 'ya')
                         {
                              $user = new User();
                              $user->name = $request->input('nama');
                              $user->email = $request->input('email');
                              $user->password = bcrypt($request->input('email'));
                              $user->prodi_id = $request->input('prodi_id');
                              $user->roles = 'mahasiswa';
                              $user->status = 'aktif';
                              $user->save();
                         }
                    }

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
          $data = Mahasiswa::where('id', $id)->first();
          return response()->json($data);
     }

     public function hapus(Request $request , $id)
     {
          $data = Mahasiswa::find($id);
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

          if ($validator->errors()->has('nama')):
               $data['input_error'][] = 'nama';
               $data['error_string'][] = $validator->errors()->first('nama');
               $data['status'] = false;
               $data['class_string'][] = 'is-invalid';
          else:
               $data['input_error'][] = 'nama';
               $data['error_string'][] = '';
               $data['class_string'][] = 'is-valid';
               $data['status'] = false;
          endif;

          if ($validator->errors()->has('email')):
               $data['input_error'][] = 'email';
               $data['error_string'][] = $validator->errors()->first('email');
               $data['status'] = false;
               $data['class_string'][] = 'is-invalid';
          else:
               $data['input_error'][] = 'email';
               $data['error_string'][] = '';
               $data['class_string'][] = 'is-valid';
               $data['status'] = false;
          endif;

          if ($validator->errors()->has('nim')):
               $data['input_error'][] = 'nim';
               $data['error_string'][] = $validator->errors()->first('nim');
               $data['status'] = false;
               $data['class_string'][] = 'is-invalid';
          else:
               $data['input_error'][] = 'nim';
               $data['error_string'][] = '';
               $data['class_string'][] = 'is-valid';
               $data['status'] = false;
          endif;


          return $data;
     }

     public function upload(Request $request) 
	{
		$this->validate($request, [
			'file' => 'required|mimes:xls,xlsx'
		]);
 
		$file = $request->file('file');
		$nama_file = rand().$file->getClientOriginalName();
          $path = $file->storeAs('public/excel/upload/mahasiswa/',$nama_file);
		$data = Excel::import(new MahasiswaImport, storage_path('app/public/excel/upload/mahasiswa/'.$nama_file));

          if($data){
               $msg = array(
                    'success' => true, 
                    'message' => 'Data berhasil diupload!',
                    'status' => TRUE
               );
               return response()->json($msg);
          }else{
               $msg = array(
                    'success' => false, 
                    'message' => 'Data gagal diupload!',
                    'status' => TRUE
               );
               return response()->json($msg);
          }
	}
    
}