<?php
    require 'config.php';
    
    class Api {

        public $con;
        public $result;
        public $table;
        
        function __construct($table) {
            $this->table = $table;
            $this->con = $this->createConnection();
        }

        function createConnection() {

            $con = mysqli_connect("localhost", "root", "", "final_project");
    
            if ($con -> connect_errno) {
                echo "Failed to connect to MySQL: " . $con -> connect_error;
              }
    
            return $con;
    
        }

        # get where method fetches specified information with a where clause
        # the 'params' array should be length 3
        # params['getCol'] == the column name you want to select/retrieve
        # params['col'] == the name of the column you want int the where clause
        # params[$col] == the value of the column you want to check for
        
        function getWhere($params) {
                if (isset($params['col']) && isset($params[$params['col']]) && isset($params['getCol'])) {
                    $getCol = $params['getCol'];
                    $col = $params['col'];
                    $value = $params[$col];
            $result = mysqli_query($this->con, "SELECT $getCol FROM $this->table where $col=$value");
            if ($result) { 
                return mysqli_fetch_assoc($result);
                }
            } return FALSE;
            }
        
        # posts user to backend as new row (can only be used in user table)
        # params should be of length 4 - contain entries into each column of the users table
        function postUser($params){

            if ($this->table == 'users') {

                if (isset($params['username']) && isset($params['password']) && isset($params['date']) && isset($params['pp'])) {
                    $username = $params['username'];
                    $password = $params['password'];
                    $date = $params['date'];
                    $pp = $params['pp'];

                    echo("<script>console.log('PHP: " . $username . "');</script>");
                    $result = mysqli_query($this->con, "INSERT INTO users VALUES(NULL, '$username', '$password', '$date', '$pp')");

                    return $result;

                }
            }

            return FALSE;
        }



}


?>
