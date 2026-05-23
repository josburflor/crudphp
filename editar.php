<?php
include 'conexion.php';


$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ?");
$stmt->execute([$id]);
$libro = $stmt->fetch();


if ($_POST) {
    $titulo    = $_POST['titulo'];
    $precio    = $_POST['precio'];
    $stock     = $_POST['stock'];
    $categoria = $_POST['categoria']; 
    $id        = $_POST['id'];

    
    if (!empty($_FILES['foto']['name'])) {
        $nombre_img = $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "img/" . $nombre_img);
        
        $sql = "UPDATE productos SET nombre = ?, precio = ?, stock = ?, imagen = ?, categoria = ? WHERE id = ?";
        $pdo->prepare($sql)->execute([$titulo, $precio, $stock, $nombre_img, $categoria, $id]);
    } else {
        
    
        $sql = "UPDATE productos SET nombre = ?, precio = ?, stock = ?, categoria = ? WHERE id = ?";
        $pdo->prepare($sql)->execute([$titulo, $precio, $stock, $categoria, $id]);
    }

    header("Location: admin.php");
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Editar Libro</title>
</head>
<body class="p-10 bg-gray-100 min-h-screen flex items-center justify-center">
    <form method="POST" enctype="multipart/form-data" class="w-full max-w-md bg-white border p-6 rounded-xl shadow-lg flex flex-col gap-4">
        <h2 class="text-xl font-bold text-gray-800 border-b pb-2 text-center uppercase">Editar Datos del Libro</h2>
        
        <input type="hidden" name="id" value="<?php echo $libro['id']; ?>">

        <div>
            <label class="block text-sm font-bold text-gray-600 mb-1">Título del Libro</label>
            <input type="text" name="titulo" value="<?php echo htmlspecialchars($libro['nombre']); ?>" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-600 mb-1">Precio ($)</label>
            <input type="number" step="0.01" name="precio" value="<?php echo $libro['precio']; ?>" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-600 mb-1">Stock Disponible</label>
            <input type="number" name="stock" value="<?php echo $libro['stock']; ?>" class="w-full border p-2 rounded" required>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-600 mb-1">Categoría</label>
            <select name="categoria" class="w-full border p-2 rounded bg-white" required>
                <option value="Ficción" <?php echo ($libro['categoria'] == 'Ficción') ? 'selected' : ''; ?>>Ficción</option>
                <option value="Comedia" <?php echo ($libro['categoria'] == 'Comedia') ? 'selected' : ''; ?>>Comedia</option>
                <option value="Infantil" <?php echo ($libro['categoria'] == 'Infantil') ? 'selected' : ''; ?>>Infantil</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-600 mb-1">Portada Actual</label>
            <img src="img/<?php echo $libro['imagen']; ?>" class="w-16 h-24 object-cover mb-2 rounded border shadow-sm">
            <input type="file" name="foto" class="text-xs text-gray-500">
            <p class="text-[10px] text-gray-400 mt-1">* Deja vacío para mantener la imagen actual.</p>
        </div>

        <div class="flex gap-2 pt-2">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded font-bold hover:bg-blue-700">Guardar Cambios</button>
            <a href="admin.php" class="w-full bg-gray-200 text-gray-700 py-2 rounded font-bold text-center hover:bg-gray-300">Cancelar</a>
        </div>
    </form>
</body>
</html>