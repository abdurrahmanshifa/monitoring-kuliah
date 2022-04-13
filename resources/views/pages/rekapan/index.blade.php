@extends('layouts.app')

@section('title')
     <title>
          Rekapan - Sistem Monitoring Perkuliahan
     </title>
@endsection

@section('content')
<section class="section">
     <div class="section-header">
          <h1>Rekapan</h1>
          <div class="section-header-breadcrumb">
               <div class="breadcrumb-item active"><a href="#">Laporan</a></div>
               <div class="breadcrumb-item">Rekapan</div>
          </div>
     </div>

     <div class="section-body">
          <div class="row">
               <div class="col-12">
                    <div class="card">
                         <div class="card-header">
                              <h4>
                              </h4>
                              <div class="card-header-form">
                                   <a data-collapse="#mycard-collapse" class="btn btn-icon btn-info" href="#">
                                        <i class="fas fa-minus"></i>
                                   </a>
                              </div>
                         </div>
                         <div class="collapse show" id="mycard-collapse" style="">
                              <div class="card-body p-0">
                                   <div style="padding: 30px;">
                                        <form action="{{ route('laporan.rekapan.cetak') }}" role="form" id="form_data" name="form_data" method="post">
                                        @csrf
                                             <div class="modal-body">
                                                  <div class="form-group row mb-4">
                                                       <label class="col-form-label col-12 col-md-3 col-lg-3">Prodi</label>
                                                       <div class="col-sm-12 col-md-9">
                                                            <select name="prodi_id" class="form-control select2" required>
                                                                 @if(\Auth::user()->roles == 'admin')
                                                                 <option value="0">Pilih Semua Studi</option>
                                                                 @endif
                                                                 @foreach($prodi as $val)
                                                                      <option value="{{ $val->id }}">
                                                                           {{ $val->nama }}
                                                                      </option>
                                                                 @endforeach
                                                            </select>
                                                            <div class="invalid-feedback">
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="form-group row mb-4">
                                                       <label class="col-form-label col-12 col-md-3 col-lg-3">Semester</label>
                                                       <div class="col-sm-12 col-md-9">
                                                            <select name="semester_id" class="form-control select2" required>
                                                                 @foreach($semester as $val)
                                                                      <option value="{{ $val->id }}">
                                                                           {{ $val->nama }} Tahun {{ $val->tahun }}
                                                                      </option>
                                                                 @endforeach
                                                            </select>
                                                            <div class="invalid-feedback">
                                                            </div>
                                                       </div>
                                                  </div>
                                                  <div class="form-group row mb-4">
                                                       <label class="col-form-label col-12 col-md-3 col-lg-3">Format</label>
                                                       <div class="col-sm-12 col-md-9">
                                                            <select name="format" class="form-control select2" required>
                                                                 <option value="pdf">PDF</option>
                                                                 <option value="excel">Excel</option>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="modal-footer br">
                                                  <button type="submit" id="btn" class="btn btn-dark">
                                                       Cetak
                                                  </button>
                                             </div>
                                        </form>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</section>
@endsection

@section('modal')
@endsection

@section('script')
@endsection