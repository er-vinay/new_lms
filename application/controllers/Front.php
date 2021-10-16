<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Front extends CI_Controller {

    public function index() 
    {
        $this->load->view('index');
    }

    public function aboutus()
    {
        $this->load->view('aboutus');
    }
    public function service()
    {
        $this->load->view('service');
    }

    public function gallary()
    {
        $this->load->view('gallary');
    }

    public function contact()
    {
        $this->load->view('contact');
    }

    public function enquiry() {

        $config = Array(
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );

        $config['newline'] = "\r\n";
        $message="<table>";

        foreach($_POST as $key=>$value)
        {
            $message.="<tr><th>".$key."</th><td>".$value."</td></tr>";
        }
                    
        $message.="</table>";
        $this->load->library('email',$config);

        $this->email->from($_POST['Email'], $_POST['Name']);
        $this->email->to('jeevanamrittrust@gmail.com');
        $this->email->subject("Jeevan Amrit Trust");
        $this->email->message($message);

        $this->email->send();

        $this->email->initialize($config);
        $this->email->from('jeevanamrittrust@gmail.com');
        $this->email->to($_POST['Email']);
        $this->email->subject("Jeevan Amrit Trust");
        $this->email->message($message);

        $this->email->send();
        //$this->db->insert('enquiry', $_POST);
        $this->session->set_flashdata('msg', 'Your Request Succeessfully Submiited');
        return redirect(base_url(), 'refresh');
    }

    public function download_file($img='')
    {
        $this->load->helper('download');
        //echo FCPATH;exit;
        force_download(FCPATH.'uploads/download/'.$img, NULL);
    }
}

