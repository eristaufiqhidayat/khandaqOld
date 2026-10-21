<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>
<div class="content-wrapper" style="min-height: 1345.31px;">
  <section class="content-header">
    <div class="container-fluid">

    </div>
  </section>
  <section class="content">
    <table border=1>
      <tr>
        <td valign=top>
          <div class="card card-blue">
            <div class="card-header">
              <h3 class="card-title">Chart Jumlah Murid
                <?php
                //$id_kelas = [];
                $cek = "";
                $count = 0;

                foreach ($sumBelumbayar_perkelas as $k => $v) {
                  if ($cek !== $v['nama_kelas']) {
                    $count = $v['jml'];
                  } else {
                    $count = $count + $v['jml'];
                  }
                  $cek = $v['nama_kelas'];
                  $id_kelas[$v['nama_kelas']] = $v['jml'];
                  //echo $v["nama_kelas"] . "=" . $v['jml'] . "=" . $count . "<br>";
                }

                $cek = "";
                $count = 0;
                $besis = array();
                foreach ($beasiswa as $k => $v) {
                  $besis[$v['nama_kelas']] = $v['jml'];
                }
                //echo $id_kelas[9];
                ?>
              </h3>
            </div>
            <div class="card-body">
              <canvas id="pieChart" style="min-height: 250px; height: 400px; max-height: 400px; max-width: 100%; display: block; width: 326px;" width="326" class="chartjs-render-monitor"></canvas>
            </div>
          </div>
        </td>
        <td>
          <div class="card card-blue">
            <div class="card-header">
              <h3 class="card-title">Chart Jumlah Murid Kurang Bayar</h3>
            </div>
            <div class="card-body">
              <canvas id="barChart" style="min-height: 250px; height: 400px; max-height: 400px; max-width: 100%;"></canvas>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td VALIGN=TOP colspan=2>
          <table class="table table-bordered table-striped table-sm">
            <thead>
              <tr>
                <td>Kelas</td>
                <td>Jumlah </td>
                <td>Beasiswa </td>
                <td>Kurang Bayar </td>
                <td>Total RP</td>
                <td>view </td>
              </tr>
            </thead>
            <tbody>
              <?php
              $totalsiswa = 0;
              $totalbesis = 0;
              $totalkurangbayar = 0;
              $totalrupiah = 0;
              $i = 0;
              foreach ($data as $datachart) { ?>
                <tr>
                  <td><?= $datachart['kelas']; ?> </td>
                  <td><?= $datachart['jml']; ?> </td>
                  <td><?= $besis[$datachart['kelas']]; ?></td>
                  <td><?php
                      if (isset($id_kelas[$datachart['kelas']]))
                        $blmbayar = $id_kelas[$datachart['kelas']];
                      else $blmbayar = 0;
                      $blmbayar = $blmbayar - $besis[$datachart['kelas']];
                      if ($blmbayar < 0) $blmbayar = 0;
                      echo $blmbayar;
                      ?>
                  </td>
                  <td align="right">
                    <?php
                    $id_kelasspp = id_kelas($datachart['kelas']);
                    $tarifspp = tarifspp($id_kelasspp['id_kelas']);
                    if (isset($tarifspp['tarif'])) {
                      $totalrupiah += $blmbayar * $tarifspp['tarif'];
                      echo number_format($blmbayar * $tarifspp['tarif'], 0);
                    }
                    ?>
                  </td>
                  <td><button data-toggle="modal" data-target="#Modal<?php echo $i; ?>" type="button" class="btn btn-primary"><i class="fas fa-search"></i></button> </td>

                </tr>
                <div class="modal fade" id="Modal<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Data Siswa</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>

                      <div class="modal-body">
                        <div class="container">
                          <div class="row">
                            <div class="col-2" style="background-color:green;border-style: ridge;">Beasiswa</div>
                            <div class="col-2" style="background-color:blue;border-style: ridge;">Lunas</div>
                            <div class="col-2" style="background-color:red;border-style: ridge;">Kurang Bayar</div>
                            <div class="col-2" style="background-color:yellow;border-style: ridge;">Tarif SPP</div>
                          </div>
                        </div>
                        <div class="container">
                          <?php
                          $data3 = list_siswa_blmbayar_perkelas($datachart['kelas']);
                          $i = 1;
                          foreach ($data3 as $datachart2) { ?>
                            <div class="row">
                              <div class="col-5" style="border-style: ridge;"><?php echo $i . " " . $datachart2['nama_siswa']; ?></div>
                              <div class="col-2" style="border-style: ridge;">Beasiswa =
                                <?php
                                if ($datachart2['peserta'] == "") echo "no";
                                else echo $datachart2['peserta'];
                                $selisih = $datachart2['jmldibayar'] - $datachart2['jmlharusbayar'];
                                if ($selisih >= 0) $bgcolor = 'blue';
                                else $bgcolor = 'red';
                                if ($datachart2['peserta'] == "yes") $bgcolor = 'green';
                                ?>
                              </div>
                              <div class="col-2" style="background-color:<?= $bgcolor ?>;border-style: ridge;">Selisih = <?php echo number_format($selisih, 0); ?></div>
                              <div class="col-2" style="background-color:yellow;border-style: ridge;"><?php echo number_format(isset($datachart2['rppersen']), 0); ?></div>
                            </div>
                          <?php $i++;
                          } ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php
                $i++;
                $totalsiswa = $totalsiswa + $datachart['jml'];
                $totalbesis = $totalbesis + $besis[$datachart['kelas']];
                $totalkurangbayar += $blmbayar;
              } ?>
              <tr>
                <td>Total</td>
                <td><?= $totalsiswa ?></td>
                <td><?= $totalbesis ?></td>
                <td><?= $totalkurangbayar ?></td>
                <td align="right"><?= number_format(isset($totalrupiah), 0) ?></td>
                <td></td>
              </tr>
            </tbody>
          </table>
        </td>

      </tr>
    </table>

  </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>

<script src=" <?php echo BPATH; ?>/asset/dist/js/pages/dashboard.js">
</script>
<script src="<?php echo BPATH; ?>/asset/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/dist/js/adminlte.min.js?v=3.2.0"></script>

<script>
  $(function() {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieData = {
      labels: [
        <?php foreach ($data as $datachart) {
          echo "'" . $datachart['kelas'] . "',";
        }
        ?>
      ],
      datasets: [{
        data: [
          <?php
          $jmlsiswa = "";
          foreach ($data as $datachart) {
            echo "'" . $datachart['jml'] . "',";
            $jmlsiswa .= "'" . $datachart['jml'] . "',";
          }
          ?>
        ],
        backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de', '#FFF333', '#FF33B2', '#1CD7CC'],
      }]
    }
    var pieOptions = {
      maintainAspectRatio: false,
      responsive: true,
    }

    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(pieChartCanvas, {
      type: 'pie',
      data: pieData,
      options: pieOptions
    })

    //-------------
    //- BAR CHART -
    //-------------
    <?php

    $data1 = "";
    $data2 = "";
    if (isset($id_kelas)) {
      foreach ($id_kelas as $key => $val) {
        //dd($val);
        if ($besis[$key]) $val2 = $besis[$key];
        else $val2 = 0;
        $val = $val - $val2;
        $data1 .=  $val . ",";
        $data2 .= $val2 . ",";
      }
      $data1 = substr(trim($data1), 0, -1);
      $data2 = substr(trim($data2), 0, -1);
    }
    ?>
    var areaChartData = {
      //labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      labels: [<?php
                $label = "";
                if (isset($id_kelas)) {
                  foreach (array_keys($id_kelas) as $k => $v) {
                    $label .= "'" . $v . "',";
                  }
                  $label = substr($label, 0, -1);
                }
                echo $label;
                ?>],

      datasets: [{
          label: 'Siswa kurang Bayar',
          backgroundColor: 'rgba(255,102,102,0.9)',
          borderColor: 'rgba(60,141,188,0.8)',
          pointRadius: false,
          pointColor: '#3b8bba',
          pointStrokeColor: 'rgba(60,141,188,1)',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data: [<?= $data1 ?>]
        },
        {
          label: 'Jumlah Siswa',
          backgroundColor: 'rgba(210, 214, 222, 1)',
          borderColor: 'rgba(210, 214, 222, 1)',
          pointRadius: false,
          pointColor: 'rgba(210, 214, 222, 1)',
          pointStrokeColor: '#c1c7d1',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data: [<?= $jmlsiswa ?>]
        },
        {
          label: 'Jumlah Beasiswa',
          backgroundColor: 'rgba(111, 111, 222, 1)',
          borderColor: 'rgba(210, 214, 222, 1)',
          pointRadius: false,
          pointColor: 'rgba(210, 214, 222, 1)',
          pointStrokeColor: '#c1c7d1',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data: [<?= $data2 ?>]
        },
      ]
    }
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    barChartData.datasets[0] = temp1
    barChartData.datasets[1] = temp0
    var barChartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      datasetFill: false
    }
    new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
    })

    //---------------------
    //- STACKED BAR CHART -
    //---------------------
    var stackedBarChartCanvas = $('#stackedBarChart').get(0).getContext('2d')
    var stackedBarChartData = $.extend(true, {}, barChartData)
    var stackedBarChartOptions = {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        xAxes: [{
          stacked: true,
        }],
        yAxes: [{
          stacked: true
        }]
      }
    }
    new Chart(stackedBarChartCanvas, {
      type: 'bar',
      data: stackedBarChartData,
      options: stackedBarChartOptions
    })
  })
</script>
<?= $this->endSection() ?>