<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="css/login.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
    <title>LogIn Page</title>
</head>

<body>

    <!------ Include the above in your HEAD tag ---------->

    <div class="wrapper fadeInDown">
        <div id="formContent">
            <!-- Tabs Titles -->

            <!-- Icon -->
            <div class="fadeIn first">
                <img src="img/logo.png" id="icon" alt="User Icon" />
            </div>

            <!-- Login Form -->
            <form>
                <input type="text" class="fadeIn second" name="login" id='username' placeholder="username">
                <input type="password" class="fadeIn third" name="login" id='password' placeholder="password">
                <input type="submit" class="fadeIn fourth" id='btnLogin'>
            </form>

            <div class="errorBox">

                <p></p>

            </div>

            <!-- Remind Passowrd -->
            <div id="formFooter">
                <a class="underlineHover" href="#">Forgot Password?</a>
            </div>

        </div>
    </div>
</body>
<script>

    //JAVASCRIPT - camelCase included classed and ID
    //PHP - PascalCase
    //name - dash SMALL LETTERS ALL
    //button - btn + naming



    $(document).ready(function() {

        const form = {

            username: $('#username'), //Inputfield for username
            password: $('#password'), 
            btnLogin: $('#btnLogin'), //JQUERY


        }


        $(document).on('click', '#btnLogin', function(e) {
            
            e.preventDefault();

            let datastring = 'username=' + form.username.val() + '&password=' + form.password.val() + '&btnLogin=' + form.btnLogin.val();

            console.log(datastring);

            $.ajax({

                type: 'POST',
                url: 'includes/login.inc.php',
                data: datastring,
                dataType: 'json',
                timeout: 5000,
                success: function(data, textStatus) {
                   
                    if (data.status) {

                        $('.errorBox').css('display','none');
                        $('.errorBox p').text("");
                        location.href = 'mainpage.php';
                        
                    }
                    else{

                        $('.errorBox').css('display', 'block');
                        $('.errorBox p').text("");
                        $('.errorBox p').text(data.message);

                    }


                },
                fail: function(xhr, textStatus, errorThrown) {
                    alert(errorThrown);
                    alert(xhr);
                    alert(textStatus);
                },
                catch: function(error){
                    alert(error);
                }

            });


        });




    });
</script>

</html>