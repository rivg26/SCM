<?php


if($_SERVER['REQUEST_METHOD'] == "POST"){
    
    require_once 'functions.inc.php';
    require_once 'dbh.inc.php';

    if (isset($_POST['itemNameId'])) {

        $ItemName = trim($_POST['itemName']);

        if (CheckingItemNameExist($Conn, $ItemName)) {
            echo json_encode([
                'status' => false
            ]);
        } 
        else {
            echo json_encode([
                'status' => true
            ]);
        }

    }

    if(isset($_POST['btnItemSave'])){

        $ItemName = trim($_POST['itemName']);
        $ItemCategory = trim($_POST['itemCategory']);
        $ItemReorder = trim($_POST['itemReorder']);
        $ItemUnit = trim($_POST['itemUnit']);
        
        if(empty($ItemName) || empty( $ItemCategory) || empty($ItemReorder) || empty($ItemUnit)){
            echo json_encode([
                'status' => false
            ]);
        }
        elseif(CheckingItemNameExist($Conn, $ItemName)){
            echo json_encode([
                'status' => false
            ]);
        }
        else{
            insertItem($Conn,  $ItemName, $ItemCategory, $ItemReorder, $ItemUnit);
            echo json_encode([
                'status' => true
            ]);
        }

    }

    if(isset($_POST['btnEditItem'])){
        $Id = $_POST['rowId'];
        $data =  getItemTableData($Conn,$Id);
        echo json_encode([
            'status' => true,
            'infoItem' => $data
        ]);
    }

   
    if(isset($_POST['btnItemUpdate'])){

        $ItemName = trim($_POST['itemName']);
        $ItemCategory = trim($_POST['itemCategory']);
        $ItemReorder = trim($_POST['itemReorder']);
        $ItemUnit = trim($_POST['itemUnit']);
        
        if(empty($ItemName) || empty( $ItemCategory) || empty($ItemReorder) || empty($ItemUnit)){
            echo json_encode([
                'status' => false
            ]);
        }
        elseif($_POST['comparisonData'] === $ItemName){
            $rowId = $_POST['rowId'];
            updateItem($Conn,  $ItemName, $ItemCategory, $ItemReorder, $ItemUnit,$rowId);
            echo json_encode([
                'status' => true
            ]);
        }
        else{

            if(CheckingItemNameExist($Conn, $ItemName)){
                echo json_encode([
                    'status' => false
                ]);
            }
            else{
                $rowId = $_POST['rowId'];
                updateItem($Conn,  $ItemName, $ItemCategory, $ItemReorder, $ItemUnit,$rowId);
                echo json_encode([
                    'status' => true
                ]);
            }

        }
       
    }

}
