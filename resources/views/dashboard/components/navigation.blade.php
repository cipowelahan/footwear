<header class="main-header">
  <!-- Logo -->
  <a href="" class="logo">
    <span class="logo-mini"><b>EFW</b></span>
    <span class="logo-lg" style="font-size: 16px"><b>ENDAR FOOT WEAR</b></span>
  </a>

  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        {{-- <li class="dropdown">
          <a href="{{route('homepage')}}">
            <i class="fa fa-globe"></i>
            Kunjungi Situs  
          </a>
        </li> --}}
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img id="profil-foto-head" src="{{asset('public/'.auth()->user()->foto)}}" class="user-image" alt="User Image">
              <span class="hidden-xs" id="profil-head">{{auth()->user()->nama}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img id="profil-foto" src="{{asset('public/'.auth()->user()->foto)}}" class="img-circle" alt="User Image">
                <p>
                  <span id="profil-nama">{{auth()->user()->nama}}</span> <br>
                  <span id="profil-username">{{auth()->user()->username}}</span> <br>
                </p>
              </li>
              <!-- Menu Body -->
              {{-- <li class="user-body">
                <div class="row">
                  <div class="col-xs-4 text-center">
                    <a href="#">Followers</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Sales</a>
                  </div>
                  <div class="col-xs-4 text-center">
                    <a href="#">Friends</a>
                  </div>
                </div>
                <!-- /.row -->
              </li> --}}
              <!-- Menu Footer-->
              <li class="user-footer">
                {{-- <div class="pull-left">
                  <a href="#" class="btn btn-default btn-flat">Profile</a>
                </div> --}}
                <div class="pull-right">
                  <a href="{{route('logout')}}" class="btn btn-default btn-flat">Logout</a>
                </div>
              </li>
            </ul>
          </li>
      </ul>
    </div>
  </nav>
</header>
