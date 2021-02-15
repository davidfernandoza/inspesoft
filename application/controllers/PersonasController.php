<?php
defined('BASEPATH') or exit('No direct script access allowed');



class PersonasController extends CI_Controller
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
	$this->load->model('Personas');
	$this->load->model('Casos');
	$this->load->model('Involucrados');
	$this->load->model('Apoderados');
	$this->load->model('Representaciones');
	$this->load->model('Comparendos');
}




/*-----------------------------------------------------------------------------------------------
* Index (view) 
*/
public function index()
{
	$i = 0;
		// Carga de datos desde la BD:
	$datos['personas'] = $this->Personas->index();

	if ($datos['personas'] == NULL || $datos['personas'] == '') 
	{
		$this->session->set_flashdata('Info','No hay personas para mostrar, crea la primera!!');
		redirect('Personas/Crear');
	}

		// Array de datos que se le pasan a la vista:
	$data = array(
		'title' => 'Personas',
		'personas'=> $datos['personas'],
		'auth'=> $this->sesion,
		'alertas'=>  $this->sesion
	);

		// LLamado de la vista blade:
	$this->blade->view('pages/personas/index', $data);
}




/*-----------------------------------------------------------------------------------------------
* Crear persona (view)
*/
public function create()
{
	
	// Carga de datos desde la BD:
	$datos['casos'] = $this->Casos->involucrar();
	$datos['apoderados'] = $this->Apoderados->index();
	$datos['comparendos'] = $this->Comparendos->involucrar();

	if (($datos['casos'] == NULL || $datos['casos'] == '') && ($datos['comparendos'] == '' || $datos['comparendos'] == NULL)) 
	{
		$this->session->set_flashdata('Info','No hay casos para mostrar en la creación de la persona, crea el primero!!');
		redirect('Casos/Crear');
	}


	// var_dump($this->sesion[0]->old['id']);
	$data = array(
		'title' => 'Crear Persona',
		'auth'=> $this->sesion,
		'alertas'=>  $this->sesion,
		'old'=> $this->sesion,
		'casos' => 	$datos['casos'],
		'comparendos'=>$datos['comparendos'],
		'apoderados'=>$datos['apoderados']
	);


	// LLamado de la vista blade:
	$this->blade->view('pages/personas/create', $data);
}



/*--------------------------------------------------------------------------------------------------
* Editar persona (view)
*/
public function edit($id)
{	
		// Permiso de usuario regular:
	if($this->session->userdata('Rol') == 'REGULAR')
	{
		$this->session->set_flashdata('Alert','No tienes los permisos para ingresar en el modulo');
		redirect('Inicio');
	}
	
	$id = urldecode($id);

	// Carga de datos desde la BD:
	$datos['personas'] = $this->Personas->detalles($id);

	if ($datos['personas'] == NULL || $datos['personas'] == '') 
	{
		redirect('Inicio');
	}

	// Array de datos que se le pasan a la vista:
	$data = array(
		'title' => 'Edicion Persona',
		'personas'=> $datos['personas'],
		'auth'=> $this->sesion,
		'old'=> $this->sesion,
		'alertas'=>  $this->sesion
	);

	// // LLamado de la vista blade:
	$this->blade->view('pages/personas/edit', $data);
}

/*--------------------------------------------------------------------------------------------------
* Involucrar persona (view)
*/
public function involve ($id)
{	

	$id = urldecode($id);

	$datos['personas'] = $this->Personas->detalles($id);
	$datos['involucrados'] = $this->Involucrados->detallesPersona($id);
	$datos['casos'] = $this->Casos->involucrar();
	$datos['apoderados'] = $this->Apoderados->index();
	$datos['comparendos'] = $this->Comparendos->involucrar();



	if ($datos['personas'] == NULL || $datos['personas'] == '') 
	{
		redirect('Inicio');
	}

	if (($datos['casos'] == NULL || $datos['casos'] == '')&& ($datos['comparendos'] == '' || $datos['comparendos'] == NULL)) 
	{
		$this->session->set_flashdata('Info','No hay casos para mostrar en la involucración de la persona, crea el primero!!');
		redirect('Casos/Crear');
	}


	if ($datos['involucrados'] != NULL && $datos['involucrados'] != '')
	{
		$contador = 0;
		foreach ($datos['casos'] as $caso) {
			foreach ($datos['involucrados'] as $involucrado) {
				if ($caso->id == $involucrado->casos_id) {
					unset($datos['casos'][$contador]);
				}
			}
			$contador		 = $contador + 1;
		}
	}

	// Array de datos que se le pasan a la vista:
	$data = array(
		'title' => 'Involucrar Persona',
		'auth'=> $this->sesion,
		'alertas'=>  $this->sesion,
		'old'=> $this->sesion,
		'casos' => 	$datos['casos'],
		'comparendos'=>$datos['comparendos'],
		'apoderados'=>$datos['apoderados'],
		'persona'=>$datos['personas']
	);

		// LLamado de la vista blade:
	$this->blade->view('pages/personas/involve', $data);
}



/*-----------------------------------------------------------------------------------------------
* Ver (view) 
*/
public function show($id)
{
	// Carga de datos desde la BD:
	$datos['personas'] = $this->Personas->detalles($id);
	$datos['casos'] = $this->Casos->ver($id);
	$datos['comparendos'] = $this->Comparendos->detalles_p($id);

	if ($datos['personas'] == NULL || $datos['personas'] == '') 
	{
		redirect('Inicio');
	}

		// Array de datos que se le pasan a la vista:
	$data = array(
		'title' => 'Ver Persona',
		'personas'=> $datos['personas'],
		'casos'=> $datos['casos'],
		'comparendos'=>$datos['comparendos'],
		'auth'=> $this->sesion,
		'alertas'=>  $this->sesion,
	);

		// LLamado de la vista blade:
	$this->blade->view('pages/personas/show', $data);
}



/*--------------------------------------------------------------------------------------------------
*  Método almacenar persona.
*/
public function store()
{

	// Captura del POST del formulario:
	$params['id'] = md5(time() . mt_rand(1, 10000000000));
	$params['primer_nombre'] = mb_strtoupper($_POST["primer_nombre"]);
	$params['segundo_nombre'] = mb_strtoupper($_POST["segundo_nombre"]);
	$params['primer_apellido'] = mb_strtoupper($_POST["primer_apellido"]);
	$params['segundo_apellido'] = mb_strtoupper($_POST["segundo_apellido"]);
	$params['direccion'] = mb_strtoupper($_POST["direccion"]);
	$params['telefono'] = mb_strtolower($_POST["telefono"]);
	$params['tipo'] = mb_strtoupper($_POST["tipo"]); 
	$params['subtipo'] = mb_strtoupper($_POST["subtipo"]);

	// Cedula:
	if ($_POST["cedula"] == "" || $_POST["cedula"] == " ") 
	{
		$params['cedula']=NULL;
	}
	else
	{
		$params['cedula']=$_POST["cedula"];
	}

	// Comparendos y Casos 
	if ($_POST["comparendos"] != "NULL" && $_POST["casos"] != "NULL") 
	{
		$this->session->set_flashdata('Error','Solo puedes seleccionar un caso o un comparendo');
		$this->session->set_userdata('old',$params);
		redirect('Personas/Crear');
	}

	// Comparendos:
	if ($_POST["comparendos"] == "NULL")
	{
		$params['comparendos'] = NULL;
	}
	else 
	{
		$params['comparendos'] = $_POST["comparendos"];
	}

	// Casos:
	if ($_POST["casos"] == "NULL")
	{
		$params['casos'] = NULL;
	}
	else 
	{
		$params['casos'] = $_POST["casos"];
		if ($params['tipo'] == "NULL") 
		{
			$this->session->set_flashdata('Error','Debes de seleccionar un tipo cuando seleccionas un caso');
			$this->session->set_userdata('old',$params);
			redirect('Personas/Crear');			
		}
	}

	// Apoderados:
	if ($_POST["apoderados"] == "NULL") 
	{
		$params['apoderados_id'] = NULL;
	}
	else
	{
		$params['apoderados_id'] = $_POST["apoderados"];
		$datos['casos'] = $this->Casos->datos_globales($params['casos']);
		foreach ($datos['casos'] as $caso) 
		{
			if ($caso->id_apoderados == $params['apoderados_id']) //si es igual ya esta en el caso
			{
				if ($params['tipo'] != $caso->tipo_involucrados) {
					if($caso->tipo_involucrados == 'CONTRAVENTOR' || $params['tipo'] == 'CONTRAVENTOR'){
						$this->session->set_flashdata('Error','El apoderado seleccionado ya esta representando la contraparte de este caso.');
						$this->session->set_userdata('old',$params);
						redirect('Personas/Crear');
					}
				}
			}
		}
	}

	if (isset($_POST["crear"])) {


		// Envio de los datos al modelo Personas:
		$resultado_p = $this->Personas->guardar(
			$params['id'],
			$params['cedula'],
			$params['primer_nombre'], 
			$params['segundo_nombre'], 
			$params['primer_apellido'], 
			$params['segundo_apellido'], 
			$params['direccion'], 
			$params['telefono']
		);	

		// Comparendos:
		if ($params['comparendos'] != NULL) 
		{
			$resultado_c = $this->Comparendos->personas(
				$params['comparendos'],
				$params['id']
			); 
			if ($resultado_c != '1') 
			{
				$this->session->set_flashdata('Error','Hubo un problema al vincular la persona al comparendo');
			}
		}
		else
		{
			// Involucrados:
			$resultado_i = $this->Involucrados->guardar(
				$params['id'],
				$params['casos'], 
				$params['tipo'], 
				$params['subtipo']
			);	
			if ($resultado_i == '3') {
				$this->session->set_flashdata('Error','La persona ya esta representada en el caso');
				$this->session->set_userdata('old',$params);
				redirect('Personas/Crear');
			}
			else{

				if ($params['apoderados_id'] != NULL) 
				{
				// Representaciones:
					$resultado_r = $this->Representaciones->guardar(
						$params['casos'],
						$params['apoderados_id'],
						$params['id']
					); 
					if ($resultado_r != '1') 
					{
						$this->session->set_flashdata('Error','Hubo un problema con el apoderado al representar la persona en el caso');
					}
				}
			// Validaciones Casos:
				if ($resultado_p == '1' && $resultado_i == '1') 
				{
					$this->session->set_flashdata('Status','Se almaceno e involucro a la persona correctamente en el caso');
					$this->session->set_flashdata('Info','Involucra a otras personas en el caso si se requiere, ¡buscalas o créalas!');
					redirect('Personas');
				}
				else
				{
					$this->session->set_flashdata('Error','La persona ya existe en la base de datos o hubo un problema al involucrarla al caso');
					$this->session->set_userdata('old',$params);
					redirect('Personas/Crear');
				}
			}			
		}

			// Validaciones Comparendos:
		if ($resultado_p == '1' && $resultado_c == '1') 
		{
			$this->session->set_flashdata('Status','Se almaceno e involucro a la persona correctamente en el comparendo');
			redirect('Comparendos');
		}
		else
		{
			$this->session->set_flashdata('Error','La persona ya existe en la base de datos o hubo un problema al involucrarla al comparendo');
			$this->session->set_userdata('old',$params);
			redirect('Personas/Crear');
		}
	}
	else
	{
		redirect('Personas'); 
	}				

}

/*--------------------------------------------------------------------------------------------------
*  Método actualizar usuario.
*/
public function update()
{

// Captura del POST del formulario:
	$params['id'] = $_POST["id"];
	$params['new_cedula'] = $_POST["new_cedula"];
	$params['cedula'] = $_POST["cedula"];
	$params['primer_nombre'] = mb_strtoupper($_POST["primer_nombre"]);
	$params['segundo_nombre'] = mb_strtoupper($_POST["segundo_nombre"]);
	$params['primer_apellido'] = mb_strtoupper($_POST["primer_apellido"]);
	$params['segundo_apellido'] = mb_strtoupper($_POST["segundo_apellido"]);
	$params['direccion'] = mb_strtoupper($_POST["direccion"]);
	$params['telefono'] = mb_strtolower($_POST["telefono"]);


	if (isset($_POST["crear"])) {


			// Envio de los datos al modelo:
		$resultado_p = $this->Personas->actualizar(
			$params['id'],
			$params['cedula'],
			$params['new_cedula'],			
			$params['primer_nombre'], 
			$params['segundo_nombre'], 
			$params['primer_apellido'], 
			$params['segundo_apellido'], 
			$params['direccion'], 
			$params['telefono']
		);	


		if ($resultado_p == '1') 
		{
			$this->session->set_flashdata('Status','Se actualizó a la persona correctamente.');
			redirect('Personas/Ver/'.$params['id']);
		}
		else
		{
			$this->session->set_flashdata('Error','La persona ya existe en la base de datos o hubo un problema al Actualizarlo');
			$this->session->set_userdata('old',$params);
			redirect('Personas/Editar/'.$params['id']);
		}
	}
	else
	{
		redirect('Personas'); 
	}					

}

/*--------------------------------------------------------------------------------------------------
*  Método implica a la persona en un caso.
*/
public function imply()
{

	// Captura del POST del formulario:
	$params['id'] = $_POST['idpersona'];
	$params['tipo'] = mb_strtoupper($_POST["tipo"]); 
	$params['subtipo'] = mb_strtoupper($_POST["subtipo"]);

// var_dump($params['id']);
	// Comparendos y Casos 
	if ($_POST["comparendos"] != "NULL" && $_POST["casos"] != "NULL") 
	{
		$this->session->set_flashdata('Error','Solo puedes seleccionar un caso o un comparendo');
		$this->session->set_userdata('old',$params);
		redirect('Personas/Involucrar/'.$params['id']);
	}

	// Comparendos:
	if ($_POST["comparendos"] == "NULL")
	{
		$params['comparendos'] = NULL;
	}
	else 
	{
		$params['comparendos'] = $_POST["comparendos"];
	}

	// Casos:
	if ($_POST["casos"] == "NULL")
	{
		$params['casos'] = NULL;
	}
	else 
	{
		$params['casos'] = $_POST["casos"];
		if ($params['tipo'] == "NULL") 
		{
			$this->session->set_flashdata('Error','Debes de seleccionar un tipo cuando seleccionas un caso');
			$this->session->set_userdata('old',$params);
			redirect('Personas/Involucrar/'.$params['id']);			
		}
	}

	// Apoderados:
	if ($_POST["apoderados"] == "NULL") 
	{
		$params['apoderados_id'] = NULL;
	}
	else
	{
		$params['apoderados_id'] = $_POST["apoderados"];
		$datos['casos'] = $this->Casos->datos_globales($params['casos']);
		foreach ($datos['casos'] as $caso) 
		{
			if ($caso->id_apoderados == $params['apoderados_id']) 
			{
				if ($params['tipo'] != $caso->tipo_involucrados) {
					if($caso->tipo_involucrados == 'CONTRAVENTOR' || $params['tipo'] == 'CONTRAVENTOR'){
						$this->session->set_flashdata('Error','El apoderado seleccionado ya esta representando la contraparte de este caso.');
						$this->session->set_userdata('old',$params);
						redirect('Personas/Involucrar/'.$params['id']);
					}
				}
			}
		}
	}

	if (isset($_POST["involucar"])) {

		// Comparendos:
		if ($params['comparendos'] != NULL) 
		{
			$resultado_c = $this->Comparendos->personas(
				$params['comparendos'],
				$params['id']
			); 
			if ($resultado_c == '3') 
			{
				$this->session->set_flashdata('Error','El comparendo no existe');
			}
		}
		else
		{
			if ($params['apoderados_id'] != NULL) 
			{
				// Representaciones:
				$resultado_r = $this->Representaciones->guardar(
					$params['casos'],
					$params['apoderados_id'],
					$params['id']
				); 
				if ($resultado_r != '1') {
					$this->session->set_flashdata('Error','La persona ya esta representada en este caso, o hubo un problema con el apoderado');
					$this->session->set_userdata('old',$params);
					redirect('Personas/Involucrar/'.$params['id']);
				}
			}

			// Involucrados:
			$resultado_i = $this->Involucrados->guardar(
				$params['id'],
				$params['casos'], 
				$params['tipo'], 
				$params['subtipo']
			);

			// Validaciones Casos:
			if ($resultado_i == '1') 
			{
				$this->session->set_flashdata('Status','Se involucro a la persona correctamente en el caso');
				$this->session->set_flashdata('Info','Involucra a otras personas en el caso si se requiere ¡buscalas o créalas!');
				redirect('Personas');
			}
			else
			{
				$this->session->set_flashdata('Error','Hubo un problema al involucrar a la persona en el caso');
				$this->session->set_userdata('old',$params);
				redirect('Personas/Involucrar/'.$params['id']);
			}
		}
	}

			// Validaciones Comparendos:
	if ($resultado_c == '1') 
	{
		$this->session->set_flashdata('Status','Se involucro a la persona correctamente en el comparendo');
		redirect('Comparendos');
	}
	else
	{
		$this->session->set_flashdata('Error','La persona no existe en la base de datos o hubo un problema al involucrarla al comparendo');
		$this->session->set_userdata('old',$params);
		redirect('Personas/Involucrar/'.$params['id']);

	}
}
}