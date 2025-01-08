<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'db.php'; 

function cargarEjercicios($nivel) {
    global $pdo;
    try {
        $query = "SELECT * FROM ejercicios WHERE nivel = :nivel";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['nivel' => $nivel]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Error al cargar ejercicios: " . $e->getMessage());
    }
}

function esEjercicioCompletado($nivel, $ejercicio_id) {
    global $pdo;
    try {
        $query = "SELECT completado FROM progreso WHERE nivel = :nivel AND ejercicio_id = :ejercicio_id AND usuario_id = :usuario_id";
        $stmt = $pdo->prepare($query);
        $stmt->execute([
            'nivel' => $nivel,
            'ejercicio_id' => $ejercicio_id,
            'usuario_id' => $_SESSION['usuario_id'] ?? 0
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row && $row['completado'] == 1;
    } catch (PDOException $e) {
        die("Error al verificar progreso: " . $e->getMessage());
    }
}

function marcarEjercicioCompletado($nivel, $ejercicio_id) {
    global $pdo;

    if (!isset($_SESSION['usuario_id'])) {
        throw new Exception("Error: Usuario no autenticado.");
    }

    $usuario_id = $_SESSION['usuario_id'];

    try {
        $sql = "INSERT INTO progreso (usuario_id, nivel, ejercicio_id, completado)
                VALUES (:usuario_id, :nivel, :ejercicio_id, 1)
                ON DUPLICATE KEY UPDATE completado = 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':usuario_id' => $usuario_id,
            ':nivel' => $nivel,
            ':ejercicio_id' => $ejercicio_id
        ]);
    } catch (PDOException $e) {
        die("Error al marcar ejercicio como completado: " . $e->getMessage());
    }
}

function obtenerEjercicioPorId($ejercicio_id) {
    global $pdo;
    $query = "SELECT sumando1, sumando2, respuesta FROM ejercicios WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['id' => $ejercicio_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function existeEjercicio($ejercicio_id) {
    global $pdo;
    try {
        $query = "SELECT COUNT(*) FROM ejercicios WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->execute(['id' => $ejercicio_id]);
        return $stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        die("Error al verificar si el ejercicio existe: " . $e->getMessage());
    }
}
