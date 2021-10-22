<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location: loginpage.php');
} else {
    require_once 'includes/functions.inc.php';
    require_once 'includes/dbh.inc.php';
    $EncoderId = $_SESSION['acc_emp_id'];
    $EncoderName = $_SESSION['first_name'];
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
            <h1 class="headingDesign1">Inbound</h1>
            <h1 class="headingDesign2">Table</h1>
        </div>
        <div class="table-responsive mt-5">
            <table id="inboundTable" class="tableDesign">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Invoice Number</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Item Cost</th>
                        <th>Inbound Date</th>
                        <th>Encoder Name</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    getInboundTable($Conn);
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>No.</th>
                        <th>Invoice Number</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Item Cost</th>
                        <th>Inbound Date</th>
                        <th>Encoder Name</th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="text-center my-5 ">
            <button class="btnDesign" id='btnAddInbound' style="padding: 1.4rem;">Add Inbound</button>
        </div>
    </div>

    <div class="modal" tabindex="-1" id='modalInbound' style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Inbound Item Information</h5>
                    <button type="button" class="btn-close btnModalInboundClose" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="inboundInvoice" class="form-label">Invoice Number</label>
                        <input type="text" class="form-control" id="inboundInvoice" placeholder="Invoice Number" readonly>
                        <input type="hidden" id="inboundRowId">
                        <input type="hidden" id="inboundRowItemId">
                    </div>
                    <div class="mb-2">
                        <label for="inboundItemName" class="form-label">Item Name</label>
                        <select class="form-select" aria-label="Default select example" id='inboundItemName' required>
                            <option selected value="">---Select Menu---</option>
                            <?php
                            ItemNameOutput($Conn);
                            ?>
                        </select>
                        <div class="invalid-feedback" id="inboundItemNameFeedback">Please Select Item Name...</div>
                    </div>
                    <div class="mb-2">
                        <label for="inboundQuantity" class="form-label">Quantity</label>
                        <input type="text" class="form-control" id="inboundQuantity" placeholder="Input Quantity" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                        <div class="invalid-feedback" id="inboundQuantityFeedback">Please Input Quantity...</div>
                    </div>
                    <div class="mb-2">
                        <label for="inboundItemCost" class="form-label">Item Cost</label>
                        <input type="text" class="form-control" id="inboundItemCost" placeholder="Input Item Cost" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                        <div class="invalid-feedback" id="inboundItemCostFeedback">Please Input Item Cost...</div>
                    </div>
                    <div class="mb-2">
                        <label for="inboundDate" class="form-label">Inbound Date</label>
                        <input type="date" class="form-control" id="inboundDate">
                        <div class="invalid-feedback" id="inboundDateFeedback">Please Select Date..</div>
                    </div>
                    <div class="mb-2">
                        <label for="inboundEncoder" class="form-label">Encoder Name</label>
                        <input type="text" class="form-control" id="inboundEncoder" value="<?= $EncoderName ?>" readonly>
                        <input type="hidden" id="inboundEncoderId" value="<?= $EncoderId ?>">
                    </div>
                    <div class="mb-2">
                        <label for="inboundRemarks" class="form-label">Remarks</label>
                        <textarea class="form-control" id="inboundRemarks" rows="3"></textarea>
                    </div>
                    <div class="redBox mt-5" id='inboundTotalError'>

                        <p>There is an error that needs to be fix..</p>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btnDesign" style="padding: 0.5rem; " id="btnSaveInbound">Save Inbound</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" tabindex="-1" id='modalInboundDelete' style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Inbound Information</h5>
                    <button type="button" class="btn-close btnModalInboundClose" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id='modalInboundDeleteInfo'>Are you sure you want to delete this Inbound data?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btnDesign" id="btnDeleteInboundFinal" style="padding: 0.5rem; ">Delete Inbound</button>
                    <button type="button" class="btnDesign btnModalInboundClose" id="btnInboundCancel" style="padding: 0.5rem; ">Cancel</button>
                </div>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>
        </div>
    </div>


</body>
<script>
    $(document).ready(function() {
        $('#inboundTable').DataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            lengthMenu: [5, 10, 20, 500, 100, 150],
            "columnDefs": [
                { targets:[3,4], className: "text-end" } , 
                { targets:[0,1,2,6] , className: "text-justify"}, 
                { targets:[5] , className: "text-center"} 
            ]
        });
        $(document).on('click', '#btnAddInbound', function() {

            let datastring = 'btnAddInbound=' + 'true';
            $.ajax({

                type: 'POST',
                url: 'includes/inbound-table.inc.php',
                data: datastring,
                dataType: 'json',
                success: function(data, textStatus) {
                    if (data.status) {
                        $('#modalInbound').show();
                        $('#inboundInvoice').val(data.genKey);
                    }

                },
                fail: function(xhr, textStatus, errorThrown, data) {
                    alert(errorThrown);
                    alert(xhr);
                    alert(textStatus);
                }

            });

        });
        $(document).on('click', '.btnModalInboundClose', function() {
            window.location.href = 'mainpage.php?component=Inbound';
        });

        $(document).on('change', '#inboundItemName', function() {
            if (!$('#inboundItemName').val() || $('#inboundItemName').val() === "") {
                $('#inboundItemName').removeClass('is-valid');
                $('#inboundItemName').addClass('is-invalid');
            } else {
                $('#inboundItemName').removeClass('is-invalid');
                $('#inboundItemName').addClass('is-valid');
            }

        });

        $(document).on('keyup', '#inboundQuantity', function() {
            if (!$('#inboundQuantity').val() || parseFloat($('#inboundQuantity').val()) <= 0) {
                $('#inboundQuantity').removeClass('is-valid');
                $('#inboundQuantity').addClass('is-invalid');
            } else {
                $('#inboundQuantity').removeClass('is-invalid');
                $('#inboundQuantity').addClass('is-valid');
            }
        });
        $(document).on('keyup', '#inboundItemCost', function() {
            if (!$('#inboundItemCost').val() || parseFloat($('#inboundItemCost').val()) <= 0) {
                $('#inboundItemCost').removeClass('is-valid');
                $('#inboundItemCost').addClass('is-invalid');
            } else {
                $('#inboundItemCost').removeClass('is-invalid');
                $('#inboundItemCost').addClass('is-valid');
            }
        });
        $(document).on('change', '#inboundDate', function() {
            if (!$('#inboundDate').val() || $('#inboundDate').val() === "") {
                $('#inboundDate').removeClass('is-valid');
                $('#inboundDate').addClass('is-invalid');
            } else {
                $('#inboundDate').removeClass('is-invalid');
                $('#inboundDate').addClass('is-valid');
            }
        });
        $(document).on('click', '#btnSaveInbound', function() {

            let allId = ['#inboundItemName', '#inboundQuantity', '#inboundItemCost', '#inboundDate'];
            var checker;
            for (let x = 0; x < 4; x++) {

                if (!$(allId[x]).val()) {
                    $(allId[x]).addClass('is-invalid');
                    checker = false;
                }

            }
            if (parseFloat($('#inboundQuantity').val()) <= 0) {
                checker = false;
            } else if (parseFloat($('#inboundItemCost').val()) <= 0) {
                checker = false;
            } else {
                checker = true;
            }
            if (checker) {

                $(this).html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                $('#btnSaveInbound').attr("disabled", true);
                let datastring = 'inboundInvoice=' + $('#inboundInvoice').val() + '&inboundItemName=' + $('#inboundItemName').val() + '&inboundQuantity=' + $('#inboundQuantity').val() + '&inboundItemCost=' + $('#inboundItemCost').val() + '&inboundDate=' + $('#inboundDate').val() + '&inboundEncoderId=' + $('#inboundEncoderId').val() + '&inboundRemarks=' + $('#inboundRemarks').val() + '&btnSaveInbound=' + 'true';
                console.log(datastring)

                $.ajax({

                    type: 'POST',
                    url: 'includes/inbound-table.inc.php',
                    data: datastring,
                    dataType: 'json',
                    success: function(data, textStatus) {

                        if (data.status === true) {

                            $('#btnSaveInbound').text('Saved');
                            $('#btnSaveInbound').attr("disabled", true);
                            $('#inboundTotalError').css('display', 'none');
                            $('input').attr('disabled', true);
                            $('select').attr('disabled', true);
                            $('textarea').attr('disabled', true);
                            // alert('success');

                        } else {
                            // alert(data.status);
                            $('#loading').remove();
                            $('#btnSaveInbound').removeAttr('disabled');
                            $('#btnSaveInbound').text('Save Inbound');
                            $('#inboundTotalError').css('display', 'block');
                        }


                    },
                    fail: function(xhr, textStatus, errorThrown, data) {
                        alert(errorThrown);
                        alert(xhr);
                        alert(textStatus);
                    }

                });
            }
        });

        $(document).on('click', '#btnEditInbound', function() {
            let rowId = $(this).attr('row.id');
            $('#inboundRowId').val(rowId);
            $('#btnSaveInbound').attr('id', 'btnUpdateInbound');
            $('#btnUpdateInbound').text('Update Inbound');
            $('#modalInbound').show();

            let datastring = 'inboundRowId=' + rowId + '&btnEditInbound=' + 'true';
            $.ajax({

                type: 'POST',
                url: 'includes/inbound-table.inc.php',
                data: datastring,
                dataType: 'json',
                success: function(data, textStatus) {

                    if (data.status === true) {
                        $('#inboundInvoice').val(data.infoItem[1]);
                        $('#inboundItemName').val(data.infoItem[2]);
                        $('#inboundQuantity').val(data.infoItem[3]);
                        $('#inboundItemCost').val(data.infoItem[4]);
                        $('#inboundDate').val(data.infoItem[5]);
                        $('#inboundEncoder').val(data.infoItem[9] + ' ' + data.infoItem[10] + ' ' + data.infoItem[11]);
                        $('#inboundRemarks').val(data.infoItem[7]);
                    }


                },
                fail: function(xhr, textStatus, errorThrown, data) {
                    alert(errorThrown);
                    alert(xhr);
                    alert(textStatus);
                }

            });

        });

        $(document).on('click', '#btnUpdateInbound', function() {

            let allId = ['#inboundItemName', '#inboundQuantity', '#inboundItemCost', '#inboundDate'];
            var checker;
            for (let x = 0; x < 4; x++) {

                if (!$(allId[x]).val()) {
                    $(allId[x]).addClass('is-invalid');
                    checker = false;
                }

            }
            if (parseFloat($('#inboundQuantity').val()) <= 0) {
                checker = false;
            } else if (parseFloat($('#inboundItemCost').val()) <= 0) {
                checker = false;
            } else {
                checker = true;
            }
            if (checker) {
                $(this).html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                $('#btnUpdateInbound').attr("disabled", true);
                let datastring = 'inboundRowId=' + $("#inboundRowId").val() + '&inboundItemName=' + $('#inboundItemName').val() + '&inboundQuantity=' + $('#inboundQuantity').val() + '&inboundItemCost=' + $('#inboundItemCost').val() + '&inboundDate=' + $('#inboundDate').val() + '&inboundRemarks=' + $('#inboundRemarks').val() + '&btnUpdateInbound=' + 'true';
                console.log(datastring)
                $.ajax({

                    type: 'POST',
                    url: 'includes/inbound-table.inc.php',
                    data: datastring,
                    dataType: 'json',
                    success: function(data, textStatus) {

                        if (data.status === true) {

                            $('#btnUpdateInbound').text('Updated');
                            $('#btnUpdateInbound').attr("disabled", true);
                            $('#inboundTotalError').css('display', 'none');
                            $('input').attr('disabled', true);
                            $('select').attr('disabled', true);
                            $('textarea').attr('disabled', true);
                            // alert('success');

                        } else {
                            // alert(data.status);
                            $('#loading').remove();
                            $('#btnUpdateInbound').removeAttr('disabled');
                            $('#btnUpdateInbound').text('Update Inbound');
                            $('#inboundTotalError').css('display', 'block');
                        }


                    },
                    fail: function(xhr, textStatus, errorThrown, data) {
                        alert(errorThrown);
                        alert(xhr);
                        alert(textStatus);
                    }

                });
            }


        });

        $(document).on('click', '#btnDeleteInbound', function() {
            $('#modalInboundDelete').show();
            let rowId = $(this).attr('row.id');
            $('#inboundRowId').val(rowId);
            let rowItemId = $(this).attr('row.item');
            $('#inboundRowItemId').val(rowItemId);
        });

        $(document).on('click', '#btnDeleteInboundFinal', function() {

            let datastring = 'rowId=' + $('#inboundRowId').val() + '&rowItemId=' + $('#inboundRowItemId').val() + '&btnDeleteInboundFinal=' + 'true';

            $.ajax({

                type: 'POST',
                url: 'includes/inbound-table.inc.php',
                data: datastring,
                dataType: 'json',
                success: function(data, textStatus) {

                    if (data.status === true) {
                        $('#modalInboundDeleteInfo').text(data.message);
                        $('#btnDeleteInboundFinal').css('display', 'none');
                        $('#btnInboundCancel').css('display', 'none');


                    } else {
                        $('#modalInboundDeleteInfo').text(data.message);
                        $('#btnDeleteInboundFinal').css('display', 'none');
                        $('#btnInboundCancel').css('display', 'none');
                    }


                },
                fail: function(xhr, textStatus, errorThrown, data) {
                    alert(errorThrown);
                    alert(xhr);
                    alert(textStatus);
                }

            });
        });

    });
</script>

</html>