<?php



function CheckingAccountExist($Conn, $Username)
{
    $Sql = " SELECT * FROM accounts WHERE username = '$Username' ";

    $ResultData = mysqli_query($Conn, $Sql);
    if ($Row = mysqli_fetch_array($ResultData, MYSQLI_BOTH)) {
        return $Row;
    } else {
        return false;
    }
}

function CheckingProductDescriptionExist($Conn, $ProductDescription)
{
    $Sql = " SELECT * FROM product_table WHERE product_description = '$ProductDescription' ";

    $ResultData = mysqli_query($Conn, $Sql);
    if ($Row = mysqli_fetch_array($ResultData, MYSQLI_BOTH)) {
        return $Row;
    } else {
        return false;
    }
}

function unitOutput($Conn)
{
    $Sql = " SELECT * FROM unit_table";

    $ResultData = mysqli_query($Conn, $Sql);
    while ($Row = mysqli_fetch_array($ResultData, MYSQLI_BOTH)) {
        echo '<option value="' . $Row['unit_id'] . '">' . $Row['unit_name'] . '---' . $Row['unit_abbr'] . '</option>';
    }
}

function insertProduct($Conn, $ProductDescription, $ProductCategory, $ProductStatus, $ProductPrice, $ProductUnit)
{

    $Sql = "INSERT INTO product_table (product_description, category, product_status, price, product_unit_id) VALUES (?,?,?,?,?)";
    $Stmt = mysqli_stmt_init($Conn);
    if (!mysqli_stmt_prepare($Stmt, $Sql)) {
        header("location: ../mainpage.php?error=true");
        exit();
    }
    mysqli_stmt_bind_param($Stmt, "sssdi", $ProductDescription, $ProductCategory, $ProductStatus, $ProductPrice, $ProductUnit);
    mysqli_stmt_execute($Stmt);
    mysqli_stmt_close($Stmt);
    mysqli_close($Conn);
}
function updateProduct($Conn, $ProductDescription, $ProductCategory, $ProductStatus, $ProductPrice, $ProductUnit, $Id)
{

    $Sql = "UPDATE product_table SET product_description = ?, category = ?, product_status = ?, price = ?, product_unit_id = ? WHERE product_id = ? ";
    $Stmt = mysqli_stmt_init($Conn);
    if (!mysqli_stmt_prepare($Stmt, $Sql)) {
        header("location: ../mainpage.php?error=true");
        exit();
    }
    mysqli_stmt_bind_param($Stmt, "sssdii", $ProductDescription, $ProductCategory, $ProductStatus, $ProductPrice, $ProductUnit, $Id);
    mysqli_stmt_execute($Stmt);
    mysqli_stmt_close($Stmt);
    mysqli_close($Conn);
}

function productTable($Conn)
{
    
    $Sql = "SELECT * FROM `product_table` FULL JOIN `unit_table` ON  product_unit_id = unit_table.unit_id;";
    $num = 1;
    $ResultData = mysqli_query($Conn, $Sql);
    while ($Row = mysqli_fetch_array($ResultData, MYSQLI_BOTH)) {
        echo '<tr >
        <td>' . $num++ . '</td>
        <td>' . $Row['product_description'] . '</td>
        <td>' . $Row['category'] . '</td>
        <td>' . $Row['product_status'] . '</td>
        <td>' . $Row['price'] . '</td>
        <td>' . $Row['unit_name'] .'---' .$Row['unit_abbr']. '</td>
        <td><button  class = "btn btnDesign" id= "btnEditProduct" row.id = '.$Row['product_id'].' >Edit</button></td>
        <td><button  class = "btn btnDesign" row.id = '.$Row['product_id'].' >Delete</button></td>
        
    </tr>';
    }
}
function getproductTableData($Conn,$Id)
{
    
    $Sql = "SELECT * FROM `product_table` FULL JOIN `unit_table` ON  product_unit_id = unit_table.unit_id WHERE `product_id` = '$Id';";
    $ResultData = mysqli_query($Conn, $Sql);
    if ($Row = mysqli_fetch_array($ResultData, MYSQLI_BOTH)) {
        return $Row;
    }
    else{
        return false;
    }
}


function saveItem($Conn, $ProductDescription, $CategorySelect, $AvailabilitySelect, $ProductPrice, $ProductUnit)
{
    $sql = "INSERT INTO product_table(description, category, status, price, unit_id) VALUES (?,?,?,?,?)";
    $stmt = mysqli_stmt_init($Conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../mainpage.php?error=true");
        exit();
    }
    mysqli_stmt_bind_param($stmt, "sssdi", $ProductDescription, $CategorySelect, $AvailabilitySelect, $ProductPrice, $ProductUnit);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($Conn);
}

//ITEM TABLE FUNCTIONS





function itemCategoryOutput($Conn)
{
    $Sql = " SELECT * FROM unit_table";

    $ResultData = mysqli_query($Conn, $Sql);
    while ($Row = mysqli_fetch_array($ResultData, MYSQLI_BOTH)) {
        echo '<option value="' . $Row['unit_id'] . '">' . $Row['unit_name'] . '---' . $Row['unit_abbr'] . '</option>';
    }
}
