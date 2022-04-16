<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
<title>Form Penilaian Dosen</title>
@include('includes.head')
</head>

<body class="layout-3">
<div id="app">
     <div class="main-wrapper container">
          <div class="navbar-bg"></div>
          <nav class="navbar navbar-expand-lg main-navbar">
               <a href="{{ url('/') }}" class="navbar-brand sidebar-gone-hide">
                    SIMONIK
               </a>
          </nav>

          <nav class="navbar navbar-secondary navbar-expand-lg">
               <div class="container">
               <ul class="navbar-nav">
                    <li class="nav-item active">
                         <a href="#" class="nav-link"><i class="far fa-heart"></i><span>Survey Penilaian Dosen</span></a>
                    </li>
               </ul>
               </div>
          </nav>

          <!-- Main Content -->
          <div class="main-content">
               <section class="section">
               <div class="section-header">
                    <h1>Survey</h1>
                    <div class="section-header-breadcrumb">
                         <div class="breadcrumb-item active"><a href="#">Survey</a></div>
                         <div class="breadcrumb-item"><a href="#">Penilaian Dosen</a></div>
                    </div>
               </div>

               <div class="section-body">
                    <div class="card">
                         <div class="card-header">
                              <h4>Form Pertanyaan</h4>
                         </div>
                         <form role="form" id="form_data" name="form_data" enctype="multipart/form-data">
                         @csrf
                         <div class="card-body">
                              <div class="form-group row mb-4">
                                   <label class="col-form-label text-md-left col-12 col-md-12 col-lg-12">Dosen</label>
                                   <div class="col-sm-12 col-md-12">
                                        <select name="dosen_id" required class="form-control select2" required>
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
                              <div class="section-title">Pertanyaan</div>
                              @foreach($pertanyaan as $val)
                              <div class="form-group row mb-4">
                                   <label class="col-form-label text-md-left col-12 col-md-12 col-lg-12">
                                        {{ $val->nama }} ({{ $val->keterangan}})
                                        <input type="hidden" name="pertanyaan[]" value="{{ $val->id }}">
                                   </label>
                                   <div class="col-sm-12 col-md-12">
                                        <select name="nilai[]" required class="form-control select2" required>
                                             <option value="">Pilih Salah Satu</option>
                                             <option value="Sangat Baik">Sangat Baik</option>
                                             <option value="Baik">Baik</option>
                                             <option value="Cukup">Cukup</option>
                                             <option value="Kurang">Kurang</option>
                                        </select>
                                        <div class="invalid-feedback">
                                        </div>
                                   </div>
                              </div>
                              @endforeach
                         </div>
                         <div class="card-footer bg-whitesmoke">
                              <button type="submit" id="btn" class="btn btn-dark">
                                   Simpan
                              </button>
                         </div>
                         </form>
                    </div>
               </div>
               </section>
          </div>
          @include('includes.footer')
     </div>
</div>
@include('includes.javascript')
<script>
     $("[name=form_data]").on('submit', function(e) {
          e.preventDefault();
          $(".form-control").removeClass("is-invalid");
          $(".form-control").removeClass("is-valid");
          $('.invalid-feedback').html('');
          $('#btn').text('Sedang menyimpan...');
          $('#btn').attr('disabled', true);

          var form = $('[name="form_data"]')[0];
          var data = new FormData(form);
          var url = '{{route("survey.simpan")}}';

          $.ajax({
               url: url,
               type: 'post',
               data: data,
               processData: false,
               contentType: false,
               cache: false,
               success: function(obj) {
                    if(obj.status)
                    {
                         if (obj.success !== true) {
                         Swal.fire({
                              text: obj.message,
                              title: "Perhatian!",
                              icon: "error",
                              button: true,
                              timer: 1000
                         });
                         }
                         else {
                         Swal.fire({
                                   text: obj.message,
                                   title: "Terima Kasih",
                                   icon: "success",
                                   button: true,
                                   }).then((result) => {
                                        if (result.value) {
                                             location.reload();
                                        }
                              });
                         
                         }
                         $('#btn').text('Simpan');
                         $('#btn').attr('disabled', false);
                    }else{
                         for (var i = 0; i < obj.input_error.length; i++) 
                         {
                              $('[name="'+obj.input_error[i]+'"]').parent().parent().addClass('has-error');
                              $('[name="'+obj.input_error[i]+'"]').next().text(obj.error_string[i]);
                              $('[name="'+obj.input_error[i]+'"]').addClass(obj.class_string[i]);
                         }
                         $('#btn').text('Simpan');
                         $('#btn').attr('disabled', false);
                    }
               }
          });
     });
</script>
</body>

</html>
