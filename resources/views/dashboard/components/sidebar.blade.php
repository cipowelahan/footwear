<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MENU UTAMA</li>
      <li class="active"><a href="{{url('dashboard/main')}}" route="menu"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-archive"></i> <span>Master Data</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('dashboard/master/supplier')}}" route="menu"><i class="fa fa-circle-o"></i>Supplier</a></li>
          <li><a href="{{url('dashboard/master/produk')}}" route="menu"><i class="fa fa-circle-o"></i>Produk</a></li>
          <li><a href="{{url('dashboard/master/produkkategori')}}" route="menu"><i class="fa fa-circle-o"></i>Kategori Produk</a></li>
          <li><a href="{{url('dashboard/master/assetkategori')}}" route="menu"><i class="fa fa-circle-o"></i>Kategori Asset</a></li>
          <li><a href="{{url('dashboard/master/kaskategori')}}" route="menu"><i class="fa fa-circle-o"></i>Kategori Kas</a></li>
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
          <li><a href="{{url('dashboard/transaksi/penjualan')}}" route="menu"><i class="fa fa-circle-o"></i>Penjualan</a></li>
          <li><a href="{{url('dashboard/transaksi/pembelian')}}" route="menu"><i class="fa fa-circle-o"></i>Pembelian</a></li>
          <li><a href="{{url('dashboard/transaksi/riwayat')}}" route="menu"><i class="fa fa-circle-o"></i>Riwayat</a></li>
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
          <li><a href="{{url('dashboard/kas/asset')}}" route="menu"><i class="fa fa-circle-o"></i>Asset</a></li>
          <li><a href="{{url('dashboard/kas/kas')}}" route="menu"><i class="fa fa-circle-o"></i>Kas</a></li>
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
          <li><a href="{{url('dashboard/kas/keuangan')}}" route="menu"><i class="fa fa-circle-o"></i>Laporan Kas</a></li>
          <li><a href="{{url('dashboard/laporan/buku-besar')}}" route="menu"><i class="fa fa-circle-o"></i>Buku Besar</a></li>
          <li><a href="{{url('dashboard/laporan/laba-rugi')}}" route="menu"><i class="fa fa-circle-o"></i>Laba Rugi</a></li>
          <li><a href="{{url('dashboard/laporan/perubahan-ekuitas')}}" route="menu"><i class="fa fa-circle-o"></i>Perubahan Ekuitas</a></li>
          <li><a href="{{url('dashboard/laporan/neraca')}}" route="menu"><i class="fa fa-circle-o"></i>Neraca</a></li>
          <li><a href="{{url('dashboard/laporan/persediaan')}}" route="menu"><i class="fa fa-circle-o"></i>Laporan Persediaan</a></li>
          <li><a href="{{url('dashboard/laporan/pembelian')}}" route="menu"><i class="fa fa-circle-o"></i>Laporan Pembelian</a></li>
          <li><a href="{{url('dashboard/laporan/penjualan')}}" route="menu"><i class="fa fa-circle-o"></i>Laporan Penjualan</a></li>
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
          <li><a href="{{url('dashboard/user')}}" route="menu"><i class="fa fa-circle-o"></i>Users</a></li>
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
