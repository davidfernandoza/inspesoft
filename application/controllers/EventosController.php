<?php
defined('BASEPATH') or exit('No direct script access allowed');


class EventosController extends CI_Controller
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
	$this->load->model('Apoderados');
	$this->load->model('Personas');
	// $this->load->model('Citas');
}




/*-----------------------------------------------------------------------------------------------
* Index (view) 
*/
public function index()
{

	$datos['casos'] = $this->Casos->eventos();
	$datos['comparendos'] = $this->Comparendos->eventos();

	$data = array(
		'title' => 'Eventos',
		'casos'=> $datos['casos'],
		'comparendos'=>$datos['comparendos'],
		'auth'=> $this->sesion,
		'alertas'=>  $this->sesion
	);

		// LLamado de la vista blade:
	$this->blade->view('pages/eventos/index', $data);
}

/*--------------------------------------------------------------------------------------------------
* Ver casos (view)
*/
public function show($id)
{
	$id = urldecode($id);

	// Carga de datos desde la BD:
	$datos['eventos'] = $this->Eventos->detalles($id);
	if ($datos['eventos'] == NULL || $datos['eventos'] == '') 
	{
		redirect('Inicio');
	}

	$data = array(
		'title' => 'Ver Evento',
		'eventos'=> $datos['eventos'],
		'auth'=> $this->sesion
	);

	// LLamado de la vista blade:
	$this->blade->view('pages/eventos/show', $data);
}

/*-----------------------------------------------------------------------------------------------
* Consult (ajax) 
*/
public function consult()
{
	// Carga de datos desde la BD:
	$datos['eventos'] = $this->Eventos->index();
	echo json_encode($datos['eventos']);
}

/*-----------------------------------------------------------------------------------------------
* Details (ajax) 
*/
public function notifications()
{
	$params['fecha'] = $_POST["fecha"];

	$datos['eventos'] = $this->Eventos->notificaciones($params['fecha']);
	echo json_encode($datos['eventos']);
}

/*-----------------------------------------------------------------------------------------------
* Actions (ajax) 
*/
public function actions($acciones)
{
	$acciones = urldecode($acciones);
	$params['titulo'] = mb_strtoupper($_POST["title"]);

	if ($_POST["casos_id"] != 'NULL' && $_POST["comparendos_id"] != 'NULL') {
		$respuesta = array('type'=>'Error','msg'=>'El evento solo puede contener un caso o un comparendo.');
	}
	else{
		if ($_POST["casos_id"] == 'NULL') {
			$_POST["casos_id"] = NULL;
		}

		if ($_POST["comparendos_id"] == 'NULL') {
			$_POST["comparendos_id"] = NULL;
		}
		if ($_POST["descripcion"] == '') {
			$params['descripcion'] = NULL;
		}
		else{
			$params['descripcion'] = $_POST["descripcion"];
		}

		switch ($acciones) {
			case 'agregar':
			$mensaje = $this->Eventos->guardar(
				$params['titulo'],
				$_POST["start"],
				$_POST["color"],
				$params['descripcion'],
				$_POST["casos_id"],
				$_POST["comparendos_id"]
			);
			$respuesta = array('type'=>'Success');
			break;
			case 'editar':
			$mensaje = $this->Eventos->actualizar(
				$_POST["id"],
				$params['titulo'],
				$_POST["start"],
				$_POST["color"],
				$params['descripcion']
			);
			if ($mensaje != '1') 
			{		
				$respuesta = array('type'=>'Error','msg'=>'El evento no existe en la base de datos');
			}
			else{
				$respuesta = array('type'=>'Success');
			}
			break;
			default:
			$mensaje = $this->Eventos->eliminar(
				$_POST["id"]
			);
			if ($mensaje == '2') 
			{		
				$respuesta = array('type'=>'Error','msg'=>'El evento no existe en la base de datos.');
			}
			else if ($mensaje == '3') 
			{		
				$respuesta = array('type'=>'Error','msg'=>'El evento no se puede borrar. Hay una audiencia que depende de este.');		
			}
			else{
				$respuesta = array('type'=>'Success');
			}
			break;
		}
	}	
	echo json_encode($respuesta);
}


}