<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ApoderadosController extends CI_Controller
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
	$this->load->model('Casos');
}




/*-----------------------------------------------------------------------------------------------
* Index (view) 
*/
public function index()
{

	// Carga de datos desde la BD:
	$datos['apoderados'] = $this->Apoderados->index();

	if ($datos['apoderados'] == NULL || $datos['apoderados'] == '') 
	{
		$this->session->set_flashdata('Info','No hay apoderados para mostrar, crea el primero!!');
		redirect('Apoderados/Crear');
	}
		// Array de datos que se le pasan a la vista:
	$data = array(
		'title' => 'Apoderados',
		'apoderados'=> $datos['apoderados'],
		'auth'=> $this->sesion,
		'alertas'=>  $this->sesion
	);

		// LLamado de la vista blade:
	$this->blade->view('pages/apoderados/index', $data);
}


/*--------------------------------------------------------------------------------------------------
* Crear usuario (view)
*/
public function create()
{
	
	$data = array(
		'title' => 'Crear Apoderado',
		'auth'=> $this->sesion,
		'alertas'=>  $this->sesion,
		'old'=> $this->sesion
	);

	// LLamado de la vista blade:
	$this->blade->view('pages/apoderados/create', $data);
}



/*--------------------------------------------------------------------------------------------------
* Editar usuario (view)
*/
public function edit($id)
{	

	$id = urldecode($id);
		// Consulta del usuario en la BD:
	$datos['apoderados'] = $this->Apoderados->detalles($id);

	if ($datos['apoderados'] == NULL || $datos['apoderados'] == '') 
	{
		redirect('Inicio');
	}
	
		// Array de datos que se le pasan a la vista:
	$data = array(
		'title' => 'Edicion Apoderados',
		'apoderados'=> $datos['apoderados'],
		'auth'=> $this->sesion,
		'old'=> $this->sesion,
		'alertas'=>  $this->sesion
	);

		// LLamado de la vista blade:
	$this->blade->view('pages/apoderados/edit', $data);
}


/*--------------------------------------------------------------------------------------------------
* Editar usuario (view)
*/
public function show($id)
{	
	$id = urldecode($id);

	// Carga de datos desde la BD:
	$datos['personas'] = $this->Personas->ver_apoderados($id);
	$datos['casos'] = $this->Casos->ver_apoderados($id);
	$datos['apoderados'] = $this->Apoderados->detalles($id);


	if ($datos['apoderados'] == NULL || $datos['apoderados'] == '') 
	{
		redirect('Inicio');
	}

	// Array de datos que se le pasan a la vista:
	$data = array(
		'title' => 'Ver Apoderados',
		'personas'=> $datos['personas'],
		'apoderados'=> $datos['apoderados'],
		'casos'=> $datos['casos'],
		'auth'=> $this->sesion,
		'alertas'=>  $this->sesion
	);

	// LLamado de la vista blade:
	$this->blade->view('pages/apoderados/show', $data);
}


/*--------------------------------------------------------------------------------------------------
*  Método almacenar usuario.
*/
public function store()
{
		// Captura del POST del formulario:
	$params['id']=$_POST["id"];
	$params['targeta_pro'] = mb_strtoupper($_POST["targeta_pro"]);
	$params['primer_nombre'] = mb_strtoupper($_POST["primer_nombre"]);
	$params['segundo_nombre'] = mb_strtoupper($_POST["segundo_nombre"]);
	$params['primer_apellido'] = mb_strtoupper($_POST["primer_apellido"]);
	$params['segundo_apellido'] = mb_strtoupper($_POST["segundo_apellido"]);
	$params['email'] = mb_strtolower($_POST["email"]);
	$params['telefono'] = $_POST["telefono"];


if($params['email'] == ""){
	$params['email'] = null;
}

	if (isset($_POST["crear"])) {

			// Envio de los datos al modelo:
		$mensaje = $this->Apoderados->guardar(
			$params['id'],
			$params['targeta_pro'],
			$params['primer_nombre'],
			$params['segundo_nombre'],
			$params['primer_apellido'],
			$params['segundo_apellido'],
			$params['email'],
			$params['telefono'],
			'ACTIVO'
		);	

		if ($mensaje == '1') 
		{
			$this->session->set_flashdata('Status','El apoderado fue almacenado correctamente');
			redirect('Apoderados/Ver/'.$params['id']);
		}
		else if($mensaje == '2')
		{
			$this->session->set_flashdata('Error','El apoderado ya existe en la base de datos');
			$this->session->set_userdata('old',$params);
			redirect('Apoderados/Crear');
		}
		else 
		{
			$this->session->set_flashdata('Error','El correo electrónico ya existe en la base de datos');
			$this->session->set_userdata('old',$params);
			redirect('Apoderados/Crear');
		}
	}
	else
	{
		redirect('Apoderados'); 
	}				
}



/*--------------------------------------------------------------------------------------------------
*  Método actualizar usuario.
*/
public function update()
{

		// Captura del POST del formulario:
	$params['id']=$_POST["id"];
	$params['new_id']=$_POST["new_id"];
	$params['targeta_pro'] = mb_strtoupper($_POST["targeta_pro"]);
	$params['new_targeta_pro'] = mb_strtoupper($_POST["new_targeta_pro"]);
	$params['primer_nombre'] = mb_strtoupper($_POST["primer_nombre"]);
	$params['segundo_nombre'] = mb_strtoupper($_POST["segundo_nombre"]);
	$params['primer_apellido'] = mb_strtoupper($_POST["primer_apellido"]);
	$params['segundo_apellido'] = mb_strtoupper($_POST["segundo_apellido"]);
	$params['email'] = mb_strtolower($_POST["email"]);
	$params['new_email'] = mb_strtolower($_POST["new_email"]);
	$params['telefono'] = $_POST["telefono"];

	if (isset($_POST["actualizar"]))
	{

			// Envió de los datos al modelo:
		$mensaje = $this->Apoderados->actualizar(
			$params['id'],
			$params['new_id'],
			$params['targeta_pro'],
			$params['new_targeta_pro'],
			$params['primer_nombre'],
			$params['segundo_nombre'],
			$params['primer_apellido'],
			$params['segundo_apellido'],
			$params['email'],
			$params['new_email'],
			$params['telefono'],
			'ACTIVO'		
		);	

		if ($mensaje == '1') 
		{
			$this->session->set_flashdata('Status','El apoderado fue actualizado correctamente');
			redirect('Apoderados/Ver/'.$params['new_id']);
			

		}
		else if($mensaje == '2')
		{
			$this->session->set_flashdata('Error','El Apoderado ya existe en la base de datos (revisa la identificación o tarjeta profesional)');
			$this->session->set_userdata('old',$params);
			redirect('Apoderados/Editar/'.$params['id']);
		}
		else 
		{
			$this->session->set_flashdata('Error','El correo electrónico ya existe en la base de datos');
			$this->session->set_userdata('old',$params);
			redirect('Apoderados/Editar/'.$params['id']);
		}
	}
	else
	{
		redirect('Apoderados');
	}		
}

/*--------------------------------------------------------------------------------------------------
*  Método destruir usuario (inavilita al usuario mas no lo elimina).
*/
public function delete($id)
{
		// Captura de datos:
	$params['id'] = $id;
	$params['estado'] = "INACTIVO";



		// Envió de los datos al modelo:
	$mensaje = $this->Apoderados->desactivar(
		$params['id'],
		$params['estado']
	);	

	if ($mensaje == '1') 
	{
		$this->session->set_flashdata('Status','El usuario fue desactivado correctamente');
		redirect('Apoderados');
	}
	else if ($mensaje == '2')
	{
		$this->session->set_flashdata('Error','No se puede desactivar el usuario actual');
		redirect('Apoderados');
	}
	else	
	{
		$this->session->set_flashdata('Error','El usuario no existe en la base de datos');
		redirect('Apoderados');
	}
	
}



/*--------------------------------------------------------------------------------------------------
*  Método activar usuario.
*/
public function activate($id)
{
		// Captura de datos:
	$params['id'] = $id;
	$params['estado'] = "ACTIVO";



		// Envió de los datos al modelo:
	$mensaje = $this->Apoderados->activar(
		$params['id'],
		$params['estado']
	);	

	if ($mensaje == '1') 
	{
		$this->session->set_flashdata('Status','El usuario fue activado correctamente');
		redirect('Apoderados');
	}
	else if($mensaje == '2')
	{
		$this->session->set_flashdata('Error','No se puede activar el usuario actual');
		redirect('Apoderados');
	}
	else
	{
		$this->session->set_flashdata('Error','El usuario no existe en la base de datos');
		redirect('Apoderados');
	}
}
}