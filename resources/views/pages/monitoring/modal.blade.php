<div class="modal fade"  role="dialog" id="modal_form" aria-hidden="true" >
     <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
               <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-dismiss="modal" aria-label="Close">
                         <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
               </div>
               <form role="form" id="form_data" name="form_data" enctype="multipart/form-data">
               @csrf
                    <div class="modal-body">
                    <input type="hidden" name="id">
                         <div class="form-group row mb-4">
                              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Tanggal Perkuliahan<span class="text-danger">*</span></label>
                              <div class="col-sm-12 col-md-9">
                                   <input class="form-control" type="date" name="tgl_perkuliahan">
                                   <div class="invalid-feedback">
                                   </div>
                              </div>
                         </div>
                         <div class="form-group row mb-4">
                              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Mata Kuliah<span class="text-danger">*</span></label>
                              <div class="col-sm-12 col-md-9">
                                   <select name="mata_kuliah_id" class="form-control select2" required>
                                        <option value="">Pilih Mata Kuliah</option>
                                        @foreach($mata_kuliah as $val)
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
                              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Pokok Bahasan <span class="text-danger">*</span></label>
                              <div class="col-sm-12 col-md-9">
                                   <input class="form-control" type="text" name="pokok_bahasan">
                                   <div class="invalid-feedback">
                                   </div>
                              </div>
                         </div>
                         <div class="form-group row mb-4">
                              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Dosen<span class="text-danger">*</span></label>
                              <div class="col-sm-12 col-md-9">
                                   <select name="dosen_id" class="form-control select2" required>
                                        <option value="">Pilih Dosen</option>
                                        @foreach($dosen as $val)
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
                              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Ruang <span class="text-danger">*</span></label>
                              <div class="col-sm-12 col-md-9">
                                   <select name="ruang_id" class="form-control select2" required>
                                        <option value="">Pilih Ruang</option>
                                        @foreach($ruang as $val)
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
                              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Kehadiran Dosen<span class="text-danger">*</span></label>
                              <div class="col-sm-12 col-md-9">
                                   <select name="hadir_dosen" class="form-control select2" required>
                                        <option value="hadir">Hadir</option>
                                        <option value="tidak hadir">Tidak Hadir</option>
                                        <option value="jadwal ulang">Jadwal Ulang</option>
                                        <option value="lainnya">Lainnya</option>
                                   </select>
                                   <div class="invalid-feedback">
                                   </div>
                              </div>
                         </div>
                         <div class="form-group row mb-4 ket" style="display:none">
                              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Lainya <span class="text-danger">*</span></label>
                              <div class="col-sm-12 col-md-9">
                                   <input class="form-control" type="text" name="ket_hadir_dosen">
                                   <div class="invalid-feedback">
                                   </div>
                              </div>
                         </div>
                         <div class="form-group row mb-4">
                              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Jumlah Kehadiran Mahasiswa <span class="text-danger">*</span></label>
                              <div class="col-sm-12 col-md-9">
                                   <input class="form-control" type="text" name="jumlah_mahasiswa">
                                   <div class="invalid-feedback">
                                   </div>
                              </div>
                         </div>
                         <div class="form-group row mb-4">
                              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto Absensi<span class="text-danger">*</span></label>
                              <div class="col-sm-12 col-md-9">
                                   <div class="foto_absensi">

                                   </div>
                                   <input class="form-control" type="file" accept="image/x-png,image/jpeg" name="foto_absensi">
                                   <div class="invalid-feedback">
                                   </div>
                                   <span>Hanya menerima file jpg,png dan maximal file 2 Mb</span>
                              </div>
                         </div>
                         <div class="form-group row mb-4">
                              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Foto Mahasiswa di Kelas<span class="text-danger">*</span></label>
                              <div class="col-sm-12 col-md-9">
                                   <div class="foto_mahasiswa">

                                   </div>
                                   <input class="form-control" type="file" accept="image/x-png,image/jpeg" name="foto_mahasiswa">
                                   <div class="invalid-feedback">
                                   </div>
                                   <span>Hanya menerima file jpg,png dan maximal file 2 Mb</span>
                              </div>
                         </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                         @if( \Auth::user()->roles == 'mahasiswa' || \Auth::user()->roles == 'admin')
                         <button type="submit" id="btn" class="btn btn-dark">
                              Simpan
                         </button>
                         @endif
                         <button type="button" class="btn btn-light" data-dismiss="modal">
                              Batal
                         </button>
                    </div>
               </form>
          </div>
     </div>
</div>
<div class="modal fade"  role="dialog" id="modal_excel" aria-hidden="true" >
     <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
               <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle"></h5>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-dismiss="modal" aria-label="Close">
                         <span class="svg-icon svg-icon-2x"></span>
                    </div>
                    <!--end::Close-->
               </div>
               <form role="form" id="form_excel" name="form_excel" enctype="multipart/form-data">
               @csrf
                    <div class="modal-body">
                         <div class="form-group row mb-4">
                              <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">File 
                                   <span class="text-danger">*</span>
                              </label>
                              <div class="col-sm-12 col-md-9">
                                   <input class="form-control" required type="file" name="file">
                                   <div class="invalid-feedback">
                                   </div>
                              </div>
                         </div>
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                         <button type="submit" id="btn" class="btn btn-dark">
                              Simpan
                         </button>
                         <button type="button" class="btn btn-light" data-dismiss="modal">
                              Batal
                         </button>
                    </div>
               </form>
          </div>
     </div>
</div>