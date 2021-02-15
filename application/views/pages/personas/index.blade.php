@extends('layouts.app')

@section('content')

<section class="content-header">
	<h1 class="encuadre">
		Personas
		<small>Listado</small>
	</h1>

	{{-- Menu Routes --}}
	<ol class="breadcrumb encuadre">
		<li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
		<li class="active">Personas</li>
	</ol>{{-- End Menu Routes --}}
</section>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">		
					<div class="boton">
						<a type="button" href="{{base_url('Personas/Crear')}}" class="btn btn-success fa fa-plus">
							<spam class="nuevo"> Nuevo</spam></a>
						</div>

						<br>
						<div class="box-body">
							<div class="table-responsive">
								<table id="tb-tabla" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>CC</th>
											<th>Nombres</th>
											<th>Apellidos</th>
											<th>Dirección</th>
											<th>Teléfono</th>
											<th>Acciones</th>
										</tr>
									</thead>
									<tbody>
										@foreach($personas as $persona)
										<tr align="center">
											<td>{{ $persona->cedula }}</td>
											<td>{{ $persona->primer_nombre.' '.$persona->segundo_nombre }}</td>
											<td>{{ $persona->primer_apellido.' '.$persona->segundo_apellido }}</td>
											<td>{{ $persona->direccion }}</td>
											<td>{{ $persona->telefono }}</td>
											<td>
												<center>
													<table>
														<tr>
															<td>
																<a href="{{ base_url('Personas/Ver/'.$persona->id) }}" class='btn btn-sm btn-info fa fa-eye' title='Ver'></a>
															</td>
															@if ($auth[0]->Rol == 'ADMINISTRADOR')
															<td>
																<a href="{{ base_url('Personas/Editar/'.$persona->id) }}" class='btn btn-sm btn-warning fa fa-edit' title='Editar'></a>
															</td>
															@endif
															<td>
																<a href="{{ base_url('Personas/Involucrar/'.$persona->id) }}" class='btn btn-sm btn-primary fa fa-plus' title='Involucrar'></a>
															</td>
														</tr>
													</table>
												</center>                         
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













