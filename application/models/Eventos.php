<?php

class Eventos extends CI_Model
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
		$consulta = $this->db->get('eventos');
		return $consulta->result();
	}


	/*-----------------------------------------------------------------------------------------------
	* Detalles
	*/
	function detalles($id)
	{
		$this->db->where('id', $id);
		$consulta = $this->db->get('eventos');
		return $consulta->row();
	}
	

	/*-----------------------------------------------------------------------------------------------
	* notificaciones
	*/
	function notificaciones($fecha)
	{
		$this->db->like('start', $fecha);
		$consulta = $this->db->get('eventos');
		return $consulta->result();
	}


	/*-----------------------------------------------------------------------------------------------
	* audiencias
	*/
	function audiencias($fecha)
	{
		$sql = "SELECT * 
		FROM eventos
		WHERE start LIKE '%".$fecha."%'
		AND (casos_id != '' OR comparendos_id != '' )";

		$consulta = $this->db->query($sql);
		return $consulta->result();
	}
	

	/*-----------------------------------------------------------------------------------------------
	* Guardar
	*/
	function guardar($title, $start, $color, $descripcion, $casos_id, $comparendos_id){
		$data = array(
			'title'=>$title,
			'start'=>$start,
			'color'=>$color,
			'descripcion'=>$descripcion,
			'casos_id'=>$casos_id,
			'comparendos_id'=>$comparendos_id
		);
		$this->db->insert('eventos', $data);
	}

		/*-----------------------------------------------------------------------------------------------
		* Actualizar
		*/
		function actualizar($id, $title, $start, $color, $descripcion)
		{
			$this->db->where('id', $id);
			$existe_id = $this->db->get('eventos');
			if($existe_id->num_rows() == 0 )
			{
				$consulta = '2';
				return $consulta;
			}
			$data = array(
				'title'=>$title,
				'start'=>$start,
				'color'=>$color,
				'descripcion'=>$descripcion
			);
			$this->db->where('id', $id);
			$this->db->update('eventos', $data);
			$consulta = '1';	
			return $consulta;
		}

		/*-----------------------------------------------------------------------------------------------
		* Eliminar 
		*/
		function eliminar($id)
		{

			$this->db->where('id', $id);
			$existe_id = $this->db->get('eventos');

			$this->db->where('eventos_id', $id);
			$existe_eventos_id = $this->db->get('audiencias');

			if($existe_id->num_rows() == 0 )
			{
				$consulta = '2';
			}
			else if ($existe_eventos_id->num_rows() > 0){
				$consulta = '3';
			}
			else{
				$this->db->where('id', $id);
				$this->db->delete('eventos');
				$consulta = '1';
			}
			return $consulta;
		}

	}