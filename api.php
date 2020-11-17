<?php
    require 'config.php';
    
    class Api {

        public $con = mysqli_connect("localhost", "root", "", "final_project");
        public $result;
        public $table;
        
        function __construct($table) {
            $this->table = $table;
        }

        if(mysqli_connect_errno()) {
            echo "Failed to connect " + mysqli_connect_errno();
        }

        function get($params) {
                if (isset($params['col'])) {
                    $col = $params['col'];
                    $value = $params[$col];
            $result = mysqli_query($con, "SELECT * FROM '$table' where '$col'='$value'");
            return mysqli_fetch_assoc($result)
                } else {
            $result = mysqli_query($con, "SELECT * FROM '$table'");
            return mysqli_fetch_assoc($result)
                }
    }


?>
