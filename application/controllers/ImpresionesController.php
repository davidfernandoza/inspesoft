<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ImpresionesController extends CI_Controller
{

/*-------------------------------------------------------------------------------------------------
* Atributos 
*/
private  $sesion;


/*-------------------------------------------------------------------------------------------------
* Métodos
* Constructor:
*/
public function __construct()
{
	parent::__construct();

		// Carga de la base url:
	$this->load->helper('url');

		// Redireccionamiento de login:
	if ($this->session->userdata('OK') == FALSE)
	{
		$this->session->set_flashdata('Alert','Debes de iniciar sesión');
		redirect('Login');	
	}

		// Asignacion de objeto: 
	$objeto = new stdClass();

		// Parseo de datos de session:
	foreach ($this->session->userdata as $key => $value)
	{
		$objeto->$key = $value;
	}
	$this->sesion = [$objeto];

		// Carga del modelo
	$this->load->model('Casos');
	$this->load->model('Impresiones');
}


/*-----------------------------------------------------------------------------------------------
* Show (view) 
*/
public function show($id)
{
	$id = urldecode($id);

	$cantidad_denunciante = 0;
	$ofendido_num = 0;
	$aprobado_ofendido = 0;
	$contraventor = 0;

	// Carga de datos desde la BD:
	$datos['casos'] = $this->Casos->datos_globales($id);	
	$datos['impresiones'] = $this->Impresiones->index();

	if ($datos['casos'] == NULL || $datos['casos'] == '' || $datos['impresiones'] == NULL || $datos['impresiones'] == '') 
	{
		redirect('Inicio');
	}

	foreach ($datos['casos'] as $value) {

		if ($value->tipo_involucrados == 'DENUNCIANTE') {
			$cantidad_denunciante = $cantidad_denunciante + 1; 
			$dato[$cantidad_denunciante] = $value;			
		}

		if ($value->tipo_involucrados == 'DENUNCIANTE' && $value->subtipo == 'OFENDIDO') {
			$ofendido_num = $ofendido_num + 1; 
		}

		if($value->tipo_involucrados == 'OFENDIDO'){
			$aprobado_ofendido = 1;
		}

		if($value->tipo_involucrados == 'CONTRAVENTOR'){
			$contraventor = 1;
		}
	}

	if ($cantidad_denunciante ==0 || $contraventor ==0 ) {
		$this->session->set_flashdata('Alert','El caso no tiene una de las dos partes para imprimir, debe de tener denunciante y contraventor');
		redirect('Personas');
	}

	if ($aprobado_ofendido ==0 && $ofendido_num == 0){
		$this->session->set_flashdata('Alert','El caso no tiene ofendidos para imprimir.');
		redirect('Personas');
	}

	// var_dump( $datos['casos']);
	// var_dump($cantidad_denunciante);

	$data = array(
		'title' => 'Caso: '.$id,
		'casos'=> $datos['casos'],
		'impresiones'=>$datos['impresiones'],
		'denunciantes' => $cantidad_denunciante,
		'dataDen'=> $dato,
		'ofendidos'=> $ofendido_num,
		'aprobado'=> $aprobado_ofendido,
		'auth'=> $this->sesion,
		'alertas'=>  $this->sesion,
		'old'=> $this->sesion
	);

	// LLamado de la vista blade:
	$this->blade->view('prints/casos', $data);
}


/*-----------------------------------------------------------------------------------------------
* Edit (view) 
*/
public function edit()
{
	// Carga de datos desde la BD:
	$datos['impresiones'] = $this->Impresiones->index();
	$data = array(
		'title' => 'Actualizar Plantilla Casos',
		'plantillas'=>$datos['impresiones'],
		'auth'=> $this->sesion,
		'alertas'=>  $this->sesion,
		'old'=> $this->sesion
	);

	// LLamado de la vista blade:
	$this->blade->view('prints/plantilla', $data);
}

/*--------------------------------------------------------------------------------------------------
*  Método actualizar casos.
*/
public function update()
{

	// Captura del POST del formulario:
	$params['secretaria'] = mb_strtoupper($_POST["secretaria"]);
	$params['titulo'] = mb_strtoupper($_POST["titulo"]);
	$params['juramento'] = $_POST["juramento"];
	$params['nombre'] = mb_strtoupper($_POST["nombre"]);
	$params['lema'] = mb_strtoupper($_POST["lema"]);
	$params['direccion'] = mb_strtoupper($_POST["direccion"]);
	$params['telefono'] = $_POST["telefono"];
	$params['fax'] = $_POST["fax"];
	$params['email'] = mb_strtolower($_POST["email"]);
	$params['web'] = mb_strtolower($_POST["web"]);


	if (isset($_POST["actualizar"]))
	{

			// Envió de los datos al modelo:
		$mensaje = $this->Impresiones->actualizar(
			$params['secretaria'], 
			$params['titulo'], 
			$params['juramento'], 
			$params['nombre'], 
			$params['lema'], 
			$params['direccion'], 
			$params['telefono'], 
			$params['fax'], 
			$params['email'], 
			$params['web']
		);		

		if ($mensaje == '1') 
		{
			$this->session->set_flashdata('Status','La plantilla fue actualizada correctamente');
			redirect('Casos/Plantilla/Editar');
		}
		else 
		{
			$this->session->set_flashdata('Error','La plantilla no se pudo actualizar.');
			$this->session->set_userdata('old',$params);
			redirect('Casos/Plantilla/Editar');
		}
	}
	else
	{
		redirect('Inicio');
	}		
}
}