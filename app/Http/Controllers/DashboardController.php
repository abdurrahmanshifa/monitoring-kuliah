<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Monitoring;
use App\Models\Prodi;
use App\Models\Survey;
use App\Models\Semester;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->roles == 'admin'){

            $mahasiswa = new Mahasiswa;
            $dosen = new Dosen;
            $data['prodi'] = Prodi::with(['monitoring.matakuliah','monitoring.dosen'])->get();

        }else{
            $mahasiswa = Mahasiswa::where('prodi_id',Auth::user()->prodi_id);
            $dosen = Dosen::where('prodi_id',Auth::user()->prodi_id);
            $data['prodi'] = Prodi::where('id',Auth::user()->prodi_id)->with(['monitoring.matakuliah','monitoring.dosen'])->get();
        }

        $data['semester'] = Semester::where('status','aktif')->first();
        
        $data['laki'] = $mahasiswa->where('jenis_kelamin','laki-laki')->count();
        $data['perempuan'] = $mahasiswa->where('jenis_kelamin','perempuan')->count();
        $data['dosen'] = $dosen->get();
        $array = null;
        foreach($data['dosen'] as $key => $val)
        {
            $array['Sangat Baik'][$key] = Survey::where('dosen_id',$val->id)->where('nilai','Sangat Baik')->where('semester_id',$data['semester']->id)->count();
            $array['Baik'][$key] = Survey::where('dosen_id',$val->id)->where('nilai','Baik')->where('semester_id',$data['semester']->id)->count();
            $array['Cukup'][$key] = Survey::where('dosen_id',$val->id)->where('nilai','Cukup')->where('semester_id',$data['semester']->id)->count();
            $array['Kurang'][$key] = Survey::where('dosen_id',$val->id)->where('nilai','Kurang')->where('semester_id',$data['semester']->id)->count();
        }
        $data['array'] = $array;
        $data['dosen_laki'] = $dosen->where('jenis_kelamin','laki-laki')->count();
        $data['dosen_perempuan'] = $dosen->where('jenis_kelamin','perempuan')->count();
        return view('pages.dashboard.index',$data);
    }

    public function fileView($dir,$filename)
    {
        return response()->file(storage_path('app/public/'.$dir.'/'.$filename));
    }
}