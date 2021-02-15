@extends('layouts.app')

@section('content')

<section class="content-header">
  <ol class="breadcrumb encuadre">
    <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
    <li><a href="{{base_url('Personas')}}">Personas</a></li>
    <li>Ver Personas</li>
  </ol>
</section>
<br>
<section class="invoice">
  <div class="row">
    <div class="col-xs-12">
      <h2 class="page-header">
        <i class="fa fa fa-child"></i> Detalles de la persona 
        <div class="pull-right">
          @if ($auth[0]->Rol == 'ADMINISTRADOR')
          <a href="{{ base_url('Personas/Editar/'.$personas->id) }}" class='btn btn-sm btn-warning 
            fa fa-edit' title='Editar'></a>
            @endif  
            <a href="{{ base_url('Personas/Involucrar/'.$personas->id) }}" class='btn btn-sm btn-primary fa fa-plus' title='Involucrar'></a>
            <div>      
            </h2>
          </div>
        </div>
        <div class="row invoice-info">  
          <div class="col-sm-8 invoice-col">
            @if ($casos[0]->id_casos != NULL || $casos[0]->id_casos != '')
            <h4><b>Casos</b></h4>
            <hr>
            <div class="table-responsive">
              <table id="tb-tabla" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Radicado</th>
                    <th>Asunto</th>                     
                    <th>Estado</th> 
                    <th>Tipo</th>
                    <th>Subtipo</th>
                    <th>Apoderado</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($casos as $caso)
                  <tr align="center">
                    <td><a href="{{base_url('Casos/Ver/'.$caso->id_casos)}}">{{ $caso->id_casos }}</td></a>
                    <td>{{ $caso->asunto }}</td>
                    <td>{{ $caso->estado}}</td>
                    <td>{{ $caso->tipo}}</td>
                    <td>{{ $caso->subtipo}}</td> 
                    <td><a href="{{base_url('Apoderados/Ver/'.$caso->id_apoderado)}}">{{ $caso->apoderado}}</a></td>                  
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
            @if ($comparendos != NULL)     
            <h4><b>Comparendos</b></h4>
            <hr>
            <div class="table-responsive">
              <table id="tb-tabla" class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th>Numero de comparendo</th>
                    <th>Tipo</th> 
                    <th>Numeral</th>                    
                    <th>Literal</th>
                    <th>Estado</th> 
                  </tr>
                </thead>
                <tbody>
                  @foreach($comparendos as $comparendo)
                  <tr align="center">
                    <td><a href="{{ base_url('Comparendos/Ver/'.$comparendo->id) }}">{{ $comparendo->id}}</a></td>
                    <td>{{ $comparendo->tipo }}</td>
                    <td>{{ $comparendo->numeral}}</td>
                    <td>{{ $comparendo->literal}}</td>
                    @if($comparendo->estado == 'CONTRA')
                    <td>FALLO EN CONTRA</td>
                    @elseif($comparendo->estado == 'FAVOR')
                    <td>FALLO A FAVOR</td>
                    @else
                    <td>{{ $comparendo->estado }}</td>
                    @endif                            
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            @else
            <h3 style="color: red">No Hay Comparendos!</h3>
            @endif
          </div>    
          <div class="col-sm-4 invoice-col">

            <div class="table-responsive">
             <h4>Información</h4>
             <table class="table">
               <tr>
                <th><b>Id:</b></th>
                <td>{{$personas->id}}</td>
              </tr>
              <tr>
                <th><b>Cedula:</b></th>
                <td>{{$personas->cedula}}</td>
              </tr>
              <tr>
                <th><b>Nombre:</b></th>
                <td>{{$personas->primer_nombre.' '.$personas->segundo_nombre.' '.$personas->primer_apellido.' '.$personas->segundo_apellido}}</td>
              </tr>
              <tr>
                <th><b>Domicilio:</b></th>
                <td>{{$personas->direccion}}</td>
              </tr>
              <tr>
                <th><b>Telefono:</b></th>
                <td>{{$personas->telefono}}</td>
              </tr>            
            </table>
          </div>
        </div>
      </div>
    </section> 
    @endsection