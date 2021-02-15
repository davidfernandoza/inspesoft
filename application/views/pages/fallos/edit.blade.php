@extends('layouts.app')

@section('content')
<section class="content-header">
  <h1 class="encuadre">
    Actualizar
    <small>Fallo</small>
  </h1>
  <ol class="breadcrumb encuadre">
    <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
    <li><a href="{{base_url('Casos')}}">Casos</a></li>
    <li><a href="{{base_url('Casos/Ver/'.$id)}}">{{'Caso: '.$id}}</a></li>
    <li>Actualizar Fallo</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-header">
        <div class="box-header with-border">
          <h2 class="box-title">
            Caso: <small>{{"  ".$id}}</small>
          </h2>
        </div>  
        <br>

        <div class="box-body">  
          <form id="formID" role="form" action="{{base_url('Fallos/Actualizar')}}" method="POST" autocomplete="off">

            {{-- Resolución --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Resolucion (*)</label>
              <input type="text" class="form-control" name="new_resolucion" placeholder="N° Resolución ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['new_resolucion'] : $fallos->num_resolucion}}" required>
              <input type="hidden" name="resolucion" value="{{$fallos->num_resolucion}}">
              <input type="hidden" name="id_caso" value="{{$id}}">
            </div>

            {{-- Fallo --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Fallo (*)</label>
              <input type="text" class="form-control" name="fallo" placeholder="Fallo ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['fallo'] : $fallos->fallo}}" required>
            </div>

            {{-- Detalles --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Detalles</label>
              <textarea class="form-control" name="detalles" rows="8" placeholder="Detalles ...">{{isset($alertas[0]->Error) ? $old[0]->old['detalles'] :$fallos->detalles}}</textarea>
            </div>

            {{-- tipo --}}
            @if($fallos->tipo != 'FINAL')
            <div class="form-group">                      
              <label>Tipo (*)</label>
              <select name="tipo" class="form-control " style="width: 100%;" required>
                <option value="" disabled selected="selected">SELECCIONAR</option>
                @if($fallos->tipo != 'APELACION')
                <option value="APELACION">APELACION</option>
                @endif
                <option value="FINAL">FINAL</option>
              </select>
            </div>
            @else
            <label>Tipo: FINAL</label>
            <input type="hidden" value="FINAL" name="tipo">
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
                  <a href="{{base_url('Casos/Ver/'.$id)}}" class="btn btn-block btn-danger btn-lg">Cancelar</a>
                </td>
              </tr>
            </table>
          </div>  
        </div>
      </div>
    </div>
  </section>  
  @endsection

