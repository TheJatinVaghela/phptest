<?php 

class model {
    public $assets = "./assets/img/";
    public $connection ;
    protected $hostname="localhost";
    protected $username = "root";
    protected $password = "";
    protected $database = "phptest";

    public function __cuntrunct(){
        $this->connect($this->hostname,$this->username,$this->password,$this->database);
    }
    public function connect($hostname,$username,$password,$database){
        try {
            $this->connection = new mysqli ($hostname,$username,$password,$database);
        } catch (\Exception $th) {
            print_r($th->getMessage());
            exit(404);
        }
    }

    protected function insert($table , $data_array){
        $first_sql = "INSERT INTO $table (";
        $last_sql = ") VALUES (";
        foreach ($data_array as $key => $value){
            $first_sql .= " `$key` ,";
            $last_sql .= " '$value' ,";
        };
        $sql = substr($first_sql,0,-1).substr($last_sql,0,-1).' )';
        $answer = $this->sql_($sql,true);
        return $answer;
    }

    protected function select($table , $data_array,$where=false){
        $sql = "SELECT ";
        foreach ($data_array as $key => $value) {
            $sql .= " $value ,";
        };
        $sql = substr($sql,0,-1);
        if($where == false){
            $sql .=" FROM $table";
        }else if(is_array($where)){
             $sql .=" FROM $table WHERE";
             foreach ($where as $key => $value) {
                $sql .= " `$key` = '$value' AND";
             };
             $sql = substr($sql ,0 ,-3);
        };
        
        $answer = $this->sql_($sql,true);
        $answer = $this->jatin_Fatch_All($answer);
        return $answer;
    }

    protected function update($table,$data_arr,$where_arr){
        $sql = "UPDATE $table SET";
        foreach($data_arr as $key => $value){
            $sql .= " $key = '$value',";
        };
        $sql = substr($sql,0,-1);
        $sql .= " WHERE";
        foreach($where_arr as $key => $value){
            $sql .= " $key = '$value' AND";
        };
        $sql = substr($sql,0,-3);

        // echo $sql;
        // exit();
        $answer = $this->sql_($sql,true);
        return $answer;
    }
    protected function truncate($table){
        $sql = "TRUNCATE $table";
        $answer = $this->sql_($sql,true);
        return $answer;
    }
    protected function jatin_Fatch_All($sqli){
        $data = array();
        $arr= array();
        if($sqli->num_rows > 0){
            while ($a= $sqli->fetch_object()) {
                foreach ($a as $key => $value) {
                    $arr[$key]=$value;
                };
                array_push($data,$arr);
            };
            return $data;
        }else{
            return "NO DATA";
        }
    }
    protected function sql_($sql,$return=false){
       
        $sqli = $this->connection->query($sql);
        if(isset($sqli) || $sqli == 1){
            if($return == true){
               return $sqli;
            }else{
                "do nothing";
            }
        }else{
            "BAD";
        }
    }
    
    protected function delete($table,$where_arr){
        $sql = "DELETE FROM $table WHERE ";
        foreach ($where_arr as $key => $value) {
            $sql .="`$key` = '$value' AND";    
        };
        $sql = substr($sql,0,-3);
    
        $answer = $this->sql_($sql , true);
        return $answer;
    }   
    protected function p($stuf){
        echo "<pre>";
        print_r ($stuf);
        echo "</pre>";
    }
}