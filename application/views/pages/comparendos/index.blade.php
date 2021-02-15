@extends('layouts.app')

@section('content')

<section class="content-header">
	<h1 class="encuadre">
		Comparendos
		<small>Listado</small>
	</h1>

	{{-- Menu Routes --}}
	<ol class="breadcrumb encuadre">
		<li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
		<li class="active">Comparendos</li>
	</ol>{{-- End Menu Routes --}}
</section>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">		
					<div class="boton">
						<a type="button" href="{{base_url('Comparendos/Crear')}}" class="btn btn-success fa fa-plus">
							<spam class="nuevo"> Nuevo</spam></a>
						</div>

						<br>
						<div class="box-body">
							<div class="table-responsive">
								<table id="tb-tabla" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Numero de comparendo</th>																					
											<th>Tipo</th>
											<th>Numeral</th>
											<th>Literal</th>
											<th>Estado</th>										
											<th>Acciones</th>
										</tr>
									</thead>
									<tbody>
										@foreach($comparendos as $comparendo)
										<tr align="center">
											<td>{{ $comparendo->id }}</td>											
											<td>{{ $comparendo->tipo}}</td>
											<td>{{ $comparendo->numeral }}</td>
											<td>{{ $comparendo->literal}}</td>
											@if($comparendo->estado == 'CONTRA')
											<td>FALLO EN CONTRA</td>
											@elseif($comparendo->estado == 'FAVOR')
											<td>FALLO A FAVOR</td>
											@else
											<td>{{ $comparendo->estado }}</td>
											@endif		
											<td>												
												<table>
													<tr>
														<td>
															<a href="{{ base_url('Comparendos/Ver/'.$comparendo->id) }}" class='btn btn-sm btn-info fa fa-eye' title='Ver'></a>
														</td>
														@if($auth[0]->Rol == "ADMINISTRADOR")																
														<td>
															<a href="{{ base_url('Comparendos/Editar/'.$comparendo->id) }}" class='btn btn-sm btn-warning fa fa-edit' title='Editar'></a>
														</td>											
														@endif
													</tr>
												</table>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>					
				</div>
			</div>
		</div>		
	</section>		
	@endsection










	

	
