<?php
// 1. Verificar si los datos existen y no estan vacios.
if (!isset($_POST['username']) || !isset($_POST['password']) || !isset($_POST['email'])) {
    die("Error: Datos incompletos en la petición.");
}

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];

// 2. Validaciones estrictas de Capa 2.
if (strlen($username) < 4 || strlen($username) > 20) {
    die("Error: El nombre de usuario debe tener entre 4 y 20 caracteres.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Error: Formato de correo electrónico inválido.");
}

if (strlen($password) < 8) {
    die("Error: La contraseña debe tener al menos 8 caracteres.");
}

// Si pasa la validación, el flujo continúa hacia la persistencia del Estudiante 2