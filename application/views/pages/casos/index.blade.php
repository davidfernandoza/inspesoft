@extends('layouts.app')

@section('content')

<section class="content-header">
	<h1 class="encuadre">
		Casos
		<small>Listado</small>
	</h1>

	{{-- Menu Routes --}}
	<ol class="breadcrumb encuadre">
		<li><a href="{{base_url('Inicio')}}"><i class="fa fa-fw fa-th"></i>Inicio</a></li>
		<li class="active">Casos</li>
	</ol>{{-- End Menu Routes --}}
</section>

<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">		
					<div class="boton">
						<a type="button" href="{{base_url('Casos/Crear')}}" class="btn btn-success fa fa-plus">
							<spam class="nuevo"> Nuevo</spam></a>
						</div>

						<br>
						<div class="box-body">
							<div class="table-responsive">
								<table id="tb-tabla" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th>Radicado</th>
											<th>Asunto</th>											
											<th>Fecha de inicio</th>
											<th>Fecha de cierre</th>
											<th>Estado</th>
											<th>N° Folio</th>
											<th>N° Caja</th>												
											<th>Acciones</th>
										</tr>
									</thead>
									<tbody>
										@foreach($casos as $caso)
										<tr align="center">
											<td>{{ $caso->id }}</td>
											<td>{{ $caso->asunto }}</td>
											<td>{{ $caso->fecha_inicio}}</td>
											<td>{{ $caso->fecha_cierre }}</span></td>
											<td>{{ $caso->estado}}</td>		
											<td>{{ $caso->num_folios }}</td>
											<td>{{ $caso->num_caja }}</td>								
											<td>
												<table>
													<tr>
														<td>
															<a href="{{ base_url('Casos/Ver/'.$caso->id) }}" class='btn btn-sm btn-info fa fa-eye' title='Ver'></a>
														</td>
														@if($caso->estado == 'ACTIVO')
														@if($auth[0]->Rol == "ADMINISTRADOR")																
														<td>
															<a href="{{ base_url('Casos/Editar/'.$caso->id) }}" class='btn btn-sm btn-warning fa fa-edit' title='Editar'></a>
														</td>									
														@endif



														@if($caso->tipo == NULL || $caso->tipo != 'PRIMERA INSTANCIA')
														<td>
															<a href="{{ base_url('Fallos/Crear/'.$caso->id) }}" class='btn btn-sm btn-danger fa  fa-legal' title='Fallo'></a>
														</td>    
														@else
														<td>
															<a class='btn btn-sm btn-danger fa  fa-legal' title='Fallo' disabled></a>
														</td>
														@endif
														@else
														@if($auth[0]->Rol == "ADMINISTRADOR")																
														<td>
															<a class='btn btn-sm btn-warning fa fa-edit' title='Editar' disabled></a>
														</td>									
														@endif
														<td>
															<a class='btn btn-sm btn-danger fa  fa-legal' title='Fallo' disabled></a>
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













