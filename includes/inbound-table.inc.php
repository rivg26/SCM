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

    if(isset($_POST['btnSaveInbound'])){
        $InboundInvoice = trim($_POST['inboundInvoice']);
        $InboundItemName = trim($_POST['inboundItemName']);
        $InboundQuantity = trim($_POST['inboundQuantity']);
        $InboundItemCost = trim($_POST['inboundItemCost']);
        $InboundDate = trim($_POST['inboundDate']);
        $InboundEncoderId = trim($_POST['inboundEncoderId']);
        $InboundRemarks = trim($_POST['inboundRemarks']);

        if(empty($InboundInvoice) ||empty($InboundItemName)  || empty($InboundQuantity) || empty($InboundItemCost) || empty($InboundDate) || empty($InboundEncoderId) ){
            echo json_encode([
                'status' => false
            ]);
        }
        else{
            insertInbound($Conn, $InboundInvoice, $InboundItemName, $InboundQuantity,  $InboundItemCost, $InboundDate, $InboundEncoderId,$InboundRemarks);
            echo json_encode([
                'status' => true
            ]);
        }
    }

    if(isset($_POST['btnUpdateInbound'])){
        $rowId = $_POST['inboundRowId'];
        $InboundItemName = trim($_POST['inboundItemName']);
        $InboundQuantity = trim($_POST['inboundQuantity']);
        $InboundItemCost = trim($_POST['inboundItemCost']);
        $InboundDate = trim($_POST['inboundDate']);
        $InboundRemarks = trim($_POST['inboundRemarks']);

        if(empty($InboundItemName)  || empty($InboundQuantity) || empty($InboundItemCost) || empty($InboundDate) || empty($rowId) ){
            echo json_encode([
                'status' => false
            ]);
        }
        else{
            updateInbound($Conn, $InboundItemName, $InboundQuantity,  $InboundItemCost, $InboundDate, $InboundRemarks, $rowId);
            echo json_encode([
                'status' => true
            ]);
        }
    }



    if(isset($_POST['btnEditInbound'])){
        $Id = $_POST['inboundRowId'];
        $data = getInboundData($Conn,$Id);
        echo json_encode([
            'status' => true,
            'infoItem' => $data
        ]);
    }

    if(isset($_POST['btnDeleteInboundFinal'])){

        $ItemId = $_POST['rowItemId'];
        $Id = $_POST['rowId'];

        if(checkingInboundDelete($Conn,$ItemId)){
            echo json_encode([
                'status' => false,
                'message' => "You cannot delete it.. Existing Outbound"
            ]);
        }
        else{
            deleteInbound($Conn, $Id);
            echo json_encode([
                'status' => true,
                'message' => "Delete Success"
            ]);
        }
    }
}




?>