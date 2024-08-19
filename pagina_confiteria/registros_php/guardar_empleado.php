<!DOCTYPE html>
<html>
<head>
    <title>Lista de Empleados</title>
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

        .success {
            color: green;
        }

        .error {
            color: red;
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
    <h1>Lista de Clientes</h1>
    <?php
session_start();

// Comprobar si el formulario se envió
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Conectar a la base de datos (asegúrate de configurar tus propias credenciales)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "confiteria_bd";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Comprobar la conexión a la base de datos
    if ($conn->connect_error) {
        die("La conexión a la base de datos falló: " . $conn->connect_error);
    }

    // Recupera los datos del formulario
    $id_empleado = $_POST["id_empleado"];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $id_sucursal = $_POST["id_sucursal"]; 

    // Inserta los datos en la base de datos
    $sql = "INSERT INTO empleados (id_empleado, nombre, apellido, id_sucursal) VALUES ('$id_empleado', '$nombre', '$apellido','$id_sucursal')";

    if ($conn->query($sql) === TRUE) {
        echo "Empleado agregado exitosamente.";
        // Consulta para listar todos los empleados
        $listarEmpleadosSQL = "SELECT * FROM empleados";
        $result = $conn->query($listarEmpleadosSQL);

        // Después de insertar el cliente y mostrar el mensaje de éxito, puedes mostrar la lista en una tabla
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr><th>Id_empleado</th><th>Nombre</th><th>Apellido</th><th>Id_Sucursal</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id_empleado"] . "</td>";
                echo "<td>" . $row["nombre"] . "</td>";
                echo "<td>" . $row["apellido"] . "</td>";
                echo "<td>" . $row["id_sucursal"] . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "No hay empleados en la base de datos.";
        }
        echo '<form action="../formularios_html/index.html">
        <input type="submit" value="Continuar">
        </form>';
    } else {
        echo "Error al agregar empleados: " . $conn->error;
    }
}