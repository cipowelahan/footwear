<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MENU UTAMA</li>
      <li><a href="{{url('dashboard/main')}}" route="menu"><i class="fa fa-home"></i> <span>Halaman Utama</span></a></li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-archive"></i> <span>Master Data</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('dashboard/loker')}}" route="menu"><i class="fa fa-circle-o"></i>Manage Data</a></li>
          <li><a href="{{url('dashboard/loker/kota')}}" route="menu"><i class="fa fa-circle-o"></i>Kota</a></li>
          <li><a href="{{url('dashboard/loker/jenis')}}" route="menu"><i class="fa fa-circle-o"></i>Jenis</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-shopping-cart"></i> <span>Transaksi</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('dashboard/pencarikerja')}}" route="menu"><i class="fa fa-circle-o"></i>Manage Data</a></li>
          <li><a href="{{url('dashboard/pencarikerja/download')}}" route="menu"><i class="fa fa-circle-o"></i>Download Data</a></li>
          <li><a href="{{url('dashboard/pencarikerja/send-message')}}" route="menu"><i class="fa fa-circle-o"></i>Kirim SMS</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-money"></i> <span>Kas</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('dashboard/kontak/bukutamu')}}" route="menu"><i class="fa fa-circle-o"></i>Buku Tamu</a></li>
          <li><a href="{{url('dashboard/kontak/pengaduan')}}" route="menu"><i class="fa fa-circle-o"></i>Pengaduan</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-book"></i> <span>Laporan</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('dashboard/karyawan')}}" route="menu"><i class="fa fa-circle-o"></i>Manage Data</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-user"></i> <span>Profil</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('dashboard/profil')}}" route="menu"><i class="fa fa-circle-o"></i>Ubah Profil</a></li>
          <li><a href="{{url('dashboard/profil/password')}}" route="menu"><i class="fa fa-circle-o"></i>Ubah Kata Sandi</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-users"></i> <span>Users</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('dashboard/user/role')}}" route="menu"><i class="fa fa-circle-o"></i>Roles</a></li>
          <li><a href="{{url('dashboard/user')}}" route="menu"><i class="fa fa-circle-o"></i>Users</a></li>
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
