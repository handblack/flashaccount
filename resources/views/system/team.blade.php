@extends('layouts.app')



@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('team.index') }}" title="Recargar">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>

                    <a class="btn btn-sm btn-success" href="{{ route('team.create') }}"
                        title="Marcar como página de inicio">
                        <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline-block">Añadir</span>
                    </a>
                    <div class="btn-group">
                        <div class="input-group input-group-sm">
                            <input class="form-control" type="text" name="query" value="" autocomplete="off"
                                placeholder="Buscar">
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="fas fa-search" aria-hidden="true"></i>
                                </button>
                            </span>
                        </div>
                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <h1 class="h4 mb-0 d-none d-md-inline-block">
                            Perfiles
                            &nbsp;<i class="fas fa-users-cog ml-3"></i>

                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



@section('container')
    <div class="card mb-2">
        <div class="card-body table-responsive p-0" >
            <table class="table table-hover text-nowrap table-sm table-borderless">
                <thead>
                    <tr class="bg-light">
                        <th>Equipo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($result as $item)
                        <tr id="tr-{{ $item->id }}">
                            <td class="" style="{{ $item->isactive == 'Y' ? '' : 'tachado' }}">
                                {{ $item->teamname }}
                            </td>
                            
                            <td class="text-right">
                                <a href="{{ route('teamgrant.show', $item->token) }}"> <i class="fas fa-key"></i>
                                    Acceso</a> |
                                <a href="{{ route('team.edit', [$item->token]) }}"> <i class="fas fa-edit"></i>
                                    Modificar</a> |
                                <a class="delete-record" data-url="{{ route('team.destroy', $item->token) }}"
                                    data-id="{{ $item->id }}"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12 pt-2">
            {{ $result->links('layouts.paginate') }}
        </div>
    </div>
@endsection


@section('script')
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.delete-record').click(function(e) {
                e.preventDefault()
                if (confirm('Estas seguro en eliminar?')) {
                    let id = $(this).data('id');
                    let url = $(this).data('url');
                    $.post(url, {
                            _method: 'delete'
                        })
                        .done(function(data) {
                            if (data.status == 100) {
                                $('#tr-' + id).remove();
                                toastr.success('Elemento eliminado');
                            } else {
                                toastr.error(data.message);
                            }
                        });
                }
            });
        });
    </script>
@endsection
