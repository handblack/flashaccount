@extends('layouts.home')


@section('style')
<style>    



</style>    
@endsection

@section('container')
<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <a class="navbar-brand" href="" onclick="location.reload();">
        <img src="{{ asset('images/AdminLTELogo.png') }}" width="30" height="30" class="align-top" alt="FacturaScripts"/>
        FacturaScripts 2022.06
    </a>
    <ul class="nav navbar-nav mr-auto"></ul>
    <ul class="navbar-nav flex-row ml-md-auto d-none d-md-flex">
        <li class="nav-item">
        </li>
    </ul>
</nav>
<div class="container">
    <br>
    <form action="{{ route('auth_login_form') }}" method="POST" class="form-signin">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="email"   id="floatingInputGrid" placeholder="name@example.com" value="{{ old('email') }}" name="email" required>
        <input type="password"  id="floatingInputGrid" placeholder="name@example.com" value="{{ old('email') }}" name="password" required>
        <button type="submit" >Go</button>
    </form>
</div>



@endsection



@section('script')
<script>

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
@endsection
