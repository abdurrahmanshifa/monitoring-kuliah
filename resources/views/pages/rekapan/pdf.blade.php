<?php
$judul = 'LAPORAN REKAPAN '.strtoupper($semester->nama).' TAHUN '.strtoupper($semester->tahun);
?>
<html>
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
         body{
              font-size:11px;
         }
    </style>
</head>
<body>
<table class="table table-borderless">
     <tr>
          <td colspan="7" style="font-weight:600;text-align:center">{{ $judul }}</td>
     </tr>
     <tr>
          <td style="font-weight:600">Prodi</td>
          <td style="text-align:left" colspan="6">{{ $prodi }}</td>
     </tr>
</table>
<br><br>
<table  class="table table-borderless" border=".5pt">
     <thead>
          <tr>
               <th style="text-align: center;">Tanggal</th>
               <th style="text-align: center;">Mata Kuliah</th>
               <th style="text-align: center;">Dosen</th>
               <th style="text-align: center;">Ruang</th>
               <th style="text-align: center;">Jumlah Mahasiswa</th>
               <th style="text-align: center;">Semester</th>
               @if(Auth::user()->roles == 'admin')
               <th style="text-align: center;">Prodi</th>
               @endif
          </tr>
     </thead>
     <tbody>
     @foreach($data as $row)
         <tr>
              <td style="vertical-align: middle;">{{ date('d F Y',strtotime($row->tgl_perkuliahan)); }}</td>
              <td style="vertical-align: middle;">{{ $row->matakuliah->nama }} <br> {{ ucwords($row->pokok_bahasan) }}</td>
              <td style="vertical-align: middle;">{{ $row->dosen->nama }} <br> {{ ucwords($row->hadir_dosen) }}</td>
              <td style="vertical-align: middle;">{{ $row->ruang->nama }}</td>
              <td style="vertical-align: middle;">{{ $row->jumlah_mahasiswa }}</td>
              <td style="vertical-align: middle;">{{  $row->semester->nama.' Tahun '.$row->semester->tahun; }}</td>
              @if(Auth::user()->roles == 'admin')
              <td style="vertical-align: middle;">{{ $row->prodi->nama}}</td>
              @endif
         </tr>
     @endforeach
     </tbody>
</table>