<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Datatables;
use App\Models\MataKuliah;
use App\Models\User;
use App\Models\Prodi;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MataKuliahImport;
use Validator;

class MataKuliahController extends Controller
{
     public function index(Request $request)
     {
          if ($request->ajax()) {
               if(\Auth::user()->roles == 'prodi')
               {
                   $data = MataKuliah::with('prodi')->where('prodi_id',\Auth::user()->prodi_id)->orderBy('created_at', 'desc')->get();
               }else{
                    $data = MataKuliah::with('prodi')->orderBy('created_at','desc')->get();
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
                    ->editColumn('nama', function($row) {
                         return $row->nama;
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
          return view('pages.mata-kuliah.index')->with('prodi',$prodi);
     }

     public function simpan(Request $request)
     {
          if($request->input())
          {
               $validator = Validator::make($request->all(), [
                         'nama'         => 'required',
                    ],
                    [
                         'required'     => 'Tidak boleh kosong',
                    ]
               );
               
          
               if ($validator->passes()) {
                    $data = new MataKuliah();
                    $data->nama = $request->input('nama');
                    $data->prodi_id = $request->input('prodi_id');
                    $data->keterangan = $request->input('keterangan');
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
                    'nama'         => 'required',
               ],
               [
                    'required'     => 'Tidak boleh kosong',
               ]
          );
          
               if ($validator->passes()) {
                    $data = MataKuliah::find($request->input('id'));
                    $data->nama = $request->input('nama');
                    $data->prodi_id = $request->input('prodi_id');
                    $data->keterangan = $request->input('keterangan');
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
          $data = MataKuliah::where('id', $id)->first();
          return response()->json($data);
     }

     public function hapus(Request $request , $id)
     {
          $data = MataKuliah::find($id);
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


          return $data;
     }

     public function upload(Request $request) 
	{
		$this->validate($request, [
			'file' => 'required|mimes:xls,xlsx'
		]);
 
		$file = $request->file('file');
		$nama_file = rand().$file->getClientOriginalName();
          $path = $file->storeAs('public/excel/upload/mata-kuliah/',$nama_file);
		$data = Excel::import(new MataKuliahImport, storage_path('app/public/excel/upload/mata-kuliah/'.$nama_file));

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