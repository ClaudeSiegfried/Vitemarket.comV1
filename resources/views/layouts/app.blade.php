<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">

        <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

        @notifyCss

        <!-- Scripts -->

        <script src="{{ asset('js/app.js') }}" defer></script>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <script src="{{ asset('custom/js/bootstrap-select/bootstrap-select.min.js') }}" defer></script>

        <link href="{{ asset('custom/css/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet">

        <script src="{{ asset('custom/DataTables/js/jquery.dataTables.js') }}" defer></script>

        <link href="{{ asset('custom/DataTables/css/jquery.dataTables.css') }}" rel="stylesheet">

        <script src="{{ asset('custom/DataTables/js/dataTables.bootstrap4.js') }}" defer></script>

        <script src="{{ asset('custom/js/datatables/autoFill.bootstrap.min.js') }}" defer></script>

        <script src="{{ asset('custom/js/datatables/dataTables.autoFill.js') }}" defer></script>

        <script src="{{ asset('custom/js/datatables/dataTables.responsive.min.js') }}" defer></script>

        <script src="{{ asset('custom/js/datatables/dataTables.select.min.js') }}" defer></script>

        <script src="{{ asset('custom/js/datatables/searchPanes.bootstrap4.min.js') }}" defer></script>

        <link href="{{ asset('custom/css/datatables/autoFill.bootstrap4.min.css') }}" rel="stylesheet">

        <link href="{{ asset('custom/css/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet">

        <link href="{{ asset('custom/css/datatables/searchPanes.bootstrap4.min.css') }}" rel="stylesheet">

        <link href="{{ asset('custom/css/datatables/select.bootstrap4.css') }}" rel="stylesheet">


        <link href="{{ asset('custom/css/styles.css') }}" rel="stylesheet">

        <link href="{{ asset('custom/css/Personnal.css') }}" rel="stylesheet">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"
                crossorigin="anonymous"></script>


    </head>

    <body class="sb-nav-fixed">

        <nav class="sb-topnav navbar navbar-expand navbar-light bg-transparent fixed-top">

            <a class="navbar-brand" href="{{ url('/home') }}">
                {{ config('app.name', 'Laravel') }}
            </a>

            <button class="btn btn-link btn-sm order-1 order-lg-0 m-lg-n4" id="sidebarToggle" href="#">
                <i class="fas fa-bars"></i>
            </button>

            <ul class="navbar-nav ml-auto">

                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle"
                           id="userDropdown"
                           href="#"
                           role="button"
                           data-toggle="dropdown"
                           aria-haspopup="true"
                           aria-expanded="true">
                            <i class="fas fa-user fa-fw"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right " aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                        </div>
                    </li>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endguest
            </ul>

        </nav>

        <div id="layoutSidenav">
            <div id="Sidenav_nav" class="shadow">
                <div id="particles-js" class="position-absolute h-75">
                </div>
                <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
                    <div class="sb-sidenav-menu py-2">
                        <div class="nav">
                            <div class="sb-sidenav-menu-heading">Core</div>
                            <a class="nav-link" href="{{ route('home') }}">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                                Dashboard
                            </a>
                            <div class="sb-sidenav-menu-heading">Products Management</div>
                            <a class="nav-link" href="{{ route('produit.index') }}">
                                <div class="sb-nav-link-icon">
                                    <i class="fab fa-product-hunt"></i>
                                </div>
                                Products
                                <i class="sb-sidenav-collapse-arrow fas fa-angle-right"></i>
                            </a>
                            <a class="nav-link" href="{{ route('stock.index') }}">
                                <div class="sb-nav-link-icon">
                                    <i class="fab fa-sourcetree"></i>
                                </div>
                                Stocks
                            </a>
                            <a class="nav-link" href="{{ route('categorie.index') }}">
                                <div class="sb-nav-link-icon">
                                    <i class="fab fa-cuttlefish"></i>
                                </div>
                                Categories
                                <i class="sb-sidenav-collapse-arrow fas fa-angle-right"></i>
                            </a>
                            <a class="nav-link" href="{{ route('marque.index') }}">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-tachometer-alt"></i>
                                </div>
                                Marques
                                <i class="sb-sidenav-collapse-arrow fas fa-angle-right"></i>
                            </a>
                            <div class="sb-sidenav-menu-heading">stakeholders</div>
                            <a class="nav-link" href="{{ route('client.index') }}">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-people-carry"></i>
                                </div>
                                Clients
                                <i class="sb-sidenav-collapse-arrow fas fa-angle-right"></i>
                            </a>
                            <a class="nav-link" href="{{ route('fournisseur.index') }}">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-parachute-box"></i>
                                </div>
                                suppliers
                                <i class="sb-sidenav-collapse-arrow fas fa-angle-right"></i>
                            </a>
                            <a class="nav-link" href="{{ route('livreur.index') }}">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-truck"></i>
                                </div>
                                Deliverers
                                <i class="sb-sidenav-collapse-arrow fas fa-angle-right"></i>
                            </a>
                            <a class="nav-link" href="{{ route('admin.users.index') }}">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-users"></i>
                                </div>
                                users
                                <i class="sb-sidenav-collapse-arrow fas fa-angle-right"></i>
                            </a>
                            <div class="sb-sidenav-menu-heading">Order processing</div>
                            <a class="nav-link" href="#">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fas fa-weight-hanging"></i>
                                </div>
                                Orders
                                <i class="sb-sidenav-collapse-arrow fas fa-angle-right"></i>
                            </a>
                            <div class="sb-sidenav-menu-heading">Delivery System</div>
                            <a class="nav-link" href="#">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fas fa-dolly"></i>
                                </div>
                                Delivery
                                <i class="sb-sidenav-collapse-arrow fas fa-angle-right"></i>
                            </a>
                            <div class="sb-sidenav-menu-heading">Configuration</div>
                            <a class="nav-link" href="{{ route('mmoney.index') }}">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                Payment Providers
                            </a>
                            <a class="nav-link" href="#">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-users-cog"></i>
                                </div>
                                Administrator
                                <i class="sb-sidenav-collapse-arrow fas fa-angle-right"></i>
                            </a>
                        </div>
                    </div>
                    @auth
                        <div class="sb-sidenav-footer">
                            <div class="small">Logged in as:</div>

                            {{ Auth::user()->name }}

                        </div>
                    @endauth
                </nav>
            </div>
            <div id="layoutSidenav_content" class="{{--bg-secondary--}}">
                <main class="py-4 p-5 container">
                    <div class="container">
                        @include('partials.alert', ['data' => $data ?? ''])
                        @include('notify::messages')
                    </div>
                    @yield('content')
                </main>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
                integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
                crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
                integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
                crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="{{asset('custom/js/scripts.js')}}"></script>
        <script src="{{asset('custom/js/jquery.nicescroll.min.js')}}"></script>
        <script src="{{asset('custom/js/particles.js')}}"></script>
        <script>
            $("*").niceScroll(
                {
                    cursorwidth: "12px",
                    cursorcolor: "#cccccc",
                    hwacceleration: true,
                    bouncescroll: true,
                    enablemousewheel: true,
                }
            );
            $(".sb-sidenav-menu").niceScroll(
                {
                    cursorwidth: "12px",
                    cursorcolor: "#cccccc",
                    hwacceleration: true,
                    bouncescroll: true,
                    enablemousewheel: true,
                }
            );
        </script>
        <script>
            particlesJS.load('particles-js', '{{asset('custom/assets/json/particlesjsbuble-config.json')}}', function () {
                console.log('callback - particles.js config loaded');
            });
        </script>

        @yield('script')
        @notifyJs

    </body>

</html>
