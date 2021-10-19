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
            <h1 class="headingDesign1">Outbound</h1>
            <h1 class="headingDesign2">Table</h1>
        </div>
        <div class="table-responsive mt-5">
            <table id="outboundTable" class="tableDesign">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Item</th>
                        <th>Product Description</th>
                        <th>Quantity</th>
                        <th>Outbound Date</th>
                        <th>Encoder Name</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    getOutboundTable($Conn);
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>No.</th>
                        <th>Item</th>
                        <th>Product Description</th>
                        <th>Quantity</th>
                        <th>Outbound Date</th>
                        <th>Encoder Name</th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="text-center my-5 ">
            <button class="btnDesign" id='btnAddOutbound' style="padding: 1.4rem;">Add Outbound</button>
        </div>

    </div>
    <div class="modal" tabindex="-1" id='modalOutbound' style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Outbound Item Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id='btnModalOutboundClose'></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label for="outboundItemName" class="form-label">Item Name</label>
                        <select class="form-select" aria-label="outboundItemName" id="outboundItemName" required>
                            <option selected value="">---Select Menu---</option>
                            <?php
                            ItemNameOutput($Conn);
                            ?>
                        </select>
                        <input type="hidden" id="outboundRowId">
                        <div class="invalid-feedback" id="outboundItemNameFeedback">Please Select Item Name...</div>
                    </div>
                    <div class="mb-2">
                        <label for="outboundProductName" class="form-label">Product Name</label>
                        <select class="form-select" aria-label="outboundProductName" id='outboundProductName' required>
                            <option selected value="">---Select Menu---</option>
                            <?php
                            ProductNameOutput($Conn);
                            ?>
                        </select>
                        <div class="invalid-feedback" id="outboundProductNameFeedback">Please Select Product Name...</div>
                    </div>
                    <div class="mb-2">
                        <label for="outboundQuantity" class="form-label">Quantity</label>
                        <input type="text" class="form-control" id="outboundQuantity" placeholder="Input Quantity" requird oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                        <div class="invalid-feedback" id="outboundQuantityFeedback">Please Input Quantity...</div>
                    </div>
                    <div class="mb-2">
                        <label for="outboundDate" class="form-label">Inbound Date</label>
                        <input type="date" class="form-control" id="outboundDate">
                        <div class="invalid-feedback" id="outboundDateFeedback">Please Select Date..</div>
                    </div>
                    <div class="mb-2">
                        <label for="outboundEncoder" class="form-label">Encoder Name</label>
                        <input type="text" class="form-control" id="outboundEncoder" value="<?= $EncoderName ?>" readonly>
                        <input type="hidden" id="outboundEncoderId" value="<?= $EncoderId ?>" readonly>
                    </div>
                    <div class="mb-2">
                        <label for="outboundRemarks" class="form-label">Remarks</label>
                        <textarea class="form-control" id="outboundRemarks" rows="3"></textarea>
                    </div>
                    <div class="redBox mt-5" id='outboundTotalError'>

                        <p>There is an error that needs to be fix..</p>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btnDesign" style="padding: 0.5rem; " id="btnSaveOutbound">Save Outbound</button>
                    </div>
                </div>
            </div>
        </div>

</body>
<script>
    $(document).ready(function() {

        $('#outboundTable').DataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            lengthMenu: [5, 10, 20, 500, 100, 150]
        });

        $(document).on('click', '#btnAddOutbound', function() {
            $('#modalOutbound').show();
        });
        $(document).on('click', '#btnModalOutboundClose', function() {
            window.location.href = 'mainpage.php?component=Outbound';
        });

        $(document).on('change', '#outboundItemName', function() {
            if (!$('#outboundItemName').val() || $('#outboundItemName').val() === "") {
                $('#outboundItemName').removeClass('is-valid');
                $('#outboundItemName').addClass('is-invalid');
            } else {
                $('#outboundItemName').removeClass('is-invalid');
                $('#outboundItemName').addClass('is-valid');
            }

        });

        $(document).on('change', '#outboundProductName', function() {
            if (!$('#outboundProductName').val() || $('#outboundProductName').val() === "") {
                $('#outboundProductName').removeClass('is-valid');
                $('#outboundProductName').addClass('is-invalid');
            } else {
                $('#outboundProductName').removeClass('is-invalid');
                $('#outboundProductName').addClass('is-valid');
            }

        });
        $(document).on('keyup', '#outboundQuantity', function() {
            if (!$('#outboundQuantity').val() || parseFloat($('#outboundQuantity').val()) <= 0) {
                $('#outboundQuantity').removeClass('is-valid');
                $('#outboundQuantity').addClass('is-invalid');
            } else {
                $('#outboundQuantity').removeClass('is-invalid');
                $('#outboundQuantity').addClass('is-valid');
            }
        });
        $(document).on('change', '#outboundDate', function() {
            if (!$('#outboundDate').val() || $('#outboundDate').val() === "") {
                $('#outboundDate').removeClass('is-valid');
                $('#outboundDate').addClass('is-invalid');
            } else {
                $('#outboundDate').removeClass('is-invalid');
                $('#outboundDate').addClass('is-valid');
            }
        });

        $(document).on('click', '#btnSaveOutbound', function() {

            let allId = ['#outboundItemName', '#outboundProductName', '#outboundQuantity', '#outboundDate'];
            var checker;
            for (let x = 0; x < 4; x++) {

                if (!$(allId[x]).val()) {
                    $(allId[x]).addClass('is-invalid');
                    checker = false;
                }

            }
            if (parseFloat($('#outboundQuantity').val()) <= 0) {
                checker = false;
            } else {
                checker = true;
            }
            if (checker) {
                $(this).html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                $('#btnSaveOutbound').attr("disabled", true);
                let datastring = 'outboundItemName=' + $('#outboundItemName').val() + '&outboundProductName=' + $('#outboundProductName').val() + '&outboundQuantity=' + $('#outboundQuantity').val() + '&outboundDate=' + $('#outboundDate').val() + '&outboundEncoderId=' + $('#outboundEncoderId').val() + '&outboundRemarks=' + $('#outboundRemarks').val() + '&btnSaveOutbound=' + 'true';
                console.log(datastring);

                $.ajax({

                    type: 'POST',
                    url: 'includes/outbound-table.inc.php',
                    data: datastring,
                    dataType: 'json',
                    success: function(data, textStatus) {

                        if (data.status === true) {

                            $('#btnSaveOutbound').text('Saved');
                            $('#btnSaveOutbound').attr("disabled", true);
                            $('#outboundTotalError').css('display', 'none');
                            $('input').attr('disabled', true);
                            $('select').attr('disabled', true);
                            $('textarea').attr('disabled', true);
                            // alert('success');

                        } else {
                            // alert(data.status);
                            $('#loading').remove();
                            $('#btnSaveOutbound').removeAttr('disabled');
                            $('#btnSaveOutbound').text('Save Outbound');
                            $('#outboundTotalError').css('display', 'block');
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

        $(document).on('click', '#btnEditOutbound', function() {
            let rowId = $(this).attr('row.id');
            $('#outboundRowId').val(rowId);
            $('#btnSaveOutbound').attr('id', 'btnUpdateOutbound');
            $('#btnUpdateOutbound').text('Update Outbound');
            $('#modalOutbound').show();

            let datastring = 'outboundRowId=' + rowId + '&btnEditOutbound=' + 'true';
            
            $.ajax({

                type: 'POST',
                url: 'includes/outbound-table.inc.php',
                data: datastring,
                dataType: 'json',
                success: function(data, textStatus) {

                    if (data.status === true) {
                        
                        $('#outboundItemName').val(data.infoItem[1]);
                        $('#outboundProductName').val(data.infoItem[2]);
                        $('#outboundQuantity').val(data.infoItem[3]);
                        $('#outboundDate').val(data.infoItem[4]);
                        $('#outboundEncoder').val(data.infoItem[9] + ' ' + data.infoItem[10] + ' ' + data.infoItem[11]);
                        $('#outboundRemarks').val(data.infoItem[6]);
                    }


                },
                fail: function(xhr, textStatus, errorThrown, data) {
                    alert(errorThrown);
                    alert(xhr);
                    alert(textStatus);
                }

            });

        });

        $(document).on('click','#btnUpdateOutbound',function(){
            let allId = ['#outboundItemName', '#outboundProductName', '#outboundQuantity', '#outboundDate'];
            var checker;
            for (let x = 0; x < 4; x++) {

                if (!$(allId[x]).val()) {
                    $(allId[x]).addClass('is-invalid');
                    checker = false;
                }

            }
            if (parseFloat($('#outboundQuantity').val()) <= 0) {
                checker = false;
            } else {
                checker = true;
            }
            if (checker) {
                $(this).html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                $('#btnUpdateOutbound').attr("disabled", true);
                let datastring = 'outboundItemName=' + $('#outboundItemName').val() + '&outboundProductName=' + $('#outboundProductName').val() + '&outboundQuantity=' + $('#outboundQuantity').val() + '&outboundDate=' + $('#outboundDate').val()  + '&outboundRemarks=' + $('#outboundRemarks').val() + '&outboundRowId=' + $('#outboundRowId').val()  +'&btnUpdateOutbound=' + 'true';
                console.log(datastring);

                $.ajax({

                    type: 'POST',
                    url: 'includes/outbound-table.inc.php',
                    data: datastring,
                    dataType: 'json',
                    success: function(data, textStatus) {

                        if (data.status === true) {

                            $('#btnUpdateOutbound').text('Updated');
                            $('#btnUpdateOutbound').attr("disabled", true);
                            $('#outboundTotalError').css('display', 'none');
                            $('input').attr('disabled', true);
                            $('select').attr('disabled', true);
                            $('textarea').attr('disabled', true);
                            // alert('success');

                        } else {
                            // alert(data.status);
                            $('#loading').remove();
                            $('#btnUpdateOutbound').removeAttr('disabled');
                            $('#btnUpdateOutbound').text('Update Outbound');
                            $('#outboundTotalError').css('display', 'block');
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

    })
</script>

</html>