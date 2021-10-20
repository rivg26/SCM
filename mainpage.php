<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location: loginpage.php');
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/mainpage.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="container-fluid">
        <div class="row flex-nowrap">
            <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 sideBar">
                <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                    <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                        <span class="fs-5 d-none d-sm-inline"><img src="img/logowhite.png" class="img-fluid" alt=""></span>
                    </a>
                    <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                        <li class="nav-item">
                            <a href="" class="nav-link align-middle px-0 navSettings" link="home">
                                <i class="fs-4 bi-house"></i> <span class="ms-1 d-none d-sm-inline">Home</span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="nav-link px-0 align-middle navSettings" link="product">
                                <i class="fs-4 bi-table"></i> <span class="ms-1 d-none d-sm-inline">Product Table</span></a>
                        </li>
                        <li>
                            <a href="" data-bs-toggle="collapse" class="nav-link px-0 align-middle navSettings" link="inbound">
                                <i class="fs-4 bi bi-file-earmark-spreadsheet-fill"></i><span class="ms-1 d-none d-sm-inline">Inbound Table</span></a>
                        </li>
                        <li>
                            <a href="" data-bs-toggle="collapse" class="nav-link px-0 align-middle  navSettings" link="outbound">
                                <i class="fs-4 bi-grid"></i> <span class="ms-1 d-none d-sm-inline">Outbound Table</span> </a>
                        </li>
                        <li>
                            <a href="" data-bs-toggle="collapse" class="nav-link px-0 align-middle  navSettings" link="item">
                                <i class="fs-4 bi bi-file-spreadsheet"></i> <span class="ms-1 d-none d-sm-inline">Item Table</span> </a>
                        </li>
                        <li>
                            <a href="" class="nav-link px-0 align-middle navSettings" link="inventory">
                                <i class="fs-4 bi bi-file-spreadsheet-fill"></i> <span class="ms-1 d-none d-sm-inline">Inventory Table</span> </a>
                        </li>
                    </ul>
                    <hr>
                    <div class="dropdown pb-4">
                        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                            <span class="d-none d-sm-inline mx-1" id="encoderId">Rig</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">

                            <!-- <li>
                                <hr class="dropdown-divider">
                            </li> -->
                            <li><a class="dropdown-item" href="#">Sign out</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        
            <div class="col py-3" id='backgroundWrapper'>
                <button type="button" class="btn" id="btnToggle"><i class="fas fa-bars" id="toggleIcon"></i></button>
                <br>
                <div class="container-fluid mt-5" id="contentContainer">

                </div>
                <div class="shapes-3 loaderImg"></div>
            </div>

        </div>
    </div>

</body>
<script>
    $(document).ready(function() {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        
        if (urlParams) {
            switch (urlParams.get('component')){
                case 'Product': 
                    var getComponent = 'product-table.php';
                    break;
                case 'Item': 
                    var getComponent = 'item-table.php';
                    break;
                case 'Inbound': 
                    var getComponent = 'inbound-table.php';
                    break;
                case 'Outbound': 
                    var getComponent = 'outbound-table.php';
                    break;
                case 'Inventory': 
                    var getComponent = 'inventory-table.php';
                    break;
                default:
                    var getComponent = false;
            }
            if(getComponent){
                $('#contentContainer').load(getComponent, function() {
                    $('.loaderImg').fadeOut(function() {
                        $('.shapes-3').css('display', 'none');
                        
                    });
                });
            }
        }
        $('#btnToggle').click(function() {
            $('.sideBar').slideToggle("fast", 'linear');
        });

        
        $(document).on('click', '.navSettings', function() {
            history.pushState(null, "", location.href.split("?")[0]);
            $('.loaderImg').fadeIn(function() {
                $('.shapes-3').css('display', 'flex');
            });
            var self = this;
            setTimeout(function() {
                var link = $(self).attr('link');
                switch (link) {
                    case 'home':
                        var component = 'home-table.php';
                        break;
                    case 'product':
                        var component = 'product-table.php';
                        break;
                    case 'inbound':
                        var component = 'inbound-table.php';
                        break;
                    case 'outbound':
                        var component = 'outbound-table.php';
                        break;
                    case 'item':
                        var component = 'item-table.php';
                        break;
                    case 'inventory':
                        var component = 'inventory-table.php';
                        break;
                    default:
                        var component = false;
                }
                if (component) {
                    $('#contentContainer').load(component, function() {
                        $('.loaderImg').fadeOut(function() {
                            $('.shapes-3').css('display', 'none');

                        });
                    });
                } else {
                    $('.loaderImg').hide();
                    alert(link + ' not found!');
                }
            }, 1000);
            return false;
        });
    });
</script>

</html>