<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMonitoringTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('monitoring', function (Blueprint $table) {
            $table->id();
            $table->integer('semester_id');
            $table->integer('user_id');
            $table->integer('prodi_id');
            $table->date('tgl_perkuliahan');
            $table->integer('mata_kuliah_id');
            $table->string('pokok_bahasan')->nullable();
            $table->integer('dosen_id');
            $table->integer('ruang_id');
            $table->enum('hadir_dosen',['hadir','tidak hadir','jadwal ulang','lainnya']);
            $table->string('ket_hadir_dosen')->nullable();
            $table->string('jumlah_mahasiswa');
            $table->string('foto_absensi');
            $table->string('foto_mahasiswa');
            $table->timestamps();
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('monitoring');
    }
}
