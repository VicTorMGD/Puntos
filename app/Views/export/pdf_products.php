<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Productos</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <h2>Listado de Productos</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Precio</th>
                <th>Imagen</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= esc($p['name']) ?></td>
                    <td><?= esc($p['category']) ?></td>
                    <td>S/ <?= number_format($p['price'], 2) ?></td>
                    <td><?= $p['image'] ? $p['image'] : 'Sin imagen' ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</body>
</html>
