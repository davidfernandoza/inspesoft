<?php

class Password extends CI_Model
{

/*-----------------------------------------------------------------------------------------------
* Constructor
*/
	public function __construct()
	{
		parent::__construct();
	}



/*-----------------------------------------------------------------------------------------------
* Index
*/
	function index($id, $password)
	{
		$this->db->select('
			password'
		);
		$this->db->from('usuarios');
		$this->db->where('id', $id);	
		$resultado = $this->db->get();

		if($resultado->num_rows() > 0)
		{
			$confirmacion = $this->encrypt->decode($resultado->row()->password);
			if ($confirmacion == $password)
			 {
			  	$consulta = '3';	
			  }
			  else
			  {
			  	$consulta = '1';
			  }  
		}
		else
		{
			$consulta = '2';	
		}

		return 	$consulta;
	}

/*-----------------------------------------------------------------------------------------------
* Verificar
*/
	function verificar($email)
	{
		$this->db->from('usuarios');
		$this->db->where('email',$email);	
		$resultado=$this->db->get();
		if($resultado->num_rows() > 0)
		{
			$consulta = '1';	
		}
		else
		{
			$consulta = '2';	
		}
		return 	$consulta;
	}


/*-----------------------------------------------------------------------------------------------
* Verificar
*/
	function detalle($email)
	{
		$this->db->where('email',$email);
		$consulta = $this->db->get('usuarios');
		return $consulta->row();
	}


/*-----------------------------------------------------------------------------------------------
* Actualizar
*/
	function actualizar($id, $new_password)
	{
		$data = array(
			'password'=>$new_password
		);
		$this->db->where('id', $id);
		$this->db->update('usuarios', $data);
		$consulta = '1';
		return $consulta;
	}
}