<div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
        aria-hidden="true" id="iconSidenav"></i>
    <a class="" href="#">
        {{-- <i style="font-size: 35px; color:aliceblue; height: 100px;"
            class="fas fa-biohazard navbar-brand-img h-100 mt-n2"></i> --}}
        <img src="{{ asset('assets/img/logojaver.png') }}" class="mt-n3 ms-n2"
            style="width:110px; height:110px; border-radius:150px;" alt="main_logo" style="">
        <span class="ms-n3 fw-bold font-weight-bold text-white ">Beyond Limits</span>
    </a>
</div>
<div class="collapse navbar-collapse  w-auto h-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
        <hr class="horizontal light mt-0">
        @can('permission_admin')
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#dashboardsExamples"
                    class="nav-link text-white {{ request()->routeIs('permissions.index', 'roles.index') ? 'active' : '' }}"
                    aria-controls="dashboardsExamples" role="button" aria-expanded="false">
                    <i class="fas fa-fingerprint"></i>
                    <span class="nav-link-text ms-2 ps-1">Roles y permisos</span>
                </a>

                <div class="collapse " id="dashboardsExamples">
                    <ul class="nav ">
                        @can('permission_admin')
                            <li class="nav-item ">
                                <a class="nav-link text-white {{ request()->routeIs('permissions.index') ? 'active bg-primary' : '' }}"
                                    href="{{ route('permissions.index') }}">
                                    <span class="sidenav-mini-icon"> P </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Permisos </span>
                                </a>
                            </li>
                        @endcan
                        @can('role_admin')
                            <li class="nav-item ">
                                <a class="nav-link text-white {{ request()->routeIs('roles.index') ? 'active bg-primary' : '' }}"
                                    href="{{ route('roles.index') }}">
                                    <span class="sidenav-mini-icon"> R </span>
                                    <span class="sidenav-normal  ms-2  ps-1"> Roles </span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
            </li>
        @endcan
        @can('user_admin')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('users.index') ? 'active bg-primary' : '' }}"
                    href="{{ route('users.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-user-lock"></i>
                    </div>
                    <span class="nav-link-text ms-2 ps-1">Usuarios</span>
                </a>
            </li>
        @endcan
        {{-- <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('crud.index') ? 'active bg-primary' : '' }}"
                href="{{ route('crud.index') }}">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="material-icons opacity-10">table_view</i>
                </div>
                <span class="nav-link-text ms-2 ps-1">Crud</span>
            </a>
        </li> --}}
        @can('materia_admin')
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('materias.index') ? 'active bg-primary' : '' }}"
                    href="{{ route('materias.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="fas fa-book"></i>
                    </div>
                    <span class="nav-link-text ms-2 ps-1">Materias</span>
                </a>
            </li>
        @endcan
        <li class="nav-item">
            <a data-bs-toggle="collapse" href="#selecAnidado"
                class="nav-link text-white {{ request()->routeIs('departamentos.index', 'ciudades.index', 'barrios.index', 'direcciones.index') ? 'active' : '' }}"
                aria-controls="selecAnidado" role="button" aria-expanded="false">
                <i class="fas fa-unlock"></i>
                <span class="nav-link-text ms-2 ps-1">Select anidado</span>
            </a>
            <div class="collapse " id="selecAnidado">
                <ul class="nav ">
                    <li class="nav-item ">
                        <a class="nav-link text-white {{ request()->routeIs('departamentos.index') ? 'active bg-primary' : '' }}"
                            href="{{ route('departamentos.index') }}">
                            <span class="sidenav-mini-icon"> D </span>
                            <span class="sidenav-normal  ms-2  ps-1"> Departamentos </span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link text-white {{ request()->routeIs('ciudades.index') ? 'active bg-primary' : '' }}"
                            href="{{ route('ciudades.index') }}">
                            <span class="sidenav-mini-icon"> C </span>
                            <span class="sidenav-normal  ms-2  ps-1"> Ciuadades </span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link text-white {{ request()->routeIs('barrios.index') ? 'active bg-primary' : '' }}"
                            href="{{ route('barrios.index') }}">
                            <span class="sidenav-mini-icon"> B </span>
                            <span class="sidenav-normal  ms-2  ps-1"> Barrios </span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link text-white {{ request()->routeIs('direcciones.index') ? 'active bg-primary' : '' }}"
                            href="{{ route('direcciones.index') }}">
                            <span class="sidenav-mini-icon"> D </span>
                            <span class="sidenav-normal  ms-2  ps-1"> Direcciones </span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('horarios.index') ? 'active bg-primary' : '' }}"
                href="{{ route('horarios.index') }}">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="far fa-calendar-alt"></i>
                </div>
                <span class="nav-link-text ms-2 ps-1">Horario</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('libros.index') ? 'active bg-primary' : '' }}"
                href="{{ route('libros.index') }}">
                <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                    <i class="fas fa-journal-whills"></i>
                </div>
                <span class="nav-link-text ms-2 ps-1">Libros</span>
            </a>
        </li>
        <li class="nav-item mt-3">
            <h6 class="ps-4  ms-2 text-uppercase text-xs font-weight-bolder text-white">PAGES</h6>
        </li>
        <li class="nav-item">
            <a data-bs-toggle="collapse" href="datatables.html#ecommerceExamples" class="nav-link text-white "
                aria-controls="ecommerceExamples" role="button" aria-expanded="false">
                <i
                    class="material-icons-round {% if page.brand == 'RTL' %}ms-2{% else %} me-2{% endif %}">shopping_basket</i>
                <span class="nav-link-text ms-2 ps-1">Ecommerce</span>
            </a>
            <div class="collapse " id="ecommerceExamples">
                <ul class="nav ">
                    <li class="nav-item ">
                        <a class="nav-link text-white " href="../ecommerce/referral.html">
                            <span class="sidenav-mini-icon"> R </span>
                            <span class="sidenav-normal  ms-2  ps-1"> Referral </span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>
