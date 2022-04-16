<?php
$judul = 'LAPORAN PENILAIAN DOSEN '.strtoupper($semester->nama).' TAHUN '.strtoupper($semester->tahun);
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
<table class="table-borderless" style="border:none;width:100%">
     <tr>
          <td colspan="7" style="font-weight:600;text-align:center">{{ $judul }}</td>
     </tr>
</table>
<br><br>
@php 
     $tanya = ($pertanyaan->count() * 4);
     $merge = (Auth::user()->roles == 'admin'?7:6)+ $tanya;
@endphp
<table  class="table table-borderless" style="border:1px solid #ccc;">
     <thead>
          <tr>
               <th rowspan="3" style="text-align: center;vertical-align:middle;border:1px solid #ccc;">No</th>
               <th rowspan="3" style="text-align: center;vertical-align:middle;border:1px solid #ccc;">Dosen</th>
               @if(Auth::user()->roles == 'admin')
               <th rowspan="3" style="text-align: center;vertical-align:middle;border:1px solid #ccc;">Prodi</th>
               @endif
               <th colspan="{{ $tanya }}" style="text-align: center;vertical-align:middle;border:1px solid #ccc;">Penilaian</th>
          </tr>
          <tr>
               @foreach($pertanyaan as $val)
                    <th colspan="4" style="width:100px;vertical-align:middle;border:1px solid #ccc;">{{ $val->nama }} <br> ( {{ $val->keterangan }} )</th>
               @endforeach
          </tr>
          <tr>
               @foreach($pertanyaan as $val)
                    <th style="text-align: center;border:1px solid #ccc;">SB</th>
                    <th style="text-align: center;border:1px solid #ccc;">B</th>
                    <th style="text-align: center;border:1px solid #ccc;">C</th>
                    <th style="text-align: center;border:1px solid #ccc;">K</th>
               @endforeach
          </tr>
     </thead>
     <tbody>
          @if($data !=  null)
               @foreach($data as $key => $val)
                    <tr>
                         <td style="text-align: center;border:1px solid #ccc;">
                              {{$key+1}}
                         </td>
                         <td style="border:1px solid #ccc;">
                              {{ $val['nama'] }}
                         </td>
                         @if(Auth::user()->roles == 'admin')
                              <td style="text-align: center;border:1px solid #ccc;">{{ $val['prodi'] }}</td>
                         @endif
                         @foreach($pertanyaan as $tanya)
                         <td style="text-align: center;border:1px solid #ccc;">{{ $val['SB '.$tanya->id] }}</td>
                         <td style="text-align: center;border:1px solid #ccc;">{{ $val['B '.$tanya->id] }}</td>
                         <td style="text-align: center;border:1px solid #ccc;">{{ $val['C '.$tanya->id] }}</td>
                         <td style="text-align: center;border:1px solid #ccc;">{{ $val['K '.$tanya->id] }}</td>
                         @endforeach
                    </tr>
               @endforeach
          @else
               <td  style="text-align: center;border:1px solid #ccc;" colspan="{{ $merge }}">
               Data Tidak Ditemukan
               </td>
         @endif
     </tbody>
</table>
<br><br>
<table class="table table-borderless" style="width:30%">
<tr>
     <th style="text-align: center;" colspan="2">Keterangan</th>
</tr>
<tr>
     <td>SB</td>
     <td>Sangat Baik</td>
</tr>
<tr>
     <td>B</td>
     <td>Baik</td>
</tr>
<tr>
     <td>C</td>
     <td>Cukup</td>
</tr>
<tr>
     <td>K</td>
     <td>Kurang</td>
</tr>
</table>
