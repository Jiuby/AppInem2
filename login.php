<?php
// Archivo: login.php

// Obtener los datos del formulario
$tarjeta = isset($_POST['tarjeta']) ? $_POST['tarjeta'] : '';
$codigo = isset($_POST['codigo']) ? $_POST['codigo'] : '';

// Verificar si se enviaron los datos del formulario
if ($tarjeta !== '' && $codigo !== '') {
  // Establecer la conexión con la base de datos
  $host = 'localhost';
  $dbname = 'estudiante';
  $username = 'root';
  $password = '';

  try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta SQL para verificar el inicio de sesión
    $query = "SELECT * FROM estudiantes WHERE tarjeta = :tarjeta AND clave = :codigo";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':tarjeta', $tarjeta);
    $stmt->bindParam(':codigo', $codigo);
    $stmt->execute();

    // Verificar si se encontró un resultado
    if ($stmt->rowCount() > 0) {
      // Inicio de sesión exitoso, redirigir al usuario a "inicio.html"
      header('Location: inicio.html');
      exit;
    } else {
      // Inicio de sesión fallido, mostrar un mensaje de error
      echo "Inicio de sesión fallido. Verifica tus credenciales.";
    }
  } catch(PDOException $e) {
    // Error en la conexión o consulta SQL
    echo "Error: " . $e->getMessage();
  }

  // Cerrar la conexión a la base de datos
  $conn = null;
} else {
  echo "Los datos de inicio de sesión no se enviaron correctamente.";
}
?>


