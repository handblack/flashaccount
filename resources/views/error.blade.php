@extends('layouts.app')

@section('container')
   
    <div class="container text-center" id="error">
      <br>
      <br>
      <br>
        <svg height="100" width="100">
          <polygon points="50,25 17,80 82,80" stroke-linejoin="round" style="fill:none;stroke:#ff0000;stroke-width:8" />
          <text x="42" y="74" fill="#ff8a00" font-family="sans-serif" font-weight="900" font-size="42px">!</text>
        </svg>
       <div class="row">
          <div class="col-md-12">
            <div class="main-icon text-warning"><span class="uxicon uxicon-alert"></span></div>
              <h1>ACCESO RESTRINGIDO</h1>
              <h3>{{ $module }}</h3>
          </div>
        </div>
        <div class="row">
            <div class="col-md-12 col-md-push-3">
                <p class="lead"><br>Ponte en contacto con el Soporte Tecnico para mas informacion
                    <br>soporte@esg.com.pe
                    <br><a href="https://wa.me/+51997752822" target="_blank"><i class="fab fa-whatsapp"></i> 997752822</a>
                  </p>
            </div>
        </div>
    </div>
@endsection