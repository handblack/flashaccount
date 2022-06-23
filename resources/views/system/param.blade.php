@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <h1>&nbsp;&nbsp;<i class="fas fa-tools"></i> {{ !empty($title) ? $title : 'SIN_TITULO_3' }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Sistema</li>
                        <li class="breadcrumb-item">{{ !empty($title) ? $title : 'SIN_TITULO_3' }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('container')


    <div class="card card-primary card-outline">
        <div class="card-header">
            <div class="card-tools" style="float:left;">
                <form action="{{ route('parameter.index') }}" method="GET" style="margin:0px;padding:0px;">
                    @csrf
                    <div class="input-group input-group-sm" >
                        <select name="group_id" class="form-control" onchange="this.form.submit()">
                            @foreach ($grupos as $item)
                                <option value="{{ $item['id'] }}" {{ ($select_id == $item['id']) ? ' selected' : '' }}>{{ $item['name'] }} </option>
                            @endforeach
                        </select>
                        <input type="text" name="q" class="form-control float-right" id="q" placeholder="Buscar..." value="">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            <a href="{{ route('parameter.index') }}" class="btn btn-default"><i class="fas fa-sync"></i> Actualizar</a>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-tools">
                     <div class="input-group input-group-sm" >
                        <div class="input-group-append">
                            <a href="{{ route('parameter.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Nuevo </a>
                        </div>
                    </div>
            </div>
        </div>



        <div class="card-body table-responsive p-0">
            <table class="table table-hover table-valign-middle table-sm">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Identidad</th>
                        <th>Nombre Corto</th>
                        <th style="border-left:1px solid #dcdcdc;border-right:1px solid #dcdcdc;">Valor</th>
                        <th>Requerido</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($result as $item)
                        <tr>
                            <form action="{{ route('parameter.destroy',$item->id) }}" method="POST" style="margin:0px;padding:0px;" id="{{ $item->id }}">
                                @csrf
                                @method('DELETE')
                                <td width="100">{{ str_pad($item->id,3,'0',STR_PAD_LEFT) }}-{{ str_pad($item->group_id,2,'0',STR_PAD_LEFT) }}-{{ str_pad($item->orden,2,'0',STR_PAD_LEFT) }}</td>
                                <td>{{ $item->identity }}</td>
                                <td>{{ $item->shortname }}</td>
                                <td style="border-left:1px solid #dcdcdc;border-right:1px solid #dcdcdc;background-color: #f4f6f98c;">{{ $item->value }}</td>
                                <td width="80">{{ $item->isrequired }}</td>
                                <td width="80">{{ $item->isactive }}</td>
                                <td width="140" class="text-right">
                                    <a href="{{ route('parameter.edit',[md5($item->id)]) }}" class=""><i class="far fa-edit"></i> </a> |
                                    <a class="delete-user" href="javascript:vid()" id="{{ $item->id }}"><i class="far fa-trash-alt"></i> </a>
                                </td>

                            </form>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-header -->
    </div>


@endsection


@section('script')
<script>
    $('.delete-user').click(function(e){
        e.preventDefault()
        if (confirm('Estas seguro en eliminar?')) {
            let id = $(this).attr('id');
            $('#'+id).submit();
            //let tid = $(this).data("tr");
            //$('#' + tid).remove();
        }
    });
    @if(session('message'))
        toastr.success('{{session('message')}}')
    @endif

</script>
@endsection
