<?php


if($_SERVER['REQUEST_METHOD'] == "POST"){
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';
    if(isset($_POST['btnAddInbound'])){
        $data = GenerateKey($Conn);
        echo json_encode([
            'status' => true,
            'genKey' => $data
        ]);
    }
}




?>