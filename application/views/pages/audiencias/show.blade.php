@extends('layouts.app')

@section('content')

<section class="content-header">
  <ol class="breadcrumb encuadre">
    <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
    <li><a href="{{base_url('Audiencias')}}">Audiencias</a></li>
    <li>Ver Audiencia</li>
  </ol>
</section>
<br>
<section class="invoice">
  <div class="row">
    <div class="col-xs-12">
      <h2 class="page-header">
        <i class="fa fa fa-university"></i> Audiencia: {{$audiencia->id}}
        <span class="pull-right"><strong>Conciliación: {{ $audiencia->conciliacion}}</strong></span>
      </h2>
    </div>
  </div>
  <div class="row invoice-info">
    <div class="col-sm-3 invoice-col">

      {{-- Denunciante --}}
      @if($audiencia->casos_id == NULL || $audiencia->casos_id == '')
      <h4><b>Policía:</b></h4>
      <br>
      @else
      <h4><b>Denunciante:</b></h4>      
      <br>
      @endif

      {{-- Asistencia --}}
      <strong>Asistencia:</strong>
      <br>
      <span>{{$audiencia->asistencia_d}}</span>
      <br>

      {{-- Escusas --}}
      @if($audiencia->asistencia_d == 'NO' && $audiencia->escusa_d == 'NO') 
      @if ($expire == FALSE)
      <form role="form" action="{{base_url('Audiencias/Escusar/D')}}" method="POST" autocomplete="off">
        <div class="form-group"> 
          <br>       
          <label>Escusa: NO</label>         
          <br>
          <select  required name="escusa_d" class="form-control" style="width: 100%;" >
            <option value="" selected="selected" disabled="">SELECCIONAR TIPO DE ESCUSA</option> 
            <option value="VALIDA" >VALIDA</option>
            <option value="INVALIDA" >INVALIDA</option>
          </select>
          <input type="hidden" name="id" value="{{$audiencia->id}}">
        </div>
        <div>
          <button type="submit" name="actualizar" class="btn btn-block btn-success btn-lg">Actualizar</button>
        </div>
      </form>
      <br>
      @else
      <strong>Escusa:</strong>
      <br>
      <span>{{$audiencia->escusa_d}}</span>
      <br>
      @endif
      @elseif($audiencia->asistencia_d == 'NO' && $audiencia->escusa_d != 'NO')
      <strong>Escusa:</strong>
      <br>
      <span>{{$audiencia->escusa_d}}</span>
      <br>
      @endif

      {{-- Argumentos --}}
      <strong>Argumentos:</strong>
      <br>
      <span>{{$audiencia->argumento_d}}</span>
      <br>

      {{-- Pruebas --}}
      <strong>Pruebas:</strong>
      <br>
      <span>{{$audiencia->pruebas_d}}</span>
      <br>

      @if($audiencia->recursos_d != '')
      {{-- Recursos --}}
      <strong>Recursos:</strong>
      <br>
      <span>{{$audiencia->recursos_d}}</span>
      <br>
      @endif
    </div> 
    <div class="col-sm-1 invoice-col"></div>
    <div class="col-sm-3 invoice-col">

     {{-- Contraventor --}}
     @if($audiencia->casos_id == NULL || $audiencia->casos_id == '')
     <h4><b>Infractor:</b></h4>
     <br>
     @else
     <h4><b>Contraventor:</b></h4>     
     <br>
     @endif

     {{-- Asistencia --}}
     <strong>Asistencia:</strong>
     <br>
     <span>{{$audiencia->asistencia_c}}</span>
     <br>

     {{-- Escusas --}}
     @if($audiencia->asistencia_c == 'NO' && $audiencia->escusa_c == 'NO') 
     @if ($expire == FALSE)
     <form role="form" action="{{base_url('Audiencias/Escusar/C')}}" method="POST" autocomplete="off">
      <div class="form-group">
        <br>
        <label>Escusa: NO</label>          
        <br>
        <select  required name="escusa_c" class="form-control" style="width: 100%;" >
          <option value="" selected="selected" disabled="">SELECCIONAR TIPO DE ESCUSA</option> 
          <option value="VALIDA" >VALIDA</option>
          <option value="INVALIDA" >INVALIDA</option>
        </select>  
        <input type="hidden" name="id" value="{{$audiencia->id}}"> 
      </div>
      <div>
        <button type="submit" name="actualizar" class="btn btn-block btn-success btn-lg">Actualizar</button>
      </div>
    </form>
    <br>
    @else
    <strong>Escusa:</strong>
    <br>
    <span>{{$audiencia->escusa_c}}</span>
    <br>
    @endif
    @elseif($audiencia->asistencia_c == 'NO' && $audiencia->escusa_c != 'NO')
    <strong>Escusa</strong>
    <br>
    <span>{{$audiencia->escusa_c}}</span>
    <br>
    @endif

    {{-- Argumentos --}}
    <strong>Argumentos:</strong>
    <br>
    <span>{{$audiencia->argumento_c}}</span>
    <br>

    {{-- Pruebas --}}
    <strong>Pruebas:</strong>
    <br>
    <span>{{$audiencia->pruebas_c}}</span>
    <br>

    {{-- Recursos --}}
    @if($audiencia->recursos_c != '')    
    <strong>Recursos:</strong>
    <br>
    <span>{{$audiencia->recursos_c}}</span>
    <br>
    @endif
  </div> 

  <div class="col-sm-1 invoice-col"></div>
  <div class="col-sm-4 invoice-col">

    <div class="table-responsive">
     <h4><b>Información:</b></h4>
     <table class="table">

      <tr>
        <th><b>Titulo:</b></th>
        <td>{{$audiencia->title}}</td>
      </tr>
      @if($audiencia->casos_id == NULL || $audiencia->casos_id == '')
      <tr>
        <th><b>Resolución de comparendo:</b></th>
        <td><a href="{{base_url('Comparendos/Ver/'.$audiencia->comparendos_id)}}">{{$audiencia->comparendos_id}}</td>
        </tr>
        @else
        <tr>
          <th><b>Caso:</b></th>
          <td><a href="{{base_url('Casos/Ver/'.$audiencia->casos_id)}}">{{ $audiencia->casos_id}}</a></td>
        </tr>
        @endif 
        <tr>
          <th><b>Evento:</b></th>
          <td><a href="{{base_url('Eventos/Ver/'.$audiencia->eventos_id)}}">{{ $audiencia->eventos_id}}</a></td>
        </tr> 
        <tr>
          <th><b>Fecha de citación:</b></th>
          <td id="fechaYhoraMoment" >{{$audiencia->start}}</td>
        </tr> 
        @if($audiencia->asistencia_d == 'NO' || $audiencia->asistencia_c == 'NO')
        <tr>
          <th><b>Fecha de caducidad:</b></th>
          <td class="fechaYhoraMoment1" >{{$fecha_caducidad}}</td>
        </tr>
        @endif
        @if($auth[0]->Rol == "ADMINISTRADOR")     
        <tr>
          <th><b>Acciones:</b></th>
          <td>
            <a href="{{ base_url('Audiencias/Editar/'.$audiencia->id) }}" class='btn btn-sm btn-warning fa fa-edit' title='Editar Detalles'></a>                                         
          </td>
        </tr>
        @endif 
      </table>
    </div>
  </div>
</div>
<br>
<hr>

@if($audiencia->detalles != null || $audiencia->detalles != '')
<div class="row invoice-info">
  <div class="col-sm-12 invoice-col">
    <strong>Detalles:</strong>
    <br>
    <p>{{ $audiencia->detalles}} </p>
  </div>
</div> 
@endif 
</section>
@endsection