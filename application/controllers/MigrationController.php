<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	class MigrationController extends CI_Controller
	{
		public function __construct()
		{
			parent::__construct();
            $this->load->model('Task_Model');
            $this->load->library('csvimport');

	    	$login = new IsLogin();
	    	$login->index();
		}

		public function migrationData()
	    {   
        	$this->load->view('Migration/index');
	    }
	    
        public function import_Loan_data()
        {
            if($this->input->server('REQUEST_METHOD') == 'POST')
            {
                $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
                
                if(!empty($file_data))
                {
                    // foreach($file_data as $row)
                    // {
                    //     echo "<pre>"; print_r($file_data); exit;
                    //     $client_name = "";
                    //     $client_mobile = "";
                    //     $client_email = "";
                    //     $service = "";
                    //     $follow_up = "";
                    //     $date = "";

                    //     if(!empty($row["Client Name"])){
                    //         $client_name = $row["Client Name"];
                    //     }

                    //     if(!empty($row["Contact Number"])){
                    //         $client_mobile = $row["Contact Number"];
                    //     }

                    //     if(!empty($row["Email Id"])){
                    //         $client_email = $row["Email Id"];
                    //     }

                    //     if(!empty($row["Service"])){
                    //         $service = $row["Service"];
                    //     }

                    //     if(!empty($row["Follow up"])){
                    //         $follow_up = $row["Follow up"];
                    //     }

                    //     if(!empty($row["Date"])){
                    //         $date = $row["Date"];
                    //     }

                    //     $data[] = array(
                    //         'agent_id'              =>  $this->input->post('agent_id'),
                    //         'master_admin_id'       =>  $this->input->post('admin_id'),
                    //         'client_name'           =>  $client_name,
                    //         'contact_number'        =>  $client_mobile,
                    //         'email_id'              =>  $client_email,
                    //         'service'               =>  $service,
                    //         'follow_up'             =>  $follow_up,
                    //         'date'                  =>  $date,
                    //         'agent_name'            =>  $this->input->post('name'),
                    //     );
                    // }
                        // $file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
                        foreach($file_data as $row)
                        {
                            $data[] = array(
                                'name' => $row["name"]
                            );
                        }
                    // $this->db->insert('leads', $data);
                    
                    $this->Task_Model->import_lead_data($data);
                }
                
            }
        }

	}

?>