<?php

require "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);

    try {

        $sql = "INSERT INTO usuarios(nombre, correo, password)
                VALUES(:nombre, :correo, :password)";

        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":correo", $correo);
        $stmt->bindParam(":password", $password);

        $stmt->execute();

        echo "Usuario registrado correctamente.";

    } catch (PDOException $e) {

        echo "Error: " . $e->getMessage();

    }

}

?>
