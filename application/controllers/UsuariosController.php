<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UsuariosController extends CI_Controller
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
		$this->load->model('Usuarios');
	}
	
	
	
	
	/*-----------------------------------------------------------------------------------------------
	* Index (view) 
	*/
	public function index()
	{
		// Permiso de usuario regular:
		if($this->session->userdata('Rol') == 'REGULAR')
		{
			$this->session->set_flashdata('Alert','No tienes los permisos para ingresar en el modulo');
			redirect('Inicio');
		}
		
		// Carga de datos desde la BD:
		$datos['usuarios'] = $this->Usuarios->index();

		if ($datos['usuarios'] == NULL || $datos['usuarios'] == '') 
		{
			$this->session->set_flashdata('Info','No hay usuarios para mostrar, crea el primero!!');
			redirect('Usuarios/Crear');
		}
		
		// Array de datos que se le pasan a la vista:
		$data = array(
			'title' => 'Usuarios',
			'usuarios'=> $datos['usuarios'],
			'auth'=> $this->sesion,
			'alertas'=>  $this->sesion
		);
		
		// LLamado de la vista blade:
		$this->blade->view('pages/usuarios/index', $data);
	}
	
	
	
	
	/*--------------------------------------------------------------------------------------------------
	* Crear usuario (view)
	*/
	public function create()
	{
		
		// Permiso de usuario regular:
		if($this->session->userdata('Rol') == 'REGULAR')
		{
			$this->session->set_flashdata('Alert','No tienes los permisos para ingresar en el modulo');
			redirect('Inicio');
		}
		
		// var_dump($this->sesion[0]->old['id']);
		$data = array(
			'title' => 'Crear Usuario',
			'auth'=> $this->sesion,
			'alertas'=>  $this->sesion,
			'old'=> $this->sesion
		);
		
		// LLamado de la vista blade:
		$this->blade->view('pages/usuarios/create', $data);
	}
	
	
	
	/*--------------------------------------------------------------------------------------------------
	* Editar usuario (view)
	*/
	public function edit($id)
	{	
		
		$id = urldecode($id);		

		// Permiso de usuario regular:
		if($this->session->userdata('Rol') == 'REGULAR' && $this->session->userdata('Id') != $id)
		{
			$this->session->set_flashdata('Alert','No tienes los permisos para ingresar en el modulo');
			redirect('Inicio');
		}


		// Consulta del usuario en la BD:
		$datos['usuarios'] = $this->Usuarios->detalles($id);

		if ($datos['usuarios'] == NULL || $datos['usuarios'] == '') 
		{
			redirect('Inicio');
		}
		
		// Seleccion de rol.
		if ($datos['usuarios']->rol == 'ADMINISTRADOR') 
		{
			$rolA = "selected = selected";
			$rolR = "";
		}
		else
		{
			$rolR = "selected = selected";
			$rolA = "";
		}
		
		// Seleccion de estado. 
		if ($datos['usuarios']->estado == 'ACTIVO') 
		{
			$estadoA = "selected = selected";
			$estadoR = "";
		}
		else
		{
			$estadoR = "selected = selected";
			$estadoA = "";
		}
		
		// Array de datos que se le pasan a la vista:
		$data = array(
			'title' => 'Edicion Usuario',
			'usuarios'=> $datos['usuarios'],
			'auth'=> $this->sesion,
			'estadoA'=> $estadoA,
			'estadoR'=> $estadoR,
			'rolR'=>	$rolR,
			'rolA'=>	$rolA,
			'old'=> $this->sesion,
			'id'=> $id,
			'alertas'=>  $this->sesion
		);
		
		// LLamado de la vista blade:
		$this->blade->view('pages/usuarios/edit', $data);
	}
	
	
	
	
	/*--------------------------------------------------------------------------------------------------
	*  Método almacenar usuario.
	*/
	public function store()
	{
		
		
		// Captura del POST del formulario:
		$params['id']=$_POST["id"];
		$params['primer_nombre'] = mb_strtoupper($_POST["primer_nombre"]);
		$params['segundo_nombre'] = mb_strtoupper($_POST["segundo_nombre"]);
		$params['primer_apellido'] = mb_strtoupper($_POST["primer_apellido"]);
		$params['segundo_apellido'] = mb_strtoupper($_POST["segundo_apellido"]);
		$params['email'] = mb_strtolower($_POST["email"]);
		$params['rol'] = mb_strtoupper($_POST["rol"]);
		$params['estado'] = mb_strtoupper($_POST["estado"]); 

			// Encriptacion de password:
		$password = $this->encrypt->encode($params['id']); 


		if (isset($_POST["crear"])) {

				// Envio de los datos al modelo:
			$mensaje = $this->Usuarios->guardar(
				$params['id'],
				$params['primer_nombre'],
				$params['segundo_nombre'],
				$params['primer_apellido'],
				$params['segundo_apellido'],
				$params['email'],
				$password,
				$params['rol'],
				$params['estado']
			);	

			if ($mensaje == '1') 
			{
				$this->session->set_flashdata('Status','El usuario fue almacenado correctamente');
				redirect('Usuarios');
			}
			else if($mensaje == '2')
			{
				$this->session->set_flashdata('Error','El usuario ya existe en la base de datos');
				$this->session->set_userdata('old',$params);
				redirect('Usuarios/Crear');
			}
			else 
			{
				$this->session->set_flashdata('Error','El correo electrónico ya existe en la base de datos');
				$this->session->set_userdata('old',$params);
				redirect('Usuarios/Crear');
			}
		}
		else
		{
			redirect('Usuarios'); 
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
			$params['primer_nombre'] = mb_strtoupper($_POST["primer_nombre"]);
			$params['segundo_nombre'] = mb_strtoupper($_POST["segundo_nombre"]);
			$params['primer_apellido'] = mb_strtoupper($_POST["primer_apellido"]);
			$params['segundo_apellido'] = mb_strtoupper($_POST["segundo_apellido"]);
			$params['email'] = mb_strtolower($_POST["email"]);
			$params['new_email'] = mb_strtolower($_POST["new_email"]);
			$params['rol'] = mb_strtoupper($_POST["rol"]);


			if (isset($_POST["actualizar"]))
			{

					// Envió de los datos al modelo:
				$mensaje = $this->Usuarios->actualizar(
					$params['id'],
					$params['new_id'],
					$params['primer_nombre'],
					$params['segundo_nombre'],
					$params['primer_apellido'],
					$params['segundo_apellido'],
					$params['email'],
					$params['new_email'],
					$params['rol']
				);	

				if ($mensaje == '1') 
				{
					$this->session->set_flashdata('Status','El usuario fue actualizado correctamente');
					if ($this->session->userdata('Rol') == "ADMINISTRADOR" && $params['new_id'] == $this->session->userdata('Id')) 
					{
						redirect('Inicio');
					}	
					else if($this->session->userdata('Rol') == "ADMINISTRADOR"){
						redirect('Usuarios');
					}
					else
					{
						redirect('Inicio');
					}

				}
				else if($mensaje == '2')
				{
					$this->session->set_flashdata('Error','El usuario ya existe en la base de datos (revisa la identificación)');
					$this->session->set_userdata('old',$params);
					redirect('Usuarios/Editar/'.$params['id']);
				}
				else 
				{
					$this->session->set_flashdata('Error','El correo electrónico ya existe en la base de datos');
					$this->session->set_userdata('old',$params);
					redirect('Usuarios/Editar/'.$params['id']);
				}
			}
			else
			{
					redirect('Inicio');
			}						
		}			

			/*--------------------------------------------------------------------------------------------------
			*  Método destruir usuario (inavilita al usuario mas no lo elimina).
			*/
			public function delete($id)
			{
				
				$id = urldecode($id);
				
				// Captura de datos:
				$params['id'] = $id;
				$params['estado'] = "INACTIVO";
				
				
				
				// Envió de los datos al modelo:
				$mensaje = $this->Usuarios->desactivar(
					$params['id'],
					$params['estado']
				);	
				
				if ($mensaje == '1') 
				{
					$this->session->set_flashdata('Status','El usuario fue desactivado correctamente');
					redirect('Usuarios');
				}
				else if ($mensaje == '2')
				{
					$this->session->set_flashdata('Error','No se puede desactivar el usuario actual');
					redirect('Usuarios');
				}
				else	
				{
					$this->session->set_flashdata('Error','El usuario no existe en la base de datos');
					redirect('Usuarios');
				}
				
			}
			
			
			
			/*--------------------------------------------------------------------------------------------------
			*  Método activar usuario.
			*/
			public function activate($id)
			{
				
				$id = urldecode($id);
				
				// Captura de datos:
				$params['id'] = $id;
				$params['estado'] = "ACTIVO";
				
				
				
				// Envió de los datos al modelo:
				$mensaje = $this->Usuarios->activar(
					$params['id'],
					$params['estado']
				);	
				
				if ($mensaje == '1') 
				{
					$this->session->set_flashdata('Status','El usuario fue activado correctamente');
					redirect('Usuarios');
				}
				else if($mensaje == '2')
				{
					$this->session->set_flashdata('Error','No se puede activar el usuario actual');
					redirect('Usuarios');
				}
				else
				{
					$this->session->set_flashdata('Error','El usuario no existe en la base de datos');
					redirect('Usuarios');
				}
			}
		}