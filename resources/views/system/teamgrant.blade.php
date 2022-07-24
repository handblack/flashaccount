@extends('layouts.app')

@section('breadcrumb')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1>&nbsp;<i class="fas fa-users-cog"></i> Accesos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Sistema</li>
                    <li class="breadcrumb-item"><a href="{{ route('team.index') }}">Grupos &amp; Accesos</a></li>
                    <li class="breadcrumb-item">Accesos</li>
                </ol>
            </div>
        </div>
    </div>
</section>
@endsection

@section('container')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
            <h3 class="card-title"><strong>{{ $team->teamname }}</strong></h3>

            <div class="card-tools float-right">
                    <div class="input-group input-group-sm" style="width: 190px;">
                        <div class="input-group-append">
                            <a href="{{ route('teamgrant.index') }}" class="btn btn-default"><i class="fas fa-sync"></i> Actualizar</a>
                            <a href="{{ route('team.index') }}" class="btn btn-default"><i class="fas fa-arrow-circle-left"></i> Regresar </a>
                        </div>
                    </div>

            </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap table-sm table-borderless" data-toggle="dataTable" data-form="deleteForm">
                    <thead>
                    <tr>
                        <th>Modulo</th>
                        <th class="text-center">Acceso</th>
                        <th class="text-center">Crear</th>
                        <th class="text-center">Leer</th>
                        <th class="text-center">Modificar</th>
                        <th class="text-center">Eliminar</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($result as $item)
                            <form action="{{ route('teamgrant.update',$item->id) }}" method="POST" name="form-grant-{{ $item->id }}" id="form-grant-{{ $item->id }}">
                                @csrf
                                @method('put')
                                <tr>
                                    <td width="40%" style="border-right:1px solid #dcdcdc;text-transform: lowercase;">{{ $team->teamname }} <i class="fas fa-angle-double-right"></i> {{ $item->module }}</td>



                                    <td width="10%" class="text-center">
                                        <div class="custom-control custom-switch {{ ($item->isgrant == 'D')? '' : 'custom-switch-off-danger custom-switch-on-success' }}" style="padding-top:3px">
                                            <input type="checkbox" class="custom-control-input" name="isgrant" id="grant-{{ $item->id }}" {{ ($item->isgrant=='Y')? 'checked' : '' }} {{ ($item->isgrant == 'D') ? 'disabled' : '' }}>
                                            <label class="custom-control-label" for="grant-{{ $item->id }}"></label>
                                        </div>
                                    </td>
                                    <td width="10%" class="text-center">
                                        <div class="custom-control custom-switch {{ ($item->iscreate == 'D')? '' : 'custom-switch-off-danger custom-switch-on-success' }}" style="padding-top:3px">
                                            <input type="checkbox" class="custom-control-input" name="iscreate" id="create-{{ $item->id }}" {{ ($item->iscreate=='Y')? 'checked' : '' }} {{ ($item->iscreate == 'D') ? 'disabled' : '' }}>
                                            <label class="custom-control-label" for="create-{{ $item->id }}"></label>
                                        </div>
                                    </td>
                                    <td width="10%" class="text-center">
                                        <div class="custom-control custom-switch {{ ($item->isread == 'D')? '' : 'custom-switch-off-danger custom-switch-on-success' }}" style="padding-top:3px">
                                            <input type="checkbox" class="custom-control-input" name="isread" id="read-{{ $item->id }}" {{ ($item->isread=='Y')? 'checked' : '' }} {{ ($item->isread == 'D') ? 'disabled' : '' }}>
                                            <label class="custom-control-label" for="read-{{ $item->id }}"></label>
                                        </div>
                                    </td>
                                    <td width="10%" class="text-center">
                                        <div class="custom-control custom-switch {{ ($item->isupdate == 'D')? '' : 'custom-switch-off-danger custom-switch-on-success' }}" style="padding-top:3px">
                                            <input type="checkbox" class="custom-control-input" name="isupdate" id="update-{{ $item->id }}" {{ ($item->isupdate=='Y')? 'checked' : '' }} {{ ($item->isupdate == 'D') ? 'disabled' : '' }}>
                                            <label class="custom-control-label" for="update-{{ $item->id }}"></label>
                                        </div>
                                    </td>
                                    <td width="10%" class="text-center">
                                        <div class="custom-control custom-switch {{ ($item->isdelete == 'D')? '' : 'custom-switch-off-danger custom-switch-on-success' }}" style="padding-top:3px">
                                            <input type="checkbox" class="custom-control-input" name="isdelete" id="delete-{{ $item->id }}" {{ ($item->isdelete == 'Y')? 'checked' : '' }} {{ ($item->isdelete == 'D') ? 'disabled' : '' }}>
                                            <label class="custom-control-label disabled" for="delete-{{ $item->id }}"></label>
                                        </div>
                                    </td>
                                    <td  class="text-right">


                                        <button type="submit" class="btn btn-outline-primary btn-sm"><i class="fas fa-save"></i> Guardar</button>

                                    </td>
                                </tr>
                            </form>
                        @endforeach
                    </tbody>

                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer pb-1 pt-1">
                <div class="row">
                    <div class="col-md-12">
                        <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse: collapse;">
                            <tr>
                                <td>{{ count($result) }} - Registro(s)</td>
                                <td class="float-right text-right">
                                    {{ $result->links('layouts.paginate') }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

        </div>
      <!-- /.card -->
    </div>
</div>

@endsection

 

@section('script')
<script>

$(document).on("submit", "form", function(event)
{
    event.preventDefault();
    $.ajax({
        url: $(this).attr("action"),
        type: $(this).attr("method"),
        dataType: "JSON",
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (data, status){
            toastr.success(data.message)
        },
        error: function (xhr, desc, err)
        {
            alert('error');

        }
    });
});
</script>
@endsection
