@extends('layouts.app')

@section('content')
<section class="content-header">
  <h1 class="encuadre">
    Actualizar
    <small>Detalles de Audiencia</small>
  </h1>
  <ol class="breadcrumb encuadre">
    <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
    <li><a href="{{base_url('Audiencias')}}">Audiencias</a></li>
    <li>Actualizar Detalles de Audiencia</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-header">
        <div class="box-header with-border">
          <h2 class="box-title">
            Audiencia:<small>{{"  ".$audiencia->id}}</small>
          </h2>
        </div>  
        <form id="formID" role="form" action="{{base_url('Audiencias/Actualizar')}}" method="POST" autocomplete="off">
          <br>

          {{-- Detalles --}}
          <div class="form-group">
            <label class="control-label" for="inputError"></i>Detalles:</label>
            <textarea class="form-control" name="detalles" rows="10" placeholder="Detalles ..." >{{isset($alertas[0]->Error) ? $old[0]->old['detalles'] : $audiencia->detalles}}</textarea>
          </div>

          <input type="hidden" value="{{$audiencia->id}}" name="id">
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
              <a href="{{base_url('Audiencias')}}" class="btn btn-block btn-danger btn-lg">Cancelar</a>
            </td>
          </tr>
        </table>
      </div>
    </div> 
  </div>
</section>  
@endsection

