<?php

class Apoderados extends CI_Model
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
	$consulta = $this->db->get('apoderados');
	return $consulta->result();
}


/*-----------------------------------------------------------------------------------------------
* Detalles
*/
function detalles($id)
{
	$this->db->where('id', $id);
	$consulta=$this->db->get('apoderados');
	return $consulta->row();
}


/*-----------------------------------------------------------------------------------------------
* Guardar
*/
function guardar(
	$id,
	$targeta_pro, 
	$primer_nombre, 
	$segundo_nombre, 
	$primer_apellido,
	$segundo_apellido,
	$email,
	$telefono,
	$estado)
{
	$this->db->where('id',$id);
	$existe_id = $this->db->get('apoderados');

	$this->db->where('targeta_pro',$targeta_pro);
	$existe_targeta = $this->db->get('apoderados'); 

	if($existe_id->num_rows() > 0 || $existe_targeta->num_rows()>0)
	{
		$consulta = '2';
	}
	else
	{
		$data = array(
			'id'=>$id, 
			'targeta_pro'=>$targeta_pro,
			'primer_nombre'=>$primer_nombre, 
			'segundo_nombre'=>$segundo_nombre, 
			'primer_apellido'=>$primer_apellido,
			'segundo_apellido'=>$segundo_apellido,
			'email'=>$email,
			'telefono'=>$telefono,
			'estado'=>$estado
		);
		$this->db->insert('apoderados', $data);
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
	$targeta_pro,
	$new_targeta_pro ,
	$primer_nombre, 
	$segundo_nombre, 
	$primer_apellido,
	$segundo_apellido,
	$email,
	$new_email,
	$telefono,
	$estado)
{

	if ($id !== $new_id) 
	{
		$this->db->where('id', $new_id);
		$existe_id = $this->db->get('apoderados');
		if($existe_id->num_rows() > 0 )
		{
			$consulta = '2';
			return $consulta;
		}
	}

	if ($targeta_pro !== $new_targeta_pro) 
	{
		$this->db->where('targeta_pro', $new_targeta_pro);
		$existe_id = $this->db->get('apoderados');
		if($existe_id->num_rows() > 0 )
		{
			$consulta = '2';
			return $consulta;
		}
	}

	$data = array(
		'id'=>$new_id, 
		'targeta_pro'=>$new_targeta_pro,
		'primer_nombre'=>$primer_nombre, 
		'segundo_nombre'=>$segundo_nombre, 
		'primer_apellido'=>$primer_apellido,
		'segundo_apellido'=>$segundo_apellido,
		'email'=>$new_email,
		'telefono'=>$telefono,
		'estado'=>$estado
	);
	$this->db->where('id', $id);
	$this->db->update('apoderados', $data);
	$consulta = '1';
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
	$existe_id = $this->db->get('apoderados');

	if($existe_id->num_rows() > 0 )
	{
		$data = array(
			'estado'=>$estado
		);
		$this->db->where('id', $id);
		$this->db->update('apoderados', $data);
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
	$existe_id = $this->db->get('apoderados');
	
	if($existe_id->num_rows() > 0 )
	{
		$data = array(
			'estado'=>$estado
		);
		$this->db->where('id', $id);
		$this->db->update('apoderados', $data);
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