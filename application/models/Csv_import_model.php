<?php
	class Csv_import_model extends CI_Model
	{
		public $table = 'tbl_old_data';

		function select()
		{
			$this->db->order_by('id', 'DESC');
			$query = $this->db->get($this->table)->result_array();
			return $query;
		}

		function filterData($agent_name)
		{
			$this->db->order_by('id', 'DESC');
			$query = $this->db->where('agent_name', $agent_name)->get($this->table)->result_array();
			return $query;
		}

		function list_agent_name()
		{
			$this->db->order_by('id', 'DESC');
			$query = $this->db->select('DISTINCT(agent_name)')->get($this->table)->result_array();
			return $query;
		}

		function insert($data)
		{
			$this->db->insert_batch($this->table, $data);
		}
	}
?>