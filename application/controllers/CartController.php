<?php
    defined('BASEPATH') OR exit('No direct script access allowed');
    
    header('Content-type: text/html; charset=UTF-8');
    class CartController extends CI_Controller
    {
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Task_Model');
            
        }

        public function index()
        {
            $this->load->view('Tasks/bank');
        }
        public function saveBankAnalysis()
        {
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {
                $ipaddress = '';
                if (getenv('HTTP_CLIENT_IP')){
                    $ipaddress = getenv('HTTP_CLIENT_IP');
                }
                else if(getenv('HTTP_X_FORWARDED_FOR')){
                    $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
                }
                else if(getenv('HTTP_X_FORWARDED')){
                    $ipaddress = getenv('HTTP_X_FORWARDED');
                }
                else if(getenv('HTTP_FORWARDED_FOR')){
                    $ipaddress = getenv('HTTP_FORWARDED_FOR');
                }
                else if(getenv('HTTP_FORWARDED')){
                   $ipaddress = getenv('HTTP_FORWARDED');
                }
                else if(getenv('REMOTE_ADDR')){
                    $ipaddress = getenv('REMOTE_ADDR');
                }
                else{
                    $ipaddress = 'UNKNOWN';
                }
    
                $filename = "";
                $password = "";
                $json = [];

                if(!empty($_POST['password'])) {
                    $password = $this->input->post('password');
                }

                $config['upload_path'] = 'public/BankAnalysis/';
                $config['allowed_types'] = 'pdf';
                $this->upload->initialize($config);
                if(!$this->upload->do_upload('file'))
                {
                    $json['err'] = $this->upload->display_errors(); 
                }
                else
                {
                    $lead_id = $this->input->post('lead_id');
                    $file = array('upload_data' => $this->upload->data());
                    $filename = $file['upload_data']['file_name'];
                    $url = 'https://cartbi.com/api/upload';
                    
                    // $Auth_Token = "UAT";
                    $Auth_Token = "LIVE";
                    
                    if($Auth_Token == "UAT") {
                        define('api_token', 'API://IlJKyP5wUwzCvKQbb796ZSjOITkMSRN8rifQTMrNM1/NUUv8/tuaN6Lun6d1NG4S');
                    } else {
                        define('api_token', 'API://9jwoyrhfdtDuDt0epG4VsisYdBHMsZMGC7IlUhwN8t1Qb2bgwxFqrn7K0LgWIly1');
                    }
                    
                    $cartJsonData = [ 'file' => new CURLFile (FCPATH.'public/BankAnalysis/'.$filename, '', $filename)];
                    $headers = [
                        'Content-Type: multipart/form-data', 
                        'auth-token: '. api_token
                        ];
                    
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $cartJsonData);
                    
                    $UploadResponse = curl_exec($ch);
                    
                    curl_close($ch);
                    $response = json_decode($UploadResponse);
                    
                    if(!empty($response->docId))
                    {
                        $docId = $response->docId;
                        $status = $response->status;
                        
                        // if($status == 'Submitted'){
                        //     $status = 'In Process';
                        // }
                        
                        $data = array (
                            'lead_id'           => $lead_id,
                            'docId'             => $docId,
                            'file'              => $filename,
                            'password'          => $password,
                            'cartJson'          => json_encode($cartJsonData),
                            'cartJsonResponse'  => $UploadResponse,
                            'status'            => $status,
                            'ip'                => $ipaddress,
                            'created_by'        => $_SESSION['isUserSession']['user_id'],
                        );
    
                        $this->db->insert('tbl_cart', $data);

                        $json['msg'] = $docId;
                        
                        ///////////////////////////// download cart data as csv ///////////////////////////////////////
                        
                            $docId = "DOC00231319";
                            $urlDownload = 'https://cartbi.com/api/downloadFile';
                            $header2 = [
                                'Content-Type: text/plain', 
                                'auth-token: '. api_token
                                ];
                            
                            $ch2 = curl_init($urlDownload);
                            curl_setopt($ch2, CURLOPT_HTTPHEADER, $header2);
                            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($ch2, CURLOPT_POSTFIELDS, $docId);
                            
                            $downloadCartData = curl_exec($ch2);
                            curl_close($ch2);
                            $this->db->where('lead_id', $lead_id)->where('docId', $docId)->update('tbl_cart', ['downloadCartData' => $downloadCartData]);
                        
                    } else {
                        $json['err'] = "Failed to Upload Docs.";
                    }
                }
                echo json_encode($json); 
            }
        }
        
        public function ViewBankingAnalysis() 
        {
            $json = '';
            $doc_id = $_POST['doc_id'];
            
		    $query = $this->db->select('tbl_cart.downloadCartData')->where('docId', $doc_id)->get('tbl_cart')->row();
		    
	        $response = 1;
		    if(empty($query->downloadCartData)){
		        $response = $this->Task_Model->DownloadBankingAnalysis($doc_id); // 1
		    }
            if($response > 0){
                $result     = $this->Task_Model->ViewBankingAnalysis($doc_id);
                // echo $result;exit;
                // $data       = $result->row_array();
                // $num_rows   = $result->num_rows();
        
                // if($num_rows > 0)
                // {   
                //     // foreach ($data as $key => $value){
                //     //     $json = $value['downloadCartData'];
                //     // }
                //     $json = $data['downloadCartData'];
                // } else{
                //     $json = 0;
                // }
                // echo json_encode($json);
                echo json_encode($result);
            }
		    
        }
        
        public function getBankAnalysis($lead_id)
        {
            $data = $this->Task_Model->bank_analiysis($lead_id);
    		echo json_encode($data);
        }
        
        public function downloadCartFile($docId)
        {
            // $docId = "DOC00231319";
            $urlDownload = 'https://cartbi.com/api/downloadFile';
            $header2 = [
                'Content-Type: text/plain', 
                'auth-token: '. api_token
                ];
            
            $ch2 = curl_init($urlDownload);
            curl_setopt($ch2, CURLOPT_HTTPHEADER, $header2);
            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch2, CURLOPT_POSTFIELDS, $docId);
            
            $downloadCartData = curl_exec($ch2);
            curl_close($ch2);
            $this->db->where('lead_id', $lead_id)->where('docId', $docId)->update('tbl_cart', ['downloadCartData' => $downloadCartData]);
        }
    }

?>