<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once 'functions.inc.php';
    require_once 'dbh.inc.php';

    if (isset($_POST['productDescriptionId'])) {

        $ProductDescription = trim($_POST['productDescription']);


        if (CheckingProductDescriptionExist($Conn, $ProductDescription)) {
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

    if(isset($_POST['btnProductUpdate'])){

        $ProductDescription = trim($_POST['productDescription']);   
        $ProductCategory = trim($_POST['productCategory']);
        $ProductStatus = trim($_POST['productStatus']);
        $ProductPrice = trim($_POST['productPrice']);
        $ProductUnit = trim($_POST['productUnit']);
        
        
        if(empty($ProductDescription) || empty($ProductCategory) || empty($ProductStatus) || empty($ProductPrice)  || empty($ProductUnit) ){

            echo json_encode([
                'status' => false
            ]);
            
        }
        elseif($_POST['comparisonData'] === $ProductDescription){

            $Id =  $_POST['rowId'];
            updateProduct($Conn, $ProductDescription, $ProductCategory, $ProductStatus, $ProductPrice, $ProductUnit,$Id);
            echo json_encode([
                'status' => true
                
            ]);
        }
        else{

            if(CheckingProductDescriptionExist($Conn, $ProductDescription)){
                echo json_encode([
                    'status' => false
                ]);
            }
            else{
                $Id =  $_POST['rowId'];
                updateProduct($Conn, $ProductDescription, $ProductCategory, $ProductStatus,$ProductPrice, $ProductUnit,$Id);
                echo json_encode([
                    'status' => true
                    
                ]);
            }
            
        }
    }

    if (isset($_POST['btnProduct'])) {
       
        $ProductDescription = trim($_POST['productDescription']);   
        $ProductCategory = trim($_POST['productCategory']);
        $ProductStatus = trim($_POST['productStatus']);
        $ProductPrice = trim($_POST['productPrice']);
        $ProductUnit = trim($_POST['productUnit']);

        if(empty($ProductDescription) || empty($ProductCategory) || empty($ProductStatus) || empty($ProductPrice) || empty($ProductUnit)){
            echo json_encode([
                'status' => false
            ]);
        }
        elseif (CheckingProductDescriptionExist($Conn, $ProductDescription)) {
            echo json_encode([
                'status' => false
            ]);
        }
        else{
            insertProduct($Conn,$ProductDescription,$ProductCategory,$ProductStatus,$ProductPrice,$ProductUnit);
            echo json_encode([
                'status' => true
            ]);


            
        }



    }


    if(isset($_POST['btnEditProduct'])){
        $Id = $_POST['rowId'];
        $data = getproductTableData($Conn,$Id);
        echo json_encode([
            'status' => true,
            'data' => $data
        ]);
    }

    if(isset($_POST['updateProductDescriptionValue'])){
        $UpdateProductDescription = trim($_POST['updateProductDescription']);


        if (CheckingProductDescriptionExist($Conn, $UpdateProductDescription)) {
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
}
