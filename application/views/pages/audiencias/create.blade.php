@extends('layouts.app')

@section('content')
<section class="content-header">
  <h1 class="encuadre">
    Crear
    <small>Audiencias</small>
  </h1>
  <ol class="breadcrumb encuadre">
    <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
    <li><a href="{{base_url('Audiencias')}}">Audiencias</a></li>
    <li>Crear Audiencias</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-header">
        <br>
        <div class="box-body"> 
          <form id="formIDAu" role="form" action="{{base_url('Audiencias/Guardar')}}" method="POST" autocomplete="off">
        
            {{-- Id --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Numero de audiencia (*)</label>
              <input type="number" class="form-control" placeholder="Numero de audiencia ..." required name="id" value="{{isset($alertas[0]->Error) ? $old[0]->old['id'] : ''}}" />
            </div> 

            {{--  Evento --}}
            <div class="form-group">
              <label>Evento (*)</label>
              <select id="eventoAu" name="eventos" class="select2 form-control" style="width: 100%;" required >
               <option value="" selected="selected" disabled>SELECCIONAR</option> 
               @foreach($eventos as $evento)
               @if($evento->casos_id == '' || $evento->casos_id == NULL )
               <option value="{{$evento->id}}">{{'Comparendo: '.$evento->comparendos_id.' |'.$evento->title }}</option>
               @else
               <option value="{{$evento->id}}">{{'Caso: '.$evento->casos_id.' | '.$evento->title}}</option>
               @endif
               @endforeach
             </select>   
           </div>
           <br>
           <hr>
           <div class="form-row col-md-6">

            <h3 id="tipoPersona_d"></h3>
            <br>
            {{-- Asistencia --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Asistencia (*)</label>
              <br>
              <label class="radio-inline"><input type="radio" name="asistencia_d" required value="SI">SI</label>
              <label class="radio-inline"><input type="radio" name="asistencia_d" value="NO">NO</label>
            </div>

            {{-- Escusa --}}
            <div class="form-group ">
              <label class="control-label " for="inputError"></i>Escusa de asistencia</label>
              <br>
              <label class="radio-inline radiEsc_d"><input class="radiEsc_d" type="radio" name="escusa_d" value="VALIDA">VALIDA</label>
              <label class="radio-inline radiEsc_d"><input class="radiEsc_d" type="radio" name="escusa_d" value="INVALIDA">INVALIDA</label>
              <label class="radio-inline radiEsc_d"><input class="radiEsc_d" type="radio" name="escusa_d" value="NO">NO</label>
            </div>

            {{-- Argumentos --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Argumentos</label>
              <br>
              <label class="radio-inline camposAd"><input class="camposAd" type="radio" name="argumentos_d" required value="SI">SI</label>
              <label class="radio-inline camposAd"><input class="camposAd" type="radio" name="argumentos_d" value="NO">NO</label>
            </div>

            {{-- Pruebas --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Pruebas</label>
              <br>
              <label class="radio-inline camposAd"><input class="camposAd" type="radio" name="pruebas_d" required value="SI">SI</label>
              <label class="radio-inline camposAd"><input class="camposAd" type="radio" name="pruebas_d" value="NO">NO</label>
            </div>


            {{-- Recursos --}}
            <div class="form-group" >
              <label class="control-label radiDes" for="inputError"></i>Recursos</label>
              <br>
              <label class="radio-inline camposAd radiDes" >
                <input  class="radiDes camposAd" type="radio" name="recursos_d" value="SI">SI
              </label>
              <label class="radio-inline camposAd radiDes">
                <input  class="radiDes camposAd" type="radio" name="recursos_d" value="NO">NO
              </label>
            </div>

          </div>

          {{-- *********************** Contraventor ***************** --}}

          <div class="form-row  col-md-6">
            <h3 id="tipoPersona_c"></h3>
            <br>
            {{-- Asistencia --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Asistencia (*)</label>
              <br>
              <label class="radio-inline"><input type="radio" name="asistencia_c" required value="SI" >SI</label>
              <label class="radio-inline"><input type="radio" name="asistencia_c" value="NO" value="NO">NO</label>
            </div>

            {{-- Escusa --}}
            <div class="form-group">
              <label class="control-label " for="inputError"></i>Escusa de asistencia</label>
              <br>
              <label class="radio-inline radiEsc_c"><input class="radiEsc_c" type="radio" name="escusa_c" value="VALIDA">VALIDA</label>
              <label class="radio-inline radiEsc_c"><input class="radiEsc_c" type="radio" name="escusa_c" value="INVALIDA">INVALIDA</label>
              <label class="radio-inline radiEsc_c"><input class="radiEsc_c" type="radio" name="escusa_c" value="NO">NO</label>
            </div>

            {{-- Argumentos --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Argumentos</label>
              <br>
              <label class="radio-inline"><input class="camposAc" type="radio" name="argumentos_c" required value="SI">SI</label>
              <label class="radio-inline"><input class="camposAc" type="radio" name="argumentos_c" value="NO">NO</label>
            </div>

            {{-- Pruebas --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Pruebas</label>
              <br>
              <label class="radio-inline"><input class="camposAc" type="radio" name="pruebas_c" required  value="SI">SI</label>
              <label class="radio-inline"><input class="camposAc" type="radio" name="pruebas_c" value="NO">NO</label>
            </div>

            {{-- Recursos --}}
            <div class="form-group" >
              <label class="control-label radiDes" for="inputError"></i>Recursos</label>
              <br>
              <label class="radio-inline radiDes" >
                <input class="radiDes camposAc" type="radio" name="recursos_c" value="SI">SI
              </label>
              <label class="radio-inline radiDes" >
                <input class="radiDes camposAc" type="radio" name="recursos_c" value="NO">NO
              </label>
            </div>
            <br><br>
          </div>


          {{-- Conciliacion --}}
          <div class="form-group">        
            <label>Conciliación</label>
            <select  required name="conciliacion" class="form-control camposA" style="width: 100%;" >
              <option value="" selected="selected" disabled="">SELECCIONAR</option> 
              <option value="SI" >SI</option>
              <option value="NO" >NO</option>
            </select>   
          </div>

          {{-- Detalles --}}
            <div class="form-group">
              <label class="control-label" for="inputError"></i>Detalles</label>
              <textarea class="form-control" name="detalles" rows="10" placeholder="Detalles ..." >{{isset($alertas[0]->Error) ? $old[0]->old['detalles'] :''}}</textarea>
            </div>

          {{-- Botones  --}}
          <div class="form-group">
            <font size="2">Los campos marcados con (*) son obligatorios</font>
          </div>
          <div class="form-group">
            <table align="center" class="table table-bordered text-center">
              <tr>
                <td width="250">
                  <button id="guardar" type="submit" name="crear" class="btn btn-block btn-success btn-lg">Guardar</button>
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
  </div>
</section>  
@endsection

