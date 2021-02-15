@extends('layouts.app')

@section('content')
<section class="content-header">
  <h1 class="encuadre">
    Actualizar
    <small>Persona</small>
  </h1>
  <ol class="breadcrumb encuadre">
    <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
    <li><a href="{{base_url('Personas')}}">Personas</a></li>
    <li>Actualizar Persona</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-header">
        <br>
        <div class="box-body">  
          <form id="formID" role="form" action="{{base_url('Personas/Actualizar')}}" method="POST" autocomplete="off">

            {{-- Cedula --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Identificación</label>
              <input type="number" class="form-control" name="new_cedula" placeholder="Identificación ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['cedula'] : $personas->cedula}}"/>
              <input type="hidden" name="cedula" value="{{$personas->cedula}}">    
              <input type="hidden" name="id" value="{{$personas->id}}">          
            </div>

            {{-- Primer nombre --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Primer Nombre (*)</label>
              <input type="text" class="form-control" name="primer_nombre" placeholder="Primer Nombre ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['primer_nombre'] :$personas->primer_nombre}}" required>
            </div>

            {{-- Segundo nombre --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Segundo Nombre</label>
              <input type="text" class="form-control" name="segundo_nombre" placeholder="Segundo Nombre ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['segundo_nombre'] :$personas->segundo_nombre}}">
            </div>

            {{-- Primer apellido --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Primer Apellido</label>
              <input type="text" class="form-control" name="primer_apellido" placeholder="Primer Apellido ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['primer_apellido'] :$personas->primer_apellido}}">
            </div>

            {{-- Segundo apellido --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Segundo Apellido</label>
              <input type="text" class="form-control" name="segundo_apellido" placeholder="Segundo Apellido ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['segundo_apellido'] :$personas->segundo_apellido}}">
            </div>

            {{-- Direccion  --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Dirección (*)</label>
              <input type="text" class="form-control" name="direccion" placeholder="Dirección ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['direccion'] :$personas->direccion}}" required>
            </div>

            {{-- Telefono  --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Teléfono</label>
              <input type="number" class="form-control" name="telefono" placeholder="Teléfono ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['telefono'] :$personas->telefono}}" >
            </div>

            {{-- Botones  --}}
            <div class="form-group">
              <font size="2">Los campos marcados con (*) son obligatorios.</font> 
            </div>
            <div class="form-group">
              <table align="center" class="table table-bordered text-center">
                <tr>
                  <td width="250">
                    <button id="crearPersona" type="submit" name="crear" class="btn btn-block btn-success btn-lg">Actualizar</button>
                  </form>
                </td>
                <td width="250">
                  <a href="{{base_url('Personas')}}" class="btn btn-block btn-danger btn-lg">Cancelar</a>
                </td>
              </tr>
            </table>
          </div>  
        </div>
      </div>
    </div>
  </section>  
  @endsection

