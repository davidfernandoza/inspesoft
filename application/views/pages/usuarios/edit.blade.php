@extends('layouts.app')

@section('content')
  <section class="content-header">
    <h1 class="encuadre">
      Actualizar
      <small>Usuario</small>
    </h1>
    <ol class="breadcrumb encuadre">
      <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
      @if ($auth[0]->Rol == 'ADMINISTRADOR')
      <li><a href="{{base_url('Usuarios')}}">Usuarios</a></li>
      @endif
      <li>Actualizar Usuario</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-header">
          <div class="box-header with-border">
            <h2 class="box-title">
              {{$usuarios->primer_nombre." ".$usuarios->segundo_nombre." ".$usuarios->primer_apellido." ".$usuarios->segundo_apellido." "}}<small>{{" (".$usuarios->id.")"}}</small>
            </h2>
          </div>  
          <br>
          <div class="box-body">  
            <form id="formID" role="form" action="{{base_url('Usuarios/Actualizar')}}" method="POST" autocomplete="off">   

              {{-- ID --}}
              <div class="form-group">
                <label class="control-label" for="inputError"></i>Identificación (*)</label>
                <input type="number" class="form-control" name="new_id" placeholder="Identificación ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['new_id'] : $usuarios->id}}" required>
                <input type="hidden" name="id" value="{{$usuarios->id}}">
              </div>

              {{-- Primer nombre --}}
              <div class="form-group">
                <label class="control-label" for="inputError"></i>Primer Nombre (*)</label>
                <input type="text" class="form-control" name="primer_nombre" placeholder="Primer Nombre ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['primer_nombre'] : $usuarios->primer_nombre}}" required>
              </div>

              {{-- Segundo nombre --}}
              <div class="form-group">
                <label class="control-label" for="inputError"></i>Segundo Nombre</label>
                <input type="text" class="form-control" name="segundo_nombre" placeholder="Segundo Nombre ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['segundo_nombre'] : $usuarios->segundo_nombre}}">
              </div>

              {{-- Primer apellido --}}
              <div class="form-group">
                <label class="control-label" for="inputError"></i>Primer Apellido (*)</label>
                <input type="text" class="form-control" name="primer_apellido" placeholder="Primer Apellido ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['primer_apellido'] : $usuarios->primer_apellido}} " required>
              </div>

              {{-- Segundo apellido --}}
              <div class="form-group">
                <label class="control-label" for="inputError"></i>Segundo Apellido</label>
                <input type="text" class="form-control" name="segundo_apellido" placeholder="Segundo Apellido ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['segundo_apellido'] : $usuarios->segundo_apellido}}" >
              </div>

              {{-- Email  --}}
              <div class="form-group">
                <label class="control-label" for="inputError"></i>Correo Electrónico (*)</label>
                <input type="email" class="form-control" name="new_email" placeholder="Correo Electrónico ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['new_email'] : $usuarios->email}}" required>
                <input type="hidden" name="email" value="{{$usuarios->email}}">
              </div>

              {{-- Rol --}}
              @if($auth[0]->Rol == "ADMINISTRADOR" && $auth[0]->Id != $id)
              <div class="form-group">
                <label>Rol (*)</label>                 
                <select name="rol" class="form-control " style="width: 100%;" required="">
                  <option  {{$rolA}} value="ADMINISTRADOR">ADMINISTRADOR</option>
                  <option  {{$rolR}} value="REGULAR">REGULAR</option>
                </select>
              </div>
              @elseif($auth[0]->Rol == "ADMINISTRADOR")
                <input type="hidden" name="rol" value="ADMINISTRADOR">
              @else
               <input type="hidden" name="rol" value="REGULAR">
              @endif  
             
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
                    @if($auth[0]->Rol == "ADMINISTRADOR")
                    <a href="{{base_url('Usuarios')}}" class="btn btn-block btn-danger btn-lg">Cancelar</a>
                    @else
                    <a href="{{base_url('Inicio')}}" class="btn btn-block btn-danger btn-lg">Cancelar</a>
                    @endif
                  </td>
                </tr>
              </table>
            </div>  
          </div>
        </div>
      </div>
    </section>  
@endsection
