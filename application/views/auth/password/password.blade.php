@extends('layouts.app')

@section('content')
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box box-header">
            <div class="box-header with-border">
              <h2 class="box-title">
                Cambio de Contraseña
              </h2>
            </div> 
            <br>
            <form id="formID" role="form" action="{{base_url('Password/Actualizar')}}" method="POST"> 

              <input type="hidden" name="id" value="{{$auth[0]->Id}}">
              <input type="hidden" name="direccion" value="1">
              

              {{-- Contraseña Actual  --}}
              <div class="form-group">
                <label class="control-label" for="inputError"></i>Contraseña Actual (*)</label>
                <input type="password" class="form-control" name="password" placeholder="Contraseña Actual ..." required>
              </div>

              {{-- Contraseña Nueva  --}}
              <div class="form-group">
                <label class="control-label" for="inputError"></i>Contraseña Nueva (*)</label>
                <input type="password" class="form-control" name="new_password" placeholder="Contraseña Nueva ..." required>
              </div>

              {{-- Contraseña Confirmada  --}}
              <div class="form-group">
                <label class="control-label" for="inputError"></i>Repita la Contraseña Nueva (*)</label>
                <input type="password" class="form-control" name="confirmate" placeholder="Confirmar Contraseña ..."  required>
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
          </form>  
        </div>
      </div>
    </div>
  </section>
@endsection
