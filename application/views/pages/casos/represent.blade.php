@extends('layouts.app')

@section('content')
<section class="content-header">
  <h1 class="encuadre">
    Representar
    <small>Persona</small>
  </h1>
  <ol class="breadcrumb encuadre">
    <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
    <li><a href="{{base_url('Casos')}}">Casos</a></li>
    <li><a href="{{base_url('Casos/Ver/'.$casos)}}">Ver Caso</a></li>
    <li>Representar Persona</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-header">
        <div class="box-header with-border">
          <h2 class="box-title">
            {{$personas->primer_nombre." ".$personas->segundo_nombre." ".$personas->primer_apellido." ".$personas->segundo_apellido." "}}
          </h2>
        </div> 
        <br>
        <div class="box-body">  
          <form id="formID" role="form" action="{{base_url('Casos/Representar/Persona')}}" method="POST" autocomplete="off">

            {{-- Apoderado --}}
            <div class="form-group">
              <label>Apoderado (*)</label>
              <select name="apoderado" class="select2 form-control" style="width: 100%;" >
                @if($apoderadoU == 'null')
                <option value="NULL" selected="selected">SELECCIONAR (Ninguno)</option>           
                @else
                <option value="NULL">SELECCIONAR (Ninguno)</option>
                @endif
                @foreach($apoderados as $apoderado)
                @if($apoderadoU == $apoderado->id)
                <option value="{{$apoderado->id}}" selected="selected" >{{$apoderado->id." | ".$apoderado->targeta_pro." | ".$apoderado->primer_nombre." ".$apoderado->segundo_nombre." ".$apoderado->primer_apellido." ".$apoderado->segundo_apellido}}
                </option>           
                @else
                <option value="{{$apoderado->id}}" >{{$apoderado->id." | ".$apoderado->targeta_pro." | ".$apoderado->primer_nombre." ".$apoderado->segundo_nombre." ".$apoderado->primer_apellido." ".$apoderado->segundo_apellido}}
                  @endif
                  @endforeach
                </select>
                <input  type="hidden" name="caso" value="{{$casos}}">
                <input  type="hidden" name="persona" value="{{$personas->id}}">
                <input  type="hidden" name="tipo" value="{{$tipo}}">
                <input  type="hidden" name="apoderadoU" value="{{$apoderadoU}}">
              </div>
              

              {{-- Botones  --}}
              <div class="form-group">
                <font size="2">Los campos marcados con (*) son obligatorios.</font> 
              </div>
              <div class="form-group">
                <table align="center" class="table table-bordered text-center">
                  <tr>
                    <td width="250">
                      <button  type="submit" name="representar" class="btn btn-block btn-success btn-lg">Representar</button>
                    </form>
                  </td>
                  <td width="250">
                    <a href="{{base_url('Casos/Ver/'.$casos)}}" class="btn btn-block btn-danger btn-lg">Cancelar</a>
                  </td>
                </tr>
              </table>
            </div>  
          </div>
        </div>
      </div>
    </section>  
    @endsection

