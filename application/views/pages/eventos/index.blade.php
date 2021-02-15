@extends('layouts.app')

@section('content')


<section class="content-header">
  <h1 class="encuadre">
    Eventos
    <small>Calendario</small>
  </h1>

  {{-- Menu Routes --}}
  <ol class="breadcrumb encuadre">
    <li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
    <li class="active">Eventos</li>
  </ol>{{-- End Menu Routes --}}
</section>

{{-- Calendar --}}
<section class="content">
  <div class="row">
    <div class="col-md-1"></div>
    <div class="col-xs-10">
      <div class="box">
        <div id="calendar" ></div>   
      </div>       
    </div>
    <div class="col-md-1"></div>
  </div>    
</section>  


<!-- Modal -->
<div id="modalForm" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" id='headerModal'>
        <button id="closeBotton" type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title h3" id="tituloEvento"></h4>
      </div>
      <div class="modal-body">
        <input type="hidden" id="idEvento" name="idEvento"><br>

        <div class="form-row">
          {{-- Titulo --}}
          <div id="modalTitulo" class="form-group">
            <label>(*) Título:</label>  
            <input type="text" id="tituloModal" class="form-control" placeholder="Titulo">      
            <span id="tituloErrorModal" class="help-block"></span> 
          </div>

          {{-- Fecha --}}
          <input type="hidden" id="fechaModal">

          {{-- Hora --}}
          <div id="modalHora" class="form-group">
            <label>(*) Hora: </label>  
            <div class="input-group" data-autoclose="true">
              <div class="input-group-addon">
                <i class="fa  fa-clock-o"></i>
              </div>
              <input type="text" id="horaModal" name="horaModal" class="form-control" placeholder="hh:mm am/pm">
            </div>            
            <span id="horaErrorModal" class="help-block"></span>         
          </div>
        </div>
        

        {{-- Descripcion --}}
        <div class="form-group">
          <label>Descripción:</label>  
          <textarea id="descripcionModal" class="form-control" rows="3" placeholder="Descripción"></textarea>      
        </div>

          {{-- Comparendos --}}
            <div id="ComparendosDiv" class="form-group">
              <label>Comparendo:</label>
              <label id="ComparendoModal"></label>
              <select id="ComparendosModal" class="select2 form-control" style="width: 100%;" >
                <option value="NULL" selected="selected">SELECCIONAR (Ninguno)</option>                
                @foreach($comparendos as $comparendo)
                <option value="{{$comparendo->id}}">{{$comparendo->id}}</option>
                @endforeach
              </select>    
            </div>

            {{-- Casos --}}
            <div id="CasosDiv" class="form-group">
              <label>Caso:</label>
              <label id="CasoModal"></label>
              <select id="CasosModal" class="select2 form-control" style="width: 100%;" >
                <option value="NULL" selected="selected">SELECCIONAR (Ninguno)</option>               
                @foreach($casos as $caso)
                <option value="{{$caso->id}}">{{$caso->id." | ".$caso->asunto}}</option>
                @endforeach
              </select>   
            </div>

       {{-- Colores --}}
       <div class="form-group">
        <label >Color:</label>
        <ul class="fc-color-picker" id="color-chooser">
          <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
          <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
          <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
          <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
          <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
          <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
          <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
          <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
        </ul>            
      </div>
      <br><br>
      Los campos marcados con (*) son obligatorios. 
    </div>
    <div class="modal-footer">
     <button type="button" class="btn btn-success" id="guardarModal">Guardar</button>
     <button type="button" class="btn btn-warning" id="editarModal">Actualizar</button>
     <button type="button" class="btn btn-danger"  id="eliminarModal">Eliminar</button>
     <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>      
   </div>
 </div>

</div>
</div>



@endsection