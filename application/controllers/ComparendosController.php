<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ComparendosController extends CI_Controller
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
		$this->load->model('Personas');
		$this->load->model('Comparendos');
		$this->load->model('Involucrados');
	}
	
	
	/*-----------------------------------------------------------------------------------------------
	* Index (view) 
	*/
	public function index()
	{
		
		// Carga de datos desde la BD:
		$datos['comparendos'] = $this->Comparendos->index();

		if ($datos['comparendos'] == NULL || $datos['comparendos'] == '') 
		{
			$this->session->set_flashdata('Info','No hay comparendos para mostrar, crea el primero!!');
			redirect('Comparendos/Crear');
		}
		
		// Array de datos que se le pasan a la vista:
		$data = array(
			'title' => 'Comparendos',
			'comparendos'=> $datos['comparendos'],
			'auth'=> $this->sesion,
			'alertas'=>  $this->sesion
		);
		// LLamado de la vista blade:
		$this->blade->view('pages/comparendos/index', $data);
	}
	
	/*-------------------------------------------------------------------------------------------------
	* Ver comparendos (view)
	*/
	public function show($id)
	{
		$id = urldecode($id);
		
		// Carga de datos desde la BD:
		$datos['comparendos'] = $this->Comparendos->detalles($id);
		$datos['persona'] = $this->Personas->detalles($datos['comparendos']->personas_id);

		if ($datos['comparendos'] == NULL || $datos['comparendos'] == '') 
		{
			redirect('Inicio');
		}
		
		$data = array(
			'title' => 'Ver Comparendo',
			'comparendos'=> $datos['comparendos'],
			'personas' => $datos['persona'],
			'auth'=> $this->sesion,
			'alertas'=>  $this->sesion,
		);
		
		// LLamado de la vista blade:
		$this->blade->view('pages/comparendos/show', $data);
	}
	
	
	/*-------------------------------------------------------------------------------------------------
	* Crear comparendos (view)
	*/
	public function create()
	{
		
		$old = $this->sesion;
		if (isset($old->old['tipo'])) {
			$old['tipo'] = $old->old['tipo'];
		}
		else
		{
			$old['tipo'] = NULL;	
		}
		
		
		if (isset($old->old['estado'])) {
			$old['estado'] = $old->old['estado'];
		}
		else
		{
			$old['estado'] = NULL;	
		}
		
		
		// Tipo
		if ($old['tipo'] == '1' ) 
		{
			$tipo[0] = "selected = selected";
			$tipo[1] = "";
			$tipo[2] = "";
			$tipo[3] = "";
		}
		elseif ($old['tipo'] == '2') {
			$tipo[0] = "";
			$tipo[1] = "selected = selected";
			$tipo[2] = "";
			$tipo[3] = "";
		}
		elseif ($old['tipo'] == '3') {
			$tipo[0] = "";
			$tipo[1] = "";
			$tipo[2] = "selected = selected";
			$tipo[3] = "";
		}
		else
		{
			$tipo[0] = "";
			$tipo[1] = "";
			$tipo[2] = "";
			$tipo[3] = "selected = selected";
		}
		
		
		// Estado
		if ($old['estado'] == 'ACEPTADO') 
		{
			$estado[0] = "selected = selected";
			$estado[1] = "";
		}
		else {
			$estado[0] = "";
			$estado[1] = "selected = selected";
		}
		
		
		
		// var_dump($this->sesion[0]->old['id']);
		$data = array(
			'title' => 'Crear Comparendos',
			'auth'=> $this->sesion,
			'alertas'=>  $this->sesion,
			'old'=> $this->sesion,
			'tipo' => $tipo,
			'estado' => $estado
		);
		
		// LLamado de la vista blade:
		$this->blade->view('pages/comparendos/create', $data);
	}
	
	
	
	/*-------------------------------------------------------------------------------------------------
	* Editar comparendos (view)
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

		$old = $this->sesion;
		if (isset($old->old['tipo'])) {
			$old['tipo'] = $old->old['tipo'];
		}
		else
		{
			$old['tipo'] = NULL;	
		}
		
		
		if (isset($old->old['estado'])) {
			$old['estado'] = $old->old['estado'];
		}
		else
		{
			$old['estado'] = NULL;	
		}
		
		// Consulta del usuario en la BD:
		$datos['comparendos'] = $this->Comparendos->detalles($id);

		if ($datos['comparendos'] == NULL || $datos['comparendos'] == '') 
		{
			redirect('Inicio');
		}

		// Permisos de asignacion de persona para editar el comparendo
		$datos['persona'] = $this->Personas->detalles($datos['comparendos']->personas_id);
		if ($datos['persona'] == NULL || $datos['persona'] == ''){
			$this->session->set_flashdata('Alert','Involucra a una persona primero en el comparendo ¡buscala o créala!');
			redirect('Personas');
		}


		
		// Tipo
		if ($datos['comparendos']->tipo == '1' || $old['tipo'] == '1' ) 
		{
			$tipo[0] = "selected = selected";
			$tipo[1] = "";
			$tipo[2] = "";
			$tipo[3] = "";
		}
		elseif ($datos['comparendos']->tipo == '2' || $old['tipo'] == '2') {
			$tipo[0] = "";
			$tipo[1] = "selected = selected";
			$tipo[2] = "";
			$tipo[3] = "";
		}
		elseif ($datos['comparendos']->tipo == '3' || $old['tipo'] == '3') {
			$tipo[0] = "";
			$tipo[1] = "";
			$tipo[2] = "selected = selected";
			$tipo[3] = "";
		}
		else
		{
			$tipo[0] = "";
			$tipo[1] = "";
			$tipo[2] = "";
			$tipo[3] = "selected = selected";
		}
		

		// Estado
		if ($datos['comparendos']->estado == 'ACEPTADO'|| $old['estado'] == 'ACEPTADO') 
		{
			$estado[0] = "selected = selected";
			$estado[1] = "";
			$estado[2] = "";
			$estado[3] = "";
		}
		else if ($datos['comparendos']->estado == 'APELADO'|| $old['estado'] == 'APELADO'){
			$estado[0] = "";
			$estado[1] = "selected = selected";
			$estado[2] = "";
			$estado[3] = "";
		}
		else if ($datos['comparendos']->estado == 'CONTRA'|| $old['estado'] == 'CONTRA') {
			$estado[0] = "";
			$estado[1] = "";
			$estado[2] = "selected = selected";
			$estado[3] = "";
		}
		else{
			$estado[0] = "";
			$estado[1] = "";
			$estado[2] = "";
			$estado[3] = "selected = selected";
		}
		
		
		// Array de datos que se le pasan a la vista:
		$data = array(
			'title' => 'Edicion Comparendos',
			'comparendos'=> $datos['comparendos'],
			'auth'=> $this->sesion,
			'old'=> $this->sesion,
			'alertas'=>  $this->sesion,
			'tipo' => $tipo,
			'estado' => $estado
			
		);
		
		// LLamado de la vista blade:
		$this->blade->view('pages/comparendos/edit', $data);
	}
	
	
	/*-------------------------------------------------------------------------------------------------
	*  Método almacenar comparendos.
	*/
	public function store()
	{
		
		// Captura del POST del formulario:
		$params['id'] = mb_strtoupper($_POST["id"]);
		$params['fecha'] = $_POST["fecha"];
		$params['articulo'] = mb_strtolower($_POST["articulo"]);
		$params['tipo'] = $_POST["tipo"];
		$params['numeral'] = mb_strtoupper($_POST["numeral"]);
		$params['literal'] = mb_strtoupper($_POST["literal"]);
		$params['multa'] = mb_strtoupper($_POST["multa"]);
		$params['num_folio'] = mb_strtoupper($_POST["num_folio"]);
		$params['num_caja'] = mb_strtoupper($_POST["num_caja"]);
		$params['estado'] = $_POST["estado"];

		if (isset($_POST["crear"])) {

				// Envio de los datos al modelo:
			$mensaje = $this->Comparendos->guardar(
				$params['id'],
				$params['fecha'],
				$params['articulo'],
				$params['tipo'],
				$params['numeral'],
				$params['literal'],
				$params['multa'],
				$params['num_folio'],
				$params['num_caja'],
				$params['estado']
			);	

			if ($mensaje == '1') 
			{		
				$this->session->set_flashdata('Status','El comparendo fue almacenado correctamente');
				$this->session->set_flashdata('Info','Involucra a una persona en el comparendo ¡buscala o créala!');
				redirect('Personas');
			}
			else 
			{
				$this->session->set_flashdata('Error','El comparendo ya existe en la base de datos');
				$params['comparendos'] = $comparendo;
				$this->session->set_userdata('old',$params);
				redirect('Comparendos/Crear');
			}
		}
		else
		{
			redirect('Comparendos'); 
		}				
	}



		/*--------------------------------------------------------------------------------------------------
		*  Método actualizar comparendos.
		*/
		public function update()
		{
			
			// Captura del POST del formulario:
			$params['id']=$_POST["id"];
			$params['new_id']=$_POST["new_id"];
			$params['fecha'] = $_POST["fecha"];
			$params['articulo'] = mb_strtolower($_POST["articulo"]);
			$params['tipo'] = $_POST["tipo"];
			$params['numeral'] = mb_strtoupper($_POST["numeral"]);
			$params['literal'] = mb_strtoupper($_POST["literal"]);
			$params['multa'] = mb_strtoupper($_POST["multa"]);
			$params['num_folio'] = mb_strtoupper($_POST["num_folio"]);
			$params['new_folio'] = mb_strtoupper($_POST["new_folio"]);
			$params['num_caja'] = mb_strtoupper($_POST["num_caja"]);
			$params['estado'] = $_POST["estado"];



			if (isset($_POST["actualizar"]))
			{

					// Envió de los datos al modelo:
				$mensaje = $this->Comparendos->actualizar(
					$params['id'],
					$params['new_id'],
					$params['fecha'],
					$params['articulo'],
					$params['tipo'],
					$params['numeral'],
					$params['literal'],
					$params['multa'],
					$params['num_folio'],
					$params['new_folio'],
					$params['num_caja'],
					$params['estado']
				);		

				if ($mensaje == '1') 
				{
					$this->session->set_flashdata('Status','El comparendo fue actualizado correctamente');
					redirect('Comparendos/Ver/'.$params['new_id']);
				}
				else if($mensaje == '2')
				{
					$this->session->set_flashdata('Error','El comparendo ya existe en la base de datos (revisa el numero de comparendo)');
					$this->session->set_userdata('old',$params);
					redirect('Comparendos/Editar/'.$params['id']);
				}
				else 
				{
					$this->session->set_flashdata('Error','Los folios ya se están usando en otros comparendos');
					$this->session->set_userdata('old',$params);
					redirect('Comparendos/Editar/'.$params['id']);
				}
			}
			else
			{
				redirect('Inicio');
			}		
		}

		/*--------------------------------------------------------------------------------------------------
		*  Método eliminar contraventor.
		*/
		public function delete($id)
		{

			// Permiso de usuario regular:
			if($this->session->userdata('Rol') == 'REGULAR')
			{
				$this->session->set_flashdata('Error','No tienes los permisos para eliminar la persona del comparendo.');
				redirect('Comparendos/Ver/'.$id);
			}

			$id = urldecode($id);

					// Envió de los datos al modelo:
			$mensaje = $this->Comparendos->eliminar(
				$id
			);		

			if ($mensaje == '1') 
			{
				$this->session->set_flashdata('Status','La persona fue eliminada del comparendo correctamente.');
				redirect('Comparendos/Ver/'.$id);
			}
			else 
			{
				$this->session->set_flashdata('Error','No se pudo eliminar a la persona del comparendo');
				redirect('Comparendos/Ver/'.$id);
			}
		}	
	}