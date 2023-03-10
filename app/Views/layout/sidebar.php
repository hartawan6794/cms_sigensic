      <!-- Main Sidebar Container -->
      <!--<aside class="main-sidebar sidebar-bg-dark sidebar-color-primary shadow">-->
      <?php helper('settings');
      $seg = segment()->uri->getSegment(1) ?>
      <aside class="main-sidebar sidebar-bg-dark  sidebar-color-primary shadow">
        <div class="brand-container">
          <a href="javascript:;" class="brand-link">
            <img src="<?= base_url('asset/img/AdminLTELogo.png') ?>" alt="AdminLTE Logo" class="brand-image opacity-80 shadow">
            <span class="brand-text fw-light">Si Gensic</span>
          </a>
          <a class="pushmenu mx-1" data-lte-toggle="sidebar-mini" href="javascript:;" role="button"><i class="fas fa-angle-double-left"></i></a>
        </div>
        <!-- Sidebar -->
        <div class="sidebar">
          <nav class="mt-2">
            <!-- Sidebar Menu -->
            <ul class="nav nav-pills nav-sidebar flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
              <li class="nav-item">
                <a href="<?= base_url() ?>" class="nav-link <?= $seg ? '' : 'active' ?> ">
                  <i class="nav-icon fa fa-desktop"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('/user') ?>" class="nav-link <?= $seg == 'user' ? 'active' : '' ?> ">
                  <i class="nav-icon fa fa-desktop"></i>
                  <p>
                    User
                  </p>
                </a>
              </li>
              <li class="nav-item <?= $seg == 'materi' || $seg == 'submateri' ? 'menu-open menu-is-open' : '' ?>">
                <a href="#" class="nav-link ">
                  <i class="nav-icon fa fa-desktop"></i>
                  <p>
                    Materi
                    <i class="end fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="<?= base_url('materi') ?>" class="nav-link <?= $seg == 'materi' ? 'active' : '' ?>">
                      <i class="nav-icon far fa-circle"></i>
                      <p>Materi</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="<?= base_url('subMateri') ?>" class="nav-link <?= $seg == 'subMateri' ? 'active' : '' ?>">
                      <i class="nav-icon far fa-circle"></i>
                      <p>Sub Materi</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('soal') ?>" class="nav-link <?= $seg == 'soal' ? 'active' : '' ?>">
                  <i class="nav-icon fa fa-desktop"></i>
                  <p>Soal</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?= base_url('hasilKuesioner') ?>" class="nav-link <?= $seg == 'hasilKuesioner' || $seg == 'hasilkuesioner' ? 'active' : '' ?> ">
                  <i class="nav-icon fa fa-desktop"></i>
                  <p>
                    Hasil Kuesioner
                  </p>
                </a>
              </li>
          </nav>
        </div>
        <!-- /.sidebar -->
      </aside>