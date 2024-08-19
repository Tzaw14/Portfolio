<!DOCTYPE html>
<html>
<head>
    <title>Lista de Productos</title>
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
    // Resto del código PHP (como lo tenías antes)
// Configura la conexión a la base de datos
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
}

// Recupera los datos del formulario
$id_producto = $_POST["id_producto"];
$nombre = $_POST["nombre"];
$descripcion = $_POST["descripcion"];
$precio = $_POST["precio"];
$stock = $_POST["stock"];

// Inserta los datos en la base de datos
$sql = "INSERT INTO producto (id_producto, nombre, descripcion, precio, stock) VALUES ('$id_producto', '$nombre', '$descripcion','$precio', '$stock')";

if ($conn->query($sql) === TRUE) {
    echo "Producto agregados exitosamente.";
        // Consulta para listar todos los clientes
        $listarProductoSQL = "SELECT * FROM producto";
        $result = $conn->query($listarProductoSQL);
    
    // Después de insertar el cliente y mostrar el mensaje de éxito, puedes mostrar la lista en una tabla
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID Producto</th><th>Nombre</th><th>Descripción</th><th>Precio</th><th>Stock</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["id_producto"] . "</td>";
            echo "<td>" . $row["nombre"] . "</td>";
            echo "<td>" . $row["descripcion"] . "</td>";
            echo "<td>" . $row["precio"] . "</td>";
            echo "<td>" . $row["stock"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No hay productos en la base de datos.";
    }
    echo '<form action="../formularios_html/index.html">
    <input type="submit" value="Continuar">
    </form>';
} else {
    echo "Error al agregar producto: " . $conn->error;
}


// Cerrar la conexión
$conn->close();

    ?>
</div>
</body>
</html>

