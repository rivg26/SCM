<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: loginpage.php');
} else {
    require_once 'includes/functions.inc.php';
    require_once 'includes/dbh.inc.php';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
    <title>Document</title>
</head>

<body>
    <div class="shadow p-3 mb-5 bg-body rounded">
        <div class="headingWrapper mt-5">
            <h1 class="headingDesign1">Inventory</h1>
            <h1 class="headingDesign2">Table</h1>
        </div>
        <div class="my-5">
            <div class="ms-3">
                <em>Please Select Date...</em>
                <div class="row mt-3">
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="mb-3 row">
                            <label for="fromDate" class="col-sm-1 col-form-label">From</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id="fromDate">
                                <div class="invalid-feedback" id="fromDateFeedback">Please Select Date..</div>
                            </div>
                            <label for="endDate" class="col-sm-1 col-form-label">To</label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" id='endDate'>
                                <div class="invalid-feedback" id="endDateFeedback">Please Select Date..</div>
                            </div>

                            <div class="col-sm-2">
                                <button class="btnDesign p-2" id="btnInventorySubmit">Submit</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12 statusIcons">
                        <p class="headerIcon"><i class="fas fa-warehouse" style="margin-right:7px"></i>Total Warehouse Value</p>
                        <p class="footerIcon" id='totalWarehouseValue'></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive my-5">
            <table id="inventoryTable" class="tableDesign">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Item Name</th>
                        <th>Total Inbound Quantity</th>
                        <th>Total Outbound Quantity</th>
                        <th>Total Remaining Quantity</th>
                        <th>Item Cost</th>
                        <th>Inventory Value</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                    <tr>
                        <th>No.</th>
                        <th>Item Name</th>
                        <th>Total Inbound Quantity</th>
                        <th>Total Outbound Quantity</th>
                        <th>Total Remaining Quantity</th>
                        <th>Item Cost</th>
                        <th>Inventory Value</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        var inventoryTable = $('#inventoryTable').DataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            lengthMenu: [5, 10, 20, 500, 100, 150],
            "columnDefs": [{
                    targets: [2,3,4,5,6],
                    className: "text-end"
                },
                {
                    targets: [0,1],
                    className: "text-justify"
                }
            ]
        });
        $(document).on('click', '#btnInventorySubmit', function() {
            let info = ['#fromDate', '#endDate'];
            var checker = true;
            for (let x = 0; x < 2; x++) {

                if (!$(info[x]).val() || $(info[x]).val() === "") {
                    $(info[x]).removeClass('is-valid');
                    $(info[x]).addClass('is-invalid');
                    checker = false;
                }
            }
            if (checker) {

                $('#fromDate').removeClass('is-invalid');
                $('#endDate').removeClass('is-invalid');
                inventoryTable.clear().draw();
                let datastring = 'btnSubmit=' + 'true' + '&fromDate=' + $('#fromDate').val() + '&endDate=' + $('#endDate').val();
                console.log(datastring)
                $.ajax({

                    type: 'POST',
                    url: 'includes/inventory-table.inc.php',
                    data: datastring,
                    dataType: 'json',
                    success: function(data, textStatus) {
                        var y = 1;
                        var arrayRow = [];
                        var totalWarehouseValue = 0;
                        for (let x = 0; x < data.length; x++) {
                            let totalQuantity = data[x]['total_inbound'] - data[x]['total_outbound'];
                            let totalItemCost = totalQuantity * Math.round(data[x]['total_cost'] * 100)/100 ;
                            totalWarehouseValue += totalItemCost;
                            var rowData = '<tr><td>' + y++ + '</td><td>' + data[x]['item_name'] + '</td> <td>' + data[x]['total_inbound'] + '</td><td>' + data[x]['total_outbound'] + '</td><td>' + totalQuantity + '</td><td>' + Math.round(data[x]['total_cost'] * 100)/100 + '</td><td>' + totalItemCost + '</td></tr>';

                            arrayRow.push(rowData);
                        }

                        for (let b = 0; b < arrayRow.length; b++) {
                            inventoryTable.rows.add($(arrayRow[b])).draw();
                        }
                        $('#totalWarehouseValue').text("₱"+ numberWithCommas(totalWarehouseValue));





                    },
                    fail: function(xhr, textStatus, errorThrown, data) {
                        alert(errorThrown);
                        alert(xhr);
                        alert(textStatus);
                    }

                });
            }



        });

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    });
</script>

</html>