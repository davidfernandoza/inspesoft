<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoginController extends CI_Controller
{
	/*-------------------------------------------------------------------------------------------------
	* Atributos.
	*/
	private  $sesion;

	/*-------------------------------------------------------------------------------------------------
	* Metodos.
	*/
	public function __construct()
	{
		parent::__construct();

		// Carga de la url:
		$this->load->helper('url');

		// Asignacion de objeto: 
		$objeto = new stdClass();

		// Parseo de datos de session:
		foreach ($this->session->userdata as $key => $value)
		{
			$objeto->$key = $value;
		}
		$this->sesion = [$objeto];
		$this->load->model('Usuarios');
	}

	/*-------------------------------------------------------------------------------------------------
	* Index.
	*/
	public function index()
	{
		// Redireccionamiento: 
		if ($this->session->userdata('OK') == TRUE)
		{
			redirect('Inicio');
		}

		// Array de datos para la vista:
		$data = array(
			'title' => 'login',
			'alertas'=>  $this->sesion
		);

			// Renderizacion de login:
		$this->blade->view('auth/login', $data);
	}

	/*-------------------------------------------------------------------------------------------------
	* Autentificar.
	*/

	public function autenticar()
	{
		$this->load->library('encryption'); 
		$params['email'] = mb_strtolower($_POST["email"]);
		$params['password'] = mb_strtolower($_POST["password"]);

		// 

		// Consulta a la BD:
		$datos = $this->Usuarios->login($params['email']);

		// Desencriptacion de password:
		$password = $this->encrypt->decode($datos['password']); 

		// var_dump($datos['password']);

		// Validacion de datos:
		if ($datos['val'] == 1 && $password == $params['password']) 
		{

			$this->session->set_userdata('Id', $datos['id']);
			$this->session->set_userdata('Nombre', $datos['nombres'].' '.$datos['apellidos']);
			$this->session->set_userdata('Rol', $datos['rol']);
			$this->session->set_userdata('Estado', $datos['estado']);
			$this->session->set_userdata('OK', 'TRUE');

			if($params['password'] == $datos['id'])
			{
				$this->session->set_flashdata('Alert','Cambia tu contraseña por seguridad');
				$this->session->set_userdata('Password_Lock', 'TRUE');
				redirect('Password');	
			}
			redirect('Inicio');	
		}
		else
		{
			$this->session->set_flashdata('Error','Correo o contraseña errados');
			redirect('Login');
		}
	}

	/*-------------------------------------------------------------------------------------------------
	* Salir.
	*/
	public function salir()
	{
		$this->session->sess_destroy();
		redirect('Login');
	} 
}