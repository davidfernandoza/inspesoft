<!doctype html>
<html lang="es">
<head>
	<meta http-equiv="content-type" content="text/html"/>
	<meta charset="UTF-8"/>
	<link rel="shortcut icon" href="{{base_url('resources/img/logos/favicon.ico')}}" type="image/
	x-icon"/>
	<link rel="stylesheet" href="{{(base_url('resources/plugins/bootstrap/css/bootstrap.min.css'))}}"/>
	<link rel="stylesheet" media="print" href="{{base_url('resources/css/own/pdf.css')}}"/>
	<script src="{{base_url('resources/plugins/jQuery/jquery-2.2.3.min.js')}}">
	</script>
	<script src="{{base_url('resources/plugins/moment/moment.min.js')}}"></script>
	<script src="{{base_url('resources/plugins/moment/es-moment.js')}}"></script>
	<script src="{{base_url('resources/plugins/bootstrap/js/bootstrap.min.js')}}" defer>
	</script>
	<script type="text/javascript">
		$(document).on("ready", function(){
			var fecha = $("#fechaCasoInicio").val();		
			var fechaFormat = moment(fecha).locale("es-moment").format('LL');
			$("#fechaCasoFormat").html(fechaFormat)
		});	
	</script>
	<style>
	.firma{
		position: relative;
		/*border:2px dashed red;*/
		float: left;
		width: 332px;
		padding-top: 50px;
	}
	.firmaBody{
		/*border:2px dashed green;*/
		width: 670px;
		display: table;
		margin-left: 30px;
		margin-right: 30px;
	}
	.tel{
		margin-bottom: 10px;
	}
	.btn{
		margin-bottom: 50px; 
		margin-left: 5px;
		margin-top:40px; 
	}
.title{
	font-family: Times New Roman;
	display: block;
    font-size: 18px;
    font-weight: bold;
}
p {
	margin-bottom: 20px;
}
.pjuramento{
	margin-top: 10px;
}
	    


</style>
<title>Inspesoft | {{ $title }}</title>
</head>
<body>
	<center>
		<table>
			<tr>
				<td align="justify">
					<table>
						<tr align="center">
							<td>
								<img src="{{base_url('resources/img/logos/strc-160.png')}}" width="75">
							</td>
							<td width="530">
								<h3 class="title">ALCALDIA MUNICIPAL<br>
									{{$impresiones->secretaria}} <br>
									SANTA ROSA DE CABAL</h3>
								</td>
								<td width="40"></td>
							</tr>
						</table>		
					</td>
				</tr>
				<tr align="justify">
					<table>
						<tr align="center">
							<td width="30">										
							</td>
							<td width="800">
								<h3 class="title">{{$impresiones->titulo}}</h3>
							</td>
							<td width="30"></td>
						</tr>
					</table>
				</tr>	
				<tr align="justify">		
					<td>
						<font face="arial" size="2" color="black">
							<table>
								<tr>
									<td width="30">
									</td>
									<td width="750">
										<p>
											<div>CASO: {{$casos[0]->id_casos}}</div>
										<div id="fechaCasoFormat"></div>
										</p>																											
										@foreach($casos as $caso)

										{{-- Denunciantes --}}
											@if($caso->tipo_involucrados == 'DENUNCIANTE')
												<div>NOMBRE DEL DENUNCIANTE: {{$caso->nombre_persona}}</div>
												<div>CEDULA DE CIUDADANIA: {{$caso->cedula ==''?'NO':$caso->cedula}}</div>
												<div>DIRECCION: {{$caso->direccion ==''?'NO':$caso->direccion}}</div>
												<div class="tel">TELEFONO: {{$caso->telefono ==''?'NO':$caso->telefono}}</div>
											@endif											
										@endforeach

										{{-- Ofendidos --}}
										@if($denunciantes == $ofendidos && $denunciantes > 1 )										
											<div class="tel">OFENDIDO: MISMOS DENUNCIANTES</div>
										@elseif($denunciantes == $ofendidos)
											<div class="tel">OFENDIDO: MISMO DENUNCIANTE</div>	
										@else

											@foreach($casos as $caso)
												@if($caso->subtipo == 'OFENDIDO')
													<div>NOMBRE DEL OFENDIDO: {{$caso->nombre_persona}}</div>
													<div>CEDULA DE CIUDADANIA: {{$caso->cedula ==''?'NO':$caso->cedula}}</div>
													<div>DIRECCION: {{$caso->direccion ==''?'NO':$caso->direccion}}</div>
													<div class="tel">TELEFONO: {{$caso->telefono ==''?'NO':$caso->telefono}}</div>
												@endif											
											@endforeach
										@endif

										@foreach($casos as $caso)
											@if($caso->tipo_involucrados == 'OFENDIDO')
												<div>NOMBRE DEL OFENDIDO: {{$caso->nombre_persona}}</div>
												<div>CEDULA DE CIUDADANIA: {{$caso->cedula ==''?'NO':$caso->cedula}}</div>
												<div>DIRECCION: {{$caso->direccion ==''?'NO':$caso->direccion}}</div>
												<div class="tel">TELEFONO: {{$caso->telefono ==''?'NO':$caso->telefono}}</div>
											@endif	
										@endforeach

										{{-- Contraventor --}}
										@foreach($casos as $caso)
										@if($caso->tipo_involucrados == 'CONTRAVENTOR')
										<div>CONTRAVENTOR: {{$caso->nombre_persona}}</div>
										<div>CEDULA DE CIUDADANIA: {{$caso->cedula ==''?'NO':$caso->cedula}}</div>
										<div>DIRECCION: {{$caso->direccion ==''?'NO':$caso->direccion}}</div>
										<div class="tel">TELEFONO: {{$caso->telefono ==''?'NO':$caso->telefono}}</div>
										@endif											
										@endforeach												
									</td>
									<td width="30"></td>
								</tr>
							</table>
						</font>
					</td>
				</tr>
				<tr align="justify">
					<table>
						<tr>
							<td width="40"></td>
							<td width="740">
								<font face="arial" size="2" color="black">
									<p align="justify" class="pjuramento"> 
										{{$impresiones->juramento}}
									</p>
									<p>ASUNTO: {{$casos[0]->asunto}}</p>									
									<p align="justify">HECHOS: {{$casos[0]->hechos}}</p>
								</font>
							</td>
							<td width="40"></td>
						</tr>
					</table>							
				</tr>
				<div class="firmaBody" >
					@for($i=1; $i<=$denunciantes; $i++)
					@if($dataDen[$i]->tipo_involucrados == 'DENUNCIANTE')											 
					<font face="arial" size="2" color="black">
						@if($i == 1)	
						<div class="firma">
							<div align="left">{{$impresiones->nombre}}</div>
							<div align="left">Inspector Rural Municipal</div>
						</div>
						<div class="firma">
							<div align="right" >{{$dataDen[$i]->nombre_persona}}</div>
							<div align="right">Querellante</div>								
						</div>
						@else	
						<div class="firma">
							<div align="{{$i%2 == 0? 'left':'right'}}">{{$dataDen[$i]->nombre_persona}}</div>
							<div align="{{$i%2 == 0? 'left':'right'}}">Querellante</div>
						</div>						
					</font>
						@endif						
					@endif
					@endfor
				</div>
				<br>

				<tr align="justify">
					<table>
						<tr>
							<td width="40"></td>
							<td width="740">
								<font face="arial" size="1" color="black">											
									<div>PROYECTO. ELABORÓ: {{$casos[0]->nombre_usuario}}</div>	
									{{$casos[0]}}								
								</font>
							</td>
							<td width="30"></td>
						</tr>
					</table>

				</tr>
				<tr align="justify">
					<table>
						<tr align="center">
							<td width="40"></td>
							<td width="740">
								<font face="arial" size="2" color="black">
									<br>											
									<div>{{'"'.$impresiones->lema.'"'}}</div>																
								</font>
								<font face="arial" size="2" color="black">																	
									<div>{{$impresiones->direccion.' Telefono PBX '.$impresiones->telefono.' - Fax '.$impresiones->fax}}</div>																
								</font>
								<font face="arial" size="2" color="black">																		
									<div>{{$impresiones->email.' - '.$impresiones->web}}</div>									
								</font>
							</td>
							<td width="40"></td>
						</tr>								
					</table>							
				</tr>
			</table>

		</font>
		<input class="btn btn-primary btn-md" name="Imprimir" type="submit" value="Imprimir" onclick="this.style.visibility='hidden' ; print(); this.style.visibility=''"/>
		<a href="{{base_url('Casos/Plantilla/Editar')}}" target="_blank" class='btn btn-warning btn-md noPrint'>Editar</a>
	</center>
</body>
</html>


