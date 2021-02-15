<?php

class Representaciones extends CI_Model
{

/*-----------------------------------------------------------------------------------------------
* Constructor
*/
public function __construct()
{
	parent::__construct();
}

// var_dump


/*-----------------------------------------------------------------------------------------------
* Index
*/
function index()
{
	$consulta = $this->db->get('representaciones');
	return $consulta->result();
}

/*-----------------------------------------------------------------------------------------------
* Detalles apoderado
*/
function detalles_apoderado()
{
	$this->db->where('apoderados_id',(int)$apoderados);
	$consulta = $this->db->get('representaciones');
	return $consulta->result();
}

/*-----------------------------------------------------------------------------------------------
* Detalles
*/
function detalles($casos, $apoderados, $personas)
{
	$this->db->where('casos_id', $casos);
	$this->db->where('apoderados_id',(int)$apoderados);
	$this->db->where('personas_id', $personas);
	$consulta = $this->db->get('representaciones');
	return $consulta->row();
}

/*-----------------------------------------------------------------------------------------------
* Guardar
*/
function guardar($casos, $apoderados, $personas)
{
	$this->db->where('casos_id', $casos);
	$this->db->where('apoderados_id',(int)$apoderados);
	$this->db->where('personas_id', $personas);
	$existe_representacio = $this->db->get('representaciones');
	if ($existe_representacio->num_rows() == 0) {

		$this->db->where('id', $casos);
		$existe_casos = $this->db->get('casos');

		$this->db->where('id', $apoderados);
		$existe_apoderados = $this->db->get('apoderados');

		$this->db->where('id', $personas);
		$existe_personas = $this->db->get('personas');

		if($existe_casos->num_rows() > 0  &&  $existe_apoderados->num_rows() > 0 &&  $existe_personas->num_rows() > 0 )
		{
			$data = array(
				'casos_id'=>$casos, 
				'apoderados_id'=>$apoderados, 
				'personas_id'=>$personas,
				'estado'=>'ACTIVO'	
			);
			$this->db->insert('representaciones', $data);
			$consulta = '1';
		}
		else 
		{
			$consulta = '2';
		}

	}else{
		$consulta = '3';
	}

	return $consulta;
}


/*-----------------------------------------------------------------------------------------------
* Eliminar:
*/
function eliminar($casos, $apoderados, $personas)
{

	$this->db->where('casos_id', $casos);
	$this->db->where('apoderados_id', $apoderados);
	$this->db->where('personas_id', $personas);
	$existe_representacio = $this->db->get('representaciones');
	if ($existe_representacio->num_rows() > 0) {
		$this->db->where('casos_id', $casos);
		$this->db->where('apoderados_id',$apoderados);
		$this->db->where('personas_id', $personas);
		$this->db->delete('representaciones');
		$consulta = '1';
	}
	else{
		$consulta = '2';
	}
	return $consulta;
}
}