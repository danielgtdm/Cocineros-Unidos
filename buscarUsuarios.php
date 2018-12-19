
<?php
require_once 'DB/CRUD/UsuarioCRUD.php';
require_once 'DB/CRUD/IngredienteCRUD.php';

session_start();

if (!isset($_SESSION['usuario'])) {
    header('Location: inicioSesion.php');
}
?>

<!DOCTYPE html>
<html lang="es">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Buscar Usuario | Cocineros Unidos</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Animaciones -->

        <link href="css/animate.css" rel="stylesheet">

        <!-- Custom fonts for this template -->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

        <!-- Plugin CSS -->
        <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/creative.min.css" rel="stylesheet">
        <link href="css/errores.css" rel="stylesheet">

        <style>
            .tarjetaInicioSesion{

                margin: auto;
                height: 500px;
            }
            .titulo{
                color: gray;
            }
            .tarjetaFormulario{
                margin-top: 20px;
            }
            .separacion{
                margin-top: 40px;
            }
            .logo{
                height: 64px;
                width: 64px;
                margin-top: 10px;
            }
            .text-white {
                color: gray!important;
            }

        </style>


    </head>

    <body id="page-top">

        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
            <div class="container">
                <a class="navbar-brand js-scroll-trigger" href="index.php"><img src="img/logo.png">Cocineros Unidos</a>
                <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="nuevaReceta.php">Nueva Receta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link js-scroll-trigger" href="cerrarSesion.php">Cerrar Sesion</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <header class="masthead text-center text-white d-flex">
            <div class="container my-auto">
                <div class="row">
                    <div class="col-lg-10 mx-auto">
                        <div class="card w-100 tarjetaInicioSesion animated bounceInDown">
                            <div class="card-body">
                                <img class="logo" src="img/logo.png"/>
                                <h2 class="titulo">Buscar Usuario</h2>
                                <!--<div class="tarjetaFormulario">
                                    <form action="acciones.php" method="POST">
                                        <div class="form-group">
                                            <label for="nombreIngrediente">Nombre del Ingrediente</label>
                                            <input type="text" class="form-control" id="nombreIngrediente" placeholder="Ej: Arroz Integral">
                                        </div>
                                        <div class="form-group">
                                            <label for="unidadMedida">Unidad de medida del Ingrediente</label>
                                            <input type="text" class="form-control" id="unidadMedida" placeholder="Ej: lt, gr, ud">
                                        </div>
                                        <button class="btn btn-primary" type="submit" name="action" value="guardarIngrediente">Guardar</button>
                                    </form>
                                </div> -->

                                <?php
                                if (isset($_SESSION['usuarioBuscado']) && $_SESSION['usuarioBuscado'] != 'none') {
                                    if ($_SESSION['usuarioBuscado'] != 'none' & $_SESSION['usuarioEncontrado'] == 'true') {
                                        
                                        $otraOpcion = '';
                                        if($_SESSION['rolUsuario'] == 'administrador'){
                                            
                                            $otraOpcion = 'cocinero';
                                            
                                        }else{
                                            $otraOpcion = 'administrador';
                                        }
                                        
                                        echo '<div class="tarjetaFormulario">
                                    <form id="frmGuardar" action="acciones.php" method="POST">
                                        <div class="form-group">
                                            <label for="nombreUsuario">Nombre del Usuario</label>
                                            <input type="text" class="form-control" name="nombreUsuario" disabled value="' . $_SESSION['nombreUsuario'] . '" id="nombreUsuario">
                                        </div>
                                        <div class="form-group">
                                            <label for="rolUsuario">Rol del Usuario</label>
                                            <select disabled name="rolUsuario" id="rolUsuario">
                                            <option selected value="'.$_SESSION['rolUsuario'].'">'.$_SESSION['rolUsuario'].'</option>
                                            <option value="'.$otraOpcion.'" >'.$otraOpcion.'</option>
                                            </select>
                                        </div>
                                        <div id="editar" class="btn btn-light">Editar</div>
                                        <div id="guardar">
                                        </div>
                                        <button type="submit" name="action" value="volverbuscarUsuario" class="btn btn-primary separacion">Volver</button>
                                        <button type="submit" name="action" value="eliminarUsuario" class="btn btn-primary separacion">Eliminar</button>
                                    </form>
                                </div> ';
                                    } else {
                                        echo '<div class="tarjetaFormulario">
                                    <div class="form-group">
                                        <form action="acciones.php" method="POST">
                                            <label for="nombreUsuarioBuscado">Nombre del Usuario</label>
                                            <input type="text" class="form-control" id="nombreUsuarioBuscado" name="nombreUsuarioBuscado">
                                            <div id="errorUsuario" class="col txtErrorSesion"> Ningun Usuario coincide con nuestros registros</div>
                                            <button type="submit" name="action" value="buscarUsuario" class="btn btn-primary separacion">Buscar</button>
                                            <a href="administracionUsuarios.php" class="btn btn-primary">Volver</a>
                                        </form>    
                                    </div>';
                                        $_SESSION['usuarioBuscado'] = 'none';
                                        $_SESSION['usuarioEncontrado'] = 'false';
                                    }
                                } else {
                                    echo '<div class="tarjetaFormulario">
                                    <div class="form-group">
                                        <form action="acciones.php" method="POST">
                                            <label for="nombreUsuarioBuscado">Nombre del Usuario</label>
                                            <input type="text" class="form-control" id="nombreUsuarioBuscado" name="nombreUsuarioBuscado">
                                            <button type="submit" name="action" value="buscarUsuario" class="btn btn-primary separacion">Buscar</button>
                                            <a href="administracionUsuarios.php" class="btn btn-primary">Volver</a>

                                        </form>    
                                    </div>';
                                }
                                ?>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

        
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="vendor/scrollreveal/scrollreveal.min.js"></script>
    <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>



    <!-- Custom scripts for this template -->
    <script src="js/creative.min.js"></script>

</body>
<script>

    var nombreOriginal = "";
    var rolOriginal = "";

    $(document).ready(function (e) {

        $('#editar').click(function (e) {
            nombreOriginal = $('#nombreUsuario').val();
            rolOriginal = $('#rolUsuario').val();
            $('#nombreUsuario').prop("disabled", false);
            $('#rolUsuario').prop("disabled", false);
            $('#guardar').html('<div id="cancelar" class="btn btn-danger">Cancelar</div>');
            $('#frmGuardar').append('<button class="btn btn-primary" type="submit" name="action" value="guardarUsuarioEditado">Guardar</button>');
        });


        $(document).on('click', '#cancelar', function (e) {
            $('#nombreUsuario').val(nombreOriginal);
            $('#rolUsuario').val(rolOriginal);
            $('#nombreUsuario').prop("disabled", true);
            $('#rolUsuario').prop("disabled", true);
            $('#guardar').html('');
            $('#guardar').html('');
        });
        

    });
    
    


</script>

</html>
