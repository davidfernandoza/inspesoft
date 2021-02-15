@extends('layouts.app')

@section('content')
<section class="content-header">
  <h1 class="encuadre">
    Actualizar Plantilla
    <small>Casos</small>
  </h1>
  <ol class="breadcrumb encuadre">
    <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
    <li>Actualizar Plantilla Casos</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-header">
        <br>
        <div class="box-body">  
          <form id="formID" role="form" action="{{base_url('Plantilla/Actualizar')}}" method="POST" autocomplete="off">

            {{-- Secretaria --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Secretaría (*)</label>
              <input type="text" class="form-control" name="secretaria" placeholder="Secretaría ..." 
              value="{{isset($alertas[0]->Error) ? $old[0]->old['secretaria'] : $plantillas->secretaria}}" required>
            </div>

            {{-- Titulo --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Titulo (*)</label>
              <input type="text" class="form-control" name="titulo" placeholder="Titulo ..." 
              value="{{isset($alertas[0]->Error) ? $old[0]->old['titulo'] : $plantillas->titulo}}" required>
            </div>

            {{-- juramento --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Juramento (*)</label>
              <textarea class="form-control" name="juramento" rows="3" placeholder="Juramento ..." required>{{isset($alertas[0]->Error) ? $old[0]->old['juramento'] : $plantillas->juramento}}</textarea>
            </div>

            {{-- nombre del inspector --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Nombre del inspector (*)</label>
              <input type="text" class="form-control" name="nombre" placeholder="Nombre del inspector ..." 
              value="{{isset($alertas[0]->Error) ? $old[0]->old['nombre'] : $plantillas->nombre}}" required>
            </div>

            {{-- Lema --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Lema (*)</label>
              <input type="text" class="form-control" name="lema" placeholder="Lema ..." 
              value="{{isset($alertas[0]->Error) ? $old[0]->old['lema'] : $plantillas->lema}}" required>
            </div>

            {{-- Direccion --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Dirección (*)</label>
              <input type="text" class="form-control" name="direccion" placeholder="Dirección ..." 
              value="{{isset($alertas[0]->Error) ? $old[0]->old['direccion'] : $plantillas->direccion}}" required>
            </div>

            {{-- Telefono --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Telefonos (*)</label>
              <input type="text" class="form-control" name="telefono" placeholder="Telefonos ..." 
              value="{{isset($alertas[0]->Error) ? $old[0]->old['telefono'] : $plantillas->telefono}}" required>
            </div>

            {{-- Fax --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Fax (*)</label>
              <input type="text" class="form-control" name="fax" placeholder="Fax ..." 
              value="{{isset($alertas[0]->Error) ? $old[0]->old['fax'] : $plantillas->fax}}" required>
            </div>

            {{-- Email --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Correo Electrónico (*)</label>
              <input type="text" class="form-control" name="email" placeholder="Correo Electrónico ..." 
              value="{{isset($alertas[0]->Error) ? $old[0]->old['email'] : $plantillas->email}}" required>
            </div>

            {{-- Pagina Web --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Pagina Web (*)</label>
              <input type="text" class="form-control" name="web" placeholder="Pagina Web ..." 
              value="{{isset($alertas[0]->Error) ? $old[0]->old['web'] : $plantillas->web}}" required>
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
                  <a href="{{base_url('Inicio')}}" class="btn btn-block btn-danger btn-lg">Cancelar</a>
                </td>
              </tr>
            </table>
          </div>  
        </div>
      </div>
    </div>
  </section>
  @endsection
