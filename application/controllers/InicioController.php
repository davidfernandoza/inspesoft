<?php
defined('BASEPATH') or exit('No direct script access allowed');

class InicioController extends CI_Controller
{

	/*
	* Atributos ------------------------------------------------------------------------------------
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

		// Redireccionamiento de login:
		if ($this->session->userdata('OK') == FALSE)
		{
			$this->session->set_flashdata('Alert','INICIA SESIÓN');
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



	}

	/*--------------------------------------------------------------------------------------
	* Index 
	*/

	public function index()
	{

    # Array para enviar a las vista:
		$data = array(
			'title' => 'Inicio',
			'alertas'=>  $this->sesion,
			'auth'=> $this->sesion
		);

    # Renderizacion de inicio:
		$this->blade->view('pages/inicio', $data);
	}

}