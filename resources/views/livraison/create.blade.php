@extends('adminlte::page')

@section('content')
    @include('partials.PreviousButton')


@stop

@section('js')
    <script>
        $('#photo_id').change(function (event) {
            var TempImg = URL.createObjectURL(event.target.files[0]);
            localStorage.setItem('TempImg', URL.createObjectURL(event.target.files[0]));
            $(".upload-btn").fadeIn("fast").css('background-image', "url(" + TempImg + ")");
            $("label[for='photo_id']").hide();
            console.log(URL.createObjectURL(event.target.files[0]));
        });


    </script>
@stop
