<?php

class Fallos extends CI_Model
{

	/*-----------------------------------------------------------------------------------------------
	* Constructor
	*/
	public function __construct()
	{
		parent::__construct();
	}


	/*-----------------------------------------------------------------------------------------------
	* Detalles
	*/
	function detalles($id)
	{
		$this->db->where('casos_id', $id);
		$consulta=$this->db->get('fallos');
		return $consulta->result();
	}

	/*-----------------------------------------------------------------------------------------------
	* Detalles por id
	*/
	function detallesId($id)
	{
		$this->db->where('num_resolucion', $id);
		$consulta=$this->db->get('fallos');
		return $consulta->row();
	}



	/*-----------------------------------------------------------------------------------------------
	* Guardar
	*/
	function guardar(
		$resolucion,
		$casos, 
		$fallo, 
		$detalles,
		$tipo,
		$fecha)
	{
		$this->db->where('num_resolucion', $resolucion);
		$existe_id = $this->db->get('fallos');

		if($existe_id->num_rows() > 0 )
		{
			$consulta = '2';
		}
		else
		{
			if (empty($casos)) 
			{
				$casos = NULL;
			}
			if (empty($detalles)) 
			{
				$detalles = NULL;
			}
			$data = array(
				'num_resolucion'=>$resolucion,
				'casos_id'=> $casos,
				'fallo'=> $fallo,
				'detalles'=> $detalles,
				'tipo'=> $tipo,
				'fecha'=> $fecha,
				'estado'=>'ACTIVO'
			);
			$this->db->insert('fallos', $data);
			$consulta = '1';
		}
		return $consulta;
	}
	/*-----------------------------------------------------------------------------------------------
	* Actualizar
	*/
	function actualizar(
		$resolucion,
		$new_resolucion,
		$fallo, 
		$detalles,
		$tipo)
	{

		if ($resolucion !== $new_resolucion) 
		{
			$this->db->where('num_resolucion', $new_resolucion);
			$existe_id = $this->db->get('fallos');
			if($existe_id->num_rows() > 0 )
			{
				$consulta = '2';
				return $consulta;
			}
		}
		$data = array(
			'num_resolucion'=>$new_resolucion,
			'fallo'=> $fallo,
			'detalles'=> $detalles,
			'tipo'=> $tipo,
			'estado'=>'ACTIVO'
		);
		$this->db->where('num_resolucion', $resolucion);
		$this->db->update('fallos', $data);
		$consulta = '1';
		return $consulta;
	}


	/*-----------------------------------------------------------------------------------------------
	* Eliminar
	*/
	function eliminar($resolucion)
	{
		$this->db->where('num_resolucion', $resolucion);
		$existe_id = $this->db->get('fallos');
		if($existe_id->num_rows() > 0 )
		{
			$this->db->where('num_resolucion', $resolucion);
			$this->db->delete('fallos');
			$consulta = '1';
		}
		else
		{
			$consulta = '2';
		}

		
		return $consulta;
	}

}