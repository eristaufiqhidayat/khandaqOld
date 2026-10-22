<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="<?php echo BPATH; ?>/asset/dist/img/logoArafah.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Lembah Arafah</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <!--  
    <div class="image">
        <img src="<?php echo BPATH; ?>/asset/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      -->
      <div class="info">
        <a href="#" class="d-block"><?php echo "User :: " . user()->username; ?></a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>


    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="<?php echo base_url(); ?>/dashboard/0/0" class="nav-link" style="background-color: navy; color: white; padding: 7px 10px; ">
            <p><i class="fas fa-chart-pie"></i>&nbsp;&nbsp;&nbsp;&nbsp;Dasboard</p>
          </a>
        </li><br>
        <?php
        $cekIdmodule = "";
        foreach ($menu as $listmenu) {
          if ($moduleAktip == $listmenu["id_module"]) {
            $navmenu = "nav-item menu-open";
            $activem = "active";
          } else {
            $navmenu = "nav-item";
            $activem = "active";
          }
          if ($menuAktip == $listmenu["id_menu"]) $active = "active";
          else $active = "";
          if ($cekIdmodule !== $listmenu["id_module"]) {

        ?><li class="<?php echo $navmenu; ?>">
              <a href="#" class="nav-link <?php echo $activem; ?>">
                <i class="<?= esc($listmenu["micon"], 'attr') ?>"></i>
                <p><?= esc($listmenu["nama_module"]) ?><i class="fas fa-angle-left right"></i></p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/index.php/<?= esc($listmenu["path"], 'attr') ?>/<?php echo $listmenu["id_menu"]; ?>/<?php echo $listmenu["id_module"]; ?>" class="nav-link <?php echo $active; ?>">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="<?= esc($listmenu["icon"], 'attr') ?>"></i>
                    <p><?= esc($listmenu["menu"]) ?></p>
                  </a>
                </li>
              </ul>
            <?php
          } else {
            ?>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="<?php echo base_url(); ?>/index.php/<?= esc($listmenu["path"], 'attr') ?>/<?php echo $listmenu["id_menu"]; ?>/<?php echo $listmenu["id_module"]; ?>" class="nav-link <?php echo $active; ?>">
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="<?= esc($listmenu["icon"], 'attr') ?>"></i>
                    <p><?= esc($listmenu["menu"]) ?> </p>
                  </a>
                </li>
              </ul>

          <?php

          }
          $cekIdmodule = $listmenu["id_module"];
        }
          ?>

            </li>

      </ul>

      <ul class="nav nav-treeview">
        <li class="nav nav-pills nav-sidebar flex-column">
          <a href="<?php echo base_url(); ?>/index.php/users/cpass/0/0" class="nav-link">
            <i class="far fa-arrow-alt-circle-left"></i>
            <p>&nbsp;&nbsp;&nbsp;Change Password</p>
          </a>
        </li>
      </ul>
      <ul class="nav nav-treeview">
        <li class="nav nav-pills nav-sidebar flex-column">
          <a href="<?php echo url_to('logout'); ?>" class="nav-link">
            <i class="far fa-arrow-alt-circle-left"></i>
            <p>&nbsp;&nbsp;&nbsp;Logout</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->


  <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>