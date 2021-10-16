<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class IsLogin
{
    public function index()
    {   
        if(isset($_SESSION['isUserSession']['email']) && $_SESSION['isUserSession']['email'] == NULL) 
        {
            $this->session->set_flashdata('err', "Session Expired, Try once more.");
            return redirect(base_url(), 'refresh');
        } else {
            // echo "Er. Vinay Kumar checking is user login or not.";
        }
    }  
}