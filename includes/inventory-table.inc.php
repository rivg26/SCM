<?php


if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['btnSubmit'])) {

        require_once 'dbh.inc.php';
        require_once 'functions.inc.php';
        
        $FromDate = $_POST['fromDate'];
        $EndDate = $_POST['endDate'];

        $Sql = "SELECT item_name,SUM(inbound_table.inbound_quantity) AS total_inbound, SUM(outbound_table.outbound_quantity) AS total_outbound, inbound_table.inbound_item_cost FROM `item_table` JOIN inbound_table ON inbound_table.inbound_item_id = item_id JOIN outbound_table ON outbound_table.outbound_item_id = item_id WHERE (inbound_table.inbound_date BETWEEN '$FromDate' AND '$EndDate') AND (outbound_table.outbound_date BETWEEN '$FromDate' AND '$EndDate') GROUP By item_id;";

        
        $ResultData = mysqli_query($Conn, $Sql);
        $Rows = [];
        while ($Row  = mysqli_fetch_assoc($ResultData)) {
            $Rows [] = $Row;
        }
        echo json_encode($Rows);
    }
}
