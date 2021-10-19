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
            <h1 class="headingDesign1">Item</h1>
            <h1 class="headingDesign2">Table</h1>
        </div>
        <div class="table-responsive mt-5">
            <table id="itemTable" class="tableDesign">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Reorder Quantity</th>
                        <th>Unit</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    getItemTable($Conn);
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>No.</th>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>Reorder Quantity</th>
                        <th>Unit</th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="text-center my-5 ">
            <button class="btnDesign" id='btnAddItem' style="padding: 1.2rem;">Add Item</button>
        </div>

    </div>
    <div class="modal" tabindex="-1" id='modalItem' style="background-color: rgba(0, 0, 0, 0.5);">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Item Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id='btnModalItemClose'></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="itemName" class="form-label" id="itemNameLabel">Item Name</label>
                        <input type="text" class="form-control" id="itemName" placeholder="Input Item Name" required>
                        <input type="hidden" id="itemRowId">
                        <input type="hidden" id="updateItemNameComparison">
                        <div class="invalid-feedback" id="itemNameFeedback">Please Fill the fields...</div>
                    </div>
                    <div class="mb-2">
                        <label for="itemCategory" class="form-label">Category</label>
                        <select class="form-select" aria-label="itemCategory" id="itemCategory" required>
                            <option selected value="">---Select Menu---</option>
                            <?php
                            itemCategoryOutput($Conn);
                            ?>
                        </select>
                        <div class="invalid-feedback" id="itemCategoryFeedback">Please Select Category...</div>
                    </div>
                    <div class="mb-3">
                        <label for="itemReorder" class="form-label">Reorder Quantity</label>
                        <input type="text" class="form-control" id="itemReorder" placeholder="Input Reorder Quantity" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                        <div class="invalid-feedback" id="itemReorderFeedback">Please Input Reorder Quantity...</div>
                    </div>
                    <div class="mb-2">
                        <label for="itemUnit" class="form-label">Unit</label>
                        <select class="form-select" aria-label="itemUnit" id="itemUnit" required>
                            <option selected value="">---Select Menu---</option>
                            <?php
                            unitOutput($Conn);
                            ?>
                        </select>
                        <div class="invalid-feedback" id="itemUnitFeedback">Please Select Unit...</div>
                    </div>
                    <div class="redBox mt-5" id='itemTotalError'>

                        <p>There is an error that needs to be fix..</p>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btnDesign" id='btnItemSave' style="padding: 0.5rem; ">Save Item</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $(document).ready(function() {
        $('#itemTable').DataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true,
            lengthMenu: [5, 10, 20, 500, 100, 150]
        });
        $(document).on('click', '#btnAddItem', function() {
            $('#modalItem').show();
        });
        $(document).on('click', '#btnModalItemClose', function() {
            window.location.href = 'mainpage.php?component=Item';
        });
        const form = {

            itemName: $('#itemName'),
            itemNameFeedback: $('#itemNameFeedback'),
            itemCategory: $('#itemCategory'),
            itemCategoryFeedback: $('#itemCategoryFeedback'),
            itemReorder: $('#itemReorder'),
            itemReorderFeedback: $('#itemReorderFeedback'),
            itemUnit: $('#itemUnit'),
            itemUnitFeedback: $('#itemUnitFeedback')

        }

        $(document).on('keyup', '#itemName', function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                $('#itemNameFeedback').text('Please Fill the fields...');
            } else {

                let datastring = 'itemName=' + $(this).val() + '&itemNameId=' + 'x';
                $.ajax({

                    type: 'POST',
                    url: 'includes/item-table.inc.php',
                    data: datastring,
                    dataType: 'json',
                    success: function(data, textStatus) {

                        if (data.status) {


                            form.itemName.removeClass('is-invalid');
                            form.itemName.addClass('is-valid');

                        } else {

                            form.itemName.removeClass('is-valid');
                            form.itemName.addClass('is-invalid');
                            form.itemNameFeedback.text('Item Name Exist...');

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

        $(document).on('change', '#itemCategory', function() {
            if (!$('#itemCategory').val() || $('#itemCategory').val() === "") {
                $('#itemCategory').removeClass('is-valid');
                $('#itemCategory').addClass('is-invalid');
            } else {
                $('#itemCategory').removeClass('is-invalid');
                $('#itemCategory').addClass('is-valid');
            }
        });
        $(document).on('keyup', '#itemReorder', function() {
            if (parseFloat($('#itemReorder').val()) === 0 || !$('#itemReorder').val()) {
                $(this).removeClass('is-valid');
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
                $(this).addClass('is-valid');
            }
        });
        $(document).on('change', '#itemUnit', function() {
            $(this).removeClass('is-invalid');
            $(this).addClass('is-valid');
        });

        $(document).on('click', '#btnItemSave', function() {
            let allId = ['#itemName', '#itemCategory', '#itemReorder', '#itemUnit'];
            var checker;
            for (let x = 0; x < 4; x++) {

                if (!$(allId[x]).val()) {
                    $(allId[x]).addClass('is-invalid');
                    checker = false;

                }

            }
            if (parseFloat($('#itemReorder').val()) <= 0) {
                checker = false;
            } else {
                checker = true;
            }

            if (checker) {
                $(this).html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                $('#btnItemSave').attr("disabled", true);
                // alert('true');

                let datastring = 'itemName=' + $('#itemName').val() + '&itemCategory=' + $('#itemCategory').val() + '&itemReorder=' + $('#itemReorder').val() + '&itemUnit=' + $('#itemUnit').val() + '&btnItemSave=' + 'true';
                console.log(datastring);
                let datas = 'btnItemSave=' + 'true';
                $.ajax({

                    type: 'POST',
                    url: 'includes/item-table.inc.php',
                    data: datastring,
                    dataType: 'json',
                    success: function(data, textStatus) {

                        if (data.status === true) {
                            // alert('succss');
                            $('#btnItemSave').text('Saved');
                            $('#btnItemSave').attr("disabled", true);
                            $('#itemTotalError').css('display', 'none');


                        } else {
                            // alert('failed');
                            $('#loading').remove();
                            $('#btnItemSave').removeAttr('disabled');
                            $('#btnItemSave').text('Save Item');
                            $('#itemTotalError').css('display', 'block');

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

        $(document).on('click', '#btnEditItem', function() {
            $('#modalItem').show();
            let rowId = $(this).attr('row.id');
            $('#itemName').attr('id', 'updateItemName');
            $('#itemNameLabel').attr('for', 'updateItemName');
            $('#btnItemSave').attr('id', 'btnItemUpdate');
            $('#btnItemUpdate').text('Update Item');
            $('#itemRowId').val(rowId);

            let datastring = 'btnEditItem=' + $('#btnEditItem').val() + '&rowId=' + rowId;
            console.log(datastring);
            $.ajax({

                type: 'POST',
                url: 'includes/item-table.inc.php',
                data: datastring,
                dataType: 'json',
                success: function(data, textStatus) {

                    if (data.status) {

                        $('#updateItemName').val(data.infoItem[1]);
                        $('#updateItemNameComparison').val(data.infoItem[1]);
                        form.itemCategory.val(data.infoItem[2]);
                        form.itemReorder.val(data.infoItem[3]);
                        form.itemUnit.val(data.infoItem[4]);
                    }


                },
                fail: function(xhr, textStatus, errorThrown, data) {
                    alert(errorThrown);
                    alert(xhr);
                    alert(textStatus);
                }

            });

        });


        $(document).on('keyup', '#updateItemName', function() {
            if (!$(this).val()) {
                $(this).addClass('is-invalid');
                $('#itemNameFeedback').text('Please Fill the fields...');
            } else if ($('#updateItemNameComparison').val() === $('#updateItemName').val()) {
                $('#updateItemName').removeClass('is-invalid');
                $('#updateItemName').addClass('is-valid');
            } else {

                let datastring = 'itemName=' + $(this).val() + '&itemNameId=true';

                $.ajax({

                    type: 'POST',
                    url: 'includes/item-table.inc.php',
                    data: datastring,
                    dataType: 'json',
                    success: function(data, textStatus) {

                        if (data.status) {

                            $('#updateItemName').removeClass('is-invalid');
                            $('#updateItemName').addClass('is-valid');

                        } else {

                            $('#updateItemName').removeClass('is-valid');
                            $('#updateItemName').addClass('is-invalid');
                            $('#itemNameFeedback').text('Item Name Exist...');

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



        $(document).on('click', '#btnItemUpdate', function() {
            let allId = ['#updateItemName', '#itemCategory', '#itemReorder', '#itemUnit'];
            var checker;
            for (let x = 0; x < 4; x++) {

                if (!$(allId[x]).val()) {
                    $(allId[x]).addClass('is-invalid');
                    checker = false;

                }

            }
            if (parseFloat($('#itemReorder').val()) <= 0) {
                checker = false;
            } else {
                checker = true;
            }
            if (checker) {
                $(this).html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                $('#btnItemUpdate').attr("disabled", true);

                let datastring = 'itemName=' + $('#updateItemName').val() + '&itemCategory=' + $('#itemCategory').val() + '&itemReorder=' + $('#itemReorder').val() + '&itemUnit=' + $('#itemUnit').val() + '&btnItemUpdate=' + 'true' + '&comparisonData=' + $('#updateItemNameComparison').val() + '&rowId=' + $('#itemRowId').val();
                console.log(datastring);

                $.ajax({

                    type: 'POST',
                    url: 'includes/item-table.inc.php',
                    data: datastring,
                    dataType: 'json',
                    success: function(data, textStatus) {

                        if (data.status === true) {
                            // alert('success');
                            $('#btnItemUpdate').text('Updated');
                            $('#btnItemUpdate').attr("disabled", true);
                            $('#itemTotalError').css('display', 'none');


                        } else {
                            // alert('failed');
                            $('#loading').remove();
                            $('#btnItemUpdate').removeAttr('disabled');
                            $('#btnItemUpdate').text('Update Item');
                            $('#itemTotalError').css('display', 'block');

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

    });
</script>

</html>