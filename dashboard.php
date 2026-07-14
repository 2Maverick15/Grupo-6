<?php
try {
    require_once 'Archivo_conexion.php'; 
} catch (Exception $e) {
    die("Error crítico en la plataforma. Por favor, intente más tarde.");
}

$registros_por_pagina = 10;
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_actual < 1) { $pagina_actual = 1; }
$offset = ($pagina_actual - 1) * $registros_por_pagina;
$sql = "SELECT id, usuario, email, fecha_registro 
        FROM usuarios 
        WHERE estado = :estado 
        ORDER BY fecha_registro DESC 
        LIMIT :limite OFFSET :offset";

try {
    $stmt = $Archivo_conexion->prepare($sql);
    
    $stmt->bindValue(':estado', 'activo', PDO::PARAM_STR);
    $stmt->bindValue(':limite', $registros_por_pagina, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
    $stmt->execute();
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Error en la consulta del Dashboard: " . $e->getMessage());
    $usuarios = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Panel de Optimización</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f9; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #fff; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #0056b3; color: white; }
        tr:hover { background-color: #f1f1f1; }
        .paginacion { margin-top: 20px; }
        .btn { padding: 8px 16px; background: #0056b3; color: white; text-decoration: none; border-radius: 4px; }
        .btn-disabled { padding: 8px 16px; background: #ccc; color: #666; cursor: not-allowed; text-decoration: none; border-radius: 4px; }
    </style>
</head>
<body>

    <h1>Panel de Control (Optimizado)</h1>
    <p>Auditoría de datos activa para prevenir sobrecarga de memoria (Full Table Scan).</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Email</th>
                <th>Fecha Registro</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $u): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($u['id'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($u['usuario'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($u['email'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?php echo htmlspecialchars($u['fecha_registro'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align: center;">No hay registros de usuarios activos.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="paginacion">
        <!-- Botón Anterior -->
        <?php if ($pagina_actual > 1): ?>
            <a class="btn" href="?pagina=<?php echo $pagina_actual - 1; ?>">« Anterior</a>
        <?php else: ?>
            <span class="btn-disabled">« Anterior</span>
        <?php endif; ?>

        <span> Página <?php echo $pagina_actual; ?> </span>

        <!-- Botón Siguiente -->
        <?php if (count($usuarios) == $registros_por_pagina): ?>
            <a class="btn" href="?pagina=<?php echo $pagina_actual + 1; ?>">Siguiente »</a>
        <?php else: ?>
            <span class="btn-disabled">Siguiente »</span>
        <?php endif; ?>
    </div>

</body>
</html>
