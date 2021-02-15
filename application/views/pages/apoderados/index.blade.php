@extends('layouts.app')

@section('content')
	
	<section class="content-header">
		<h1 class="encuadre">
			Apoderados
			<small>Listado</small>
		</h1>

		{{-- Menu Routes --}}
		<ol class="breadcrumb encuadre">
			<li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
			<li class="active">Apoderados</li>
		</ol>{{-- End Menu Routes --}}
	</section>

	<section class="content">
		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">		
						<div class="boton">
							<a type="button" href="{{base_url('Apoderados/Crear')}}" class="btn btn-success fa fa-plus">
								<spam class="nuevo"> Nuevo</spam></a>
							</div>

							<br>
							<div class="box-body">
								<div class="table-responsive">
									<table id="tb-tabla" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>CC</th>
												<th>Tarjeta Pro</th>
												<th>Nombres</th>
												<th>Apellidos</th>
												<th>Teléfono</th>
												<th>Correo electrónico</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tbody>
											@foreach($apoderados as $apoderado)
											<tr align="center">
												<td>{{ $apoderado->id }}</td>
												<td>{{ $apoderado->targeta_pro }}</td>
												<td>{{ $apoderado->primer_nombre.' '.$apoderado->segundo_nombre }}</td>
												<td>{{ $apoderado->primer_apellido.' '.$apoderado->segundo_apellido }}</td>
												<td>{{ $apoderado->telefono }}</td>
												<td>{{ $apoderado->email }}</td>
												<td>
													<center>
													<table>
														<tr>
															<td>
																<a href="{{ base_url('Apoderados/Editar/'.$apoderado->id) }}" class='btn btn-sm btn-warning fa fa-edit' title='Editar'></a>
															</td>
															<td>
																<a href="{{ base_url('Apoderados/Ver/'.$apoderado->id) }}" class='btn btn-sm btn-info fa fa-eye' title='Ver'></a>
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










					

   
