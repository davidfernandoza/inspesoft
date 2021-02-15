@extends('layouts.app')

@section('content')

<section class="content-header">
	<h1 class="encuadre">
		Audiencias
		<small>Listado</small>
	</h1>

	{{-- Menu Routes --}}
	<ol class="breadcrumb encuadre">
		<li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
		<li class="active">Audiencias</li>
	</ol>{{-- End Menu Routes --}}
</section>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">		
					<div class="boton">
						<a type="button" href="{{base_url('Audiencias/Crear')}}" class="btn btn-success fa fa-plus">
							<spam class="nuevo"> Nuevo</spam></a>
						</div>

						<br>
						<div class="box-body">
							<div class="table-responsive">
								<table id="tb-tabla" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Numero de audiencia</th>
											<th>Titulo</th>
											<th>Caso</th>	
											<th>Comparendo</th>
											<th>Fecha y hora</th>																		
											<th>Acciones</th>
										</tr>
									</thead>
									<tbody>
										@foreach($audiencias as $audiencia)
										<tr align="center">
											<td>
												{{ $audiencia->id }}
											</td>
											<td>
												{{ $audiencia->title }}
											</td>
											<td>
												<a href="{{ base_url('Casos/Ver/'.$audiencia->casos_id) }}">{{ $audiencia->casos_id}}</a>
											</td>
											<td>
												<a href="{{ base_url('Comparendos/Ver/'.$audiencia->comparendos_id) }}">{{ $audiencia->comparendos_id}}</a>
											</td>
											<td>
												{{$audiencia->start}}
											</td>											
											<td>
												<table>
													<tr>
														<td>
															<a href="{{ base_url('Audiencias/Ver/'.$audiencia->id) }}" class='btn btn-sm btn-info fa fa-eye' title='Ver'></a>
															@if($auth[0]->Rol == "ADMINISTRADOR")     
															<a href="{{ base_url('Audiencias/Editar/'.$audiencia->id) }}" class='btn btn-sm btn-warning fa fa-edit' title='Editar Detalles'></a>
															@endif
														</td>														
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













