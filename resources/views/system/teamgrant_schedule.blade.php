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

    <section class="content-header pt-1 pb-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('team.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a class="btn btn-sm btn-secondary" href="#" onclick="location.reload()" title="Recargar">
                            <i class="fas fa-redo fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline-block"> Actualizar</span>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6"></div>
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


<form action="{{ route('teamgrant.store') }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="team_id" value="{{ $team->id }}">
    <input type="hidden" name="token" value="{{ $team->token }}">
    <input type="hidden" name="mode" value="schedule-add">
    <div class="card">
        <div class="card-header">        
            <h5 class="card-title"><strong>{{ $team->teamname }}</strong></h5>
        </div>  
        <div class="card-body table-responsive">
            <div class="col-md-12">
                <table class="w-100">
                    
                    <tr class="border-bottom">
                        <th class="border-right"></th>
                        @foreach ($horas as $h )
                            <th class="text-midle">
                                <a href="#" 
                                    class="hora-head"                                    
                                    data-hora="hora-{{ str_pad($h,2,'0',STR_PAD_LEFT) }}"
                                    data-check="false">
                                    {{ str_pad($h,2,'0',STR_PAD_LEFT) }}
                                </a>
                            </th>
                        @endforeach
                        
                    </tr>
                    @foreach ($semanas as $s)
                        <tr>
                            <th class="border-right">
                                <span class="pl-2 pr-2">
                                    <a href="#"
                                        class="week-head"
                                        data-week="week-{{ $s }}"
                                        data-check="false">
                                        {{ $weekname[$s] }}
                                    </a>
                                </span>
                            </th>
                            @foreach ($horas as $h )
                                <td class="text-center">                              
                                    <div class="custom-control custom-checkbox">
                                        <input name="schedule_{{ $s }}_{{ str_pad($h,2,'0',STR_PAD_LEFT) }}" 
                                            class="custom-control-input custom-control-input-success all-days week-{{ $s }} hora-{{ str_pad($h,2,'0',STR_PAD_LEFT) }} schedule_{{ $s }}_{{ str_pad($h,2,'0',STR_PAD_LEFT) }}"  
                                            type="checkbox" 
                                            id="schedule-{{ $s }}-{{ str_pad($h,2,'0',STR_PAD_LEFT) }}"
                                            checked="">
                                        <label for="schedule-{{ $s }}-{{ str_pad($h,2,'0',STR_PAD_LEFT) }}" class="custom-control-label"></label>
                                    </div>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
        
                </table>
                <br>
                <a href="#" class="all-mark">Marcar todo</a> | <a href="#" class="all-unmark">Descarmarcar todo</a>
            </div>
        </div>
        <div class="card-footer">
            <div class="float-right">
                <a href="{{ route('team.index') }}" class="btn btn-default"> <i class="fas fa-times"></i> Cancelar</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('script')
<script>
$(function(){

    $('.all-mark').click(function(){
        $('.all-days').each(function(){ this.checked = true; });
    });
    $('.all-unmark').click(function(){
        $('.all-days').each(function(){ this.checked = false; });
    });
    $('.hora-head').click(function(){
        let h = $(this).data('hora');
        let v = $(this).data('check');
        $('.' + h).each(function(){ this.checked = v; });
        $(this).data('check', (v == 'false' ) ? 'true' : 'false');
    });
    $('.week-head').click(function(){
        let h = $(this).data('week');
        let v = $(this).data('check');
        $('.' + h).each(function(){ this.checked = v; });
        $(this).data('check', (v == 'false' ) ? 'true' : 'false');
    });
    // Carga inicial de valores
    @foreach ($row->toArray() as $ff)
        @foreach ($ff as $k => $v )
            @if(substr($k,0,8) == 'schedule')                
                $('.{{ $k }}').prop('checked', {{ ($v == 'Y') ? 'true' : 'false' }});
            @endif
        @endforeach
    @endforeach
    
    
});
 
</script>
@endsection


 