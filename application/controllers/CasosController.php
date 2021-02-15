<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CasosController extends CI_Controller
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
	$this->load->model('Fallos');
	$this->load->model('Comparendos');
	$this->load->model('Involucrados');
	$this->load->model('Apoderados');
	$this->load->model('Representaciones');
}


/*-----------------------------------------------------------------------------------------------
* Index (view) 
*/
public function index()
{

		// Carga de datos desde la BD:
	$datos['casos'] = $this->Casos->index();

	if ($datos['casos'] == NULL || $datos['casos'] == '') 
	{
		$this->session->set_flashdata('Info','No hay casos para mostrar, crea el primero!!');
		redirect('Casos/Crear');
	}

		// Array de datos que se le pasan a la vista:
	$data = array(
		'title' => 'Casos',
		'casos'=> $datos['casos'],
		'auth'=> $this->sesion,
		'alertas'=>  $this->sesion
	);
		// LLamado de la vista blade:
	$this->blade->view('pages/casos/index', $data);
}

/*--------------------------------------------------------------------------------------------------
* Ver casos (view)
*/
public function show($id)
{
	$id = urldecode($id);

	// Carga de datos desde la BD: 
	$datos['casos'] = $this->Casos->datos_globales($id);
	$datos['fallos'] = $this->Fallos->detalles($id);

	if ($datos['casos'] == NULL || $datos['casos'] == '') 
	{
		redirect('Inicio');
	}

	$data = array(
		'title' => 'Ver Caso',
		'casos'=> $datos['casos'],
		'fallos' => $datos['fallos'],
		'auth'=> $this->sesion,
		'alertas'=>  $this->sesion,
		'old'=> $this->sesion
	);

	// LLamado de la vista blade:
	$this->blade->view('pages/casos/show', $data);
}


/*--------------------------------------------------------------------------------------------------
* Crear casos (view)
*/
public function create()
{
	// var_dump($this->sesion[0]->old['id']);
	$data = array(
		'title' => 'Crear Caso',		
		'auth'=> $this->sesion,
		'alertas'=>  $this->sesion,
		'old'=> $this->sesion
	);

	// LLamado de la vista blade:
	$this->blade->view('pages/casos/create', $data);
}



/*--------------------------------------------------------------------------------------------------
* Editar casos (view)
*/
public function edit($id)
{	

	$id = urldecode($id);

	// Permiso de usuario regular: 
	if($this->session->userdata('Rol') == 'REGULAR')
	{
		$this->session->set_flashdata('Alert','No tienes los permisos para ingresar en el modulo');
		redirect('Inicio');
	}

	$datos['casos'] = $this->Casos->detalles($id);

	if ($datos['casos'] == NULL || $datos['casos'] == '') 
	{
		redirect('Inicio');
	}
	if ($datos['casos']->estado != 'ACTIVO') {
		redirect('Inicio');
	}

	// Array de datos que se le pasan a la vista:
	$data = array(
		'title' => 'Edicion Casos',
		'casos'=> $datos['casos'],
		'auth'=> $this->sesion,
		'old'=> $this->sesion,
		'alertas'=>  $this->sesion
	);

		// LLamado de la vista blade:
	$this->blade->view('pages/casos/edit', $data);
}


/*--------------------------------------------------------------------------------------------------
* Ver Representar (view)
*/
public function represent($casos, $personas, $apoderado)
{
	$casos = urldecode($casos);
	$personas = urldecode($personas);

	// Carga de datos desde la BD:
	$datos['apoderados'] = $this->Apoderados->index();
	$datos['persona'] = $this->Personas->detalles($personas);
	$datos['casos'] = $this->Casos->datos_globales($casos);

	if ($datos['casos'] == NULL || $datos['casos'] == '') 
	{
		redirect('Inicio');
	}

	foreach ($datos['casos'] as $caso) 
	{
		if ($caso->id_personas == $personas) {
			$tipo = $caso->tipo_involucrados; 
		}
	}


	$data = array(
		'title' => 'Representaciones',
		'casos'=> $casos,
		'apoderados' => $datos['apoderados'],
		'apoderadoU'=> $apoderado,
		'personas'=>$datos['persona'],
		'tipo'=>$tipo,
		'auth'=> $this->sesion,
		'alertas'=>  $this->sesion,
		'old'=> $this->sesion
	);

	// LLamado de la vista blade:
	$this->blade->view('pages/casos/represent', $data);
}

/*--------------------------------------------------------------------------------------------------
*  Método almacenar casos.
*/
public function store()
{

		// Captura del POST del formulario:
	$hoy = date('Y')."-".date('m')."-".date("d");
	$params['id']=$_POST["id"];
	$params['usuario_id'] = $this->sesion[0]->Id;
	$params['asunto'] = mb_convert_case(mb_strtolower($_POST["asunto"]),MB_CASE_TITLE, "UTF-8");
	$params['hechos'] = mb_strtolower($_POST["hechos"]);
	$params['num_folio'] = mb_strtoupper($_POST["num_folio"]);
	$params['num_caja'] = mb_strtoupper($_POST["num_caja"]);

	if (isset($_POST["crear"])) {

		// Envio de los datos al modelo:
		$mensaje = $this->Casos->guardar(
			$params['id'],
			$params['usuario_id'],
			$hoy,
			$params['asunto'], 
			$params['hechos'], 
			$params['num_folio'], 
			$params['num_caja'] 
		);	

		if ($mensaje == '1' ){
			$this->session->set_flashdata('Status','El caso fue almacenado correctamente');
			$this->session->set_flashdata('Info','Involucra las personas a el caso ¡buscalas o créalas!');
			redirect('Personas');
		}
		else
		{
			$this->session->set_flashdata('Error','El caso ya existe en la base de datos');
			$this->session->set_userdata('old',$params);
			redirect('Casos/Crear');
		}
	}
	else
	{
		redirect('Inicio'); 
	}				
}



/*--------------------------------------------------------------------------------------------------
*  Método actualizar casos.
*/
public function update()
{

		// Captura del POST del formulario:
	$params['id']=$_POST["id"];
	$params['new_id']=$_POST["new_id"];
	$params['usuario_id'] = $this->sesion[0]->Id;
	$params['asunto'] = mb_convert_case(mb_strtolower($_POST["asunto"]),MB_CASE_TITLE, "UTF-8");
	$params['hechos'] = mb_strtolower($_POST["hechos"]);
	$params['new_folio'] = mb_strtoupper($_POST["new_folios"]);
	$params['num_folio'] = mb_strtoupper($_POST["num_folios"]);
	$params['num_caja'] = mb_strtoupper($_POST["num_caja"]);


	if (isset($_POST["actualizar"]))
	{

			// Envió de los datos al modelo:
		$mensaje = $this->Casos->actualizar(
			$params['id'],
			$params['new_id'],
			$params['asunto'], 
			$params['hechos'], 
			$params['num_folio'],
			$params['new_folio'], 
			$params['num_caja'] 
		);		

		if ($mensaje == '1') 
		{
			$this->session->set_flashdata('Status','El caso fue actualizado correctamente');
			redirect('Casos/Ver/'.$params['new_id']);
		}
		else if($mensaje == '2')
		{
			$this->session->set_flashdata('Error','El caso ya existe en la base de datos (revisa el radicado)');
			$this->session->set_userdata('old',$params);
			redirect('Casos/Editar/'.$params['id']);
		}
		else 
		{
			$this->session->set_flashdata('Error','Los folios ya se están usando en otros casos');
			$this->session->set_userdata('old',$params);
			redirect('Casos/Editar/'.$params['id']);
		}
	}
	else
	{
		redirect('Inicio');
	}		
}
/*--------------------------------------------------------------------------------------------------
*  Método Eliminar involucrados del caso.
*/
public function delete($id, $view, $persona, $apoderado)
{
	$id = urldecode($id);


// Permiso de usuario regular:
	if($this->session->userdata('Rol') == 'REGULAR')
	{
		$this->session->set_flashdata('Error','No tienes los permisos para eliminar la persona del caso');
		redirect('Casos/Ver/'.$view);
	}

	if ($apoderado != 'NULL') {
	// Envió de los datos al modelo:
		$mensaje_r = $this->Representaciones->eliminar(
			$view,
			$apoderado,
			$persona			
		);	
		// validacion de eliminacion de apoderado
		if ($mensaje_r != '1') 
		{
			$this->session->set_flashdata('Error','La persona no puede ser eliminada del caso');
			redirect('Casos/Ver/'.$view);
		}
	}
	// Envió de los datos al modelo:
	$mensaje_i = $this->Involucrados->eliminar(
		$id
	);		

	if ($mensaje_i == '1') 
	{
		$this->session->set_flashdata('Status','La persona fue eliminada del caso correctamente');
		redirect('Casos/Ver/'.$view);
	}
	else
	{
		$this->session->set_flashdata('Error','La persona no se encuentra involucrada en el caso');
		redirect('Casos/Ver/'.$view);
	}
}

/*--------------------------------------------------------------------------------------------------
*  asignaccion y cambio de apoderado.
*/
public function attorney()
{

	$params['persona']=			$_POST["persona"];
	$params['caso']=				$_POST["caso"];
	$params['apoderado'] = 	$_POST["apoderado"];
	$params['apoderadoU'] = $_POST["apoderadoU"];
	$params['tipo'] = 			$_POST['tipo'];

	if (isset($_POST["representar"])) {

// validar igualdad de apoderados
		if ($params['apoderadoU'] == $params['apoderado']) {
			$this->session->set_flashdata('Error','La persona ya esta representada por el apoderado seleccionado ó no se a seleccionado a ningun apoderado.');
			redirect('Casos/Representar/'.$params['caso'].'/'.$params['persona'].'/'.$params['apoderadoU']
		);
		}

		$datos['casos'] = $this->Casos->datos_globales($params['caso']);
		foreach ($datos['casos'] as $caso) 
		{
			if ($caso->id_apoderados == $params['apoderado']) 
			{
				if ($params['tipo'] != $caso->tipo_involucrados) {
					if($caso->tipo_involucrados == 'CONTRAVENTOR' || $params['tipo'] == 'CONTRAVENTOR'){
						$this->session->set_flashdata('Error','El apoderado seleccionado ya esta representando la contraparte de este caso.');
					$this->session->set_userdata('old',$params);
					redirect('Casos/Representar/'.$params['caso'].'/'.$params['persona'].'/'.$params['apoderadoU']);
					}
				}
			}
		}


// Eliminar:
		if ($params['apoderadoU'] != 'NULL' && $params['apoderado'] == 'NULL') {

			$mensaje_r = $this->Representaciones->eliminar(
				$params['caso'],
				$params['apoderadoU'],
				$params['persona']			
			);
				var_dump($mensaje_r);
			if ($mensaje_r != '1') 
			{
				$this->session->set_flashdata('Error','Hay un error al eliminar la representacion de esta persona.');
				redirect('Casos/Representar/'.$params['caso'].'/'.$params['persona'].'/'.$params['apoderadoU']
			);
			}
			else{
				$this->session->set_flashdata('Status','El apoderado ya no representa a la persona en este caso.');
				redirect('Casos/Ver/'.$params['caso']);
			}
		}

	// Creacion o cambio de representacion:
		$this->Representaciones->eliminar(
			$params['caso'],
			$params['apoderadoU'],
			$params['persona']			
		);

		$resultado_r = $this->Representaciones->guardar(
			$params['caso'],
			$params['apoderado'],
			$params['persona']
		); 
		if ($resultado_r == '1') 
		{
			$this->session->set_flashdata('Status','El apoderado empezo a representar a la persona en este caso.');
			redirect('Casos/Ver/'.$params['caso']);
		}
		else
		{
			$this->session->set_flashdata('Error','Hubo un error al representar a la persona en este caso.');
			redirect('Casos/Representar/'.$params['caso'].'/'.$params['persona'].'/'.$params['apoderadoU']
		);
		}
	}
	else{
		redirect('Inicio');
	}
}


}