@extends('layouts.app')

@section('content')
<section class="content-header">
  <h1 class="encuadre">
    Involucrar
    <small>Persona</small>
  </h1>
  <ol class="breadcrumb encuadre">
    <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
    <li><a href="{{base_url('Personas')}}">Personas</a></li>
    <li>Involucar Persona</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-header">
        <div class="box-header with-border">
          <h2 class="box-title">
            {{$persona->primer_nombre." ".$persona->segundo_nombre." ".$persona->primer_apellido." ".$persona->segundo_apellido." "}}
          </h2>
        </div> 
        <br>
        <div class="box-body">  
          <form id="formID" role="form" action="{{base_url('Personas/Implicar')}}" method="POST" autocomplete="off">

            {{-- Comparendos --}}
            <div id="personasAdd2" class="form-group">
              <label>Comparendo (A)</label>
              <select id="comparendos" name="comparendos" class="select2 form-control" style="width: 100%;" >
                <option value="NULL" selected="selected" >SELECCIONAR</option>                
                @foreach($comparendos as $comparendo)
                <option value="{{$comparendo->id}}">{{$comparendo->id}}</option>
                @endforeach
              </select>
              <span id="error2" class="help-block"></span> 
              <input id="comparendosHidden" type="hidden" name="comparendos" value="NULL">     
            </div>
            <input type="hidden" name='idpersona' value={{$persona->id}}>

            {{-- Casos --}}
            <div id="personasAdd1" class="form-group">
              <label>Caso (B)</label>
              <select id="casos" name="casos" class="select2 form-control" style="width: 100%;" >
                <option value="NULL" selected="selected" >SELECCIONAR</option>      
                
                @foreach($casos as $caso)
                <option value="{{$caso->id}}">{{$caso->id." | ".$caso->asunto}}</option>    
                @endforeach
              </select>
              <span id="error1" class="help-block"></span>
              <input id="casosHidden" type="hidden" name="casos" value="NULL">     
            </div>

            {{-- Apoderado --}}
            <div class="form-group">
              <label>Apoderado</label>
              <select id="apoderados" name="apoderados" class="select2 form-control" style="width: 100%;" >
                <option value="NULL" selected="selected">SELECCIONAR</option>              
                @foreach($apoderados as $apoderado)
                <option value="{{$apoderado->id}}">{{$apoderado->id." | ".$apoderado->targeta_pro." | ".$apoderado->primer_nombre." ".$apoderado->segundo_nombre." ".$apoderado->primer_apellido." ".$apoderado->segundo_apellido}}</option>
                @endforeach
              </select>
              <input id="apoderadosHidden" type="hidden" name="apoderados" value="NULL">
            </div>

            {{--  Tipo --}}
            <div class="form-group">
              <label>Tipo (b)</label>                 
              <select onchange="selectTipo()" id="tipoPersona" name="tipo" class="form-control"  style="width: 100%;">
                <option value="NULL" selected="selected">SELECCIONAR</option> 
                <option value="DENUNCIANTE">DENUNCIANTE</option>
                <option value="OFENDIDO">OFENDIDO</option>
                <option value="CONTRAVENTOR">CONTRAVENTOR</option>
              </select>
              <input id="tipoPersonaHidden" type="hidden" name="tipo" value="NULL">
            </div>

            {{-- SubTipo --}}
            <div class="form-group">
              <label>Subtipo </label>                 
              <select id="subtipoPersona" name="subtipo" class="form-control" style="width: 100%;" disabled>
                <option value="NULL" selected="selected">SELECCIONAR</option> 
                <option value="OFENDIDO">OFENDIDO</option>
              </select>
              <input id="subtipoPersonaHidden" type="hidden" name="subtipo" value="NULL">
            </div>


            {{-- Botones  --}}
            <div class="form-group">
              <font size="2">Los campos marcados con (*) son obligatorios.</font> 
              <br>
              <font size="2">En los campos marcados con (A) o (B) es obligatorio seleccionar tan solo uno.</font>
              <br>
              <font size="2">Si existe un campo con (b) es porque depende de un campo (B), se debe llenar los dos.</font>
            </div>
            <div class="form-group">
              <table align="center" class="table table-bordered text-center">
                <tr>
                  <td width="250">
                    <button id="crearPersona" type="submit" name="involucar" class="btn btn-block btn-success btn-lg">Involucrar</button>
                  </form>
                </td>
                <td width="250">
                  <a href="{{base_url('Personas')}}" class="btn btn-block btn-danger btn-lg">Cancelar</a>
                </td>
              </tr>
            </table>
          </div>  
        </div>
      </div>
    </div>
  </section>  
  @endsection

