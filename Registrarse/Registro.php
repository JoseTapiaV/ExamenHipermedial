<?php
    $registroCreado = FALSE;
    if($_POST){
        if($_POST['registroCli']){
            $cedulaCliente = ($_POST["cedCli"]);
            $nombreCliente = ($_POST["nombCli"]);
            $apellidoCliente = ($_POST["apeCli"]);
            $direccionCliente = ($_POST["dirCli"]);
            $telefonoCliente = ($_POST["telCli"]);
            $correoCliente = ($_POST["corrCli"]);
            $contrasenaCliente = ($_POST["contCli"]);
            $tarjetaCredito = ($_POST["tarjetaCredito"]);
    
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "practica2";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO usuario (correo, contrasena, rol)
            VALUES ( '$correoCliente', '$contrasenaCliente', 'C')";

            //echo $sql;

            if ($conn->query($sql) === TRUE) {
                //echo "New record created successfully";
                $registroCreado = TRUE;
                $last_id = $conn->insert_id;
                //echo "New record created successfully. Last inserted ID is: " . $last_id;
            } else {
                //echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $sql = "INSERT INTO cliente (cedula, nombre, apellido, direccion, telefono, tarjeta_credito, usuario_id)
            VALUES ('$cedulaCliente', '$nombreCliente', '$apellidoCliente', '$direccionCliente', '$telefonoCliente', '$tarjetaCredito', $last_id)";

            if ($conn->query($sql) === TRUE) {
                //echo $last_id;
            } else {
                //echo "Error: " . $sql . "<br>" . $conn->error;
            }


            $conn->close();

        }elseif($_POST['registroRe']){
            $nombreRe = ($_POST["nomRe"]);
            $direccionRe = ($_POST["dirRe"]);
            $telefonoRe = ($_POST["telRe"]);
            $correoRe = ($_POST["corrRe"]);
            $contrasenaRe = ($_POST["contRe"]);

            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "practica2";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "INSERT INTO usuario (correo, contrasena, rol)
            VALUES ( '$correoRe', '$contrasenaRe', 'R')";

            //echo $sql;

            if ($conn->query($sql) === TRUE) {
                //echo "New record created successfully";
                $registroCreado = TRUE;
                $last_id = $conn->insert_id;
                echo "New record created successfully. Last inserted ID is: " . $last_id;
            } else {
                //echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $sql = "INSERT INTO restaurante (nombre, direccion, telefono, usuario_id)
            VALUES ('$nombreRe', '$direccionRe', '$telefonoRe',  $last_id)";

            if ($conn->query($sql) === TRUE) {
                echo $last_id;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }
    }   
    
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Registrarse</title>
    <link rel="stylesheet" href="../CSS/Registro.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Nanum+Gothic&display=swap" rel="stylesheet">
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="center">
    <main>

    <div id="columna1">
        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-person-plus-fill" viewBox="0 0 16 16">
            <path d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
            <path fill-rule="evenodd" d="M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z"/>
          </svg>
        <h1>Registro para nuevos clientes o restaurantes</h1>
        <?php 
            if ($registroCreado){
                echo '<div class="alert alert-dark" role="alert">
                Creado correctamente!
                </div>';
            }
            if($_POST && !$registroCreado){
                echo '<div class="alert alert-dark" role="alert">
                Error al crear!
                </div>';
            }
        ?>
    </div>

    <!-- Registro cliente -->
    <form method="post" action="">

    <div id="columna2">
        <h1 class="h1">Registro para un cliente</h1><br>
        <p>A continuación ingrese los siguientes datos del cliente:</p><br>        
        
        <table id="tabla">
            <tr>
                <td> 
                    <p>Cédula:&nbsp;</p> 
                </td>
                <td> 
                    <input type="text" class="form-control" id="cedula" placeholder="0123456789" size="40" name="cedCli"> 
                </td>
            </tr>
            <tr>
                <td> 
                    <p>Nombres:&nbsp;</p> 
                </td>
                <td> 
                    <input type="text" class="form-control" id="nombres" placeholder="Juanito Alberto" size="40" name="nombCli"> 
                </td>
            </tr>
            <tr>
                <td>
                    <p>Apellidos:&nbsp;</p>
                </td>
                <td>
                    <input type="text" class="form-control" id="apellidos" placeholder="Alvarez Gonzalez" size="40" name="apeCli">
                </td>
            </tr>
            <tr>
                <td>
                    <p>Dirección:&nbsp;</p>
                </td>
                <td>
                    <input type="text" class="form-control" id="direccion" placeholder="Av. Gonzales Suarez" size="40" name="dirCli">
                </td>
            </tr>
            <tr>
                <td>
                    <p>Teléfono:&nbsp;</p>
                </td>
                <td>
                    <input type="number" class="form-control" id="telefono" placeholder="0987654321" size="40" name="telCli"> 
                </td>
            </tr>
            <tr>
                <td>
                    <p>Tarjeta de crédito:&nbsp;</p>
                </td>
                <td>
                    <input type="text" class="form-control" id="tarjetaCredito" placeholder="Ingresa tu número de tarjeta" size="40" name="tarjetaCredito">
                </td>
            </tr>
            <tr>
                <td>
                    <p>Correo Electrónico:&nbsp;</p>
                </td>
                <td>
                    <input type="email" class="form-control" id="correo" placeholder="nombre@ejemplo.com" size="40" name="corrCli">
                </td>
            </tr>
            <tr>
                <td>
                    <p>Contraseña:&nbsp;</p>
                </td>
                <td>
                    <input type="password" class="form-control" id="contrasena" placeholder="" size="40" name="contCli">
                </td>
            </tr>
        </table>
        <br>
        <input type="submit" value="Registrar Cliente" class="w-50 btn btn-secondary" id="registrarCliente" name="registroCli">
    </div>

    </form>

    <!-- Registro restaurante -->
    <form method="post" action=""> 
    <div id="columna3">
        <h1 class="h1">Registro para un restaurante</h1><br>
        <p>A continuación ingrese los siguientes datos del restaurante:</p><br>
        <table id="tabla">
            <tr>
                <td> 
                    <p>Nombre:&nbsp;</p> 
                </td>
                <td> 
                    <input type="text" class="form-control" id="nombresRe" placeholder="La Comelona" size="40" name="nomRe"> 
                </td>
            </tr>
            <tr>
                <td>
                    <p>Dirección:&nbsp;</p>
                </td>
                <td>
                    <input type="text" class="form-control" id="direccionRe" placeholder="Av. Gonzales Suarez" size="40" name="dirRe">
                </td>
            </tr>
            <tr>
                <td>
                    <p>Teléfono:&nbsp;</p>
                </td>
                <td>
                    <input type="number" class="form-control" id="telefonoRe" placeholder="0987654321" size="40" name="telRe">
                </td>
            </tr>
            <tr>
                <td>
                    <p>Correo Electrónico:&nbsp;</p>
                </td>
                <td>
                    <input type="email" class="form-control" id="correoRe" placeholder="nombre@ejemplo.com" size="40" name="corrRe">
                </td>
            </tr>
            <tr>
                <td>
                    <p>Contraseña:&nbsp;</p>
                </td>
                <td>
                    <input type="password" class="form-control" id="contrasenaRe" placeholder="" size="40" name="contRe">
                </td>
            </tr>
        </table>
        <br>
        <input type="submit" value="Registrar Restaurante" class="w-50 btn btn-secondary" id="registrarRestaurante" name="registroRe">
    </div>
    </form>

    <div id="columna4">
        <a href="../Index.php"><input type="button" value="Regresar" class="w-50 btn btn-secondary"></a>
    </div>

    </main>
        
</body>

</html>

