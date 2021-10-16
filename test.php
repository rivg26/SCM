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

$x = 300.12;
$y = 5;
// insertProduct($Conn,"Yellow Bi",'Living',"Avail",$x, $y);

updateProduct($Conn, 'Blue Chaird', 'Dining_Area', 'Available' , 2400, 1, 1);
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