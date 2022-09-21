<nav style="background-color: rgb(255, 251, 247)"
    class="navbar navbar-main navbar-expand-lg px-0 mx-4 mt-4 shadow-none border-radius-xl" id="navbarBlur"
    navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Software</a></li>
                <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Solutions</li>
            </ol>
            <h6 class="font-weight-bolder mb-0">&copy; Javier Spinoza</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group input-group-outline">
                    <label id="reloj" class="form-label reloj"></label>
                    <input type="text" disabled class="form-control">
                </div>
            </div>
            <ul class="navbar-nav  justify-content-end">

                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-user cursor-pointer me-sm-1"></i>
                        <span class="d-sm-inline d-none">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                        aria-labelledby="dropdownMenuButton">
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="{{ asset('assets/img/team-2.jpg') }}"
                                            class="avatar avatar-sm  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <h5 class="font-weight-bold">Bienvenido!</h5>
                                        </h6>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2 border-radius-md" href="javascript:;">
                            <a class="border-radius-md">
                                <div class="d-flex py-1 mb-n4">
                                    <a href="#" class="btn btn-light btn-sm btn-lg w-100 ml-3">Ver perfil</a>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2 border-radius-md" href="javascript:;">
                            <a class="border-radius-md">
                                <div class="py-1 mb-n4">
                                    <form method="POST" action="{{ route('logout') }}" class="form-horizontal">
                                        @csrf
                                        <div class="d-grid gap-2">
                                            <a class="btn btn-light btn-sm btn-lg w-100 ml-3"
                                                href="{{ route('logout') }}" onclick="event.preventDefault();
                                                this.closest('form').submit();"> <i style="font-size: 19px"
                                                    class="ni ni-user-run"></i> {{ __('Cerrar sesión') }}
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                            <i class="sidenav-toggler-line"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item px-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-body p-0">
                        <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                    </a>
                </li>
                <li class="nav-item dropdown pe-2 d-flex align-items-center ">
                    <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i style="font-size: 19px" class="fa fa-bell cursor-pointer"></i>
                    </a>
                    @if (count(auth()->user()->unreadNotifications))
                        <span
                            class="position-absolute top-5 start-100 translate-middle badge rounded-pill bg-danger border border-white small py-1 px-2">
                            <span class="small">
                                <span class="small">
                                    {{-- <div wire:poll.5000ms> --}}
                                    {{ count(auth()->user()->unreadNotifications) }}
                                    {{-- </div> --}}
                                </span>
                            </span>
                            <span class="visually-hidden">unread notifications</span>
                        </span>
                    @endif
                    <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4 scroll-notifi"
                        aria-labelledby="dropdownMenuButton">
                        <h6>Notificaciones sin leer</h6>
                        @forelse (auth()->user()->unreadNotifications as $notification)
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="javascript:;">
                                    <div class="d-flex py-1">
                                        <div class="my-auto me-2">
                                            <span style="font-size: 25px" class="material-icons">email</span>
                                            {{-- <img src="{{ asset('assets/img/team-2.jpg') }}"
                                            class="avatar avatar-sm  me-3 "> --}}
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                <span style="font-size: 12px"
                                                    class="font-weight-bold">{{ $notification->data['sms'] }}</span>
                                                {{ $notification->data['nombre'] }}
                                            </h6>
                                            <p class="text-xs text-secondary mb-0">
                                                <i class="fa fa-clock me-1"></i>
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <label for="">sin notificaciones sin leer</label>
                        @endforelse
                        <div class="dropdown-divider"></div>
                        <h6>Notificaciones leidas</h6>
                        @forelse (auth()->user()->readNotifications as $notification)
                            <li class="mb-2">
                                <a class="dropdown-item border-radius-md" href="javascript:;">
                                    <div class="d-flex py-1">
                                        <div class="my-auto me-2">
                                            <span style="font-size: 25px" class="material-icons">email</span>
                                            {{-- <img src="{{ asset('assets/img/team-2.jpg') }}"
                                        class="avatar avatar-sm  me-3 "> --}}
                                        </div>
                                        <div class="d-flex flex-column justify-content-center">
                                            <h6 class="text-sm font-weight-normal mb-1">
                                                <span style="font-size: 12px"
                                                    class="font-weight-bold">{{ $notification->data['sms'] }}
                                                </span>
                                                {{ $notification->data['nombre'] }}
                                            </h6>
                                            <p class="text-xs text-secondary mb-0">
                                                <i class="fa fa-clock me-1"></i>
                                                {{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        @empty
                            <label for="">sin notificaciones leidas</label>
                        @endforelse
                        <div class="text-center mt-4">
                            <a href="{{ route('markAsReadNotifications') }}" class="fs-6 fw-bold">Marcar
                                notificaciones como leidas</a>
                        </div>
                        {{-- <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="{{ asset('assets/img/team-2.jpg') }}"
                                            class="avatar avatar-sm  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">New message</span> from Laur
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            13 minutes ago
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="mb-2">
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="my-auto">
                                        <img src="{{ asset('assets/img/small-logos/logo-spotify.svg') }}"
                                            class="avatar avatar-sm bg-gradient-dark  me-3 ">
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            <span class="font-weight-bold">New album</span> by Travis Scott
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            1 day
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item border-radius-md" href="javascript:;">
                                <div class="d-flex py-1">
                                    <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                                        <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <title>credit-card</title>
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <g transform="translate(-2169.000000, -745.000000)" fill="#FFFFFF"
                                                    fill-rule="nonzero">
                                                    <g transform="translate(1716.000000, 291.000000)">
                                                        <g transform="translate(453.000000, 454.000000)">
                                                            <path class="color-background"
                                                                d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                                                opacity="0.593633743"></path>
                                                            <path class="color-background"
                                                                d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z">
                                                            </path>
                                                        </g>
                                                    </g>
                                                </g>
                                            </g>
                                        </svg>
                                    </div>
                                    <div class="d-flex flex-column justify-content-center">
                                        <h6 class="text-sm font-weight-normal mb-1">
                                            Payment successfully completed
                                        </h6>
                                        <p class="text-xs text-secondary mb-0">
                                            <i class="fa fa-clock me-1"></i>
                                            2 days
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li> --}}
                    </ul>
                </li>






            </ul>
        </div>
    </div>
</nav>

<script>
    function actual() {
        fecha = new Date(); //Actualizar fecha.
        hora = fecha.getHours(); //hora actual
        minuto = fecha.getMinutes(); //minuto actual
        segundo = fecha.getSeconds(); //segundo actual
        if (hora < 10) { //dos cifras para la hora
            hora = "0" + hora;
        }
        if (minuto < 10) { //dos cifras para el minuto
            minuto = "0" + minuto;
        }
        if (segundo < 10) { //dos cifras para el segundo
            segundo = "0" + segundo;
        }
        //devolver los datos:
        mireloj = hora + " : " + minuto + " : " + segundo;
        return mireloj;
    }

    function actualizar() { //función del temporizador
        mihora = actual(); //recoger hora actual
        mireloj = document.getElementById("reloj"); //buscar elemento reloj
        mireloj.innerHTML = mihora; //incluir hora en elemento
    }
    setInterval(actualizar, 1000); //iniciar temporizador
</script>
