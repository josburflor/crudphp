<?php
include 'conexion.php';

if ($_POST) {
    

    $nombre_img = $_FILES['foto']['name'];
    move_uploaded_file($_FILES['foto']['tmp_name'], "img/" . $nombre_img);

    
    
    $sql = "INSERT INTO productos (nombre, precio, stock, imagen, categoria) VALUES (?, ?, ?, ?, ?)";
    $pdo->prepare($sql)->execute([
        $_POST['titulo'], 
        $_POST['precio'], 
        $_POST['stock'], 
        $nombre_img,
        $_POST['categoria'] 
    ]);

    header("Location: admin.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Añadir Libro</title>
</head>
<body class="p-20 bg-gray-100">
    <form method="POST" enctype="multipart/form-data" class="max-w-sm mx-auto bg-white border p-6 rounded shadow-lg flex flex-col gap-4">
        <h2 class="text-xl font-bold mb-2 text-blue-600 border-b pb-2 text-center uppercase">Añadir Nuevo Libro</h2>
        
        <div>
            <label class="block text-sm font-bold text-gray-600 mb-1">Título</label>
            <input type="text" name="titulo" placeholder="Ej: Harry Potter" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-600 mb-1">Precio ($)</label>
            <input type="number" step="0.01" name="precio" placeholder="0.00" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-600 mb-1">Stock</label>
            <input type="number" name="stock" placeholder="Cantidad" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-600 mb-1">Categoría</label>
            <select name="categoria" class="w-full border p-2 rounded bg-white" required>
                <option value="Ficción">Ficción</option>
                <option value="Comedia">Comedia</option>
                <option value="Infantil">Infantil</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-600 mb-1">Portada del Libro</label>
            <input type="file" name="foto" class="text-sm text-gray-500" required>
        </div>

        <button class="w-full bg-blue-600 text-white py-2 rounded font-bold hover:bg-blue-700 mt-2">Guardar Libro</button>
        <a href="admin.php" class="text-center text-gray-400 text-sm underline">Cancelar y volver</a>
    </form>
</body>
</html>