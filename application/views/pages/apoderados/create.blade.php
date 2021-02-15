@extends('layouts.app')

@section('content')
  <section class="content-header">
    <h1 class="encuadre">
      Crear
      <small>Apoderado</small>
    </h1>
    <ol class="breadcrumb encuadre">
      <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
      <li><a href="{{base_url('Apoderados')}}">Apoderados</a></li>
      <li>Crear Apoderado</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-header">
        <br>
        <div class="box-body">  
          <form id="formID" role="form" action="{{base_url('Apoderados/Guardar')}}" method="POST" autocomplete="off">

            {{-- ID --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Identificación (*)</label>
              <input type="number" class="form-control" name="id" placeholder="Identificación ..." 
              value="{{isset($alertas[0]->Error) ? $old[0]->old['id'] : ''}}" required>
            </div>

            {{-- Targeta Pro --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Tarjeta Profesional (*)</label>
              <input type="text" class="form-control" name="targeta_pro" placeholder="Targeta Profesional ..." 
              value="{{isset($alertas[0]->Error) ? $old[0]->old['targeta_pro'] : ''}}" required>
            </div>

            {{-- Primer nombre --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Primer Nombre (*)</label>
              <input type="text" class="form-control" name="primer_nombre" placeholder="Primer Nombre ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['primer_nombre'] :''}}" required>
            </div>

            {{-- Segundo nombre --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Segundo Nombre</label>
              <input type="text" class="form-control" name="segundo_nombre" placeholder="Segundo Nombre ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['segundo_nombre'] :''}}">
            </div>

            {{-- Primer apellido --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Primer Apellido (*)</label>
              <input type="text" class="form-control" name="primer_apellido" placeholder="Primer Apellido ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['primer_apellido'] :''}}" required>
            </div>

            {{-- Segundo apellido --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Segundo Apellido </label>
              <input type="text" class="form-control" name="segundo_apellido" placeholder="Segundo Apellido ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['segundo_apellido'] :''}}">
            </div>

            {{-- Email  --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Correo Electrónico </label>
              <input type="email" class="form-control" name="email" placeholder="Correo Electrónico ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['email'] :''}}">
            </div>  

            {{-- Telefono  --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Telefono </label>
              <input type="number" class="form-control" name="telefono" placeholder="Telefono ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['telefono'] :''}}">
            </div>  

            {{-- Botones  --}}
            <div class="form-group">
              <font size="2">Los campos marcados con (*) son obligatorios</font>
            </div>
            <div class="form-group">
              <table align="center" class="table table-bordered text-center">
                <tr>
                  <td width="250">
                    <button type="submit" name="crear" class="btn btn-block btn-success btn-lg">Guardar</button>
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

