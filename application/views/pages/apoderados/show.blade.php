@extends('layouts.app')

@section('content')

<section class="content-header">
  <ol class="breadcrumb encuadre">
    <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
    <li><a href="{{base_url('Apoderados')}}">Apoderados</a></li>
    <li>Ver Apoderado</li>
  </ol>
</section>
<br>
<section class="invoice">
  <div class="row">
    <div class="col-xs-12">
      <h2 class="page-header">
        <i class="fa fa fa-mortar-board"></i> Detalles del apoderado 
        <div class="pull-right">
          <a href="{{ base_url('Apoderados/Editar/'.$apoderados->id) }}" class='btn btn-sm btn-warning fa fa-edit' title='Editar'></a>
          <div>      
          </h2>
        </div>
      </div>
      <div class="row invoice-info">  
        <div class="col-sm-8 invoice-col">
          @if ($casos != NULL)
          <h4><b>Casos</b></h4>
          <hr>
          <div class="table-responsive">
            <table id="tb-tabla" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Radicado</th>
                  <th>Asunto</th>                     
                  <th>Estado</th>                   
                </tr>
              </thead>
              <tbody>
                @foreach($casos as $caso)
                <tr align="center">
                  <td><a href="{{ base_url('Casos/Ver/'.$caso->id) }}">{{ $caso->id }}</a></td>
                  <td>{{ $caso->asunto }}</td>
                  <td>{{ $caso->estado}}</td>               
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @else
          <h3 style="color: red">No Hay Casos!</h3>
          @endif
          <hr>
          <br> 
          @if ($personas != NULL)     
          <h4><b>Representaciones (Personas)</b></h4>
          <hr>
          <div class="table-responsive">
            <table id="tb-tabla" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Cedula</th>
                  <th>Nombre</th>
                </tr>
              </thead>
              <tbody>
                @foreach($personas as $persona)
                <tr align="center">
                  <td>{{ $persona->cedula}}</td>
                  <td><a href="{{ base_url('Personas/Ver/'.$persona->id) }}">{{$persona->nombre_persona}}</a></td>              
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @else
          <h3 style="color: red">No Hay Personas Representadas!</h3>
          @endif
        </div>    
        <div class="col-sm-4 invoice-col">

          <div class="table-responsive">
           <h4>Información</h4>
           <table class="table">
             <tr>
              <th><b>CC:</b></th>
              <td>{{$apoderados->id}}</td>
            </tr>
            <tr>
              <th><b>Tarjeta profesional:</b></th>
              <td>{{$apoderados->targeta_pro}}</td>
            </tr>
            <tr>
              <th><b>Nombre:</b></th>
              <td>{{$apoderados->primer_nombre.' '.$apoderados->segundo_nombre.' '.$apoderados->primer_apellido.' '.$apoderados->segundo_apellido}}</td>
            </tr>
            <tr>
              <th><b>Email:</b></th>
              <td>{{$apoderados->email}}</td>
            </tr>
            <tr>
              <th><b>Telefono:</b></th>
              <td>{{$apoderados->telefono}}</td>
            </tr>      
          </table>
        </div>
      </div>
    </div>
  </section> 
  @endsection