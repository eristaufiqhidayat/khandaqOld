<?= $this->extend('Views\layout.php') ?>

<?= $this->section('css') ?>

<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="content-wrapper" style="min-height: 1345.31px;">
  <section class="content-header">
    <div class="container-fluid">

    </div>
  </section>
  <section class="content">
    <!-- <table style="width:100%" border=1>
      <?php
      //var_dump($dataBerita);
      //foreach ($dataBerita as $datav) { ?>
        <tr>
          <td width=10%><img src="<?php //echo $datav["gambar"] ?>" width="50%"></td>
          <td><?php //echo $datav["post_title"] ?></td>
        </tr>

      <?php //} ?>
    </table> -->
    <table style="width:100%" border=0>
      <tr>
        <td align=center>
          <div class="card card-blue">
            <div class="card-header">
              <h3 class="card-title">Info Hari ini</h3>
            </div>
            <div class="card-body">
              <img id="banner-load" src="<?= base_url() ?>/uploads/images/kursus.png" class="iru_random" width=300 hidden>
              <img id="banner-load" src="<?= base_url() ?>/uploads/images/kursus3.jpg" class="iru_random" width=300 hidden>
              <img id="banner-load" src="<?= base_url() ?>/uploads/images/kursus2.jpg" class="iru_random" width=300 hidden>
              <img id="banner-load" src="<?= base_url() ?>/uploads/images/iklan1.jpg" class="iru_random" width=300>
              <!-- <img id="banner-load" src="<?= base_url() ?>/uploads/images/LebaranArafah.jpg" class="iru_random" width=300> -->
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="card card-blue">
            <div class="card-header">
              <h3 class="card-title">Berita Arafah</h3>
            </div>
            <table class="table table-bordered table-striped table-sm">
              <?php
              //var_dump($dataBerita);
              //foreach ($dataBerita as $datav) { ?>
                <tr>
                  <td width=40% align="center"><img src="<?php //echo $datav["gambar"] ?>" width="50%"></td>
                  <td><?php //echo $datav["post_title"] . "......" ?><a href="https://ww2.lembaharafah.com/<?php //echo $datav["post_name"] ?>/">[Detil]</a></td>
                </tr>

              <?php// } ?>
            </table>
          </div>
        </td>
      </tr>
      <tr>
        <td>
          <div class="card card-blue">
            <div class="card-header">
              <h3 class="card-title">Kalender Akedemik Arafah</h3>
            </div>
            <table class="table table-bordered table-striped table-sm">
              <?php
              //var_dump($dataBerita);
              //foreach ($dataKalender as $datav) { ?>
                <tr>
                  <td width=40% align="center"><?php //echo $datav["tanggal"] ?></td>
                  <td><?php //echo $datav["kegiatan"] ?></td>
                </tr>

              <?php //} ?>
            </table>
          </div>
        </td>
      </tr>
      <tr>
        <td width=50% valign=top>
          <div class="card card-blue">
            <div class="card-header">
              <h3 class="card-title">Chart Jumlah Murid Bebas Biaya (Yatim / Beasiswa)</h3>
            </div>
            <div class="card-body">
              <canvas id="pieChart" style="min-height: 250px; height: 400px; max-height: 400px; max-width: 100%; display: block; width: 326px;" width="326" class="chartjs-render-monitor"></canvas>
              <br>
              <table class="table table-bordered table-striped table-sm">
                <thead>
                  <tr>
                    <td>Kelas</td>
                    <td>Jumlah</td>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($data as $datachart) { ?>
                    <tr>
                      <td><?php echo $datachart['kelas']; ?> </td>
                      <td><?php echo $datachart['jml']; ?> </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        </td>
      </tr>
    </table>

  </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>

<script src="<?php echo BPATH; ?>/asset/dist/js/pages/dashboard.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/jquery/jquery.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo BPATH; ?>/asset/dist/js/adminlte.min.js?v=3.2.0"></script>
<script>
  var images = Array();
  jQuery(".iru_random").each(function(index) {
    images.push(jQuery(this).attr('src'));
    jQuery(this).attr('src', images[Math.floor(Math.random() * images.length)]);
  });
</script>

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
          echo "'Kelas " . $datachart['kelas'] . "',";
        }
        ?>
      ],
      datasets: [{
        data: [
          <?php foreach ($data as $datachart) {
            echo "'" . $datachart['jml'] . "',";
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
    var areaChartData = {
      labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
      datasets: [{
          label: 'Digital Goods',
          backgroundColor: 'rgba(60,141,188,0.9)',
          borderColor: 'rgba(60,141,188,0.8)',
          pointRadius: false,
          pointColor: '#3b8bba',
          pointStrokeColor: 'rgba(60,141,188,1)',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(60,141,188,1)',
          data: [28, 48, 40, 19, 86, 27, 90]
        },
        {
          label: 'Electronics',
          backgroundColor: 'rgba(210, 214, 222, 1)',
          borderColor: 'rgba(210, 214, 222, 1)',
          pointRadius: false,
          pointColor: 'rgba(210, 214, 222, 1)',
          pointStrokeColor: '#c1c7d1',
          pointHighlightFill: '#fff',
          pointHighlightStroke: 'rgba(220,220,220,1)',
          data: [65, 59, 80, 81, 56, 55, 40]
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
