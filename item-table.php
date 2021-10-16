<?php
require_once 'includes/functions.inc.php';
require_once 'includes/dbh.inc.php';
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
                    <h5 class="modal-title">Add Product Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id='btnModalItemClose'></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Item Name</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Input Item Name">
                    </div>
                    <div class="mb-2">
                        <label for="exampleFormControlInput1" class="form-label">Category</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected disabled>---Select Menu---</option>
                            <option value="1">Wood --- Wood Materials</option>
                            <option value="2">Metal --- Metal Materials</option>
                            <option value="3">Screw</option>
                            <option value="3">Philipps</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Reorder Quantity</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Input Reorder Quantity" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                    </div>
                    <div class="mb-2">
                        <label for="exampleFormControlInput1" class="form-label">Unit</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected disabled>---Select Menu---</option>
                            <?php
                                unitOutput($Conn);
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btnDesign" style="padding: 0.5rem; ">Save Item</button>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    $('#itemTable').DataTable({
        "bPaginate": true,
        "bLengthChange": true,
        "bFilter": true,
        "bInfo": false,
        "bAutoWidth": true
    });
    $(document).on('click', '#btnAddItem', function() {
        $('#modalItem').show();
    });
    $(document).on('click', '#btnModalItemClose', function() {
        $('#modalItem').hide();
    });
</script>

</html>