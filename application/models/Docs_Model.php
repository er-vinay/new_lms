<?php

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Docs_Model extends CI_Model

    {

        private $table = 'docs';

        private $table_docs_master = 'docs_master';

    	

    	public function docs_type_master() {

    	    return $this->db->select('distinct(docs_type)')->from($this->table_docs_master)->get();

    	}



        public function getDocumentSubType($docs_type) {

            return $this->db->select('docs_type, docs_sub_type')->where('docs_type', $docs_type)->from($this->table_docs_master)->get();

        }



        public function index($limit = null, $order_by = null) {

            return $this->db->select('*')->from($this->table)->limit($limit)->order_by($order_by)->get();

        }

        

        public function select($conditions, $data = null) {

            return $this->db->select($data)->where($conditions)->from($this->table)->get();

        }

        

        public function insert($data) {

            return $this->db->insert($this->table, $data);

        }

        

        public function update($conditions, $data) {

            return $this->db->where($conditions)->update($this->table, $data);

        }

        

        public function delete($conditions) {

            return $this->db->where($conditions)->delete($this->table);

        }



        public function join_table($conditions = null, $data = null, $table2 = null, $table3 = null) 

        {

            return $this->db->select($data)

                ->where($conditions)

                ->from($this->table.' LD')

                ->join($table2, 'DS.lead_id = LD.lead_id')

                ->join($table3, 'ST.state_id = LD.state_id')

                ->get();

        }



    }