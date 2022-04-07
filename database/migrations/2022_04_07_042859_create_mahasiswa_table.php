<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMahasiswaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->id();
            $table->integer('prodi_id')->nullable();
            $table->string('nim')->nullable();
            $table->string('nama')->nullable();
            $table->string('email')->nullable();
            $table->string('tahun_angkatan')->nullable();
            $table->enum('jenis_kelamin',['laki-laki','perempuan']);
            $table->enum('status_ketua',['ya','tidak'])->default('ya');
            $table->string('tahun_angkatan')->nullable();
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
        Schema::dropIfExists('mahasiswa');
    }
}
