<?php
    defined('BASEPATH') OR exit('No direct script access allowed');  
    class Blocker extends CI_Controller
    {
        function __construct(){
            // $CI =& get_instance();
        }

        public function isLogin() 
        {
            $this->CI = & get_instance();
            if(!isset($_SESSION)){
                return redirect(base_url());
            }
        }
        /**
         * This function used to block the every request except allowed ip address
         */

        public function requestBlocker()
        {
            $ip = $_SERVER["REMOTE_ADDR"];
            
            if($ip == "49.248.51.230")
            {
                $currentPath = $_SERVER['PHP_SELF']; 
                $pathInfo = pathinfo($currentPath); 
                $hostName = $_SERVER['HTTP_HOST']; 

                $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
                $url = $protocol.'://'.$hostName.$pathInfo['dirname']."/";
                $base_url = $url. "public/front/images/access_denied.jpg";

                $access_denied_image = str_replace("index.php/", "", $base_url);
                echo "<div style='margin-left : 35%; margin-top : 10%;'><img src='".$access_denied_image."' width='300' height='250'><br>";
                echo "Sorry! You can not access this page. Please take permission from Admin"; die;
            }
        }
    }
?>