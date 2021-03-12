@extends('adminlte::master')

@inject('layoutHelper', \JeroenNoten\LaravelAdminLte\Helpers\LayoutHelper)

@if($layoutHelper->isLayoutTopnavEnabled())
    @php( $def_container_class = 'container' )
@else
    @php( $def_container_class = 'container-fluid' )
@endif

@section('adminlte_css')
    @stack('css')
    @yield('css')
    @notifyCss
    <link href="{{ asset('custom/css/styles.css') }}" rel="stylesheet">
    <link href="{{ asset('custom/css/Personnal.css') }}" rel="stylesheet">
    <link href="{{ asset('custom/css/MediaQuery_Sm.css') }}" rel="stylesheet">
    <link href="{{ asset('custom/css/datatables/responsive.dataTables.css') }}" rel="stylesheet">
    <link href="{{ asset('custom/css/datatables/datatables.min.css') }}" rel="stylesheet">
    <script src="{{ asset('custom/js/bootstrap-select/bootstrap-select.min.js') }}" defer></script>
    <link href="{{ asset('custom/css/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js"
            crossorigin="anonymous"></script>
@stop

@section('classes_body', $layoutHelper->makeBodyClasses())

@section('body_data', $layoutHelper->makeBodyData())

@section('body')
    @include('notify::messages')

    <div class="wrapper container-fluid">

        {{-- Top Navbar --}}
        @if($layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.navbar.navbar-layout-topnav')
        @else
            @include('adminlte::partials.navbar.navbar')
        @endif

        {{-- Left Main Sidebar --}}
        @if(!$layoutHelper->isLayoutTopnavEnabled())
            @include('adminlte::partials.sidebar.left-sidebar')
        @endif
        {{-- Content Wrapper --}}
        <div class="content-wrapper {{ config('adminlte.classes_content_wrapper') ?? '' }}">

            {{-- Content Header --}}
            <div class="content-header">
                <div class="{{ config('adminlte.classes_content_header') ?: $def_container_class }}">
                    @yield('content_header')
                </div>
            </div>

            {{-- Main Content --}}
            <div class="content p-3">
                <div class="{{ config('adminlte.classes_content') ?: $def_container_class }}">
                    @yield('content')
                </div>
            </div>

        </div>

        {{-- Footer --}}
        @hasSection('footer')
            @include('adminlte::partials.footer.footer')
        @endif

        {{-- Right Control Sidebar --}}
        @if(config('adminlte.right_sidebar'))
            @include('adminlte::partials.sidebar.right-sidebar')
        @endif

    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')
    @notifyJs
    <script src="{{asset('custom/js/scripts.js')}}"></script>
    <script src="{{asset('custom/js/jquery.nicescroll.min.js')}}"></script>
    <script src="{{asset('custom/js/particles.js')}}"></script>
    <script>
        particlesJS.load('particles-js', '{{asset('custom/assets/json/particlesjsbuble-config.json')}}', function () {
            //console.log('callback - particles.js config loaded');
        });
    </script>
    <script type="text/javascript">

        $(document).ready(function () {
            var table = $('#tableau').DataTable({
                scrollY: 400,
                select: true,
                fixedHeader: true,
                searching: true,
                ordering: true,
                responsive: true,
                processing: true,
            });

            $('#tableau tbody').on( 'click', 'tr', function () {
                console.log( table.row( this ).data() );
            } );

            $.extend($.fn.dataTable.defaults, {
                searching: true,
                ordering: true,
                responsive: true,
                processing: true,
            });
        });
    </script>
    <script src="{{asset('custom/js/datatables/datatables.js')}}"
            crossorigin="anonymous"></script>
    <script src="{{asset('custom/js/datatables/dataTables.responsive.js')}}"
            crossorigin="anonymous"></script>
    <script src="{{asset('custom/js/datatables/dataTables.searchPanes.js')}}"
            crossorigin="anonymous"></script>
    <script src="{{asset('custom/js/datatables/autoFill.bootstrap.js')}}"
            crossorigin="anonymous"></script>

@stop
