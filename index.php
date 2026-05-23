<?php 
include 'conexion.php'; 

$categoria_seleccionada = isset($_GET['cat']) ? $_GET['cat'] : 'Todos';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Burgos-Libros | Tienda</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <nav class="bg-white border-b-2 border-blue-600 p-4">
    <div class="max-w-6xl mx-auto flex justify-between items-center">
      <span class="text-xl font-bold text-blue-600">BURGOS-LIBROS</span>
      <div class="flex gap-4 items-center">
        <a href="index.php" class="text-blue-600 font-bold underline">Catálogo</a>
        <a href="admin.php" class="text-gray-600 hover:text-blue-600">Admin</a>
      </div>
    </div>
  </nav>

  <div class="bg-blue-50 border-b border-blue-200 py-3">
    <div class="max-w-6xl mx-auto flex justify-center gap-6 font-semibold text-sm">
      <a href="index.php?cat=Todos" class="<?php echo ($categoria_seleccionada == 'Todos') ? 'text-blue-600 underline' : 'text-gray-600 hover:text-blue-600'; ?>">Todos</a>
      <a href="index.php?cat=Ficción" class="<?php echo ($categoria_seleccionada == 'Ficción') ? 'text-blue-600 underline' : 'text-gray-600 hover:text-blue-600'; ?>">Ficción</a>
      <a href="index.php?cat=Comedia" class="<?php echo ($categoria_seleccionada == 'Comedia') ? 'text-blue-600 underline' : 'text-gray-600 hover:text-blue-600'; ?>">Comedia</a>
      <a href="index.php?cat=Infantil" class="<?php echo ($categoria_seleccionada == 'Infantil') ? 'text-blue-600 underline' : 'text-gray-600 hover:text-blue-600'; ?>">Infantil</a>
    </div>
  </div>

  <header class="relative bg-slate-700 text-white py-24 overflow-hidden">
    <img src="img/principalbiblioteca.avif" alt="Biblioteca Digital" class="absolute inset-0 w-full h-full object-cover opacity-30" />
    <div class="mx-auto px-4 text-center relative z-10">
      <h1 class="text-5xl font-bold mb-5">LA LECTURA ES PRIMERO</h1>
      <p class="text-blue-500 text-2xl">Vendemos Experiencias para las Futuras Generaciones.</p>
    </div>
  </header>

  <main class="max-w-6xl mx-auto px-4 py-12">
    <h2 class="text-2xl font-bold mb-8 border-b pb-2">
      Libros de: <span class="text-blue-600 italic"><?php echo htmlspecialchars($categoria_seleccionada); ?></span>
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      
      <?php
      
      if ($categoria_seleccionada == 'Todos') {
          $stmt = $pdo->query("SELECT * FROM productos");
      } else {
          $stmt = $pdo->prepare("SELECT * FROM productos WHERE categoria = ?");
          $stmt->execute([$categoria_seleccionada]);
      }

      while ($row = $stmt->fetch()):
          $hayStock = $row['stock'] > 0;
      ?>

      <div class="flex flex-col rounded-2xl shadow-lg overflow-hidden border transition-all 
        <?php echo $hayStock ? 'bg-white border-gray-100 hover:shadow-2xl hover:-translate-y-2' : 'bg-gray-200 border-gray-300 opacity-70'; ?>">
        
        <div class="relative">
          <img src="img/<?php echo $row['imagen']; ?>" alt="Libro" class="w-full h-48 object-cover <?php echo !$hayStock ? 'grayscale' : ''; ?>">
          <?php if (!$hayStock): ?>
            <span class="absolute top-2 right-2 bg-red-600 text-white text-xs px-2 py-1 font-bold">AGOTADO</span>
          <?php endif; ?>
        </div>

        <div class="p-4 text-center flex-grow flex flex-col justify-between">
          <div>
            <h3 class="font-bold <?php echo $hayStock ? 'text-gray-800' : 'text-gray-500'; ?>">
              <?php echo htmlspecialchars($row['nombre']); ?>
            </h3>
            <p class="<?php echo $hayStock ? 'text-green-600' : 'text-gray-400'; ?> font-bold text-xl my-2">
              $<?php echo $row['precio']; ?>
            </p>
          </div>

          <?php if ($hayStock): ?>
            <button class="w-full bg-blue-600 text-white py-2 font-bold rounded hover:bg-blue-700">Comprar</button>
          <?php else: ?>
            <button disabled class="w-full bg-gray-400 text-white py-2 font-bold rounded cursor-not-allowed">Sin Stock</button>
          <?php endif; ?>
        </div>
      </div>

      <?php endwhile; ?>

    </div>
  </main>

  <footer class="bg-gray-800 text-white py-6 mt-10">
    <div class="text-center text-sm text-gray-400">
      &copy; 2026 Burgos-Libros - Proyecto de Clase
    </div>
  </footer>

</body>
</html>