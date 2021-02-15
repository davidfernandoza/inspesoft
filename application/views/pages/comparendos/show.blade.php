@extends('layouts.app')

@section('content')

<section class="content-header">
  <ol class="breadcrumb encuadre">
    <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
    <li><a href="{{base_url('Comparendos')}}">Comparendos</a></li>
    <li>Ver Comparendo</li>
  </ol>
</section>
<br>
<section class="invoice">
  <div class="row">
    <div class="col-xs-12">
      <h2 class="page-header">
        <i class="fa fa fa-file-text-o"></i> Detalles de comparendo 
        @if($comparendos->estado == 'CONTRA')
        <span class="pull-right"><strong>FALLO EN CONTRA</strong></span>
        @elseif($comparendos->estado == 'FAVOR')
        <span class="pull-right"><strong>FALLO A FAVOR</strong></span>
        @else
        <span class="pull-right"><strong>{{$comparendos->estado}}</strong></span>
        @endif

      </h2>
    </div>
  </div>
  <div class="row invoice-info">
    <div class="col-sm-6 invoice-col">
      <strong>Numero de comparendo</strong>
      <br>
      <span>{{$comparendos->id}}</span>
      <br><br>
      <strong>Articulo</strong>
      <br> 
      <span>{{$comparendos->articulo}}</span>
    </div>    
    <div class="col-sm-1 invoice-col">
    </div>
    <div class="col-sm-5 invoice-col">

      <div class="table-responsive">
       <h4>Información</h4>
       <table class="table">
         <tr>
          <th><b>Infractor:</b></th>
          <td>
            @if($personas != null)
            <a href="{{ base_url('Personas/Ver/'.$personas->id) }}">{{$personas->primer_nombre." ".$personas->segundo_nombre." ".$personas->primer_apellido." ".$personas->segundo_apellido." "}}
            </a>
            @else
            <h4 style="color: red">No Hay Involucrado!</h4>
            @endif
          </td>
          @if($auth[0]->Rol == "ADMINISTRADOR") 
          @if($personas != null)
          <td>            
            <a href="{{ base_url('Comparendos/Ver/Eliminar/'.$comparendos->id) }}" class='btn btn-sm btn-danger fa fa-trash' title="Eliminar del comparendo">
            </a>            
          </td>
          @endif
          @endif
        </tr>
        <tr>
          <th><b>Fecha:</b></th>
          <td><span id="fechaMoment">{{$comparendos->fecha}}</span></td>
        </tr>
        <tr>
          <th><b>Tipo:</b></th>
          <td>{{$comparendos->tipo}}</td>
        </tr>
        <tr>
          <th><b>Numeral:</b></th>
          <td>{{$comparendos->numeral}}</td>
        </tr>
        <tr>
          <th><b>Literal:</b></th>
          <td>{{$comparendos->literal}}</td>
        </tr>
        <tr>
          <th><b>Multa:</b></th>
          <td>{{$comparendos->multa}}</td>
        </tr>
        <tr>
          <th><b>Numero de folio:</b></th>
          <td>{{$comparendos->num_folios}}</td>
        </tr>
        <tr>
          <th><b>Numero de caja:</b></th>
          <td>{{$comparendos->num_caja}}</td>
        </tr>  
        @if($auth[0]->Rol == "ADMINISTRADOR")
        <tr>
          <th><b>Acciones:</b></th>
          <td><a href="{{ base_url('Comparendos/Editar/'.$comparendos->id) }}" class='btn btn-sm btn-warning fa fa-edit' title='Editar'></a></td>
        </tr>  
        @endif    
      </table>
    </div>
  </div>
</div>
</section> 
@endsection