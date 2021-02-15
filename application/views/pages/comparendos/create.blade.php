@extends('layouts.app')

@section('content')
<section class="content-header">
  <h1 class="encuadre">
    Crear
    <small>Comparendo</small>
  </h1>
  <ol class="breadcrumb encuadre">
    <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
    <li><a href="{{base_url('Comparendos')}}">Comparendos</a></li>
    <li>Crear Comparendo</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-header">
        <br>
        <div class="box-body">  
          <form id="formID" role="form" action="{{base_url('Comparendos/Guardar')}}" method="POST" autocomplete="off">

            {{-- ID --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Numero de comparendo (*)</label>
              <input type="text" class="form-control" name="id" placeholder="Numero de comparendo ..." 
              value="{{isset($alertas[0]->Error) ? $old[0]->old['id'] : ''}}" required>
            </div>

            {{-- Fecha --}}
            <div class="form-group">
              <label>Fecha (*)</label>
              <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control pull-right" id="datepicker" name="fecha" value="{{isset($alertas[0]->Error) ? $old[0]->old['fecha'] : ''}}" required
                placeholder="AAAA-MM-DD">
              </div>
            </div>

            {{-- Articulo --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Articulo (*)</label>
              <textarea class="form-control" name="articulo" rows="8" placeholder="Articulo ..." required>{{isset($alertas[0]->Error) ? $old[0]->old['articulo'] :''}}</textarea>
            </div>

            {{-- Tipo --}}
            <div id="personasAdd2" class="form-group">
              <label>Tipo (*)</label>
              <select  name="tipo" class="form-control" style="width: 100%;" required>
                <option {{isset($alertas[0]->Error) ? '' :'selected = selected'}} value="NULL" disabled>SELECCIONAR</option> 
                <option {{isset($alertas[0]->Error) ? $tipo[0] :''}} value="1">1</option>
                <option {{isset($alertas[0]->Error) ? $tipo[1] :''}} value="2">2</option>
                <option {{isset($alertas[0]->Error) ? $tipo[2] :''}} value="3">3</option>
                <option {{isset($alertas[0]->Error) ? $tipo[3] :''}} value="4">4</option>
              </select>   
            </div>
            
            {{-- Numeral --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Numeral (*)</label>
              <input type="text" class="form-control" name="numeral" placeholder="Numeral ..." 
              value="{{isset($alertas[0]->Error) ? $old[0]->old['numeral'] : ''}}" required>
            </div>

            {{-- Literal --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Literal </label>
              <input type="text" class="form-control" name="literal" placeholder="Literal ..." 
              value="{{isset($alertas[0]->Error) ? $old[0]->old['literal'] : ''}}">
            </div>

            {{-- Multa --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Multa</label>
              <input type="number" class="form-control" name="multa" placeholder="Multa ..." 
              value="{{isset($alertas[0]->Error) ? $old[0]->old['multa'] : ''}}" >
            </div>


            {{-- N° Folio --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Numero de Folio</label>
              <input type="text" class="form-control" name="num_folio" placeholder="N° Folio ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['num_folio'] :''}}">
            </div>

            {{-- N° Caja --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Numero de Caja</label>
              <input type="text" class="form-control" name="num_caja" placeholder="N° Caja ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['num_caja'] :''}}">
            </div>

            {{-- Estado --}}
            <div id="personasAdd2" class="form-group">
              <label>Estado (*)</label>
              <select  name="estado" class="form-control" style="width: 100%;" required>
                <option {{isset($alertas[0]->Error) ? '' :'selected = selected'}} value="NULL" disabled>SELECCIONAR</option> 
                <option {{isset($alertas[0]->Error) ? $estado[0] :''}} value="ACEPTADO">ACEPTADO</option>
                <option {{isset($alertas[0]->Error) ? $estado[1] :''}} value="APELADO">APELADO</option>                
              </select>   
            </div>


            {{-- Botones  --}}
            <div class="form-group">
              <font size="2">Los campos marcados con (*) son obligatorios</font>
            </div>
            <div class="form-group">
              <table align="center" class="table table-bordered text-center">
                <tr>
                  <td width="250">
                    <button type="submit" name="crear" class="btn btn-block btn-success btn-lg">Siguiente</button>
                  </form>
                </td>
                <td width="250">
                  <a href="{{base_url('Comparendos')}}" class="btn btn-block btn-danger btn-lg">Cancelar</a>
                </td>
              </tr>
            </table>
          </div>  
        </div>
      </div>
    </div>
  </section>  
  @endsection

