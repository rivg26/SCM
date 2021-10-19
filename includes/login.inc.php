<?php

if($_SERVER['REQUEST_METHOD'] == "POST"){

    if(isset( $_POST['btnLogin'] )){

        $Username = $_POST['username'];
        $Password = $_POST['password'];

        if(empty($Username) || empty($Password)){

            echo json_encode([
                'status' => false, 
                'message' => 'Please fill all the fields...'
            ]);

        }

        else{

            require_once 'dbh.inc.php';
            require_once 'functions.inc.php';

            if(!CheckingAccountExist($Conn, $Username)){
                echo json_encode([
                    'status' => false, 
                    'message' => 'User doesn\'t exist...'
                ]);
            }
            else{
                
                $Data = CheckingAccountExist($Conn, $Username);
                $HashPassword = $Data['password'];
                $CheckPassword = password_verify($Password, $HashPassword);

                if($CheckPassword === false){

                    echo json_encode([
                        'status' => false, 
                        'message' => 'Wrong Password...'
                    ]);
                    
                }
                else{
                    $acc = accountSession ($Conn,$Data['acc_emp_id']);
                    session_start();
                    $_SESSION['username'] = $Username;
                    $_SESSION['first_name'] = $acc['first_name']. ' ' .$acc['middle_name']. ' ' .$acc['last_name'];
                    $_SESSION['acc_emp_id'] = $acc['acc_emp_id'];
                    echo json_encode([
                        'status' => true
                    ]);

                }
            }


        }


    }


}
