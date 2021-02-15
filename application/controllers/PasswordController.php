<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PasswordController extends CI_Controller
{
/*------------------------------------------------------------------------------------
* Atributos 
*/
	
	private  $sesion;

/* --------------------------------------------------------------------------------------
* Metodos
*/
	public function __construct()
	{
		parent::__construct();

		// Carga de la base url:
		$this->load->helper('url');

		// Asignacion de objeto: 
		$objeto = new stdClass();

		// Parseo de datos de session:
		foreach ($this->session->userdata as $key => $value)
		{
			$objeto->$key = $value;
		}
		$this->sesion = [$objeto];

		// Carga del modelo
		$this->load->model('Password');		
	}

/*--------------------------------------------------------------------------------------
* Index 
*/

	public function index()
	{

    # Array para enviar a las vista:
		$data = array(
			'title' => 'Password',
			'alertas'=>  $this->sesion,
			'auth'=> $this->sesion
		);

    # Renderizacion de inicio:
		$this->blade->view('auth/password/password', $data);
	}


/*--------------------------------------------------------------------------------------
* Email: 
*/
	public function email()
	{

    # Array para enviar a las vista:
		$data = array(
			'title' => 'Email',
			'alertas'=>  $this->sesion
		);

    # Renderizacion de inicio:
		$this->blade->view('auth/password/email', $data);
	}


/*--------------------------------------------------------------------------------------
* Enviar: 
*/
	public function enviar()
	{
		// Carga del modelo	
		$this->load->library('encryption');
		$email = mb_strtolower($_POST["email"]);
		$mensaje = $this->Password->verificar($email);
		if($mensaje == '1')
		{
			$datos['detalle'] = $this->Password->detalle($email);

			$Nombre = $datos['detalle']->primer_nombre.' '.$datos['detalle']->segundo_nombre.' '.$datos['detalle']->primer_apellido.' '.$datos['detalle']->segundo_apellido;
			$Email = $datos['detalle']->email;
			$Password = $this->encrypt->encode($datos['detalle']->id); 
			$respuesta = $this->Password->actualizar(
				$datos['detalle']->id,
				$Password
			);

			$config = array(
				'protocol' => 'smtp',
				'smtp_host' => 'smtp.googlemail.com',
				'smtp_user' => 'inspesoft@gmail.com',
				'smtp_pass' => 'inspesoftalcaldiamunisipalsantarosadecabal',
				'smtp_port' => '465',
				'smtp_crypto' => 'ssl',
				'mailtype' => 'html',
				'wordwrap' => TRUE,
				'charset' => 'utf-8',
				'newline' => "\r\n"
			);

			$this->load->library('email');
			$this->email->initialize($config);
			$this->email->from('inspesoft@gmail.com');
			$this->email->subject('Recuperación de contraseña');
			$this->email->message("<p>Hola ".$Nombre.".</p> <br> <p>Nos llegó un requerimiento de cambio de contraseña a la plataforma, quizás de tu parte, por lo que hemos optado en cambiarte la contraseña que tenias actualmente por una contraseña provisional, la cual es: <b><i>".$datos['detalle']->id."</b></i></p> <p>Debes de iniciar sesion con tu correo y esta contraseña nueva, cuando ingreses en la plataforma, está te requerirá que cambies tu contraseña. <BR><b>¡TEN CUIDADO! al cambiar la contraseña.</b> En el campo de: “<i><U>contraseña actual</U></i>” debes poner la contraseña recibida por este correo.</p> <p> Fue un placer para nosotros darte este servicio de recuperación de contraseña.</p> <br><p><b>ATT: INSPESOFT</b> tu software para casos y querellas.</p>");
			$this->email->to($Email);
			$this->email->send();
			$this->session->set_flashdata('Status','La contraseña fue enviada a tu correo electrónico');
			redirect('Login');
		}
		else
		{
			$this->session->set_flashdata('Error','Correo no existe en nuestra base de datos');
			redirect('Password/Email');
		}
	}


	/*--------------------------------------------------------------------------------------
	* update
	*/
	public function update()
	{

	// Captura del POST del formulario:
		$id =  $_POST["id"];
		$params['password'] = mb_strtolower($_POST["password"]);
		$params['new_password'] = mb_strtolower($_POST["new_password"]);
		$params['confirmate'] = mb_strtolower($_POST["confirmate"]);

		if (isset($_POST["actualizar"]))
		{

			// Envió de los datos al modelo:
			$mensaje = $this->Password->index($id, $params['password']);

			if ($mensaje == '1') 
			{
				$this->session->set_flashdata('Error','La contraseña actual no es correcta');
				redirect('Password');
			}
			else if ($mensaje == '2') 
			{
				$this->session->set_flashdata('Error','No existe el usuario');
				redirect('Password');
			}
			else if ($params['new_password'] !== $params['confirmate']) 
			{
				$this->session->set_flashdata('Error','La contraseña nueva no coincide con la confirmación');
				redirect('Password');
			}
			else
			{
				// Encriptacion de password:
				$new_password = $this->encrypt->encode($params['new_password']); 
				$respuesta = $this->Password->actualizar(
					$id,
					$new_password
				);
				if ($respuesta == '1') 
				{
					$this->session->set_flashdata('Status','La contraseña fue actualizada correctamente');
					redirect('Inicio');
				}
			}
		}
	}
}
