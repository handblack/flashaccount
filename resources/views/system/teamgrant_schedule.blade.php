@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header pb-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <h1><i class="far fa-clock fa-fw"></i> Horarios de accesos</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Sistema</li>
                        <li class="breadcrumb-item"><a href="{{ route('team.index') }}">Grupos &amp; Accesos</a></li>
                        <li class="breadcrumb-item">Horarios de accesos</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('style')
<style>    
table {
   border-spacing: 0;
   border-collapse: collapse;
   overflow: hidden;
   background-color: transparent;
}

td, th {
   padding: 2px;
   position: relative;
}

tr:hover{
   background-color: rgba(0, 68, 255, 0.376);
}

td:hover::after { 
   background-color: rgba(0, 68, 255, 0.376);
   content: '\00a0';  
   height: 10000px;    
   left: 0;
   position: absolute;  
   top: -5000px;
   width: 100%;   
}

</style>    
@endsection

@section('container')
<div class="card">
    <div class="card-header">        
        <h5 class="card-title">{{ $row->teamname }}</h5>
    </div>
    <div class="card-body table-responsive">
   
        <div class="col-md-12">
            <table>
                
                <tr class="border-bottom">
                    <th class="border-right"></th>
                    @foreach ($horas as $h )
                        <th class="text-midle">
                            <a href="#">
                                {{ str_pad($h,2,'0',STR_PAD_LEFT) }}
                            </a>
                        </th>
                    @endforeach
                    
                </tr>
                @foreach ($semanas as $s)
                    <tr>
                        <th class="border-right">
                            <span class="pl-2 pr-2">
                                <a href="#">
                                    {{ $weekname[$s] }}
                                </a>
                            </span>
                        </th>
                        @foreach ($horas as $h )
                            <td class="text-center">                              
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input custom-control-input-success" type="checkbox" id="customCheckbox-{{ $s }}-{{ $h }}" checked="">
                                    <label for="customCheckbox-{{ $s }}-{{ $h }}" class="custom-control-label"></label>
                                </div>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
     
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="float-right">
            <a href="{{ route('team.index') }}" class="btn btn-default"> <i class="fas fa-times"></i> Cancelar</a>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
        </div>
    </div>
</div>

@endsection

 