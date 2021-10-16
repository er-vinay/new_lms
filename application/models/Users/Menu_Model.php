<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	 
    class Menu_Model extends CI_Model
    {
        private $table = 'ftc_menu_master';
        
		public function menusList($where)
		{
			return $this->db->select('*')->where($where)->from($this->table)->order_by('menu_order', 'asc')->get();
			
		}
		
		// public function menusList($company_id, $product_id)  
		// {
		//     $where = array('ftc_menu_permission.user_id' => user_id, 'ftc_menu_permission.is_active' => 1);
	 //        return $this->db->select('*')
	 //        ->where($where)
	 //        ->from('ftc_menu_permission')
	 //        ->join($this->table, 'ftc_menu_master.id = ftc_menu_permission.menu_id')
	 //        ->get();
		// }
    }
?>