<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Welcome extends CI_Controller {
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('User_Model');
        $this->load->model('Common');
    }
    public function index() {
        $x = $this->session->userdata('logged');
        /*if(get_cookie('email')!='' && get_cookie('password')!=''){
        
        $data=array('email'=>get_cookie('email'),'password'=> get_cookie('password'));
        
        if($this->User_Model->login($data)){
        
        set_cookie('email',$data['email'],'3600');
        
        set_cookie('password',$data['password'],'3600');
        
        $this->load->view('dashboard');
        
        }else{
        
        $this->load->view('login');
        
        }
        
        }*/
        if ($x['email'] != '' && $x['password'] != '') {
            $data = [];
            $this->profile();
        } else {
            $this->load->view('login');
        }
    }
    public function login() {
        $x = $this->session->userdata('logged');
        if ($x['email'] != '' && $x['password'] != '') {
            $data = [];
            $this->profile();
        } else {
            $data = $this->input->post();
            if (isset($data['remember'])) {
                unset($data['remember']);
                $pass = $data['password'];
                $data['password'] = md5($data['password']);
                if ($this->User_Model->login($data)) {
                    set_cookie('email', $data['email'], '3600');
                    set_cookie('password', $pass, '3600');
                    $this->session->set_userdata('logged', $data);
                    $data = [];
                    $this->profile();
                } else {
                    $val['err'] = 'Please Enter Valid Credential';
                    $this->load->view('login', $val);
                }
            } else {
                $data['password'] = md5($data['password']);
                //unset($data['remeber']);
                if ($this->User_Model->login($data)) {
                    $this->session->set_userdata('logged', $data);
                    $data = [];
                    $this->profile();
                } else {
                    $val['err'] = 'Please Enter Valid Credential';
                    $this->load->view('login', $val);
                }
            }
        }
    }
    public function logout() {
        $this->session->unset_userdata('logged');
        return redirect('Welcome/index', 'refresh');
    }
    public function dashboard() {
        $this->load->view('dashboard');
    }
    public function profile() {
        $x = $this->session->userdata('logged');
        if ($x['email'] == '') {
            return redirect('Welcome/index', 'refresh');
        }
        $data['admin'] = $this->db->where('email', $x['email'])->get('user')->result_array();
        $this->load->view('profile', $data);
    }
    public function change_pass() {
        $x = $this->session->userdata('logged');
        if ($x['email'] == '') {
            return redirect('Welcome/index', 'refresh');
        }
        $this->load->view('change_pass');
    }
    public function save_password() {
        $x = $this->session->userdata('logged');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('change_pass');
        } else {
            $password = md5($this->input->post('password'));
            if ($this->db->where('email', $x['email'])->update('user', array('password' => $password))) {
                $this->session->set_flashdata('msg', 'Password Updated Successfully');
                return redirect(base_url('profile'), 'refresh');
            } else {
                $this->session->set_flashdata('err', 'Password Not Updated Please Try Again');
                return redirect(base_url('profile'), 'refresh');
            }
        }
    }
    public function event_holiday() {
        $data['class'] = $this->db->where('status', 1)->get('class')->result_array();
        $this->load->view('events', $data);
    }
    public function get_number() {
        if ($_POST['search_by1'] == 'class') {
            if ($_POST['section'] != 'Select Section') {
                $data = $this->db->select('parent_contact')->from('student')->where(array('class' => $_POST['class'], 'section' => $_POST['section'], 'status' => 1))->get()->result_array();
            } else {
                $data = $this->db->select('parent_contact')->from('student')->where(array('class' => $_POST['class'], 'status' => 1))->get()->result_array();
            }
        } elseif ($_POST['search_by1'] == 'all') {
            $data = $this->db->select('parent_contact')->from('student')->where(array('status' => 1))->get()->result_array();
        } elseif ($_POST['search_by1'] == 'parent_contact') {
            $data = $this->db->select('parent_contact')->from('student')->where(array('parent_contact' => $_POST['field_val'], 'status' => 1))->get()->result_array();
        }
        print_r(json_encode($data));
    }
    public function send_notification() {
        /*print_r($_POST);
        
        exit;*/
        //print_r(json_decode($_POST['all_cont']));
        $val = [];
        foreach (json_decode($_POST['all_cont']) as $key => $value) {
            $val[] = $value->parent_contact;
        }
        $cont = implode(',', $val);
        $data11 = $this->db->get('smsinfo')->result_array();
        $msg = $_POST['msg'];
        $parampro['uname'] = $data11[0]['user_name'];
        $parampro['password'] = $data11[0]['password'];
        $parampro['sender'] = $data11[0]['sender_id'];
        $parampro['receiver'] = $cont;
        $parampro['route'] = "TA";
        $parampro['msgtype'] = "1";
        $parampro['sms'] = $msg;
        $sendsmspro = http_build_query($parampro);
        $urlpro = "http://staticking.org/index.php/smsapi/httpapi/?" . $sendsmspro;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlpro);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $resultpro = curl_exec($ch);
        return redirect(base_url(), 'refresh');
    }
    public function sms_details() {
        $data['sms'] = $this->db->get('smsinfo')->result_array();
        $this->load->view('sms_info', $data);
    }
    public function update_sms_info() {
        $this->form_validation->set_rules('user_name', 'User Name', 'required');
        $this->form_validation->set_rules('password', 'Passsword', 'required');
        $this->form_validation->set_rules('sender_id', 'Sender ID', 'required');
        if ($this->form_validation->run() == FALSE) {
            $data['sms'] = $this->db->where('id', $this->input->post('id'))->get('smsinfo')->result_array();
            $this->load->view('sms_info', $data);
        } else {
            $this->db->where('id', $this->input->post('id'))->update('smsinfo', $this->input->post());
            $data['sms'] = $this->db->where('id', $this->input->post('id'))->get('smsinfo')->result_array();
            $this->load->view('sms_info', $data);
        }
    }

    public function sign_up()
    {
        $query['countries'] = $this->db->select('*')->get('countries')->result_array();
        // print_r($query);
        return $this->load->view('userRegister', $query);
    }

    public function selectState($id)
    {
        $result = $this->db->where("country_id",$id)->get("states")->result();
        echo json_encode($result);
    }

    public function selectCity($id)
    {
        $result = $this->db->where("state_id",$id)->get("cities")->result();
        echo json_encode($result);
    }

    public function addUser()
    {
        if ($this->input->server('REQUEST_METHOD') == 'POST') 
        {
            $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|alpha|min_length[3]|max_length[12]');
            $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|alpha');
            $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
            $this->form_validation->set_rules('phone', 'Phone', 'trim|required|min_length[10]|max_length[10]|numeric');
            $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[8]|md5');
            $this->form_validation->set_rules('confirm_password', 'confirm_password', 'trim|required|matches[password]|md5');
            $this->form_validation->set_rules('gender', 'Gender', 'required');
            $this->form_validation->set_rules('dateofbirth', 'Date Of Birth', 'required');
            $this->form_validation->set_rules('country', 'Country', 'required');
            $this->form_validation->set_rules('state', 'State', 'required');
            $this->form_validation->set_rules('city', 'Distict', 'required');
            $this->form_validation->set_rules('town', 'Town', 'trim|required');
            $this->form_validation->set_rules('pincode', 'Pincode', 'trim|required|min_length[6]|max_length[6]|numeric');

            $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');


            if($this->form_validation->run()== true)
            {
                if($_FILES['image']['name']!='')
                {
                    $journalName = str_replace(' ', '_', $_FILES['image']['name']);
                    $config['file_name'] = time() . $journalName;
                    $config['upload_path'] = './public/images/';
                    $config['allowed_types'] = 'gif|jpg|png|JPG|JPEG|jpeg';
                    $this->upload->initialize($config);
                    $this->upload->do_upload('image');
                    $_POST['image'] = $config['file_name'];
                }
                if($this->db->insert('users',$_POST))
                {
                    $this->session->set_flashdata('msg', 'User Add Successfully!');
                    return redirect(base_url('sign-up'),'refresh');
                }
                else
                {
                    $this->session->set_flashdata('err', 'Please try Again After SomeTimes');
                    return redirect(base_url('sign-up'),'refresh');
                }
            }
            // else
            // {
                //return redirect(base_url('sign-up'),'refresh');
                $this->load->view('userRegister'); 
            // }
        }
        else
        {
            return $this->load->view('userRegister');
        }
    }

}
