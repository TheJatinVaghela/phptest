<?php

require_once ("./model/model.php");

class controller extends model{

    public function __construct(){
        parent::__cuntrunct();
        try {
            $path = (!isset($_SERVER["PATH_INFO"]) || $_SERVER["PATH_INFO"] == null)? "home" : $_SERVER["PATH_INFO"];
            // echo $path;
        } catch (\Exception $th) {
            print_r($th->getMessage());
            exit(400);
        }

        switch ($path) {
            case '/home':
                $this->view("./view/welcome.php");
                break;
            case '/create':
                $this->view("./view/create_form.php");
                break;
            case '/update':
                $this->view("./view/update_form.php");
                break;
            case '/updateUser':
                if($_SERVER["REQUEST_METHOD"] == "POST" || isset($_POST)){
                    if(!isset($_FILES) || $_FILES['userImage']['size'] == 0){
                        print_r($_POST);
                        $answer = $this->update('user',$_POST,['id'=>$_POST['id']]);
                        print_r(json_encode($answer));
                    }else{
                        $answer = $this->select('user',['userImage'],['id'=>$_POST['id']]);
                        $imgName = $answer[0]['userImage'];
                        
                        $img_location = $this->upload_files($_FILES);
                        $_POST["userImage"] = $img_location;
                        $answer = $this->update('user',$_POST,['id'=>$_POST['id']]);
                        if(isset($answer)){
                            if(is_file($imgName)){
                            unlink($imgName);
                            };
                        }
                        print_r(json_encode($answer));
                    }
                };
                break;
            case "/getusers":
                if(isset($_REQUEST['id'])){
                    // print_r($_REQUEST['id']);
                    $answer = $this->select('user',['*'],['id'=>$_REQUEST['id']]);
                    print_r(json_encode($answer));
                }else{
                    $answer = $this->select('user',['*']);
                    print_r(json_encode($answer));
                };
                break;
            case '/adduser':
                if($_SERVER["REQUEST_METHOD"] == 'POST'){
                   $img_location = $this->upload_files($_FILES);
                   $_POST["userImage"] = $img_location;
                   $answer = $this->insert('user', $_POST); 
                   print_r(json_encode($answer));
                }   
                break;
            case '/delete':
                if($_SERVER["REQUEST_METHOD"] == 'GET' || $_GET){
                    $answer = $this->select('user',['userImage'],['id'=>$_GET['id']]);
                    $imgName = $answer[0]['userImage'];
                    $id= $_GET["id"]; 
                    $answer = $this->delete('user',['id'=>$id]);
                    if(isset($answer)){
                        if(is_file($imgName)){
                        unlink($imgName);
                        };
                    };
                    print_r(json_encode($answer));
                };
                break;
            case '/truncate':
                if($_SERVER["REQUEST_METHOD"] == 'GET' || $_GET){
                    $answer = $this->truncate('user');
                    print_r(json_encode($answer));
                    if($answer){
                        $files = glob('./assets/img/*'); // get all file names
                        foreach($files as $file){ // iterate files
                            if(is_file($file)) {
                                unlink($file); // delete file
                            }
                        }
                        print_r($answer);
                    };
                };
                break;
            default:
                header("Location:home");
                break;
        }
    }

    protected function upload_files($file){
        $id = time().uniqid();
        $imgname = $id.$file['userImage']['name'];
        try {
            move_uploaded_file($file['userImage']['tmp_name'],$this->assets.$imgname);
        } catch (\Exception $th) {
            $this->p("somthing went wrong while uploading product Images");
            exit();
        };
        return $img_location = $this->assets.$imgname;
    }
    protected function view($url){
        require_once("./view/head.php");
        require_once($url);
        require_once("./view/foot.php");
    }
}