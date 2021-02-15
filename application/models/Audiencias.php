<?php

class Audiencias extends CI_Model
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
	$sql = "SELECT 
	e.start,
	e.casos_id,
	e.comparendos_id,
	e.title,
	a.id
	FROM audiencias AS a 
	LEFT JOIN eventos AS e ON e.id = a.eventos_id
	";

	$consulta = $this->db->query($sql);
	return $consulta->result();
}

/*-----------------------------------------------------------------------------------------------
* Detalles
*/
function detalles($id)
{
	$sql = "SELECT
	a.id,
	a.asistencia_d,
	a.eventos_id,
	a.asistencia_d,
	a.escusa_d,
	a.argumento_d,
	a.pruebas_d,
	a.recursos_d,
	a.asistencia_c,
	a.escusa_c,
	a.argumento_c,
	a.pruebas_c,
	a.recursos_c,
	a.conciliacion,
	a.detalles,
	e.start,
	e.casos_id,
	e.comparendos_id,
	e.title	
	FROM audiencias AS a 
	LEFT JOIN eventos AS e ON e.id = a.eventos_id
	WHERE a.id = '".$id."'";

	$consulta = $this->db->query($sql);
	return $consulta->row();
}

/*-----------------------------------------------------------------------------------------------
* Guardar
*/
function guardar(
	$id,
	$eventos,
	$asistencia_d,
	$escusa_d,
	$argumentos_d,
	$pruebas_d,
	$recursos_d,
	$asistencia_c,
	$escusa_c,
	$argumentos_c,
	$pruebas_c,
	$recursos_c,
	$conciliacion,
	$detalles)
{
	$this->db->where('id', $id);
	$existe_id = $this->db->get('audiencias');

	$this->db->where('eventos_id', $eventos);
	$existe_eventosid = $this->db->get('audiencias');

	if($existe_id->num_rows() > 0)
	{
		$consulta = '2';
	}
	else if ($existe_eventosid->num_rows() > 0)
	{
		$consulta = '3';
	}
	else
	{
		$data = array(
			'id'=>$id,
			'eventos_id'=>	$eventos,
			'asistencia_d'=>	$asistencia_d,
			'escusa_d'=>	$escusa_d,
			'argumento_d'=>	$argumentos_d,
			'pruebas_d'=>	$pruebas_d,
			'recursos_d'=>	$recursos_d,
			'asistencia_c'=>	$asistencia_c,
			'escusa_c'=>	$escusa_c,
			'argumento_c'=>	$argumentos_c,
			'pruebas_c'=>	$pruebas_c,
			'recursos_c'=>	$recursos_c,
			'conciliacion'=>	$conciliacion,
			'detalles'=> $detalles
		);
		$this->db->insert('audiencias', $data);
		$consulta = '1';
	}
	return $consulta;
}


	/*-----------------------------------------------------------------------------------------------
	* Actualizar
*/
	function actualizarc($id, $escusa_c)
	{
		$this->db->where('id', $id);
		$existe_id = $this->db->get('audiencias');

		if($existe_id->num_rows() == 0)
		{
			$consulta = '2';
		}
		else
		{
			$data = array(
				'id'=>$id,
				'escusa_c'=>	$escusa_c
			);
			$this->db->where('id', $id);
			$this->db->update('audiencias', $data);
			$consulta = '1';	
			return $consulta;
		}
	}


	/*-----------------------------------------------------------------------------------------------
	* Actualizar
*/
	function actualizard($id, $escusa_d)
	{
		$this->db->where('id', $id);
		$existe_id = $this->db->get('audiencias');

		if($existe_id->num_rows() == 0)
		{
			$consulta = '2';
		}
		else
		{
			$data = array(
				'id'=>$id,
				'escusa_d'=>	$escusa_d
			);
			$this->db->where('id', $id);
			$this->db->update('audiencias', $data);
			$consulta = '1';	
			return $consulta;
		}
	}

		/*-----------------------------------------------------------------------------------------------
	* Actualizar
*/
	function actualizar($id, $detalles)
	{
		$this->db->where('id', $id);
		$existe_id = $this->db->get('audiencias');

		if($existe_id->num_rows() == 0)
		{
			$consulta = '2';
		}
		else
		{
			$data = array(
				'id'=>$id,
				'detalles'=>	$detalles
			);
			$this->db->where('id', $id);
			$this->db->update('audiencias', $data);
			$consulta = '1';	
			return $consulta;
		}
	}


}