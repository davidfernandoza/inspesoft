@extends('layouts.app')

@section('content')
<section class="content-header">
  <h1 class="encuadre">
    Crear
    <small>Caso</small>
  </h1>
  <ol class="breadcrumb encuadre">
    <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
    <li><a href="{{base_url('Casos')}}">Casos</a></li>
    <li>Crear Caso</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-header">
        <br>
        <div class="box-body">  
          <form id="formID" role="form" action="{{base_url('Casos/Guardar')}}" method="POST" autocomplete="off">

            {{-- ID --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Radicado (*)</label>
              <input type="text" class="form-control" name="id" placeholder="Radicado ..." 
              value="{{isset($alertas[0]->Error) ? $old[0]->old['id'] : ''}}" required>
            </div>

            {{-- Asunto --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Asunto (*)</label>
              <input type="text" class="form-control" name="asunto" placeholder="Asunto ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['asunto'] :''}}" required>
            </div>

            {{-- Hechos --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Hechos (*)</label>
              <textarea class="form-control" name="hechos" rows="8" placeholder="Hechos ..." required>{{isset($alertas[0]->Error) ? $old[0]->old['hechos'] :''}}</textarea>
            </div>
           
            {{-- N° Folio --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Numero de Folio</label>
              <input type="text" class="form-control" name="num_folio" placeholder="N° Folio ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['num_caja'] :''}}">
            </div>

            {{-- N° Caja --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Numero de Caja</label>
              <input type="text" class="form-control" name="num_caja" placeholder="N° Caja ..." value="{{isset($alertas[0]->Error) ? $old[0]->old['num_caja'] :''}}">
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

