<?php
require_once 'config/parameters.php';
require_once 'config/conexion.php';
session_start();

//Funcion para obtener los libros por categoria
function obtenerLibrosPorCategoria($conexion, $categoriaNombre) {
    $sql = "SELECT l.* FROM libros l 
            JOIN categorias c ON l.id_categoria = c.id_categoria 
            WHERE c.nombre_categoria = '$categoriaNombre'";
    return $conexion->query($sql);
}

if (isset($_SESSION['id_usuario'])) {
    require_once 'views/header.php';
} else {
    require_once 'views/header_publico.php';
}
?>
<main class="Contenedor principal">
    <div class="Conthcc" style="margin-top: 60px;">
      <h1 style="margin-top: -20px; font-size: clamp(1.5rem, 3.5vw, 2.5rem); white-space: nowrap;">Bienvenido a la biblioteca digital</h1>
    </div>

    <div class="Conthtl" style="padding: 20px 80px; gap: 40px;">
      <div style="flex: 1;">
        <h3 style="margin-top: 130px;">¿Quienes somos?</h3>
        <p style="font-size: 1.2rem; line-height: 1.6; font-weight: bold;">
          Explora un universo de historias y aprendizaje a un solo clic. Nuestra plataforma conecta a lectores y 
          estudiantes con miles de títulos digitales, permitiendo una gestión de préstamos ágil y una búsqueda inteligente. 
        </p>
      </div>

      <div style="flex: 1; text-align: right; margin-top: 50px;">
        <img src="assets/images/somos.jpg" alt="Edificio" class="Brd20" style="width: 100%; max-width: 650px; height: auto;">
      </div>
    </div>

    <div id="catalogo" style="padding: 40px 80px;">
      <div class="Conthcc">
        <h2 style="margin-bottom: 30px; white-space: nowrap; font-size: clamp(1.2rem, 3.5vw, 1.8rem); text-align: center; width: 100%;">¿Que quieres leer?</h2>
      </div>

      <div class="Conthcj" style="gap: 10px;">
      <?php
      $res_cats = $conexion->query("SELECT * FROM categorias");
      $iconos = [
        'Terror' => '🌑',
        'Acción' => '💥',
        'Aventura' => '🧭',
        'Ficción' => '🎭'
      ];

      while($cat = $res_cats->fetch_assoc()):
          $nombre = $cat['nombre_categoria'];
          $id_ancla = 'cat-' . strtolower(str_replace(['ó', 'á', 'é', 'í', 'ú'], ['o', 'a', 'e', 'i', 'u'], $nombre));
          $icono = isset($iconos[$nombre]) ? $iconos[$nombre] : '📚';
        ?>
        <div class="Contvcc Brd20 Smbr1" style="flex: 1; background-color: #ffffff56; padding: 20px;">
          <div style="font-size: 2rem; margin-bottom: 10px;"><?= $icono ?></div>
          <h4><?= $nombre ?></h4>
          <p><?= $cat['descripcion'] ?></p>
          <a href="javascript:void(0)" onclick="document.getElementById('<?= $id_ancla ?>').scrollIntoView({behavior: 'smooth'})" class="clic" style="font-weight: bold; margin-top: 10px;">Explorar →</a>
        </div>
      <?php endwhile; ?>
      </div>
    </div>
    <div style="padding: 40px 80px;">
      <h3 id="cat-terror">Terror</h3>
        <div class="Conthcl Brd20 Smbr2" style="background: #fff; padding: 10px; margin-bottom: 40px; position: relative; display: flex; align-items: center; overflow: hidden; flex-direction: row !important;">
            <button class="Bt2" onclick="document.getElementById('terror-scroll').scrollBy({left: -350, behavior: 'smooth'})" style="border-radius: 50%; width: 40px; height: 40px; position: absolute; left: 10px; z-index: 10; flex-shrink: 0;">❮</button>

            <div id="terror-scroll" style="display: flex; overflow-x: hidden; scroll-behavior: smooth; gap: 20px; padding: 10px 60px; width: 100%;">
              <?php 
              $librosTerror = obtenerLibrosPorCategoria($conexion, 'Terror');
              if ($librosTerror && $librosTerror->num_rows > 0):
                  while($libro = $librosTerror->fetch_assoc()): 
              ?>
                  <div class="product" style="min-width: 200px; height: 300px; flex-shrink: 0; background: #f4f4f4; border-radius: 15px; overflow: hidden;">
                    <?php if (isset($_SESSION['id_usuario'])): ?>
                        <a href="libros.php?id=<?=$libro['id_libro']?>">
                            <img src="assets/images/caratula/terror/<?=$libro['portada_url']?>" class="Brd15" style="width: 100%; height: 100%; object-fit: contain;">
                        </a>
                    <?php else: ?>
                        <a href="login.php" onclick="alert('Debes iniciar sesión para ver los detalles del libro')">
                            <img src="assets/images/caratula/terror/<?=$libro['portada_url']?>" class="Brd15" style="width: 100%; height: 100%; object-fit: contain;">
                        </a>
                    <?php endif; ?>
                  </div>
              <?php 
                  endwhile; 
              else:
                  echo "<p style='padding: 20px;'>Próximamente más títulos de Terror...</p>";
              endif; 
              ?>
            </div>

            <button class="Bt2" onclick="document.getElementById('terror-scroll').scrollBy({left: 350, behavior: 'smooth'})" style="border-radius: 50%; width: 40px; height: 40px; position: absolute; right: 10px; z-index: 10; flex-shrink: 0;">❯</button>
        </div>
        <h3 id="cat-accion">Acción</h3>
        <div class="Conthcl Brd20 Smbr2" style="background: #fff; padding: 10px; margin-bottom: 40px; position: relative; display: flex; align-items: center; overflow: hidden; flex-direction: row !important;">
            <button class="Bt2" onclick="document.getElementById('accion-scroll').scrollBy({left: -350, behavior: 'smooth'})" style="border-radius: 50%; width: 40px; height: 40px; position: absolute; left: 10px; z-index: 10; flex-shrink: 0;">❮</button>

            <div id="accion-scroll" style="display: flex; overflow-x: hidden; scroll-behavior: smooth; gap: 20px; padding: 10px 60px; width: 100%;">
              <?php 
              $librosAccion = obtenerLibrosPorCategoria($conexion, 'Accion');
              if ($librosAccion && $librosAccion->num_rows > 0):
                  while($libro = $librosAccion->fetch_assoc()): 
              ?>
                  <div class="product" style="min-width: 200px; height: 300px; flex-shrink: 0; background: #f4f4f4; border-radius: 15px; overflow: hidden;">
                    <?php if (isset($_SESSION['id_usuario'])): ?>
                        <a href="libros.php?id=<?=$libro['id_libro']?>">
                            <img src="assets/images/caratula/accion/<?=$libro['portada_url']?>" class="Brd15" style="width: 100%; height: 100%; object-fit: contain;">
                        </a>
                    <?php else: ?>
                        <a href="login.php" onclick="alert('Debes iniciar sesión para ver los detalles del libro')">
                            <img src="assets/images/caratula/accion/<?=$libro['portada_url']?>" class="Brd15" style="width: 100%; height: 100%; object-fit: contain;">
                        </a>
                    <?php endif; ?>
                  </div>
              <?php 
                  endwhile; 
              else:
                  echo "<p style='padding: 20px;'>Próximamente más títulos de Acción...</p>";
              endif; 
              ?>
            </div>

            <button class="Bt2" onclick="document.getElementById('accion-scroll').scrollBy({left: 350, behavior: 'smooth'})" style="border-radius: 50%; width: 40px; height: 40px; position: absolute; right: 10px; z-index: 10; flex-shrink: 0;">❯</button>
        </div>
        <h3 id="cat-aventura">Aventura</h3>
        <div class="Conthcl Brd20 Smbr2" style="background: #fff; padding: 10px; margin-bottom: 40px; position: relative; display: flex; align-items: center; overflow: hidden; flex-direction: row !important;">
            <button class="Bt2" onclick="document.getElementById('aventura-scroll').scrollBy({left: -350, behavior: 'smooth'})" style="border-radius: 50%; width: 40px; height: 40px; position: absolute; left: 10px; z-index: 10; flex-shrink: 0;">❮</button>

            <div id="aventura-scroll" style="display: flex; overflow-x: hidden; scroll-behavior: smooth; gap: 20px; padding: 10px 60px; width: 100%;">
              <?php 
              $librosAventura = obtenerLibrosPorCategoria($conexion, 'Aventura');
              if ($librosAventura && $librosAventura->num_rows > 0):
                  while($libro = $librosAventura->fetch_assoc()): 
              ?>
                  <div class="product" style="min-width: 200px; height: 300px; flex-shrink: 0; background: #f4f4f4; border-radius: 15px; overflow: hidden;">
                    <?php if (isset($_SESSION['id_usuario'])): ?>
                        <a href="libros.php?id=<?=$libro['id_libro']?>">
                            <img src="assets/images/caratula/aventura/<?=$libro['portada_url']?>" class="Brd15" style="width: 100%; height: 100%; object-fit: contain;">
                        </a>
                    <?php else: ?>
                        <a href="login.php" onclick="alert('Debes iniciar sesión para ver los detalles del libro')">
                            <img src="assets/images/caratula/aventura/<?=$libro['portada_url']?>" class="Brd15" style="width: 100%; height: 100%; object-fit: contain;">
                        </a>
                    <?php endif; ?>
                  </div>
              <?php 
                  endwhile; 
              else:
                  echo "<p style='padding: 20px;'>Próximamente más títulos de Aventura...</p>";
              endif; 
              ?>
            </div>

            <button class="Bt2" onclick="document.getElementById('aventura-scroll').scrollBy({left: 350, behavior: 'smooth'})" style="border-radius: 50%; width: 40px; height: 40px; position: absolute; right: 10px; z-index: 10; flex-shrink: 0;">❯</button>
        </div>
        <h3 id="cat-ficcion">Ficción</h3>
        <div class="Conthcl Brd20 Smbr2" style="background: #fff; padding: 10px; margin-bottom: 40px; position: relative; display: flex; align-items: center; overflow: hidden; flex-direction: row !important;">
            <button class="Bt2" onclick="document.getElementById('ficcion-scroll').scrollBy({left: -350, behavior: 'smooth'})" style="border-radius: 50%; width: 40px; height: 40px; position: absolute; left: 10px; z-index: 10; flex-shrink: 0;">❮</button>

            <div id="ficcion-scroll" style="display: flex; overflow-x: hidden; scroll-behavior: smooth; gap: 20px; padding: 10px 60px; width: 100%;">
              <?php 
              $librosFiccion = obtenerLibrosPorCategoria($conexion, 'Ficcion');
              if ($librosFiccion && $librosFiccion->num_rows > 0):
                  while($libro = $librosFiccion->fetch_assoc()): 
              ?>
                  <div class="product" style="min-width: 200px; height: 300px; flex-shrink: 0; background: #f4f4f4; border-radius: 15px; overflow: hidden;">
                    <?php if (isset($_SESSION['id_usuario'])): ?>
                        <a href="libros.php?id=<?=$libro['id_libro']?>">
                            <img src="assets/images/caratula/ficcion/<?=$libro['portada_url']?>" class="Brd15" style="width: 100%; height: 100%; object-fit: contain;">
                        </a>
                    <?php else: ?>
                        <a href="login.php" onclick="alert('Debes iniciar sesión para ver los detalles del libro')">
                            <img src="assets/images/caratula/ficcion/<?=$libro['portada_url']?>" class="Brd15" style="width: 100%; height: 100%; object-fit: contain;">
                        </a>
                    <?php endif; ?>
                  </div>
              <?php 
                  endwhile; 
              else:
                  echo "<p style='padding: 20px;'>Próximamente más títulos de Ficción...</p>";
              endif; 
              ?>
            </div>

            <button class="Bt2" onclick="document.getElementById('ficcion-scroll').scrollBy({left: 350, behavior: 'smooth'})" style="border-radius: 50%; width: 40px; height: 40px; position: absolute; right: 10px; z-index: 10; flex-shrink: 0;">❯</button>
        </div>
    </div>
</main>
<?php require_once 'views/footer.php'; ?>