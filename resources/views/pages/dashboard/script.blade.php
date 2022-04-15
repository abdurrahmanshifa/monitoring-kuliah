<script src="{{ asset('public/node_modules/jquery-sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('public/node_modules/chart.js/dist/Chart.min.js') }}"></script>
<script src="{{ asset('public/node_modules/owl.carousel/dist/owl.carousel.min.js') }}"></script>
<script src="{{ asset('public/node_modules/summernote/dist/summernote-bs4.js') }}"></script>
<script src="{{ asset('public/node_modules/chocolat/dist/js/jquery.chocolat.min.js') }}"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/drilldown.js"></script>

<script>
     Highcharts.chart('dosen', {
          chart: {
               plotBackgroundColor: null,
               plotBorderWidth: null,
               plotShadow: false,
               type: 'pie'
          },
          title: {
               text: ''
          },
          tooltip: {
               pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          accessibility: {
               point: {
                    valueSuffix: '%'
               }
          },
          plotOptions: {
               pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                         enabled: true,
                         format: '<b>{point.name}</b>: {point.y} Orang'
                    },
                    colors: [
                         '#ffa426', 
                         '#48c363', 
                    ],
               }
          },
          series: [{
               name: 'Jumlah',
               colorByPoint: true,
               data: [
                    {
                         name: 'Laki - Laki',
                         y: {{ $dosen_laki }},
                    }, {
                         name: 'Perempuan',
                         y: {{ $dosen_perempuan }}
                    }, 
               ]
          }]
     });

     Highcharts.chart('mahasiswa', {
          chart: {
               plotBackgroundColor: null,
               plotBorderWidth: null,
               plotShadow: false,
               type: 'pie'
          },
          title: {
               text: ''
          },
          tooltip: {
               pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
          },
          accessibility: {
               point: {
                    valueSuffix: '%'
               }
          },
          plotOptions: {
               pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                         enabled: true,
                         format: '<b>{point.name}</b>: {point.y} Orang'
                    },
                    colors: [
                         '#3392FF', 
                         '#FF3333', 
                    ],
               }
          },
          series: [{
               name: 'Jumlah',
               colorByPoint: true,
               data: [
                    {
                         name: 'Laki - Laki',
                         y: {{ $laki }},
                    }, {
                         name: 'Perempuan',
                         y: {{ $perempuan }}
                    }, 
               ]
          }]
     });

     Highcharts.chart('prodi', {
          chart: {
               type: 'column'
          },
          title: {
               text: 'Laporan Rekapan Perkuliahan'
          },
          subtitle: {
               text: '{{ $semester->nama." Tahun ".$semester->tahun }}'
          },
          accessibility: {
               announceNewData: {
                    enabled: true
               }
          },
          xAxis: {
               type: 'category'
          },
          yAxis: {
               title: {
                    text: 'Perkuliahan Per Prodi'
               }

          },
          legend: {
               enabled: false
          },
          plotOptions: {
               series: {
                    borderWidth: 0,
                    dataLabels: {
                         enabled: true,
                         format: '{point.y}'
                    }
               }
          },

          tooltip: {
               headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
               pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y} </b> <br/>'
          },

          series: [
               {
                    name: "Jumlah",
                    colorByPoint: true,
                    data: [
                         @foreach($prodi as $val)
                         {
                              name: "{{ $val->nama }}",
                              y: {{ $val->monitoring->count() }},
                              drilldown: "{{ $val->nama }}"
                         },
                         @endforeach
                    ]
               }
          ],
          drilldown: {
               breadcrumbs: {
                    position: {
                         align: 'center'
                    }
               },
               series: [
                    @foreach($prodi as $val)
                    {
                         name: "{{ $val->nama }}",
                         id: "{{ $val->nama }}",
                         data: [
                              @foreach($val->monitoring->groupBy('tgl_perkuliahan') as $key => $row)
                              {
                                   name : "{{ date('d F Y',strtotime($key)) }}",
                                   y : {{ $row->count() }},
                              },
                              @endforeach
                         ],
                    },
                    @endforeach

               ]
          }
     });

     Highcharts.chart('survey', {
          chart: {
               type: 'column'
          },
          title: {
               text: 'Rekapan Penilaian Dosen'
          },
          subtitle: {
               text: '{{ $semester->nama." Tahun ".$semester->tahun }}'
          },
          xAxis: {
               categories: [
                    @foreach($dosen as $val)
                         '{{ $val->nama }}',
                    @endforeach
               ],
               crosshair: true
          },
          yAxis: {
               min: 0,
               title: {
                    text: 'Penilaian'
               }
          },
          tooltip: {
               headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
               pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>{point.y}</b></td></tr>',
               footerFormat: '</table>',
               shared: true,
               useHTML: true,
          },
          plotOptions: {
               column: {
                    pointPadding: 0.2,
                    borderWidth: 0
               }
          },
          colors: [
               '#0030FB',
               '#00B1FB',
               '#FB9000',
               '#FB0F00',
          ],
          series: [{
               name: 'Sangat Baik',
               data: {{ @json_encode($array['Sangat Baik']) }}

          }, {
               name: 'Baik',
               data: {{ @json_encode($array['Baik']) }}

          }, {
               name: 'Cukup',
               data: {{ @json_encode($array['Cukup']) }}

          }, {
               name: 'Kurang',
               data: {{ @json_encode($array['Kurang']) }}

          }]
          });
</script>