<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="notranslate" translate="no">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google" content="notranslate" />
    <meta name="mobile-web-app-capable" content="yes">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('/plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/plugins/sweetalert2/sweetalert2.min.css') }}">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body>
    @yield('container')
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
@if (\Session::has('error'))
    toastr.error('{{ session('error') }}');
@endif

@if (\Session::has('message'))
    toastr.success('{{ session('message') }}');
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
        toastr.error('{{ $error }}');
    @endforeach
@endif
$(function(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.delete-record').click(function(e){
        e.preventDefault()
        if (confirm('Estas seguro en eliminar?')) {
            let id = $(this).data('id');
            let url = $(this).data('url');
            $.post(url,{_method:'delete'})
            .done(function(data){
                if(data.status == 100){
                    $('#tr-'+id).remove();
                    toastr.success('Elemento eliminado');
                }else{
                    toastr.error(data.message);
                }
            });
        }
    });
});
</script>
@yield('script')
</body>