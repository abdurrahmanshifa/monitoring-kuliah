<script>
     $('.select2').select2();

     var table = $('#table').DataTable({
        pageLength: 10,
        processing: true,
        serverSide: true,
        info :true,
        ajax: {
            url: "{{ route('perkuliahan') }}",
        },
        columns: [
            {"data":"DT_RowIndex"},
            {"data":"tgl_perkuliahan"},
            {"data":"mata_kuliah"},
            {"data":"dosen"},
            {"data":"ruang"},
            {"data":"jumlah_mahasiswa"},
            {"data":"semester"},
            {"data":"prodi"},
            {"data":"aksi"},
        ],
        columnDefs: [
            {
                targets: [0,-1],
                className: 'text-center'
            },
        ]
    });

     $(".refresh").click(function(){
          table_data();
     });

     $("[name='hadir_dosen']").change(function(){
          var id = $(this).val();
          if(id == 'lainnya')
          {
               $('.ket').attr('style','display:flex');
               $('[name="ket_hadir_dosen"]').attr('required','true');
          }else{
               $('.ket').attr('style','display:none');
               $('[name="ket_hadir_dosen"]').removeAttr('required');
          }
     });

     

     function table_data(){
          table.ajax.reload(null,true);
     }

     $("[name=form_data]").on('submit', function(e) {
          e.preventDefault();
          $(".form-control").removeClass("is-invalid");
          $(".form-control").removeClass("is-valid");
          $('.invalid-feedback').html('');
          $('#btn').text('Sedang menyimpan...');
          $('#btn').attr('disabled', true);

          var form = $('[name="form_data"]')[0];
          var data = new FormData(form);
          if(save_method == 'add'){
               var url = '{{route("perkuliahan.simpan")}}';
          }else{
               var url = '{{route("perkuliahan.ubah")}}';
          }

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
                         $('#modal_form').modal('hide');
                         Swal.fire({
                                   text: obj.message,
                                   title: "Perhatian !",
                                   icon: "success",
                                   button: true,
                                   }).then((result) => {
                                        if (result.value) {
                                             table_data();
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

     $(".tambah").click(function(){
          save_method = 'add';
          $('#form_data')[0].reset();
          $(".form-control").removeClass("is-invalid");
          $(".form-control").removeClass("is-valid");
          $('.invalid-feedback').html('');
          $('#modal_form').modal('show');
          $('.modal-title').text('Tambah Data');
          $('[name="mata_kuliah_id"]').val('').change();
          $('[name="dosen_id"]').val('').change();
          $('[name="ruang_id"]').val('').change();
          $('[name="hadir_dosen"]').val('hadir').change();

          $('.ket').attr('style','display:none');
          $('[name="ket_hadir_dosen"]').removeAttr('required');
          $('.foto_mahasiswa').html('');
          $('.foto_absensi').html('');
     });

     function ubah(id)
     {
          save_method = 'edit';
          $('#form_data')[0].reset();
          $(".form-control").removeClass("is-invalid");
          $(".form-control").removeClass("is-valid");
          $('.invalid-feedback').html('');

          $.ajax({
               url : "{{url('perkuliahan/data/')}}"+"/"+id,
               type: "GET",
               dataType: "JSON",
               success: function(data){
                    $('#modal_form').modal('show');
                    $('.modal-title').text('Ubah data');
                    $('[name="id"]').val(data.id);
                    $('[name="tgl_perkuliahan"]').val(data.tgl_perkuliahan);
                    $('[name="pokok_bahasan"]').val(data.pokok_bahasan);
                    $('[name="dosen_id"]').val(data.dosen_id).change();
                    $('[name="ruang_id"]').val(data.ruang_id).change();
                    $('[name="hadir_dosen"]').val(data.hadir_dosen).change();
                    $('[name="mata_kuliah_id"]').val(data.mata_kuliah_id).change();
                    if(data.hadir_dosen == 'lainnya')
                    {
                         $('.ket').attr('style','display:flex');
                         $('[name="ket_hadir_dosen"]').attr('required','true');
                    }else{
                         $('.ket').attr('style','display:none');
                         $('[name="ket_hadir_dosen"]').removeAttr('required');
                    }
                    $('.foto_mahasiswa').html('<img width="50%" src="'+data.foto_mahasiswa+'">');
                    $('.foto_absensi').html('<img width="50%" src="'+data.foto_absensi+'">');
                    $('[name="jumlah_mahasiswa"]').val(data.jumlah_mahasiswa);
               },
               error: function (jqXHR, textStatus, errorThrown){
                    alert('Error get data from ajax');
               }
          });
     }

     function hapus(id)
     {
          Swal.fire({
               text: "Apakah Data ini Ingin Di Hapus?",
               title: "Perhatian",
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: "#2196F3",
               confirmButtonText: "Iya",
               cancelButtonText: "Tidak",
               closeOnConfirm: false,
               closeOnCancel: true
          }).then((result) => {
               if (result.value) {
                    $.ajax({
                         url : "{{url('perkuliahan/hapus/')}}"+"/"+id,
                         type: "POST",
                         data : {
                              '_method'   : 'delete',
                              '_token'    : '{{ csrf_token() }}',
                         },
                         dataType: "JSON",
                         success: function (obj) {
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
                                   table_data();
                                   Swal.fire({
                                        text: obj.message,
                                        title: "Perhatian!",
                                        icon: "success",
                                        button: true,
                                        timer: 1000
                                   });
                              }
                         },
                         error: function (jqXHR, textStatus, errorThrown){
                              alert('Error get data from ajax');
                         }
                    });
               }else{
                    table_data(); 
               }

          });
     }
</script>