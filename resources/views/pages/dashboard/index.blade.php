@extends('layouts.app')

@section('title')
<title>
    Dashboard - Sistem Monitoring Perkuliahan
</title>
@endsection

@section('content')
<section class="section">
     <div class="section-header">
     <h1>Dashboard</h1>
     </div>
     <div class="row">
     <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
               <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
               </div>
               <div class="card-wrap">
                    <div class="card-header">
                         <h4>User</h4>
                    </div>
                    <div class="card-body">
                         {{ \App\Models\User::count() }}
                    </div>
               </div>
          </div>
     </div>
     <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
               <div class="card-icon bg-danger">
                    <i class="far fa-newspaper"></i>
               </div>
               <div class="card-wrap">
                    <div class="card-header">
                         <h4>Dosen</h4>
                    </div>
                    <div class="card-body">
                         {{ \App\Models\Dosen::count() }}
                    </div>
               </div>
          </div>
     </div>
     <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
               <div class="card-icon bg-warning">
                    <i class="far fa-file"></i>
               </div>
               <div class="card-wrap">
                    <div class="card-header">
                         <h4>Mata Kuliah</h4>
                    </div>
                    <div class="card-body">
                    {{ \App\Models\MataKuliah::count() }}
                    </div>
               </div>
          </div>
     </div>
     <div class="col-lg-3 col-md-6 col-sm-6 col-12">
          <div class="card card-statistic-1">
               <div class="card-icon bg-success">
                    <i class="fas fa-circle"></i>
               </div>
               <div class="card-wrap">
                    <div class="card-header">
                         <h4>Mahasiswa</h4>
                    </div>
                    <div class="card-body">
                    {{ \App\Models\Mahasiswa::count() }}
                    </div>
               </div>
          </div>
     </div>
     </div>
</section>
@endsection

@section('script')
@include('pages.dashboard.script')
@endsection