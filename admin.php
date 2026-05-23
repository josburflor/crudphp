<?php include 'conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Admin - Burgos Libros</title>
</head>
<body class="p-10 bg-gray-50">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">
        <div class="flex justify-between mb-6">
            <h2 class="text-2xl font-bold text-blue-600">Inventario de Libros (Panel Admin)</h2>
            <a href="crear.php" class="bg-blue-600 text-white px-4 py-2 rounded font-bold hover:bg-blue-700"> + Añadir Nuevo</a>
        </div>

        <table class="w-full border border-gray-200 text-left">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="p-2 border">ID</th>
                    <th class="p-2 border">Miniatura</th>
                    <th class="p-2 border">Título</th>
                    <th class="p-2 border">Precio</th>
                    <th class="p-2 border">Stock</th>
                    <th class="p-2 border text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $pdo->query("SELECT * FROM productos");
                while ($row = $stmt->fetch()):
                ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="p-2 border"><?php echo $row['id']; ?></td>
                    <td class="p-2 border">
                        <img src="img/<?php echo $row['imagen']; ?>" class="w-12 h-16 object-cover rounded shadow-sm border">
                    </td>
                    <td class="p-2 border font-medium"><?php echo $row['nombre']; ?></td>
                    <td class="p-2 border text-green-600 font-bold">$<?php echo $row['precio']; ?></td>
                    <td class="p-2 border"><?php echo $row['stock']; ?> uds</td>
                    <td class="p-2 border text-center">
                        <div class="flex justify-center gap-3">
                            <a href="editar.php?id=<?php echo $row['id']; ?>" class="bg-yellow-500 text-white px-3 py-1 rounded text-sm font-bold hover:bg-yellow-600">Editar</a>
                            <a href="eliminar.php?id=<?php echo $row['id']; ?>" class="bg-red-500 text-white px-3 py-1 rounded text-sm font-bold hover:bg-red-600" onclick="return confirm('¿Borrar este libro?')">Eliminar</a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        
        <div class="mt-6">
            <a href="index.php" class="text-blue-600 underline">← Volver a la tienda</a>
        </div>
    </div>
</body>
</html>