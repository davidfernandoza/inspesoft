<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AudienciasController extends CI_Controller
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
	$this->load->model('Audiencias');
	$this->load->model('Personas');
	$this->load->model('Casos');
	$this->load->model('Comparendos');
	$this->load->model('Eventos');
}




/*-----------------------------------------------------------------------------------------------
* Index (view) 
*/
public function index()
{

	// Carga de datos desde la BD:
	$datos['audiencias'] = $this->Audiencias->index();

	if ($datos['audiencias'] == NULL || $datos['audiencias'] == '') 
	{
		$this->session->set_flashdata('Info','No hay audiencias para mostrar, crea la primera!!');
		redirect('Audiencias/Crear');
	}

		// Array de datos que se le pasan a la vista:
	$data = array(
		'title' => 'Audiencias',
		'audiencias'=> $datos['audiencias'],
		'auth'=> $this->sesion,
		'alertas'=>  $this->sesion
	);

		// LLamado de la vista blade:
	$this->blade->view('pages/audiencias/index', $data);
}


/*--------------------------------------------------------------------------------------------------
* Crear (view)
*/
public function create()
{
	date_default_timezone_set('UTC');
	date_default_timezone_set('America/Bogota');	
	$hoy = date("Y").'-'.date("m").'-'.date("d");
	$datos['eventos']=  $this->Eventos->audiencias($hoy);
	$data = array(
		'title' => 'Crear Audiencia',
		'eventos'=> $datos['eventos'],
		'auth'=> $this->sesion,
		'alertas'=>  $this->sesion,
		'old'=> $this->sesion
	);

	// LLamado de la vista blade:
	$this->blade->view('pages/audiencias/create', $data);
}


/*--------------------------------------------------------------------------------------------------
* Editar (view)
*/
public function show($id)
{	
	$id = urldecode($id);

	// Carga de datos desde la BD:
	$datos['audiencias'] = $this->Audiencias->detalles($id);

	date_default_timezone_set('UTC');
	date_default_timezone_set('America/Bogota');

	$fecha = split (" ", $datos['audiencias']->start); 

	// hora juridica
	$fecha = $fecha[0]." 18:00:00";

	// convertir a unix y agregarle  dias a la fecha de cracion
	$fecha_caducidad = strtotime('+3 day', strtotime($fecha));
	$fecha_actual = strtotime(date("Y").'-'.date("m").'-'.date("d").' '.date("H").':'.date("i").':'.date("s"));

// validar fecha de expiracion
	if ($fecha_actual > $fecha_caducidad) {
		$expire = TRUE;
	}
	else{
		$expire = FALSE;
	}

	// Convertir a fecha normal
	$fecha_caducidad = date("Y-m-d H:i:s", $fecha_caducidad);

	// Array de datos que se le pasan a la vista:
	$data = array(
		'title' => 'Ver Audiencias',
		'audiencia'=> $datos['audiencias'],
		'auth'=> $this->sesion,
		'expire'=>$expire,
		'alertas'=>  $this->sesion,
		'fecha_caducidad' => $fecha_caducidad
	);

	// LLamado de la vista blade:
	$this->blade->view('pages/audiencias/show', $data);
}


/*--------------------------------------------------------------------------------------------------
* Editar (view)
*/
public function edit($id)
{	
	$id = urldecode($id);

	// Carga de datos desde la BD:
	$datos['audiencias'] = $this->Audiencias->detalles($id);

	// Array de datos que se le pasan a la vista:
	$data = array(
		'title' => 'Actualizar Audiencias',
		'audiencia'=> $datos['audiencias'],
		'auth'=> $this->sesion,
		'expire'=>$expire,
		'alertas'=>  $this->sesion
	);

	// LLamado de la vista blade:
	$this->blade->view('pages/audiencias/edit', $data);
}

/*--------------------------------------------------------------------------------------------------
*  Método almacenar.
*/
public function store()
{
		// Captura del POST del formulario:
	$params['id']	=	$_POST["id"];
	$params['eventos']	=	$_POST["eventos"];
	$params['asistencia_d']	=	$_POST["asistencia_d"];
	$params['escusa_d']	=	isset($_POST["escusa_d"])?$_POST["escusa_d"]:'NO';
	$params['argumentos_d']	=	isset($_POST["argumentos_d"])?$_POST["argumentos_d"]:'NO';
	$params['pruebas_d']	=	isset($_POST["pruebas_d"])?$_POST["pruebas_d"]:'NO';
	$params['recursos_d']	=	isset($_POST["recursos_d"])?$_POST["recursos_d"]:'NO';
	$params['asistencia_c']	=	$_POST["asistencia_c"];
	$params['escusa_c']	=	isset($_POST["escusa_c"])?$_POST["escusa_c"]:'NO';
	$params['argumentos_c']	=	isset($_POST["argumentos_c"])?$_POST["argumentos_c"]:'NO';
	$params['pruebas_c']	=	isset($_POST["pruebas_c"])?$_POST["pruebas_c"]:'NO';
	$params['recursos_c']	=	isset($_POST["recursos_c"])?$_POST["recursos_c"]:'NO';
	$params['conciliacion']	=	isset($_POST["conciliacion"])?$_POST["conciliacion"]:'NO';
	$params['detalles']	=	$_POST["detalles"];
	
	if (isset($_POST["crear"])) {

			// Envio de los datos al modelo:
		$mensaje = $this->Audiencias->guardar(
			$params['id'],
			$params['eventos'],
			$params['asistencia_d'],
			$params['escusa_d'],
			$params['argumentos_d'],
			$params['pruebas_d'],
			$params['recursos_d'],
			$params['asistencia_c'],
			$params['escusa_c'],
			$params['argumentos_c'],
			$params['pruebas_c'],
			$params['recursos_c'],
			$params['conciliacion'],
			$params['detalles']
		);	

		if ($mensaje == '1') 
		{
			$this->session->set_flashdata('Status','La audiencia fue almacenada correctamente.');
			redirect('Audiencias/Ver/'.$params['id']);
		}
		else if ($mensaje == '2') {
			$this->session->set_flashdata('Error','La audiencia ya existe en la base de datos.');
			$this->session->set_userdata('old',$params);
			redirect('Audiencias/Crear');
		}
		else 
		{
			$this->session->set_flashdata('Error','El evento seleccionado ya tiene una adiencia.');
			$this->session->set_userdata('old',$params);
			redirect('Audiencias/Crear');
		}
	}
	else
	{
		redirect('Inicio'); 
	}				
}



/*--------------------------------------------------------------------------------------------------
*  Método actualizar.
*/
public function updatec()
{

		// Captura del POST del formulario:
	$params['id']=$_POST["id"];
	$params['escusa_c']	=	$_POST["escusa_c"];

	if (isset($_POST["actualizar"]))
	{
		// Envió de los datos al modelo:
		$mensaje = $this->Audiencias->actualizarc(
			$params['id'],
			$params['escusa_c']	
		);	

		if ($mensaje == '1') 
		{
			$this->session->set_flashdata('Status','La escusa fue almacenada correctamente.');
			redirect('Audiencias/Ver/'.$params['id']);		
		}
		else
		{
			$this->session->set_flashdata('Error','La escusa no se pudo almacenar.');
			redirect('Audiencias/Ver/'.$params['id']);
		}
	}
	else
	{
		redirect('Inicio');
	}
}	

	/*--------------------------------------------------------------------------------------------------
*  Método actualizar.
*/
public function updated()
{

		// Captura del POST del formulario:
	$params['id']=$_POST["id"];
	$params['escusa_d']	=	$_POST["escusa_d"];

	if (isset($_POST["actualizar"]))
	{


		// Envió de los datos al modelo:
		$mensaje = $this->Audiencias->actualizard(
			$params['id'],
			$params['escusa_d']	
		);	

		if ($mensaje == '1') 
		{
			$this->session->set_flashdata('Status','La escusa fue almacenada correctamente.');
			redirect('Audiencias/Ver/'.$params['id']);		
		}
		else
		{
			$this->session->set_flashdata('Error','La escusa no se pudo almacenar.');
			redirect('Audiencias/Ver/'.$params['id']);
		}
	}
	else
	{
		redirect('Inicio');
	}	
}


	/*--------------------------------------------------------------------------------------------------
*  Método actualizar.
*/
public function update()
{

		// Captura del POST del formulario:
	$params['id']=$_POST["id"];
	$params['detalles']	=	$_POST["detalles"];

	if (isset($_POST["actualizar"]))
	{


		// Envió de los datos al modelo:
		$mensaje = $this->Audiencias->actualizar(
			$params['id'],
			$params['detalles']	
		);	

		if ($mensaje == '1') 
		{
			$this->session->set_flashdata('Status','Los detalles de la audiencia fueron actualizados correctamente.');
			redirect('Audiencias/Ver/'.$params['id']);		
		}
		else
		{
			$this->session->set_flashdata('Error','Los detalles de la audiencia no se pudieron actualizar.');
			redirect('Audiencias/Ver/'.$params['id']);
		}
	}
	else
	{
		redirect('Inicio');
	}	
}
}
