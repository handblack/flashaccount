@extends('layouts.app')

@section('container')
<form action="{{ route('auth_login_form') }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="text" name="email" required>
    <input type="text" name="password">
    <button type="submit">Go</button>
</form>
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
