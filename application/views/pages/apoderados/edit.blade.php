@extends('layouts.app')

@section('content')
<section class="content-header">
  <h1 class="encuadre">
    Actualizar
    <small>Apoderado</small>
  </h1>
  <ol class="breadcrumb encuadre">
    <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
    <li><a href="{{base_url('Apoderados')}}">Apoderados</a></li>
    <li>Actualizar Apoderado</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-header">
        <div class="box-header with-border">
          <h2 class="box-title">
            {{$apoderados->primer_nombre." ".$apoderados->segundo_nombre." ".$apoderados->primer_apellido." ".$apoderados->segundo_apellido." "}}<small>{{" (".$apoderados->id.")"}}</small>
          </h2>
        </div> 
        <br>
        <div class="box-body">  
          <form id="formID" role="form" action="{{base_url('Apoderados/Actualizar')}}" method="POST" autocomplete="off">

            {{-- ID --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Identificación (*)</label>
              <input type="number" class="form-control" name="new_id" placeholder="Identificación ..." 
              value="{{isset($alertas[0]->Error) ? $old[0]->old['new_id'] : $apoderados->id}}" required>
              <input type="hidden" name="id" value="{{$apoderados->id}}">
            </div>

            {{-- Targeta Pro --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Tarjeta Profesional (*)</label>
              <input type="text" class="form-control" name="new_targeta_pro" placeholder="Targeta Profesional ..." 
              value="{{isset($alertas[0]->Error) ? $old[0]->old['new_targeta_pro'] : $apoderados->targeta_pro}}" required>
              <input type="hidden" name="targeta_pro" value="{{$apoderados->targeta_pro}}">
            </div>

            {{-- Primer nombre --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Primer Nombre (*)</label>
              <input type="text" class="form-control" name="primer_nombre" placeholder="Primer Nombre ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['primer_nombre'] :$apoderados->primer_nombre}}" required>
            </div>

            {{-- Segundo nombre --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Segundo Nombre</label>
              <input type="text" class="form-control" name="segundo_nombre" placeholder="Segundo Nombre ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['segundo_nombre'] :$apoderados->segundo_nombre}}">
            </div>

            {{-- Primer apellido --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Primer Apellido (*)</label>
              <input type="text" class="form-control" name="primer_apellido" placeholder="Primer Apellido ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['primer_apellido'] :$apoderados->primer_apellido}}" required>
            </div>

            {{-- Segundo apellido --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Segundo Apellido </label>
              <input type="text" class="form-control" name="segundo_apellido" placeholder="Segundo Apellido ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['segundo_apellido'] :$apoderados->segundo_apellido}}">
            </div>

            {{-- Email  --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Correo Electrónico </label>
              <input type="email" class="form-control" name="new_email" placeholder="Correo Electrónico ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['new_email'] :$apoderados->email}}">
              <input type="hidden" name="email" value="{{$apoderados->email}}">
            </div>  

            {{-- Telefono  --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Telefono </label>
              <input type="number" class="form-control" name="telefono" placeholder="Telefono ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['telefono'] :$apoderados->telefono}}">
            </div>  

            {{-- Botones  --}}
            <div class="form-group">
              <font size="2">Los campos marcados con (*) son obligatorios</font>
            </div>
            <div class="form-group">
              <table align="center" class="table table-bordered text-center">
                <tr>
                  <td width="250">
                    <button type="submit" name="actualizar" class="btn btn-block btn-success btn-lg">Actualizar</button>
                  </form>
                </td>
                <td width="250">
                  <a href="{{base_url('Apoderados')}}" class="btn btn-block btn-danger btn-lg">Cancelar</a>
                </td>
              </tr>
            </table>
          </div>  
        </div>
      </div>
    </div>
  </section>  
  @endsection