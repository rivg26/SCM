<?php

require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

// function insertProduct($Conn,$ProductDescription,$ProductCategory,$ProductStatus,$ProductPrice,$ProductUnit)
// {

//     $Sql = "INSERT INTO product_table (product_description, category, product_status, price, product_unit_id) VALUES (?,?,?,?,?)";
//     $Stmt = mysqli_stmt_init($Conn);
//     if (!mysqli_stmt_prepare($Stmt, $Sql)) {
//         header("location: ../mainpage.php?error=true");
//         exit();
//     }
//     mysqli_stmt_bind_param($Stmt, "sssdi",$ProductDescription,$ProductCategory,$ProductStatus,$ProductPrice,$ProductUnit);
//     mysqli_stmt_execute($Stmt);
//     mysqli_stmt_close($Stmt);
//     mysqli_close($Conn);
// }

// $Sql = "SELECT item_name,SUM(inbound_table.inbound_quantity) AS total_inbound, SUM(outbound_table.outbound_quantity) AS total_outbound, inbound_table.inbound_item_cost FROM `item_table` JOIN inbound_table ON inbound_table.inbound_item_id = item_id JOIN outbound_table ON outbound_table.outbound_item_id = item_id GROUP By item_id;";

        
// $ResultData = mysqli_query($Conn, $Sql);
// $Rows = [];
// while ($Row  = mysqli_fetch_assoc($ResultData)) {
//     $Rows [] = $Row;
// }
// echo json_encode($Rows);

// var_dump(CheckingAccountExist($Conn, 'hello'));


$Data = getInboundQuantityInOutbound($Conn,1);
$TotalInboundQuantity = (float) $Data['total_inbound_quantity'];
$TotalItemId = $Data['item_id'];


if(is_null($TotalInboundQuantity) || is_null($TotalItemId)) {
    echo json_encode([
        'status' => false,
        'error' =>  'emptyOutbound'
    ]);
}
else{
    echo json_encode([
        'status' => true
        
    ]);
}
// print_r($Rows);
// $x = 300.12;
// $y = 5;
// insertProduct($Conn,"Yellow Bi",'Living',"Avail",$x, $y);

// updateProduct($Conn, 'Blue Chaird', 'Dining_Area', 'Available' , 2400, 1, 1);
// insertItem($Conn,  '2x3 Wood', 1, 4, 5);
// print_r(getInventoryTable($Conn));

// // Check connection
// if (!$Conn) {
//   die("Connection failed: " . mysqli_connect_error());
// }

// $sql = "INSERT INTO product_table (product_description, category, product_status, price, product_unit_id) VALUES ('Yellow Ha' , 'red ha', 'haha' , 1000, 200)";

// if (mysqli_query($Conn, $sql)) {
//   echo "New record created successfully";
// } else {
//   echo "Error: " . $sql . "<br>" . mysqli_error($Conn);
// }

// mysqli_close($Conn);