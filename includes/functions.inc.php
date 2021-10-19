<?php

function accountSession ($Conn,$Id){
    $Sql = "SELECT * FROM `accounts` FULL JOIN employee_table ON acc_emp_id = employee_table.emp_id WHERE acc_emp_id = '$Id';";
    $ResultData = mysqli_query($Conn, $Sql);
    if ($Row = mysqli_fetch_assoc($ResultData)) {
        return $Row;
    } else {
        return false;
    }
}

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
    $Sql = " SELECT * FROM item_category_table";

    $ResultData = mysqli_query($Conn, $Sql);
    while ($Row = mysqli_fetch_array($ResultData, MYSQLI_BOTH)) {
        echo '<option value="' . $Row['category_id'] . '">' . $Row['category_name'] . '---' . $Row['category_abbr'] . '</option>';
    }
}

function CheckingItemNameExist($Conn, $ItemName)
{
    $Sql = " SELECT * FROM item_table WHERE item_name = '$ItemName' ";

    $ResultData = mysqli_query($Conn, $Sql);
    if ($Row = mysqli_fetch_array($ResultData, MYSQLI_BOTH)) {
        return $Row;
    } else {
        return false;
    }
}
function insertItem($Conn,  $ItemName, $ItemCategory, $ItemReorder, $ItemUnit)
{

    $Sql = "INSERT INTO item_table (item_name, item_category, reorder_quantity,item_unit_id) VALUES (?,?,?,?)";
    $Stmt = mysqli_stmt_init($Conn);
    if (!mysqli_stmt_prepare($Stmt, $Sql)) {
        header("location: ../mainpage.php?error=true");
        exit();
    }
    mysqli_stmt_bind_param($Stmt, "sidi",  $ItemName, $ItemCategory, $ItemReorder, $ItemUnit);
    mysqli_stmt_execute($Stmt);
    mysqli_stmt_close($Stmt);
    mysqli_close($Conn);
}
function getItemTable($Conn)
{
    
    $Sql = "SELECT * FROM `item_table` JOIN item_category_table ON item_table.item_category = item_category_table.category_id JOIN unit_table ON item_table.item_unit_id = unit_table.unit_id;";
    $num = 1;
    $ResultData = mysqli_query($Conn, $Sql);
    while ($Row = mysqli_fetch_array($ResultData, MYSQLI_BOTH)) {
        echo '<tr >
        <td>' . $num++ . '</td>
        <td>' . $Row['item_name'] . '</td>
        <td>' . $Row['category_name'] .'---' .$Row['category_abbr']. '</td>
        <td>' . $Row['reorder_quantity'] . '</td>
        <td>' . $Row['unit_name'] .'---' .$Row['unit_abbr']. '</td>
        <td><button  class = "btn btnDesign" id= "btnEditItem" row.id = '.$Row['item_id'].' >Edit</button></td>
        <td><button  class = "btn btnDesign" row.id = '.$Row['item_id'].' >Delete</button></td>
        
    </tr>';
    }
}
function getItemTableData($Conn,$Id)
{
   
    $Sql = "SELECT * FROM `item_table` WHERE `item_id` = '$Id';";
    $ResultData = mysqli_query($Conn, $Sql);
    if ($Row = mysqli_fetch_array($ResultData, MYSQLI_BOTH)) {
        return $Row;
    }
    else{
        return false;
    }
}

function updateItem($Conn,  $ItemName, $ItemCategory, $ItemReorder, $ItemUnit,$rowId)
{

    $Sql = "UPDATE item_table SET item_name = ?, item_category = ?, reorder_quantity = ?,item_unit_id = ? WHERE item_id = ?";
    $Stmt = mysqli_stmt_init($Conn);
    if (!mysqli_stmt_prepare($Stmt, $Sql)) {
        header("location: ../mainpage.php?error=true");
        exit();
    }
    mysqli_stmt_bind_param($Stmt, "sidii",  $ItemName, $ItemCategory, $ItemReorder, $ItemUnit, $rowId);
    mysqli_stmt_execute($Stmt);
    mysqli_stmt_close($Stmt);
    mysqli_close($Conn);
}

//INNERBOUND FUNCTIONS
function CheckKeys($Conn,$RandStr)
{

    $Sql = 'SELECT * FROM inbound_table';
    $Result = mysqli_query($Conn,$Sql);

    while($Row = mysqli_fetch_assoc($Result)){
        if($Row['invoice_number'] === $RandStr){
            return $KeyExists = true;
            break;
        }
        else{
            return $KeyExists = false;
        }
    }
    

}

function GenerateKey($Conn)
{
    $KeyLength = 8;
    $Str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $RandStr = substr(str_shuffle($Str),0,$KeyLength);

    $CheckKey = CheckKeys($Conn,$RandStr);
    while($CheckKey === true){
        $RandStr = substr(str_shuffle($Str),0,$KeyLength);
    }
    return 'SCM-' . $RandStr;
}

function ItemNameOutput($Conn)
{
    $Sql = " SELECT * FROM item_table";

    $ResultData = mysqli_query($Conn, $Sql);
    while ($Row = mysqli_fetch_array($ResultData, MYSQLI_BOTH)) {
        echo '<option value="' . $Row['item_id'] . '">' . $Row['item_name'] . '</option>';
    }
}

function insertInbound($Conn, $InboundInvoice, $InboundItemName, $InboundQuantity,  $InboundItemCost, $InboundDate, $InboundEncoderId,$InboundRemarks)
{

    $Sql = "INSERT INTO inbound_table (invoice_number, inbound_item_id, inbound_quantity ,inbound_item_cost, inbound_date, inbound_encoder_id, inbound_remarks) VALUES (?,?,?,?,?,?,?)";
    $Stmt = mysqli_stmt_init($Conn);
    if (!mysqli_stmt_prepare($Stmt, $Sql)) {
        header("location: ../mainpage.php?error=true");
        exit();
    }
    mysqli_stmt_bind_param($Stmt, "siddsis", $InboundInvoice, $InboundItemName, $InboundQuantity,  $InboundItemCost, $InboundDate, $InboundEncoderId,$InboundRemarks);
    mysqli_stmt_execute($Stmt);
    mysqli_stmt_close($Stmt);
    mysqli_close($Conn);
}

function getInboundTable($Conn)
{
    
    $Sql = "SELECT `inbound_id`,`invoice_number`,`inbound_item_id`,`inbound_quantity`,`inbound_item_cost`,`inbound_date`,`inbound_encoder_id`,`inbound_remarks`, item_table.item_name, employee_table.first_name, employee_table.middle_name, employee_table.last_name FROM `inbound_table` JOIN item_table ON inbound_item_id = item_table.item_id JOIN employee_table ON inbound_encoder_id = employee_table.emp_id;";
    $num = 1;
    $ResultData = mysqli_query($Conn, $Sql);
    while ($Row = mysqli_fetch_array($ResultData, MYSQLI_BOTH)) {
        echo '<tr >
        <td>' . $num++ . '</td>
        <td>' . $Row['invoice_number'] . '</td>
        <td>' . $Row['item_name']. '</td>
        <td>' . $Row['inbound_quantity'] . '</td>
        <td>' . $Row['inbound_item_cost'] .'</td>
        <td>' . $Row['inbound_date'] .'</td>
        <td>' . $Row['first_name'] . ' '.$Row['middle_name'] . ' '.$Row['last_name'] .'</td>
        <td><button  class = "btn btnDesign" id= "btnEditInbound" row.id = '.$Row['inbound_id'].' >Edit</button></td>
        <td><button  class = "btn btnDesign" row.id = '.$Row['inbound_id'].' >Delete</button></td>
        
    </tr>';
    }
}

function getInboundData($Conn,$Id)
{
   
    $Sql = "SELECT `inbound_id`,`invoice_number`,`inbound_item_id`,`inbound_quantity`,`inbound_item_cost`,`inbound_date`,`inbound_encoder_id`,`inbound_remarks`, item_table.item_name, employee_table.first_name, employee_table.middle_name, employee_table.last_name FROM `inbound_table` JOIN item_table ON inbound_item_id = item_table.item_id JOIN employee_table ON inbound_encoder_id = employee_table.emp_id WHERE inbound_id = '$Id';";
    $ResultData = mysqli_query($Conn, $Sql);
    if ($Row = mysqli_fetch_array($ResultData, MYSQLI_BOTH)) {
        return $Row;
    }
    else{
        return false;
    }
}

function updateInbound($Conn, $InboundItemName, $InboundQuantity,  $InboundItemCost, $InboundDate,$InboundRemarks, $rowId)
{

    $Sql = "UPDATE inbound_table SET inbound_item_id = ?, inbound_quantity = ? ,inbound_item_cost = ?, inbound_date = ?, inbound_remarks = ? WHERE inbound_id = ?";
    $Stmt = mysqli_stmt_init($Conn);
    if (!mysqli_stmt_prepare($Stmt, $Sql)) {
        header("location: ../mainpage.php?error=true");
        exit();
    }
    mysqli_stmt_bind_param($Stmt, "iddssi",$InboundItemName, $InboundQuantity,  $InboundItemCost, $InboundDate ,$InboundRemarks , $rowId);
    mysqli_stmt_execute($Stmt);
    mysqli_stmt_close($Stmt);
    mysqli_close($Conn);
}

// OUTBOUND FUNCTIONS

function ProductNameOutput($Conn)
{
    $Sql = " SELECT * FROM product_table";

    $ResultData = mysqli_query($Conn, $Sql);
    while ($Row = mysqli_fetch_array($ResultData, MYSQLI_BOTH)) {
        echo '<option value="' . $Row['product_id'] . '">' . $Row['product_description'] . '</option>';
    }
}

function insertOutbound($Conn, $OutboundItemName,  $OutboundProductName, $OutboundQuantity,  $OutboundDate, $OutboundEncoderId, $OutboundRemarks)
{

    $Sql = "INSERT INTO outbound_table (outbound_item_id, outbound_product_id, outbound_quantity, outbound_date, outbound_encoder_id, outbound_remarks) VALUES (?,?,?,?,?,?)";
    $Stmt = mysqli_stmt_init($Conn);
    if (!mysqli_stmt_prepare($Stmt, $Sql)) {
        header("location: ../mainpage.php?error=true");
        exit();
    }
    mysqli_stmt_bind_param($Stmt, "iidsis",$OutboundItemName,  $OutboundProductName, $OutboundQuantity,  $OutboundDate, $OutboundEncoderId, $OutboundRemarks);
    mysqli_stmt_execute($Stmt);
    mysqli_stmt_close($Stmt);
    mysqli_close($Conn);
}
function getOutboundTable($Conn)
{
    
    $Sql = "SELECT `outbound_id`,`outbound_item_id`,`outbound_product_id`,`outbound_quantity`,`outbound_date`,`outbound_encoder_id`,`outbound_remarks`, item_table.item_name, product_table.product_description, employee_table.first_name, employee_table.middle_name, employee_table.last_name FROM `outbound_table` JOIN item_table ON outbound_item_id = item_table.item_id JOIN product_table ON outbound_product_id = product_table.product_id JOIN employee_table ON outbound_encoder_id = employee_table.emp_id;";
    $num = 1;
    $ResultData = mysqli_query($Conn, $Sql);
    while ($Row = mysqli_fetch_array($ResultData, MYSQLI_BOTH)) {
        echo '<tr >
        <td>' . $num++ . '</td>
        <td>' . $Row['item_name'] . '</td>
        <td>' . $Row['product_description']. '</td>
        <td>' . $Row['outbound_quantity'] . '</td>
        <td>' . $Row['outbound_date'] .'</td>
        <td>' . $Row['first_name'] . ' '.$Row['middle_name'] . ' '.$Row['last_name'] .'</td>
        <td><button  class = "btn btnDesign" id= "btnEditOutbound" row.id = '.$Row['outbound_id'].' >Edit</button></td>
        <td><button  class = "btn btnDesign" row.id = '.$Row['outbound_id'].' >Delete</button></td>
        
    </tr>';
    }
}

function getOutboundData($Conn,$Id)
{
   
    $Sql = "SELECT item_name,SUM(inbound_table.inbound_quantity), SUM(outbound_table.outbound_quantity) FROM `item_table` JOIN inbound_table ON inbound_table.inbound_item_id = item_id JOIN outbound_table ON outbound_table.outbound_item_id = item_id GROUP By item_id;";
    $ResultData = mysqli_query($Conn, $Sql);
    if ($Row = mysqli_fetch_array($ResultData, MYSQLI_BOTH)) {
        return $Row;
    }
    else{
        return false;
    }
}

function updateOutbound($Conn, $OutboundItemName,  $OutboundProductName, $OutboundQuantity,  $OutboundDate, $OutboundRemarks, $Id)
{

    $Sql = "UPDATE outbound_table SET outbound_item_id = ?, outbound_product_id = ?, outbound_quantity = ?, outbound_date = ?,  outbound_remarks = ? WHERE outbound_id = ?";
    $Stmt = mysqli_stmt_init($Conn);
    if (!mysqli_stmt_prepare($Stmt, $Sql)) {
        header("location: ../mainpage.php?error=true");
        exit();
    }
    mysqli_stmt_bind_param($Stmt, "iidssi",$OutboundItemName,  $OutboundProductName, $OutboundQuantity,  $OutboundDate, $OutboundRemarks, $Id);
    mysqli_stmt_execute($Stmt);
    mysqli_stmt_close($Stmt);
    mysqli_close($Conn);
}

function getInventoryTable($Conn)
{
    $num = 2;
    for($x = 0; $x < 21; $x++){

    }
}