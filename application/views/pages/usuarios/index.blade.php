@extends('layouts.app')

@section('content')
	
	<section class="content-header">
		<h1 class="encuadre">
			Usuarios
			<small>Listado</small>
		</h1>

		{{-- Menu Routes --}}
		<ol class="breadcrumb encuadre">
			<li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
			<li class="active">Usuarios</li>
		</ol>{{-- End Menu Routes --}}
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">		
						<div class="boton">
							<a type="button" href="{{base_url('Usuarios/Crear')}}" class="btn btn-success fa fa-plus">
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
												<th>Correo electrónico</th>
												<th>Rol</th>
												<th>Estado</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tbody>
											@foreach($usuarios as $usuario)
											<tr align="center">
												<td>{{ $usuario->id }}</td>
												<td>{{ $usuario->primer_nombre.' '.$usuario->segundo_nombre }}</td>
												<td>{{ $usuario->primer_apellido.' '.$usuario->segundo_apellido }}</td>
												<td>{{ $usuario->email }}</td>
												<td>{{ $usuario->rol }}</td>
												<td>{{ $usuario->estado }}</td>
												<td>
													<center>
														<table>
															<tr>
																<td>
																	<a href="{{ base_url('Usuarios/Editar/'.$usuario->id) }}" class='btn btn-sm btn-warning fa fa-edit' title='Editar'></a>
																</td>
																<td>
																	@if($usuario->estado == 'ACTIVO')
																	<a href="{{ base_url('Usuarios/Eliminar/'.$usuario->id) }}" class='btn btn-sm btn-danger fa fa-trash' title='Eliminar'></a>
																	@else
																	<a href="{{ base_url('Usuarios/Activar/'.$usuario->id) }}" class='btn btn-sm btn-success fa fa-reply' title='Activar'></a>
																	@endif
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










					

   
