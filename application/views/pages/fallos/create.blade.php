@extends('layouts.app')

@section('content')
  <section class="content-header">
    <h1 class="encuadre">
      Crear
      <small>Fallo</small>
    </h1>
    <ol class="breadcrumb encuadre">
      <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
      <li><a href="{{base_url('Casos')}}">Casos</a></li>
      <li>Crear Fallo</li>
    </ol>
  </section>

  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box box-header">
          <div class="box-header with-border">
            <h2 class="box-title">
              Caso:<small>{{"  ".$id_caso}}</small>
            </h2>
          </div>  
        <br>

        <div class="box-body">  
          <form id="formID" role="form" action="{{base_url('Fallos/Guardar')}}" method="POST" autocomplete="off">

            {{-- Resolución --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Resolucion (*)</label>
              <input type="text" class="form-control" name="resolucion" placeholder="N° Resolución ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['resolucion'] : ''}}" required>
              <input type="hidden" name="id_caso" value="{{$id_caso}}">
            </div>

            {{-- Fallo --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Fallo (*)</label>
              <input type="text" class="form-control" name="fallo" placeholder="Fallo ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['fallo'] :''}}" required>
            </div>

            {{-- Detalles --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Detalles</label>
              <textarea class="form-control" name="detalles" rows="8" placeholder="Detalles ...">{{isset($alertas[0]->Error) ? $old[0]->old['detalles'] :''}}</textarea>
            </div>

            {{-- tipo --}}
            <div class="form-group">                      
                @if($contador_casos == 0)
                <label>Tipo: PRIMERA INSTANCIA</label>
                <input type="hidden" value="PRIMERA INSTANCIA" name="tipo">    
                @else
                <label>Tipo: FINAL</label>
                <input type="hidden" value="FINAL" name="tipo">
                @endif                
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
                  <a href="{{base_url('Casos')}}" class="btn btn-block btn-danger btn-lg">Cancelar</a>
                </td>
              </tr>
            </table>
          </div>  
        </div>
      </div>
    </div>
  </section>  
@endsection

