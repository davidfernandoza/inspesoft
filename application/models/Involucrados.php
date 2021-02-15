<?php

class Involucrados extends CI_Model
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
		$consulta = $this->db->get('involucrados');
		return $consulta->result();
	}

/*-----------------------------------------------------------------------------------------------
* detalles caso
*/
	function detallesCasos($id_caso)
	{
		$this->db->where('casos_id', $id_caso);
		$consulta = $this->db->get('involucrados');
		return $consulta->result();
	}

	/*-----------------------------------------------------------------------------------------------
* detalles persona
*/
	function detallesPersona($id_persona)
	{
		$this->db->where('personas_id', $id_persona);
		$consulta = $this->db->get('involucrados');
		return $consulta->result();
	}

/*-----------------------------------------------------------------------------------------------
* Guardar
*/
	function guardar(
		$persona, 
		$caso, 
		$tipo,
		$subtipo)
	{
		$this->db->where('id', $persona);
		$existe_personas = $this->db->get('personas');

		$this->db->where('id',$caso);
		$existe_casos = $this->db->get('casos');
		
		if($existe_personas->num_rows() > 0 && $existe_casos->num_rows() > 0 )
		{
			$data = array(
				'id'=>NULL, 
				'personas_id'=>$persona, 
				'casos_id'=>$caso, 
				'tipo'=>$tipo,
				'subtipo'=>$subtipo,
				'estado'=>'ACTIVO'
			);
			$this->db->insert('involucrados', $data);
			$consulta = '1';
		}
		else
		{
			$consulta = '2';
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
			$existe_id = $this->db->get('involucrados');
			if($existe_id->num_rows() > 0 )
			{
				$consulta = '2';
				return $consulta;
			}
		}

		if ($email !== $new_email)
		{
			$this->db->where('email',$new_email);
			$existe_email = $this->db->get('involucrados');
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
		$this->db->update('involucrados', $data);
		$consulta = '1';

		// Verificar si el editado es el usuario AUTH
		if ($this->session->userdata('Id') == $id) 
		{
				// Actualizar las variables de sesion
			$datos = $this->involucrados->detalles($new_id);
			$this->session->set_userdata('Id', $datos->id);
			$this->session->set_userdata('Nombre', $datos->primer_nombre.' '.$datos->segundo_nombre.' '.$datos->primer_apellido.' '.$datos->segundo_apellido);
			$this->session->set_userdata('Rol', $datos->rol);
		}	
		return $consulta;
	}

/*-----------------------------------------------------------------------------------------------
* eliminar involucrados:
*/
function eliminar($id)
{

	$this->db->where('id', $id);
	$existe_id = $this->db->get('involucrados');

	if($existe_id->num_rows() > 0 )
	{
		$this->db->where('id', $id);
		$this->db->delete('involucrados');
		$consulta = '1';
	}
	else
	{
		$consulta = '2';
		return $consulta;
	}
	return $consulta;
}
}