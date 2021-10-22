<?php

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if(isset($_POST['btnSaveOutbound'])){
        $OutboundItemName = trim($_POST['outboundItemName']);
        $OutboundProductName = trim($_POST['outboundProductName']);
        $OutboundQuantity = trim($_POST['outboundQuantity']);
        $OutboundDate = trim($_POST['outboundDate']);
        $OutboundEncoderId = trim($_POST['outboundEncoderId']);
        $OutboundRemarks = trim($_POST['outboundRemarks']);
        $Data = getInboundQuantityInOutbound($Conn,$OutboundItemName);

        if( empty($OutboundItemName) || empty($OutboundProductName) || empty($OutboundQuantity) || empty($OutboundDate) || empty($OutboundEncoderId) ){
            echo json_encode([
                'status' => false
            ]);
        }
        elseif(is_null($Data['total_inbound_quantity']) || is_null($Data['item_id'])) {
            echo json_encode([
                'status' => false,
                'errorStatus' => "emptyNull"
            ]);
        }
        elseif($Data['total_inbound_quantity'] < $OutboundQuantity){
            echo json_encode([
                'status' => false,
                'errorStatus' => "over"
            ]);
        }
        else{
            insertOutbound($Conn, $OutboundItemName,  $OutboundProductName, $OutboundQuantity,  $OutboundDate, $OutboundEncoderId, $OutboundRemarks);
            echo json_encode([
                'status' => true
            ]);
        }
    }
    if(isset($_POST['btnUpdateOutbound'])){
        
        $OutboundItemName = trim($_POST['outboundItemName']);
        $OutboundProductName = trim($_POST['outboundProductName']);
        $OutboundQuantity = trim($_POST['outboundQuantity']);
        $OutboundDate = trim($_POST['outboundDate']);
        $OutboundRemarks = trim($_POST['outboundRemarks']);
        $Data = getInboundQuantityInOutbound($Conn,$OutboundItemName);

        if( empty($OutboundItemName) || empty($OutboundProductName) || empty($OutboundQuantity) || empty($OutboundDate)  ){
            echo json_encode([
                'status' => false
            ]);
        }
        elseif(is_null($Data['total_inbound_quantity']) || is_null($Data['item_id'])) {
            echo json_encode([
                'status' => false,
                'errorStatus' => "emptyNull"
            ]);
        }
        elseif($Data['total_inbound_quantity'] < $OutboundQuantity){
            echo json_encode([
                'status' => false,
                'errorStatus' => "over"
            ]);
        }
        else{
            $Id = $_POST['outboundRowId'];
            updateOutbound($Conn, $OutboundItemName,  $OutboundProductName, $OutboundQuantity,  $OutboundDate, $OutboundRemarks, $Id);
            echo json_encode([
                'status' => true
            ]);
        }
    }

    if(isset($_POST['btnEditOutbound'])){

        $Id = $_POST['outboundRowId'];
        $data = getOutboundData($Conn,$Id);

        echo json_encode([
            'status' => true,
            'infoItem' => $data
        ]);
    }

    if(isset($_POST['btnDeleteOutboundFinal'])){
        $Id = $_POST['rowId'];
        deleteOutbound($Conn, $Id);
        echo json_encode([
            'status' => true,
            'message' => "Delete Sucess"
        ]);
    }
    
}






?>