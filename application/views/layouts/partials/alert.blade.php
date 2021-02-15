@if(isset($alertas[0]->Error))
  <div class="alert alert-danger alert-dismissible callout callout-danger " >
    <button type="button" class="close fa fa-fw fa-remove" data-dismiss="alert" aria-hidden="true"></button>
    <h4><i class="icon fa fa-ban"></i> Error!</h4>
    <lu>
      @foreach($alertas as $error)
      <li>{{$error->Error}}</li>
      @endforeach
    </lu>
  </div>
@endif

@if(isset($alertas[0]->Status))
  <div class="alert alert-danger alert-dismissible callout callout-success " >
    <button type="button" class="close fa fa-fw fa-remove" data-dismiss="alert" aria-hidden="true"></button>
    <h4><i class="icon fa fa-check"></i> Felicidades!</h4>
    @foreach($alertas as $estado)
      <li>{{$estado->Status}}</li>
    @endforeach
  </div>
@endif

@if(isset($alertas[0]->Info))
  <div class="alert alert-danger alert-dismissible callout callout-info " >
    <button type="button" class="close fa fa-fw fa-remove" data-dismiss="alert" aria-hidden="true"></button>
    <h4><i class="icon fa fa-info"></i> Información!</h4>
    @foreach($alertas as $estado)
      <li>{{$estado->Info}}</li>
    @endforeach
  </div>
@endif


@if(isset($alertas[0]->Alert))
  <div class="alert alert-warning alert-dismissible callout callout-warning " >
    <button type="button" class="close fa fa-fw fa-remove" data-dismiss="alert" aria-hidden="true"></button>
    <h4> <i class="fa fa-fw fa-exclamation-triangle"></i> Advertencia!!</h4>
    @foreach($alertas as $alerta)
      <li>{{$alerta->Alert}}</li>
    @endforeach
  </div>
@endif


