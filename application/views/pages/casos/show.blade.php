@extends('layouts.app')

@section('content')

<section class="content-header">
  <ol class="breadcrumb encuadre">
    <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
    <li><a href="{{base_url('Casos')}}">Casos</a></li>
    <li>Ver Caso</li>
  </ol>
</section>
<br>
<section class="invoice">
  <div class="row">
    <div class="col-xs-12">
      <h2 class="page-header">
        <i class="fa fa  fa-balance-scale"></i> Caso: {{$casos[0]->id_casos}}
        <span class="pull-right"><strong>{{$casos[0]->estado}}</strong></span>

      </h2>
    </div>
  </div>
  <div class="row invoice-info">
    <div class="col-sm-6 invoice-col">
      <strong>Asunto</strong>
      <br>
      <span>{{$casos[0]->asunto}}</span>
      <br><br>
      <strong>Hechos</strong>
      <br> 
      <span>{{$casos[0]->hechos}}</span>
    </div>    
    <div class="col-sm-1 invoice-col">
    </div>
    <div class="col-sm-5 invoice-col">

      <div class="table-responsive">
       <h4>Información</h4>
       <table class="table">
         <tr>
          <th><b>Numero de caso:</b></th>
          <td>{{$casos[0]->id_casos}}</td>
        </tr> 
        <tr>
          <th><b>Fecha de inicio:</b></th>
          <td><span id="fechaMoment">{{$casos[0]->fecha_inicio}}</span></td>
        </tr>
        @if ($casos[0]->fecha_cierre != "0000-00-00")
        <tr>
          <th><b>Fecha de cierre:</b></th>
          <td><span id="fechaMoment2">{{$casos[0]->fecha_cierre}}</span></td>
        </tr>
        @endif
        <tr>
          <th><b>Numero de folio:</b></th>
          <td>{{$casos[0]->num_folios}}</td>
        </tr>
        <tr>
          <th><b>Numero de caja:</b></th>
          <td>{{$casos[0]->num_caja}}</td>
        </tr>
        <tr>
          <th><b>Acciones:</b></th>
          <td>
            @if($casos[0]->estado == 'ACTIVO')
            @if($auth[0]->Rol == "ADMINISTRADOR")                    
            <a href="{{ base_url('Casos/Editar/'.$casos[0]->id_casos) }}" class='btn btn-sm btn-warning fa fa-edit' title='Editar'></a>                             
            @endif 
            @if($fallos == NULL || $fallos[0]->tipo != 'PRIMERA INSTANCIA')
            <a href="{{ base_url('Fallos/Crear/'.$casos[0]->id_casos) }}" class='btn btn-sm btn-danger fa  fa-legal' title='Fallo'></a>       
            @else
            <a class='btn btn-sm btn-danger fa  fa-legal' title='Fallo' disabled></a> 
            @endif     
            @else
            @if($auth[0]->Rol == "ADMINISTRADOR")                                           
            <a class='btn btn-sm btn-warning fa fa-edit' title='Editar' disabled></a>         
            @endif            
            <a class='btn btn-sm btn-danger fa  fa-legal' title='Fallo' disabled></a>
            @endif                                                       
            <a href="{{ base_url('Imprimir/'.$casos[0]->id_casos) }}" class='btn btn-sm btn-primary fa  fa-print' title='Imprimir' target="_blank"></a>                                 
          </td>
        </tr>     
      </table>
    </div>
  </div>
</div>
<br>
@if ($casos[0]->id_personas != NULL)
<h4><b>Involucrados</b></h4>
<hr>
<div class="row">
  <div class="col-xs-12 table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Cedula</th>
          <th>Nombres y Apellidos</th>
          <th>Tipo</th>
          <th>Subtipo</th>
          <th>Dirección</th>
          <th>Teléfono</th>
          <th>Apoderado</th> 
          @if($fallos == null)
          <th>Acciones</th>
          @elseif(!isset($fallos[1]) && $fallos[0]->tipo == 'APELACION')               
          <th>Acciones</th>
          @endif
        </tr>
      </thead>
      <tbody>
       @foreach($casos as $caso)
       <tr>
        <td>{{ $caso->cedula}}</td>
        <td><a href="{{base_url('Personas/Ver/'.$caso->id_personas)}}">{{ $caso->nombre_persona }}</a></td>
        <td>{{ $caso->tipo_involucrados}}</td>
        <td>{{ $caso->subtipo }}</td>
        <td>{{ $caso->direccion}}</td>   
        <td>{{ $caso->telefono }}</td>    
        <td><a href="{{base_url('Apoderados/Ver/'.$caso->id_apoderados)}}">{{ $caso->nombre_apoderados}}</a></td> 
         
        <td>
          @if($caso->id_apoderados == null)
          @if($fallos == NULL) 
          <a href="{{ isset($caso->id_apoderados) ? base_url('Casos/Representar/'.$casos[0]->id_casos.'/'.$caso->id_personas.'/'.$caso->id_apoderados)  : base_url('Casos/Representar/'.$casos[0]->id_casos.'/'.$caso->id_personas.'/NULL')}}" class='btn btn-sm btn-primary fa fa-plus' title='Asignar Apoderado'></a>
          @elseif(!isset($fallos[1]) && $fallos[0]->tipo == 'APELACION')
          <a href="{{ isset($caso->id_apoderados) ? base_url('Casos/Representar/'.$casos[0]->id_casos.'/'.$caso->id_personas.'/'.$caso->id_apoderados)  : base_url('Casos/Representar/'.$casos[0]->id_casos.'/'.$caso->id_personas.'/NULL')}}" class='btn btn-sm btn-primary fa fa-plus' title='Asignar Apoderado'></a>
          @endif
          @else
          @if($fallos == NULL) 
          <a href="{{ isset($caso->id_apoderados) ? base_url('Casos/Representar/'.$casos[0]->id_casos.'/'.$caso->id_personas.'/'.$caso->id_apoderados)  : base_url('Casos/Representar/'.$casos[0]->id_casos.'/'.$caso->id_personas.'/NULL')}}" class='btn btn-sm btn-primary fa fa-refresh' title='Cambiar Apoderado'></a>
          @elseif(!isset($fallos[1]) && $fallos[0]->tipo == 'APELACION')
          <a href="{{ isset($caso->id_apoderados) ? base_url('Casos/Representar/'.$casos[0]->id_casos.'/'.$caso->id_personas.'/'.$caso->id_apoderados)  : base_url('Casos/Representar/'.$casos[0]->id_casos.'/'.$caso->id_personas.'/NULL')}}" class='btn btn-sm btn-primary fa fa-refresh' title='Cambiar Apoderado'></a>
          @endif          
          @endif
          @if($auth[0]->Rol == "ADMINISTRADOR")  
          @if($fallos == NULL) 
          <a href="{{ isset($caso->id_apoderados) ? base_url('Casos/Involucrados/Eliminar/'.$caso->id_involucrados.'/'.$casos[0]->id_casos.'/'.$caso->id_personas.'/'.$caso->id_apoderados)  : base_url('Casos/Involucrados/Eliminar/'.$caso->id_involucrados.'/'.$casos[0]->id_casos.'/'.$caso->id_personas.'/NULL')}}" class='btn btn-sm btn-danger fa fa-trash' title='Eliminar del caso'></a>
          @endif
          @endif
        </td>                
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
</div>
@else
<h3 style="color: red">No Hay Involucrados!</h3>
@endif

@if ($fallos != NULL)
<h4><b>Fallos</b></h4>
<hr>
<div class="row">
  <div class="{{count($fallos) > 1 ? 'col-xs-6' : 'col-xs-8'}}">
    <p class="lead" id="fechaMoment3">{{ $fallos[0]->fecha}} </p>
    <div class="table-responsive">
      <table class="table">
       <tr>
        @if($casos[0]->estado == 'ACTIVO' && $auth[0]->Rol == "REGULAR")
        <th>Acciones:</th>
        @elseif($auth[0]->Rol == "ADMINISTRADOR")
        <th>Acciones:</th>
        @endif
        <td>
          @if($casos[0]->estado == 'ACTIVO')
          <a title="Editar" class="btn btn-sm btn-warning fa fa-edit" href="{{base_url('Fallos/Editar/'.$fallos[0]->num_resolucion.'/'.$casos[0]->id_casos)}}">
          </a>
          @endif

          @if($auth[0]->Rol == "ADMINISTRADOR")
          <a title="Eliminar" class="btn btn-sm btn-danger fa fa-trash" href="{{base_url('Fallos/Eliminar/'.$fallos[0]->num_resolucion.'/'.$casos[0]->id_casos.'/'.$fallos[0]->tipo)}}"></a>
          @endif
        </td>
      </tr>      
      <tr>
        <th>Resolución:</th>
        <td>{{ $fallos[0]->num_resolucion}}</td>
      </tr>
      <tr>
        <th>Tipo:</th>
        <td>{{ $fallos[0]->tipo }}</td>
      </tr>
      <tr>
        <th>Fallo:</th>
        <td>{{ $fallos[0]->fallo}}</td>
      </tr>
      <tr>
        <th>Detalles:</th>
        <td>{{ $fallos[0]->detalles}}</td>
      </tr>
    </table>
  </div>
</div>
@if(count($fallos) > 1)
<div class="col-xs-6">
  <p class="lead" id="fechaMoment4">{{ $fallos[1]->fecha}}</p>
  <div class="table-responsive">
    <table class="table">
       <tr>
        @if($casos[0]->estado == 'ACTIVO' && $auth[0]->Rol == "REGULAR")
        <th>Acciones:</th>
        @elseif($auth[0]->Rol == "ADMINISTRADOR")
        <th>Acciones:</th>
        @endif
        <td>
          @if($casos[0]->estado == 'ACTIVO')
          <a title="Editar" class="btn btn-sm btn-warning fa fa-edit" href="{{base_url('Fallos/Editar/'.$fallos[1]->num_resolucion.'/'.$casos[0]->id_casos)}}">
          </a>
          @endif

          @if($auth[0]->Rol == "ADMINISTRADOR")
          <a title="Eliminar" class="btn btn-sm btn-danger fa fa-trash" href="{{base_url('Fallos/Eliminar/'.$fallos[1]->num_resolucion.'/'.$casos[0]->id_casos.'/'.$fallos[1]->tipo)}}"></a>
          @endif
        </td>
      </tr>   
      <tr>
        <th>Resolución:</th>
        <td>{{ $fallos[1]->num_resolucion}}</td>
      </tr>
      <tr>
        <th>Tipo:</th>
        <td>{{ $fallos[1]->tipo }}</td>
      </tr>
      <tr>
        <th>Fallo:</th>
        <td>{{ $fallos[1]->fallo}}</td>
      </tr>
      <tr>
        <th>Detalles:</th>
        <td>{{ $fallos[1]->detalles}}</td>
      </tr>
    </table>
  </div>
</div>
@endif
</div>
@endif
</section>
@endsection