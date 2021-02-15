@extends('layouts.app')

@section('content')

<section class="content-header">
  <ol class="breadcrumb encuadre">
    <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
    <li><a href="{{base_url('Eventos')}}">Eventos</a></li>
    <li>Ver Evento</li>
  </ol>
</section>
<br>
<section class="invoice">
  <div class="row">
    <div class="col-xs-12">
      <h2 class="page-header">
        <i class="fa fa-calendar"></i> Detalles del evento 
      </h2>
    </div>
  </div>
  <div class="row invoice-info">
    <div class="col-sm-6 invoice-col">
    	<strong>Título:</strong>
      <br> 
      <span>{{$eventos->title}}</span>
      <br><br>
      <strong>Id:</strong>
      <br>
      <span>{{$eventos->id}}</span>
      <br><br>
      <strong>Fecha y hora:</strong>
      <br> 
      <span id="fechaYhoraMoment">{{$eventos->start}}</span>
      <br><br>
      @if($eventos->descripcion != null)
      <strong>Descripción:</strong>
      <br> 
      <span>{{$eventos->descripcion}}</span>
      <br><br>
      @endif
      @if($eventos->casos_id != null)
      <strong>Caso:</strong>
      <br> 
      <span><a href="{{ base_url('Casos/Ver/'.$eventos->casos_id) }}">{{$eventos->casos_id}}</a></span>
      @elseif ($eventos->comparendos_id != null)
      <strong>Comparendo:</strong>
      <br> 
      <span><a href="{{ base_url('Comparendos/Ver/'.$eventos->comparendos_id) }}">{{$eventos->comparendos_id}}</a></span>
      @endif
    </div>    
</div>
</section> 
@endsection