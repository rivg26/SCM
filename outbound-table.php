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
                        <th>Remarks</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                    <tr>
                        <th>No.</th>
                        <th>Item</th>
                        <th>Product Description</th>
                        <th>Quantity</th>
                        <th>Outbound Date</th>
                        <th>Encoder Name</th>
                        <th>Remarks</th>
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
                        <label for="exampleFormControlInput1" class="form-label">Item Name</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>---Select Menu---</option>
                            <option value="1">2x2 Wood</option>
                            <option value="2">1x1 Metal</option>
                            <option value="3">Screw</option>
                            <option value="3">Philipps</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="exampleFormControlInput1" class="form-label">Product Name</label>
                        <select class="form-select" aria-label="Default select example">
                            <option selected>---Select Menu---</option>
                            <option value="1">Chair</option>
                            <option value="2">Table</option>
                            <option value="3">Fan</option>
                            <option value="3">Cabinet</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="exampleFormControlInput1" class="form-label" >Quantity</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Input Quantity" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                    </div>
                    <div class="mb-2">
                        <label for="exampleFormControlInput1" class="form-label">Inbound Date</label>
                        <input type="date" class="form-control" id="exampleFormControlInput1" >
                    </div>
                    <div class="mb-2">
                        <label for="exampleFormControlInput1" class="form-label">Encoder Name</label>
                        <input type="text" class="form-control" id="encoderName" readonly>
                    </div>
                    <div class="mb-2">
                        <label for="exampleFormControlInput1" class="form-label">Remarks</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
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
            "bAutoWidth": true
        });

        $(document).on('click', '#btnAddOutbound', function() {
            $('#modalOutbound').show();
        });
        $(document).on('click', '#btnModalOutboundClose', function() {
            $('#modalOutbound').hide();
        });

    })
</script>

</html>