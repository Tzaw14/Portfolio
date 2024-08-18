<!DOCTYPE html>
<html>
<head>
    <title>Lista de Sucursales</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        h1 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Lista de Sucursales</h1>
    <?php
    // Configura la conexión a la base de datos (asegúrate de configurar tus propias credenciales)
    session_start();

    // Comprobar si el formulario se envió
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Conectar a la base de datos (asegúrate de configurar tus propias credenciales)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "confiteria_bd";   
    
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        // Comprobar la conexion a la base de datos
        if ($conn->connect_error) {
            die("La conexión a la base de datos falló: " . $conn->connect_error);
        }
    }
    $id_sucursal = $_POST["id_sucursal"];
    $nombre = $_POST["nombre"];
    $direccion= $_POST["direccion"];
    $sql = "INSERT INTO sucursal (id_sucursal, nombre, direccion) VALUES ('$id_sucursal', '$nombre', '$direccion')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Sucursal Agregada Exitosamente.";
            // Consulta para listar las sucursales
            $listaSucursal = "SELECT * FROM sucursal";
            $result = $conn->query($listaSucursal);
        
        // Despues de insertar el cliente y mostrar el mensaje de exito, puedes mostrar la lista en una tabla
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>ID</th><th>Nombre</th><th>Direccion</th></tr>";
    
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id_sucursal"] . "</td>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>" . $row["direccion"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No hay sucursales en la base de datos.";
        }
                // Agrega un boton "Continuar" que redirija al index.html
        // Agrega un boton "Continuar" que redirige al index.html en otra carpeta
    echo '<form action="../formularios_html/index.html">
    <input type="submit" value="Continuar">
    </form>';
    
    } else {
        echo "Error al agregar sucursal: " . $conn->error;
    }
    $conn->close();
    ?>
</div>
</body>
</html>
