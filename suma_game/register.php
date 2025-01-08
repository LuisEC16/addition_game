<?php
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include 'db.php'; 

    $nombre = $_POST['nombre'];
    $contraseña = $_POST['contraseña'];
    $confirmarContraseña = $_POST['confirmar_contraseña'];

    if (strlen($contraseña) < 5) {
        $error = "La contraseña debe tener al menos 5 caracteres.";
    }

    if ($contraseña !== $confirmarContraseña) {
        $error = "Las contraseñas no coinciden.";
    }

    if (!$error) {  
        $contraseñaEncriptada = password_hash($contraseña, PASSWORD_BCRYPT);

        $sql = "INSERT INTO usuarios (nombre, contraseña) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(1, $nombre, PDO::PARAM_STR);
        $stmt->bindParam(2, $contraseñaEncriptada, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $success = "Usuario registrado correctamente. <a href='index.php'>Inicia sesión</a>";
        } else {
            $error = "Error al registrar el usuario.";
        }

        $stmt = null;
        $pdo = null;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="css/styles.css">
    
</head>
<body>
    <h1>¡Únete a la diversión! Regístrate ahora</h1>
    <div class="login-container">
        <h1>Ingrese los datos</h1>
        <form method="POST">
            <?php if ($error): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php elseif (isset($success)): ?>
                <p style="color: green;"><?php echo $success; ?></p>
            <?php endif; ?>
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="password" name="contraseña" placeholder="Contraseña" required>
            <input type="password" name="confirmar_contraseña" placeholder="Confirmar Contraseña" required>
            <button type="submit">Registrar</button>
        </form>
        <p>¿Ya tienes cuenta? <a href="index.php">Inicia sesion</a></p>
    </div>

    <div class="sound-control">
        <img id="sound-icon" src="iconos/corneta-consonido.png" alt="Sonido Activado" />
    </div>

    <audio id="musica" loop>
        <source src="iconos/musica.mp3" type="audio/mp3">
    </audio>
</body>
<style>
    .login-container {
        position: absolute;
        top: 50%; 
        left: 50%; 
        transform: translate(-50%, -50%); 
        background: rgba(255, 255, 255, 0.9); 
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.2);
        width: 350px;
        text-align: center;
    }

    .login-container h1 {
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
    }

    .login-container input {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 14px;
    }

    .login-container button {
        width: 100%;
        padding: 10px;
        background-color: #ff7043;
        color: white;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
    }

    .login-container button:hover {
        background-color: #e64a19;
    }

    .login-container p {
        margin-top: 15px;
        font-size: 14px;
        color: #666;
    }

    .login-container a {
        color: #007BFF;
        text-decoration: none;
    }

    .login-container a:hover {
        text-decoration: underline;
    }
</style>
</html>
