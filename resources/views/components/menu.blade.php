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


            <div class="pcoded-navigation-label">Data Master</div>
            <ul class="pcoded-item pcoded-left-item">
                <!-- Golongan ---!>
                <li class="{{ Request::segment(1) == 'golongan' ? 'active' : '' }}">
                    <a href="{{ route('golongan.index') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-database"></i>
                        </span>
                        <span class="pcoded-mtext">Golongan</span>
                    </a>
                </li>
                <!-- End Golongan ---!>
                <!-- Jabatan ---!>
                <li class="{{ Request::segment(1) == 'jabatan' ? 'active' : '' }}">
                    <a href="{{ route('jabatan.index') }}" class="waves-effect waves-dark">
                        <span class="pcoded-micon">
                            <i class="fa fa-database"></i>
                        </span>
                        <span class="pcoded-mtext">Jabatan</span>
                    </a>
                </li>
                <!-- End Jabatan ---!>
                <!-- Unit Kerja ---!>
                    <li class="{{ Request::segment(1) == 'unit-kerja' ? 'active' : '' }}">
                        <a href="{{ route('unit-kerja.index') }}" class="waves-effect waves-dark">
                            <span class="pcoded-micon">
                                <i class="fa fa-database"></i>
                            </span>
                            <span class="pcoded-mtext">Unit Kerja</span>
                        </a>
                    </li>
                <!-- End Unit Kerja ---!>
            </ul>
        </div>
    </div>
</nav>
