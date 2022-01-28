<nav class="pcoded-navbar">
    <div class="nav-list">
        <div class="pcoded-inner-navbar main-menu">
            {{-- master --}}
            <div class="pcoded-navigation-label">Master</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ Request::segment(1) == 'dashboard' ? 'active' : '' }}">
                    <a href="{{ url('dashboard') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="feather icon-home"></i>
                        </span>
                        <span class="pcoded-mtext">Dashboard</span>
                    </a>
                </li>
            </ul>
            {{-- end master --}}


            {{-- hls --}}
            {{--  <div class="pcoded-navigation-label">HLS</div>
            <ul class="pcoded-item pcoded-left-item">
                <li class="{{ Request::segment(2) == 'master-hls' ? 'active' : '' }}">
                    <a href="{{ url('hls/master-hls') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-database"></i>
                        </span>
                        <span class="pcoded-mtext">Master HLS</span>
                    </a>
                </li>

                <li class="{{ Request::segment(2) == 'faktor-koreksi-pesantren' ? 'active' : '' }}">
                    <a href="{{ url('hls/faktor-koreksi-pesantren') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-database"></i>
                        </span>
                        <span class="pcoded-mtext">Faktor Koreksi Pesantren</span>
                    </a>
                </li>

                <li class="{{ Request::segment(2) == 'hitung-hls' ? 'active' : '' }}">
                    <a href="{{ url('hls/hitung-hls') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-calculator"></i>
                        </span>
                        <span class="pcoded-mtext">Hitung HLS</span>
                    </a>
                </li>

            </ul>  --}}
            {{-- end hls --}}
            
        </div>
    </div>
</nav>
