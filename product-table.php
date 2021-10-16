<?php
require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <form class="">
        <div class="shadow p-3 mb-5 bg-body rounded">
            <div class="headingWrapper mt-5">
                <h1 class="headingDesign1">Product</h1>
                <h1 class="headingDesign2">Table</h1>
            </div>
            <div class="table-responsive mt-5">
                <table id="productTable" class="tableDesign">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Product Description</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Price</th>
                            <th>Unit</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        productTable($Conn);
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Product Description</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Price</th>
                            <th>Unit</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="text-center my-5 ">
                <button class="btnDesign" id='btnAddProduct' style="padding: 1.2rem;">Add Product</button>
            </div>
        </div>

        <div class="modal" tabindex="-1" id='modalProduct' style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add Product Information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id='btnModalProductClose'></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label for="productDescription" class="form-label" id="productDescriptionLabel">Product Description</label>
                            <textarea class="form-control " id="productDescription" rows="3" required></textarea>
                            <input type='hidden' id="updateProductDescriptionComparison"></input>
                            <input type='hidden' id="productRowId"></input>
                            <div class="invalid-feedback" id="productDescriptionFeedback">Please Fill the fields...</div>
                        </div>
                        <div class="mb-2">
                            <label for="productCategory" class="form-label">Category</label>
                            <select class="form-select" aria-label="productCategoryFeedback" id="productCategory" required>
                                <option selected disabled value="">---Select Menu---</option>
                                <option value="Dining_Area">Dining Area</option>
                                <option value="Living_Area">Living Area</option>
                                <option value="Kitchen_Area">Kitchen Area</option>
                                <option value="Home_Office">Home Office</option>
                            </select>
                            <div class="invalid-feedback" id="productCategoryFeedback">Please Select Category...</div>
                        </div>
                        <div class="mb-2">
                            <label for="productStatus" class="form-label">Status</label>
                            <select class="form-select" aria-label="productStatusFeedback" id='productStatus' required>
                                <option selected disabled value="">---Select Menu---</option>
                                <option value="Available">Available</option>
                                <option value="Unavailable">Unavailable</option>
                                <option value="Processing">Processing</option>
                            </select>
                            <div class="invalid-feedback" id="productStatusFeedback">Please Select Status...</div>
                        </div>
                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Price</label>
                            <input type="text" class="form-control" id="productPrice" placeholder="Input Price" required oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                            <div class="invalid-feedback" id="productPriceFeedback">Please Input Price...</div>
                        </div>
                        <div class="mb-2">
                            <label for="productUnit" class="form-label">Unit</label>
                            <select class="form-select" aria-label="productUnit" id='productUnit' required>
                                <option selected disabled>---Select Menu---</option>

                                <?php
                                unitOutput($Conn);
                                ?>

                            </select>
                            <div class="invalid-feedback" id="productUnitFeedback">Please Select Unit...</div>
                        </div>

                        <div class="redBox mt-5" id='productTotalError'>

                            <p>There is an error that needs to be fix..</p>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btnDesign" id="btnSaveProduct" style="padding: 0.5rem; ">Save Product</button>
                    </div>
                    <div class="valid-feedback">
                        Looks good!
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
<script>
    $(document).ready(function() {

        $('#productTable').DataTable({
            "bPaginate": true,
            "bLengthChange": true,
            "bFilter": true,
            "bInfo": false,
            "bAutoWidth": true
        });

        $('#btnAddProduct').click(function() {
            $('#modalProduct').show();
        });

        $('#btnModalProductClose').click(function() {
            window.location.href = 'mainpage.php?component=Product';
            
        });

        const form = {
            productDescription: $('#productDescription'),
            productCategory: $('#productCategory'),
            productStatus: $('#productStatus'),
            productPrice: $('#productPrice'),
            productUnit: $('#productUnit')
        }



        $(document).on('keyup', '#productDescription', function() {
            if (!$(this).val()) {
                // $(this).removeClass('is-valid');
                $(this).addClass('is-invalid');
                $('#productDescriptionFeedback').text('Please Fill the fields...');
            } else {

                let datastring = 'productDescription=' + $(this).val() + '&productDescriptionId=' + 'x';
                $.ajax({

                    type: 'POST',
                    url: 'includes/product-table.inc.php',
                    data: datastring,
                    dataType: 'json',
                    success: function(data, textStatus) {

                        if (data.status) {

                            form.productDescription.removeClass('is-invalid');
                            form.productDescription.addClass('is-valid');

                        } else {

                            form.productDescription.removeClass('is-valid');
                            form.productDescription.addClass('is-invalid');
                            $('#productDescriptionFeedback').text('Product Description Exist...');

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


        $(document).on('change', '#productCategory', function() {
            getRemoveClass(this);
            setClass(this);
        });
        $(document).on('change', '#productStatus', function() {
            getRemoveClass(this);
            setClass(this);
        });
        $(document).on('change', '#productUnit', function() {
            getRemoveClass(this);
            setClass(this);
        });
        $(document).on('keyup', '#productPrice', function() {
            if (parseFloat($('#productPrice').val()) === 0 || !$('#productPrice').val()) {
                $(this).removeClass('is-valid');
                $(this).addClass('is-invalid');
            } else {
                getRemoveClass(this);
                setClass(this);
            }
        });

        function setClass(name) {
            $(name).addClass('is-valid');
        }

        function getRemoveClass(name) {
            $(name).removeClass('is-invalid');
        }




        $(document).on('click', '#btnSaveProduct', function() {


            let allId = ['#productDescription', '#productCategory', '#productStatus', '#productPrice', '#productUnit'];
            var checker;
            for (let x = 0; x < 5; x++) {

                if (!$(allId[x]).val()) {
                    $(allId[x]).addClass('is-invalid');
                    checker = false;

                } else {
                    checker = true;
                }

            }

            if (checker) {

                $(this).html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                $('#btnSaveProduct').attr("disabled", true);

                let datastring = 'productDescription=' + form.productDescription.val() + '&productCategory=' + form.productCategory.val() + '&productStatus=' + form.productStatus.val() + '&productPrice=' + form.productPrice.val() + '&productUnit=' + form.productUnit.val() + '&btnProduct=' + 'save';
                console.log(datastring);

                $.ajax({

                    type: 'POST',
                    url: 'includes/product-table.inc.php',
                    data: datastring,
                    dataType: 'json',
                    success: function(data, textStatus) {

                        if (data.status === true) {

                            $('#btnSaveProduct').text('Saved');
                            $('#btnSaveProduct').attr("disabled", true);
                            $('#productTotalError').css('display', 'none');


                        } else {

                            $('#loading').remove();
                            $('#btnSaveProduct').removeAttr('disabled');
                            $('#btnSaveProduct').text('Save Product');
                            $('#productTotalError').css('display', 'block');
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

        $(document).on('click', '#btnUpdateProduct', function() {


            let allId = ['#updateProductDescription', '#productCategory', '#productStatus', '#productPrice', '#productUnit'];
            var checker;
            for (let x = 0; x < 5; x++) {

                if (!$(allId[x]).val()) {
                    $(allId[x]).addClass('is-invalid');
                    checker = false;

                } else {
                    checker = true;
                }

            }

            if (checker) {

                // $(this).html("<span class='spinner-border spinner-border-sm ' id = 'loading' role='status' aria-hidden='true'></span>");
                $('#btnUpdateProduct').attr("disabled", true);
                let btnData = 'update';
                let datastring = 'productDescription=' + $('#updateProductDescription').val() + '&productCategory=' + form.productCategory.val() + '&productStatus=' + form.productStatus.val() + '&productPrice=' + form.productPrice.val() + '&productUnit=' + form.productUnit.val() + '&btnProductUpdate=' + btnData + '&rowId=' + $('#productRowId').val() + '&comparisonData=' + $('#updateProductDescriptionComparison').val();
                console.log(datastring);

                $.ajax({

                    type: 'POST',
                    url: 'includes/product-table.inc.php',
                    data: datastring,
                    dataType: 'json',
                    success: function(data, textStatus) {

                        if (data.status === true) {

                            $('#btnUpdateProduct').text('Updated');
                            $('#btnUpdateProduct').attr("disabled", true);
                            $('#productTotalError').css('display', 'none');

                            // alert('success');

                        } else {
                            // alert(data.status);
                            $('#loading').remove();
                            $('#btnUpdateProduct').removeAttr('disabled');
                            $('#btnUpdateProduct').text('Update Product');
                            $('#productTotalError').css('display', 'block');
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


        $(document).on('click', '#btnEditProduct', function() {

            $('#modalProduct').show();
            $('#productDescription').attr('id', 'updateProductDescription');
            $('#productDescriptionLabel').attr('for', 'updateProductDescription');
            $('#btnSaveProduct').attr('id', 'btnUpdateProduct');
            $('#btnUpdateProduct').text('Update Product');
            let rowId = $(this).attr('row.id');
            $('#productRowId').val(rowId);

            let datastring = 'rowId=' + rowId + '&btnEditProduct=' + $('#btnEditProduct').val();
            $.ajax({

                type: 'POST',
                url: 'includes/product-table.inc.php',
                data: datastring,
                dataType: 'json',
                success: function(data, textStatus) {

                    if (data.status) {

                        $('#updateProductDescription').val(data.data[1]);
                        $('#updateProductDescriptionComparison').val(data.data[1]);
                        form.productCategory.val(data.data[2]);
                        form.productStatus.val(data.data[3]);
                        form.productPrice.val(data.data[4]);
                        form.productUnit.val(data.data[5]);
                    }


                },
                fail: function(xhr, textStatus, errorThrown, data) {
                    alert(errorThrown);
                    alert(xhr);
                    alert(textStatus);
                }

            });

        });

        $(document).on('keyup', '#updateProductDescription', function() {
            if (!$(this).val()) {
                // $(this).removeClass('is-valid');
                $(this).addClass('is-invalid');
                $('#productDescriptionFeedback').text('Please Fill the fields...');
            } else if ($('#updateProductDescriptionComparison').val() === $('#updateProductDescription').val()) {
                $('#updateProductDescription').removeClass('is-invalid');
                $('#updateProductDescription').addClass('is-valid');
            } else {

                let datastring = 'updateProductDescription=' + $(this).val() + '&updateProductDescriptionValue=' + $('#updateProductDescriptionComparison').val();

                $.ajax({

                    type: 'POST',
                    url: 'includes/product-table.inc.php',
                    data: datastring,
                    dataType: 'json',
                    success: function(data, textStatus) {

                        if (data.status) {

                            $('#updateProductDescription').removeClass('is-invalid');
                            $('#updateProductDescription').addClass('is-valid');

                        } else {

                            $('#updateProductDescription').removeClass('is-valid');
                            $('#updateProductDescription').addClass('is-invalid');
                            $('#productDescriptionFeedback').text('Product Description Exist...');

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