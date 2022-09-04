<?php
    function base_url(){
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            $pageURL = "https://";
        } else {
            $pageURL = 'http://';
        }
        $pageURL .= $_SERVER["SERVER_NAME"]."/nongsanviet";
        return $pageURL;
    }
    
    function base_url_admin(){
        if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {
            $pageURL = "https://";
        } else {
            $pageURL = 'http://';
        }
        $pageURL .= $_SERVER["SERVER_NAME"]."/nongsanviet/admin";
        return $pageURL;
    }
?>