<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PUSKOGAP | SATPOL PP</title>
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
      integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO"
      crossorigin="anonymous"
    />    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />    
    <link rel="stylesheet" href="{{ asset('') }}css/select2.min.css" />
    <link rel="stylesheet" href="{{ asset('') }}vendor/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" />
    <link rel="stylesheet" href="{{ asset('') }}vendor/sweetalert-master/dist/sweetalert.css" />
    <link rel="stylesheet" href="{{ asset('') }}css/custom.css" />

</head>
<body>
    <div class="container custom">
        <nav class="navbar navbar-expand-lg py-3 navbar-light mt-4">
            <div class="container custom">

                <a class="navbar-brand font-weight-bold" href="#"><img src="{{ asset('') }}png/satpol-pp.png" width="40px" class="mr-2" alt=""> PUSKOGAP</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}" href="{{url('/dashboard')}}"><span class="fa fa-home mr-1"></span> Dashboard <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::segment(2) == 'jadwal' ? 'active' : '' }}" href="{{url('penugasan/jadwal')}}"><span class="fa fa-calendar mr-1"></span> Schedule</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::segment(1) == 'penugasan' && Request::segment(2) != 'jadwal' ? 'active' : '' }}" href="{{url('penugasan')}}"><span class="fa fa-car mr-1"></span> Penugasan</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="fa fa-database"></span> Data Master
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      <a class="dropdown-item" href="{{ route('anggota.index') }}">Master Anggota</a>
                      <a class="dropdown-item" href="{{ route('user.index') }}">Master User</a>
                      <a class="dropdown-item" href="{{ route('jenis-kegiatan.index') }}">Master Jenis Kegiatan</a>
                      <a class="dropdown-item" href="{{ route('jabatan.index') }}">Master Jabatan</a>
                      <a class="dropdown-item" href="{{ route('golongan.index') }}">Master Golongan</a>
                      <a class="dropdown-item" href="{{ route('unit-kerja.index') }}">Master Unit Kerja</a>
                      <a class="dropdown-item" href="{{ route('kompetensi-khusus.index') }}">Master Kompetensi Khusus</a>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <span class="fa fa-user"></span> User
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                      {{-- <a class="dropdown-item" href="{{ url('logout') }}">Logout</a> --}}
                      <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                    </div>
                  </li>
            </ul>
        </div>
    </div>
    </nav> 
    <div class="box-content px-3 py-4 my-4">
        <div class="container cusutom">

            <div class="row row-breadcrumbs align-items-center">
                <div class="col-md-6">
                    <h5>
                        <a @if(Request::segment(1)!='dashboard') onclick="window.history.back()" @endif>
                            @if(Request::segment(1)!='dashboard') <span class="fa fa-arrow-left mr-3 btn-rgb-primary fa-sm p-2 "></span> @endif </span> 
                        </a>
                        {{ ucwords(Request::segment(1)) }}</h5>
                </div>
                <div class="col-md-6 text-right">
                    <h6>{{ ucwords(Request::segment(1)) }} / {{$pageTitle}}</h6>
                </div>
            </div>
            <hr class="mt-4">
            @yield('content')
        </div>
    </div>   
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="https://unpkg.com/popper.js@1.12.8/dist/umd/popper.min.js"></script>
<script src="https://unpkg.com/tooltip.js@1.3.1/dist/umd/tooltip.min.js"></script>
<script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
      integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
      crossorigin="anonymous"
  ></script>
<script src="{{ asset('') }}vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<script src="{{ asset('') }}vendor/sweetalert-master/dist/sweetalert.min.js"></script>
<script src="{{ asset('') }}js/select2.full.min.js"></script>

<script>
    // $(document).ready(function(){
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        $(".select2").select2()
        $(".datepicker").datepicker();
    // })
</script>
@stack('custom-script')
</body>
</html>