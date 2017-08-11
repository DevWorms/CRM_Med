<?php
    error_reporting(0);
    include dirname(__FILE__) . "/datos/config.php";
    include dirname(__FILE__) . "/sesion/Session.php";

    if (auth()) {
        header("Location: " . app_url() . $_SESSION["url"]);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="<?php echo app_url(); ?>img/HiAppHere_com_giannisgx89.morena.icons.png"
          type="image/x-icon">
    <title>Medilaser - Login</title>
    <!-- Bootstrap Core CSS -->
    <link href="<?php echo app_url(); ?>css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="<?php echo app_url(); ?>css/login-style.css" rel="stylesheet">
    <!-- scripts -->
    <script type="text/javascript" src="<?php echo app_url(); ?>js/jquery-1.11.3-jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo app_url(); ?>js/validation.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="login-container">
            <div id="output"></div>
            <img src="<?php echo app_url(); ?>img/logo1.jpg" height="70px" class="img-responsive">
            <div class="form-box">
                <form action="" method="POST" id="login-form">
                    <input type="text" name="id_usuario" id="id_usuario" placeholder="Id de Usuario" required>
                    <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña" required>
                    <button class="btn btn-info btn-block login" id="btn-login">Iniciar Sesión</button>
                    <div id="error">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo app_url(); ?>js/bootstrap.min.js"></script>
    <script src="<?php echo app_url(); ?>js/login.js"></script>
    <script src="<?php echo app_url(); ?>js/funciones_post.js"></script>
    <script type="text/javascript">
        $('document').ready(function() {
            /* validation */
            $("#login-form").validate({
                rules: {
                    id_usuario: {
                        required: true
                    },
                    contrasena: {
                        required: true
                    }
                },
                messages:
                    {
                        id_usuario:{
                            required: "Introduce tu id de usuarios"
                        },
                        contrasena: {
                            required: "Introduce tu contraseña"
                        }
                    },
                submitHandler: submitForm
            });

            function submitForm() {
                var data = $("#login-form").serialize();
                $.ajax({
                    type : 'POST',
                    url  : '<?php echo app_url(); ?>controladores/sesion/iniciar_sesion.php',
                    data : data,
                    beforeSend: function() {
                        $("#error").fadeOut();
                        $("#btn-login").html('&nbsp; Conectando...');
                    },
                    success :  function(response) {
                        response = JSON.parse(response);
                        if (response.estado == 1) {
                            $("#error").fadeIn(1000, function() {
                                $("#error").html('<div class="alert alert-success">&nbsp; ' + response.mensaje + '</div>');
                                $("#btn-login").html('&nbsp; Entrando...');
                            });
                            setTimeout(' window.location.href = "<?php echo app_url(); ?>' + response.url + '";', 1000);
                        }
                        else {
                            $("#error").fadeIn(1000, function() {
                                $("#error").html('<div class="alert alert-danger"> &nbsp; ' + response.mensaje + '</div>');
                                $("#btn-login").html('&nbsp; Iniciar Sesión');
                            });
                        }
                    },
                    error : function (response) {
                        console.log(response);
                    }
                });
            }
        });
    </script>
</body>
</html>