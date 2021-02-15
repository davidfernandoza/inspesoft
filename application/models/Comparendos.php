<?php

class Comparendos extends CI_Model
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
		$consulta = $this->db->get('comparendos');
		return $consulta->result();
	}

	/*-----------------------------------------------------------------------------------------------
	* Index eventos
	*/
	function eventos()
	{
		$this->db->where('estado =', 'APELADO');
		$consulta = $this->db->get('comparendos');
		return $consulta->result();
	}
	

	/*-----------------------------------------------------------------------------------------------
	* involucrar
	*/
	function involucrar()
	{
		$this->db->where('personas_id =', NULL);
		$consulta = $this->db->get('comparendos');
		return $consulta->result();
	}

	/*-----------------------------------------------------------------------------------------------
	* personasNull
	*/
	function personasNull()
	{
		$this->db->where('personas_id !=', NULL);
		$consulta = $this->db->get('comparendos');
		return $consulta->result();
	}
	
	
	/*-----------------------------------------------------------------------------------------------
	* Detalles
	*/
	function detalles($id)
	{
		$this->db->where('id', $id);
		$consulta=$this->db->get('comparendos');
		return $consulta->row();
	}

	/*-----------------------------------------------------------------------------------------------
	* Detalles p
	*/
	function detalles_p($id)
	{
		$this->db->where('personas_id', $id);
		$consulta=$this->db->get('comparendos');
		return $consulta->result();
	}

	
	/*-----------------------------------------------------------------------------------------------
	* Guardar
	*/
	function guardar(
		$id,
		$fecha,
		$articulo,
		$tipo,
		$numeral,
		$literal,
		$multa,
		$num_folios,
		$num_cajas,
		$estado
	)
	{
		$this->db->where('id', $id);
		$existe_id = $this->db->get('comparendos');
		$num_folios == "" ? $num_folios = NULL : $num_folios = $num_folios;		

		if($existe_id->num_rows() > 0 )
		{
			$consulta = '2';
		}
		else
		{

			$data = array(
				'id'=> $id,
				'tipo' => $tipo,
				'articulo' => $articulo,
				'numeral' => $numeral,
				'literal' => $literal,
				'multa' => $multa,
				'num_folios' => $num_folios,
				'num_caja' => $num_cajas,
				'fecha' => $fecha,
				'estado' => $estado
			);
			$this->db->insert('comparendos', $data);
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
			$fecha,
			$articulo,
			$tipo,
			$numeral,
			$literal,
			$multa,
			$folio,
			$new_folio,
			$num_cajas,
			$estado)
		{

			if ($id !== $new_id) 
			{
				$this->db->where('id', $new_id);
				$existe_id = $this->db->get('comparendos');
				if($existe_id->num_rows() > 0 )
				{
					$consulta = '2';
					return $consulta;
				}
			}

			$new_folio == "" ? $new_folio = NULL : $new_folio = $new_folio;	

			if ($new_folio != NULL) {
				if ($folio !== $new_folio)
				{
					$this->db->where('num_folios', $new_folio);
					$existe_folio = $this->db->get('comparendos');
					if($existe_folio->num_rows() > 0 )
					{
						$consulta = '3';
						return $consulta;
					}
				}
			}		


			$data = array(
				'id'=> $new_id,
				'tipo' => $tipo,
				'articulo' => $articulo,
				'numeral' => $numeral,
				'literal' => $literal,
				'multa' => $multa,
				'num_folios' => $new_folio,
				'num_caja' => $num_cajas,
				'fecha' => $fecha,
				'estado' => $estado
			);
			$this->db->where('id', $id);
			$this->db->update('comparendos', $data);
			$consulta = '1';	
			return $consulta;
		}

	/*-----------------------------------------------------------------------------------------------
		* Involucrar Persona
		*/
		function personas($id, $persona)
		{

			$this->db->where('id', $id);
			$existe_folio = $this->db->get('comparendos');
			if($existe_folio->num_rows() == 0)
			{
				$consulta = '3';
				return $consulta;
			}
			$this->db->where('id', $persona);
			$existe_folio = $this->db->get('personas');
			if($existe_folio->num_rows() > 0){
				$data = array(
					'personas_id'=> $persona
				);
				$this->db->where('id', $id);
				$this->db->update('comparendos', $data);
				$consulta = '1';	
			}
			else{
				$consulta = '2';
			}			
			return $consulta;
		}

		/*-----------------------------------------------------------------------------------------------
		* Eliminar contraventor
		*/
		function eliminar($id)
		{
			$this->db->where('id', $id);
			$existe_id = $this->db->get('comparendos');
			if($existe_id->num_rows() == 0 )
			{
				$consulta = '2';
			}
			else{
				$data = array(
					'personas_id'=> null
				);
				$this->db->where('id', $id);
				$this->db->update('comparendos', $data);
				$consulta = '1';
			}
			return $consulta;
		}

	}
		// CREAR EL METODO PARA AGRAGAR UN INVOLUCRADO