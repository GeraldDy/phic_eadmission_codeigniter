<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('get_config_ini')) {
    function get_config_ini($section = null) {
        $file_path = APPPATH . 'config/config.ini';
        
        if (!file_exists($file_path)) {
            return false; // File does not exist
        }

        $config = parse_ini_file($file_path, true); // Load as an associative array
        
        if ($section !== null && isset($config[$section])) {
            return $config[$section]; // Return a specific section
        }
        
        return $config; // Return the full config
    }
}
?>