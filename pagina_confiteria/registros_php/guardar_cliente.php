<!DOCTYPE html>
<html>
<head>
    <title>Lista de Clientes</title>
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
 }
 
 // Recupera los datos del formulario
 $id_cliente = $_POST["id_cliente"];
 $nombre = $_POST["nombre"];
 $apellido = $_POST["apellido"];
 $correo = $_POST["correo"];
 $telefono = $_POST["telefono"];
 
 // Inserta los datos en la base de datos
 $sql = "INSERT INTO clientes (id_cliente, nombre, apellido, correo, telefono) VALUES ('$id_cliente', '$nombre', '$apellido','$correo','$telefono')";
 
 if ($conn->query($sql) === TRUE) {
     echo "Cliente agregado exitosamente.";
         // Consulta para listar todos los clientes
         $listarClientesSQL = "SELECT * FROM clientes";
         $result = $conn->query($listarClientesSQL);
     
     // Después de insertar el cliente y mostrar el mensaje de éxito, puedes mostrar la lista en una tabla
     if ($result->num_rows > 0) {
         echo "<table>";
         echo "<tr><th>ID Cliente</th><th>Nombre</th><th>Apellido</th><th>Correo</th><th>Teléfono</th></tr>";
 
         while ($row = $result->fetch_assoc()) {
             echo "<tr>";
             echo "<td>" . $row["id_cliente"] . "</td>";
             echo "<td>" . $row["nombre"] . "</td>";
             echo "<td>" . $row["apellido"] . "</td>";
             echo "<td>" . $row["correo"] . "</td>";
             echo "<td>" . $row["telefono"] . "</td>";
             echo "</tr>";
         }
 
         echo "</table>";
     } else {
         echo "No hay clientes en la base de datos.";
     }
     // Agrega un botón "Continuar" que redirija al index.html
     echo '<form action="../formularios_html/index.html">
     <input type="submit" value="Continuar">
     </form>';
 } else {
     echo "Error al agregar cliente: " . $conn->error;
 }
    ?>
</div>
</body>
</html>

