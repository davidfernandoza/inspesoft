<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FallosController extends CI_Controller
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
	$this->load->model('Fallos');
	$this->load->model('Casos');
	$this->load->model('Involucrados');
}


/*--------------------------------------------------------------------------------------------------
* Crear fallos (view)
*/
public function create($id_caso)
{
	$id_caso = urldecode($id_caso);


	$datos['casos'] = $this->Casos->detalles($id_caso);

	if ($datos['casos'] == NULL || $datos['casos'] == '') 
	{
		redirect('Inicio');
	}

	//Validar 
	$datos['involucrados'] = $this->Involucrados->detallesCasos($id_caso);
	if (empty($datos['involucrados'])) 
	{
		$this->session->set_flashdata('Alert','El caso no tiene involucrados para dar un fallo, debe de tener denunciante y contraventor.');
		redirect('Personas');
	}

	$datos['fallos'] = $this->Fallos->detalles($id_caso);
	if (empty($datos['fallos'])) 
	{
		$contador_casos = 0;
	}
	else
	{
		$contador_casos = 1;
	}

	if ($datos['casos']->estado != 'ACTIVO') {
		redirect('Inicio');
	}

	$data = array(
		'id_caso' => $id_caso,
		'title' => 'Crear Fallo',
		'auth'=> $this->sesion,
		'alertas'=>  $this->sesion,
		'old'=> $this->sesion,
		'contador_casos' => $contador_casos
	);

	// LLamado de la vista blade:
	$this->blade->view('pages/fallos/create', $data);
}



/*--------------------------------------------------------------------------------------------------
* Editar fallos (view)
*/
public function edit($resolucion, $id)
{	

	$resolucion = urldecode($resolucion);
	$id = urldecode($id);

	$datos['casos'] = $this->Casos->detalles($id);

	if($datos['casos']->estado != 'ACTIVO')
	{
		$this->session->set_flashdata('Error','No se puede editar el fallo.');
		redirect('Casos/Ver/'.$id);
	}	

		// Consulta del usuario en la BD:
	$datos['fallos'] = $this->Fallos->detallesId($resolucion);


	if ($datos['fallos'] == NULL || $datos['fallos'] == '') 
	{
		redirect('Inicio');
	}

		// Array de datos que se le pasan a la vista:
	$data = array(
		'title' => 'Edicion Fallo',
		'fallos'=> $datos['fallos'],
		'id'=> $id,
		'auth'=> $this->sesion,
		'old'=> $this->sesion,
		'alertas'=>  $this->sesion
	);

		// LLamado de la vista blade:
	$this->blade->view('pages/fallos/edit', $data);
}



/*--------------------------------------------------------------------------------------------------
*  Método almacenar fallos.
*/
public function store()
{

		// Captura del POST del formulario:
	date_default_timezone_set('UTC');
	date_default_timezone_set('America/Bogota');
	$hoy = date('Y')."-".date('m')."-".date("d");
	$params['resolucion']= mb_strtoupper($_POST["resolucion"]);
	$params['id_caso']=$_POST["id_caso"];
	$params['fallo'] = mb_convert_case(mb_strtolower($_POST["fallo"]),MB_CASE_TITLE,"UTF-8");
	$params['detalles'] = mb_strtolower($_POST["detalles"]);
	$params['tipo'] = mb_strtoupper($_POST["tipo"]);

	if (isset($_POST["crear"])) {

		$mensaje = $this->Fallos->guardar(
			$params['resolucion'],
			$params['id_caso'],
			$params['fallo'],
			$params['detalles'],
			$params['tipo'],
			$hoy
		);
		if($params['tipo'] == 'FINAL')
		{
			$params['estado'] = "CERRADO";
			$respuesta = $this->Casos->cerrar(
				$params['id_caso'],
				$params['estado'],
				$hoy
			);
		}

		if (isset($respuesta)) 
		{
			if ($respuesta !== '1') 
			{
				$this->session->set_flashdata('Error','El caso no existe en la base de datos');
				redirect('Casos');
			}
		}

		if ($mensaje == '1') 
		{

			if (isset($respuesta)) 
			{
				if ($respuesta == '1') 
				{
					$this->session->set_flashdata('Status','El fallo fue almacenado correctamente y el caso fue cerrado con éxito');
					redirect('Casos/Ver/'.$params['id_caso']);
				}
			}

			$this->session->set_flashdata('Status','El fallo fue almacenado correctamente');
			redirect('Casos/Ver/'.$params['id_caso']);
		}
		else if($mensaje == '2')
		{
			$this->session->set_flashdata('Error','El fallo ya existe en la base de datos');
			$this->session->set_userdata('old',$params);
			redirect('Fallos/Crear/'.$params['id_caso']."/".$params['lugar']);
		}
	}
	else
	{
		redirect('Casos'); 
	}				
}



/*--------------------------------------------------------------------------------------------------
*  Método actualizar fallos.
*/
public function update()
{

	// Captura del POST del formulario:
	$hoy = date('Y')."-".date('m')."-".date("d");
	$params['new_resolucion'] = mb_strtoupper($_POST["new_resolucion"]);
	$params['resolucion']= mb_strtoupper($_POST["resolucion"]);
	$params['id_caso']=$_POST["id_caso"];
	$params['fallo'] = mb_convert_case(mb_strtolower($_POST["fallo"]),MB_CASE_TITLE, "UTF-8");
	$params['detalles'] = mb_strtolower($_POST["detalles"]);
	$params['tipo'] = mb_strtoupper($_POST["tipo"]);


	if (isset($_POST["actualizar"])) {

		$mensaje = $this->Fallos->actualizar(
			$params['resolucion'],
			$params['new_resolucion'],
			$params['fallo'],
			$params['detalles'],
			$params['tipo'],
			$hoy
		);
		if($params['tipo'] == 'FINAL')
		{
			$params['estado'] = "CERRADO";
			$respuesta = $this->Casos->cerrar(
				$params['id_caso'],
				$params['estado'],
				$hoy
			);
		}


		if (isset($respuesta)) 
		{
			if ($respuesta !== '1') 
			{
				$this->session->set_flashdata('Error','El caso no existe en la base de datos');
				redirect('Casos/Ver/'.$params['id_caso']);
			}
		}

		if ($mensaje == '1') 
		{

			if (isset($respuesta)) 
			{
				if ($respuesta == '1') 
				{
					$this->session->set_flashdata('Status','El fallo fue actualizado correctamente y el caso fue cerrado con éxito');
					redirect('Casos/Ver/'.$params['id_caso']);
				}
			}

			$this->session->set_flashdata('Status','El fallo fue actualizado correctamente');
			redirect('Casos/Ver/'.$params['id_caso']);
		}
		else if($mensaje == '2')
		{
			$this->session->set_flashdata('Error','El fallo ya existe en la base de datos');
			$this->session->set_userdata('old',$params);
			redirect('Fallos/Editar/'.$params['resolucion']."/".$params['id_caso']);
		}
	}
	else
	{
		redirect('Casos'); 
	}				
}


/*--------------------------------------------------------------------------------------------------
*  Método actualizar fallos.
*/
public function delete($resolucion, $caso, $tipo)
{

// Permiso de usuario regular:
	if($this->session->userdata('Rol') == 'REGULAR')
	{
		$this->session->set_flashdata('Error','No tienes los permisos para eliminar el fallo.');
		redirect('Casos/Ver/'.$view);
	}	
	$resolucion = urldecode($resolucion);
	$caso = urldecode($caso);
	$tipo = urldecode($tipo);

	$params['resolucion'] = mb_strtoupper($resolucion);
	$params['id_caso'] = $caso;


	$mensaje = $this->Fallos->eliminar(
		$params['resolucion']
	);

	if ($tipo == "FINAL") 
	{
		$respuesta = $this->Casos->activar(
			$params['id_caso']
		);
	}
	
	if (isset($respuesta)) 
	{
		if ($respuesta !== '1') 
		{
			$this->session->set_flashdata('Error','El caso no existe en la base de datos');
			redirect('Casos/Ver/'.$params['id_caso']);
		}
	}

	if ($mensaje == '1') 
	{

		if (isset($respuesta)) 
		{
			if ($respuesta == '1') 
			{
				$this->session->set_flashdata('Status','El fallo fue eliminado correctamente y el caso fue abierto con éxito');
				redirect('Casos/Ver/'.$params['id_caso']);
			}
		}

		$this->session->set_flashdata('Status','El fallo fue eliminado correctamente');
		redirect('Casos/Ver/'.$params['id_caso']);
	}
	else 
	{
		$this->session->set_flashdata('Error','El fallo no se pudo eliminar');
		redirect('Casos/Ver/'.$params['id_caso']);
	}		
}

}