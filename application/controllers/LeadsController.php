<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LeadsController extends CI_Controller {  
    function __construct()  
		{
			parent::__construct();
	        define("ip", $this->input->ip_address());
	    	date_default_timezone_set('Asia/Kolkata');
	        define("todayDate", date('Y-m-d'));
	        define("tableLeads", "leads");
	        define("currentDate", date('Y-m-d'));
	        define("created_at", date('Y-m-d H:i:s'));
	        define("updated_at", date('Y-m-d H:i:s'));
	        define("server", $_SERVER['SERVER_NAME']);
	        define("localhost", "public/images/");
	        define("live", base_url()."upload/");
	        define("product_id", $_SESSION['isUserSession']['product_id']);
	        define("company_id", $_SESSION['isUserSession']['company_id']);
	        define("user_id", $_SESSION['isUserSession']['user_id']);
	        
	        /////////// define role ///////////////////////////////////////
	        
            define('screener', "SANCTION QUICKCALLER");
            define('creditManager', "Sanction & Telecaller");
            define('headCreditManager', "Sanction Head");
            define('admin', "Client Admin");
            define('teamDisbursal', "Disbursal");
            define('teamClosure', "Account and MIS");
            define('teamCollection', "Collection");
		}

    

    // function for upding the varification table 
    public function add_action()
    {


            $data = array(
                'pan_verified'                       => $_POST['data']['PANverified'],
                'bank_statement_verified'            => $_POST['data']['BankStatementSVerified'],
                'init_office_email_verification'     => $_POST['data']['officeEmailVerification'],
                'init_mobile_verification'           => $_POST['data']['initiateMobileVerification'],
                'mobile_otp'                         =>$_POST['data']['enterOTPMobile'],
                'init_residence_cpv'                 => $_POST['data']['residenceCPV'],
                'init_office_cpv'                    => $_POST['data']['officeCPV'],
                'residece_cpv_allocated_to'          =>$_POST['data']['residece_cpv_allocated_to'],
                'office_cpv_allocated_to'            =>$_POST['data']['office_cpv_allocated_to'],
                'residence_cpv_allocated_on'         =>$_POST['data']['residence_cpv_allocated_on'],
                'office_cvp_allocated_on'            =>$_POST['data']['office_cvp_allocated_on']
            );
            $table='tbl_verification';
            $upd_id=$_POST['data']['lead_id'];
            $colm='lead_id';
            $res = $this->Leadmod->globel_update($table,$data,$upd_id,$colm);

            echo json_encode(['status' => TRUE]);
            
      }

      // function for save the data of personal tab1
    public function savepersonal1()
    {
        $table='tbl_cam';
        $upd_id=$_POST['data']['lead_id'];
        $lead_id=$_POST['data']['lead_id'];
        $colm='lead_id';
        $status = getLeadIdstatus($table,$upd_id);

        date_default_timezone_set("Asia/Kolkata");
        $currentdate = date('Y-m-d H:i:s');

            $data = array(
                'borrower_name'                       => $_POST['data']['borrower_name'],
                'middle_name'            => $_POST['data']['middle_name'],
                'surname'     => $_POST['data']['surname'],
                'gender'           => $_POST['data']['gender'],
                'dob'                         =>$_POST['data']['dob'],
                'pancard'                 => $_POST['data']['pancard'],
                'mobile'                    => $_POST['data']['mobile'],
                'alternate_no'          =>$_POST['data']['alternate_no'],
                'email'            =>$_POST['data']['email'],
                'alternateEmail'         =>$_POST['data']['alternateEmail']
            );
          
          //  echo "<pre>";print_r($data);
          if($status=='0')
           {
                    $insertDate = [
                    'lead_id' 					=> $lead_id,
                    'usr_created_by' 			=> user_id,
                    'usr_created_at' 			=> $currentdate,
                ];
                       $data = array_merge($insertDate, $data);
                       $res = $this->Leadmod->globel_inset($table,$data);

                      // echo  $this->db->last_query();
                     

            }
           else
            {
                $insertDate = [
                    'usr_updated_by' 			=> user_id,
                    'usr_updated_at' 			=> $currentdate,
                ];
                $data = array_merge($insertDate, $data);
             $res = $this->Leadmod->globel_update($table,$data,$upd_id,$colm);
              // echo  $this->db->last_query();
               
                
          }
          
           
            //
           // $res = $this->Leadmod->globel_update($table,$data,$upd_id,$colm);

            //echo json_encode(['status' => TRUE]);
            
      }


      public function insertPersonal4()
      {
  
       
              $data = array(
                  'refrence1'                       => $_POST['data']['refrence1'],
                  'refrence2'            => $_POST['data']['refrence2'],
                  'relation'     => $_POST['data']['relation'],
                  'relation1'           => $_POST['data']['relation1'],
                  'refrence1mobile'                         =>$_POST['data']['refrence1mobile'],
                  'refrence2mobile'                 => $_POST['data']['refrence2mobile']
                 
              );
              $table='tbl_cam';
              $upd_id=$_POST['data']['lead_id'];
              $colm='lead_id';
              $res = $this->Leadmod->globel_update($table,$data,$upd_id,$colm);
  
              echo json_encode(['status' => TRUE]);
              
        }



        public function insertPersonal3()
      {
  
       
              $data = array(
                  'refrence1'                => $this->input->post('hfBulNo1'),
                  'refrence2'                => $this->input->post('lcss1'),
                  'relation'                 => $this->input->post('lankmark1'),
                  'relation'                 => $this->input->post('city1'),
                  'relation'                 => $this->input->post('pincode1'),
                  'relation'                 => $this->input->post('district1'),
                  'relation'                 => $this->input->post('state1'),
                  'relation'                 => $this->input->post('aadhar1'),
                  'relation'                 => $this->input->post('addharAddressSameasAbove'),
                  'relation'                 => $this->input->post('lcss2'),
                  'relation'                 => $this->input->post('lcss2'),
                  'relation'                 => $this->input->post('landmark2'),
                  'relation'                 => $this->input->post('city2'),
                  'relation'                 => $this->input->post('presentResidenceType'),
                  'relation'                 => $this->input->post('residenceSince'),
                  'relation'                 => $this->input->post('SCM_CONF_REQ'),
                  'relation'                 => $this->input->post('scmResponce'),
                  'relation'                 => $this->input->post('scmConfIntOn'),
                  'relation'                 => $this->input->post('scmResponceOn'),
                  'relation'                 => $this->input->post('scmResponceOn')
                  
                 
              );
              $table='tbl_cam';
              $upd_id=$this->input->post('lead_id');
              $colm='lead_id';
              $res = $this->Leadmod->globel_update($table,$data,$upd_id,$colm);
  
              echo json_encode(['status' => TRUE]);
              
        }




}
?>
