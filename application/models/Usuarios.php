<?php

class Usuarios extends CI_Model
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
function index()
{
	$this->db->order_by('rol', 'DESC');
	$consulta = $this->db->get('usuarios');
	return $consulta->result();
}



/*-----------------------------------------------------------------------------------------------
* Detalles
*/
function detalles($id)
{
	$this->db->where('id', $id);
	$consulta=$this->db->get('usuarios');
	return $consulta->row();
}



/*-----------------------------------------------------------------------------------------------
* Login
*/
function login($email)
{	 
	$this->db->select('
		id,
		primer_nombre,
		segundo_nombre,
		primer_apellido,
		segundo_apellido,
		email,
		password,
		rol,
		estado'
	);
	$this->db->from('usuarios');
	$this->db->where('email',$email);
	$this->db->where('estado','ACTIVO');		
	$resultado=$this->db->get();
	if($resultado->num_rows() != 0)
	{
		$resultado = array(
			'val' => 			1,
			'id' => 			$resultado->row()->id,
			'nombres' => 	$resultado->row()->primer_nombre." ".$resultado->row()->segundo_nombre,
			'apellidos'=>	$resultado->row()->primer_apellido." ".$resultado->row()->segundo_apellido,
			'password' =>	$resultado->row()->password,
			'rol' => 			$resultado->row()->rol,
			'estado' => 	$resultado->row()->estado
		);
	}
	else
	{
		$resultado = array(
			'val' => 			0
		);
	}
	return $resultado; 
}




/*-----------------------------------------------------------------------------------------------
* Guardar
*/
function guardar(
	$id, 
	$primer_nombre, 
	$segundo_nombre, 
	$primer_apellido,
	$segundo_apellido,
	$email,
	$password,
	$rol,
	$estado)
{
	$this->db->where('id',$id);
	$existe_id = $this->db->get('usuarios');

	$this->db->where('email',$email);
	$existe_email = $this->db->get('usuarios');

	if($existe_id->num_rows() > 0 )
	{
		$consulta = '2';
	}
	else if($existe_email->num_rows() > 0 )
	{
		$consulta = '3';
	}
	else
	{

		$data = array(
			'id'=>$id, 
			'primer_nombre'=>$primer_nombre, 
			'segundo_nombre'=>$segundo_nombre, 
			'primer_apellido'=>$primer_apellido,
			'segundo_apellido'=>$segundo_apellido,
			'email'=>$email,
			'password'=>$password,
			'rol'=>$rol,
			'estado'=>$estado
		);
		$this->db->insert('usuarios', $data);
		$consulta = '1';
	}
	return $consulta;
}



/*-----------------------------------------------------------------------------------------------
* Actualizar
*/
function actualizar(
	$id,
	$new_id, 
	$primer_nombre, 
	$segundo_nombre, 
	$primer_apellido,
	$segundo_apellido,
	$email,
	$new_email,
	$rol)
{

	if ($id !== $new_id) 
	{
		$this->db->where('id', $new_id);
		$existe_id = $this->db->get('usuarios');
		if($existe_id->num_rows() > 0 )
		{
			$consulta = '2';
			return $consulta;
		}
	}

	if ($email !== $new_email)
	{
		$this->db->where('email',$new_email);
		$existe_email = $this->db->get('usuarios');
		if($existe_email->num_rows() > 0 )
		{
			$consulta = '3';
			return $consulta;
		}
	}
	$data = array(
		'id'=>$new_id,
		'primer_nombre'=>$primer_nombre, 
		'segundo_nombre'=>$segundo_nombre, 
		'primer_apellido'=>$primer_apellido,
		'segundo_apellido'=>$segundo_apellido,
		'email'=>$new_email,
		'rol'=>$rol
	);
	$this->db->where('id', $id);
	$this->db->update('usuarios', $data);
	$consulta = '1';

		// Verificar si el editado es el usuario AUTH
	if ($this->session->userdata('Id') == $id) 
	{
				// Actualizar las variables de sesion
		$datos = $this->Usuarios->detalles($new_id);
		$this->session->set_userdata('Id', $datos->id);
		$this->session->set_userdata('Nombre', $datos->primer_nombre.' '.$datos->segundo_nombre.' '.$datos->primer_apellido.' '.$datos->segundo_apellido);
		$this->session->set_userdata('Rol', $datos->rol);
	}	
	return $consulta;
}

/*-----------------------------------------------------------------------------------------------
* Desactivar:
*/
function desactivar($id, $estado)
{

	if ($this->session->userdata('Id') == $id) 
	{
		$consulta = '2';
		return $consulta;
	}	

	$this->db->where('id', $id);
	$existe_id = $this->db->get('usuarios');

	if($existe_id->num_rows() > 0 )
	{
		$data = array(
			'estado'=>$estado
		);
		$this->db->where('id', $id);
		$this->db->update('usuarios', $data);
		$consulta = '1';
	}
	else
	{
		$consulta = '3';
		return $consulta;
	}
	return $consulta;
}

/*-----------------------------------------------------------------------------------------------
* Activar:
*/
function activar($id, $estado)
{

	if ($this->session->userdata('Id') == $id) 
	{
		$consulta = '2';
		return $consulta;
	}	

	$this->db->where('id', $id);
	$existe_id = $this->db->get('usuarios');
	
	if($existe_id->num_rows() > 0 )
	{
		$data = array(
			'estado'=>$estado
		);
		$this->db->where('id', $id);
		$this->db->update('usuarios', $data);
		$consulta = '1';
	}
	else
	{
		$consulta = '3';
		return $consulta;
	}
	return $consulta;
}	

}