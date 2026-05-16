<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

require_once 'config/parameters.php';
require_once 'config/conexion.php';

$id_libro = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$id_usuario_sesion = $_SESSION['id_usuario'];

//Aqui se consulta el libro y su autor
$sql = "SELECT l.*, c.nombre_categoria, GROUP_CONCAT(a.nombre_autor SEPARATOR ', ') AS nombre_autor 
        FROM libros l 
        JOIN categorias c ON l.id_categoria = c.id_categoria 
        LEFT JOIN libros_autor la ON l.id_libro = la.id_libro 
        LEFT JOIN autores a ON la.id_autor = a.id_autor 
        WHERE l.id_libro = $id_libro
        GROUP BY l.id_libro";

$resultado = $conexion->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    $libro = $resultado->fetch_assoc();
    $cat_folder = strtolower(str_replace(['ó', 'á', 'é', 'í', 'ú'], ['o', 'a', 'e', 'i', 'u'], $libro['nombre_categoria']));
} else {
    echo "<h1>El libro no existe.</h1><a href='index.php'>Volver al catálogo</a>";
    exit();
}

// Verifica si el usuario ya hizo una reseña
$sql_check = "SELECT * FROM resenas WHERE id_libro = $id_libro AND id_usuario = $id_usuario_sesion";
$res_check = $conexion->query($sql_check);
$ya_hizo_resena = ($res_check && $res_check->num_rows > 0);
$datos_resena_propia = $ya_hizo_resena ? $res_check->fetch_assoc() : null;

require_once 'views/header.php';
?>
<style>
    .libro-detalle-contenedor {
        display: flex;
        gap: 40px;
        margin-top: 70px; /* Separacion desde el menu superior */
        margin-bottom: 50px;
        padding: 0 10px; /* Reducido para que la columna izquierda este mas a la izquierda en PC */
        align-items: flex-start;
    }
    .libro-columna-izquierda {
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 20px;
        align-items: center;
    }
    .libro-columna-derecha {
        flex: 1;
        padding: 30px;
        margin-top: 0 !important;
        margin-right: 40px;
        box-sizing: border-box;
    }
    .libro-botones {
        display: flex;
        flex-direction: column; /*Apilados en PC: descargar arriba, leer abajo. */
        gap: 15px;
        width: 100%;
        align-items: center;
    }
    .libro-botones a {
        width: 100%;
        max-width: 250px; /*Mismo ancho de la portada*/
        text-decoration: none;
        text-align: center;
    }
    
    @media (max-width: 850px) {
        .libro-detalle-contenedor {
            flex-direction: column;
            align-items: center;
            padding: 0 20px;
            margin-top: 40px;
        }
        .libro-columna-izquierda {
            align-items: center;
            text-align: center;
            width: 100%;
        }
        .libro-columna-derecha {
            margin-top: 20px !important;
            margin-right: 0 !important;
            width: 90%; /*Disminuye el ancho para que no desborde en movil */
        }
        .libro-columna-izquierda img {
            margin: 0 auto !important;
            width: 80% !important;
            max-width: 250px !important;
        }
        .libro-columna-izquierda h3 {
            margin-left: 0 !important;
            margin-top: 10px !important;
        }
        .libro-botones {
            flex-direction: row; /* Mantiene la posicion de los botones en movil */
            justify-content: center;
            flex-wrap: wrap;
        }
        .libro-botones a {
            max-width: none;
            width: 45%;
            min-width: 160px;
        }
    }
</style>

<section class="libro-detalle-contenedor">
    <div class="libro-columna-izquierda">
        <img src="assets/images/caratula/<?= htmlspecialchars($cat_folder, ENT_QUOTES, 'UTF-8') ?>/<?= htmlspecialchars($libro['portada_url'], ENT_QUOTES, 'UTF-8') ?>" alt="<?= htmlspecialchars($libro['titulo'], ENT_QUOTES, 'UTF-8') ?>" class="Brd20 Smbr2" style="width: 100%; max-width: 250px; height: auto;">
        
        <h3 class="Txtitle20" style="text-shadow: none; font-size: 30px; margin-bottom: 0px;"><?= htmlspecialchars($libro['titulo'], ENT_QUOTES, 'UTF-8') ?></h3>
        
        <h4 style="color: #555; font-size: 1.2rem; margin-top: 5px; margin-bottom: 15px; font-weight: normal;">
            <?= !empty($libro['nombre_autor']) ? htmlspecialchars($libro['nombre_autor'], ENT_QUOTES, 'UTF-8') : 'Autor desconocido' ?>
        </h4>
        
        <div class="libro-botones">
            <a href="assets/pdfs/<?= htmlspecialchars($libro['archivo_pdf'], ENT_QUOTES, 'UTF-8') ?>" download class="Bt1" style="text-decoration:none; text-align:center;">📥 Descargar</a>
            <a href="assets/pdfs/<?= htmlspecialchars($libro['archivo_pdf'], ENT_QUOTES, 'UTF-8') ?>" target="_blank" class="Bt1" style="text-decoration:none; text-align:center;">📖 Leer en Línea</a>
        </div>
    </div>

    <div class="Contvtl Brd20 synopsis-box libro-columna-derecha" style="background: #fff;">
        <h3>Sinopsis</h3>
        <p style="font-size: 1.1rem; line-height: 1.6; font-weight: bold; color: #4b4b4b; margin-top: 15px;">
            <?= htmlspecialchars($libro['sinopsis'], ENT_QUOTES, 'UTF-8') ?>
        </p>
    </div>
</section>

<hr style="border-top: 1px solid #ddd; margin-bottom: 50px;">

<section class="Contvcc" style="margin-bottom: 50px; text-align: center;">
    <?php if (!$ya_hizo_resena): ?>
        <h3>¡Danos tu opinión!</h3>
        <form action="backend/guardar_resena.php" method="POST">
            <input type="hidden" name="id_libro" value="<?= htmlspecialchars($id_libro, ENT_QUOTES, 'UTF-8') ?>">
            <div class="star-rating clic">
                <input type="radio" name="rating" id="star1" value="5" onclick="toggleReviewForm()"><label for="star1">&#9733;</label>
                <input type="radio" name="rating" id="star2" value="4" onclick="toggleReviewForm()"><label for="star2">&#9733;</label>
                <input type="radio" name="rating" id="star3" value="3" onclick="toggleReviewForm()"><label for="star3">&#9733;</label>
                <input type="radio" name="rating" id="star4" value="2" onclick="toggleReviewForm()"><label for="star4">&#9733;</label>
                <input type="radio" name="rating" id="star5" value="1" onclick="toggleReviewForm()"><label for="star5">&#9733;</label>
            </div>

            <div id="review-textarea-block" class="Contvtl Brd20 synopsis-box" style="padding: 20px; display: none; width: 600px; margin: 0 auto;">
                <label for="user-review-text" style="font-size: 14px;">Cuéntanos más...</label>
                <textarea id="user-review-text" name="comentario" rows="5" class="Brd15" placeholder="Escribe tu reseña aquí..." onkeyup="validateReviewContent()" style="width: 100%; padding: 10px; margin-top: 10px; border: 1px solid #bababa; resize: none;"></textarea>
                <button type="submit" id="send-review-btn" class="Bt4b" style="margin-top: 15px;" disabled>Enviar Reseña</button>
            </div>
        </form>
    <?php else: ?>
        <h3>Ya has calificado este libro</h3>
        <p style="color: #777; margin-bottom: 15px;">¿Quieres cambiar algo?</p>
        <button class="Bt4b" onclick="prepararEdicion(<?= htmlspecialchars($datos_resena_propia['id_resena'], ENT_QUOTES, 'UTF-8') ?>, <?= htmlspecialchars($datos_resena_propia['calificacion'], ENT_QUOTES, 'UTF-8') ?>, '<?= htmlspecialchars(addslashes(str_replace(["\r", "\n"], ' ', $datos_resena_propia['comentario'])), ENT_QUOTES, 'UTF-8') ?>')">
            Editar mi reseña
        </button>
    <?php endif; ?>
</section>

<div id="modalOverlay" class="modal-overlay" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000; justify-content: center; align-items: center;">
    <div id="modalEditarResena" class="modal-content Frm2" style="display:none;">
        <form action="backend/procesar_cuenta.php" method="POST" class="Contvcc" style="gap: 10px; width: 100%;">
            <input type="hidden" name="id_resena_edit" id="id_resena_edit">
            <input type="hidden" name="redirect_to_libro" value="<?= htmlspecialchars($id_libro, ENT_QUOTES, 'UTF-8') ?>">
            
            <h7>Calificación</h7>
            <div class="star-rating">
                <input type="radio" id="edit_star5" name="rating" value="5"><label for="edit_star5">★</label>
                <input type="radio" id="edit_star4" name="rating" value="4"><label for="edit_star4">★</label>
                <input type="radio" id="edit_star3" name="rating" value="3"><label for="edit_star3">★</label>
                <input type="radio" id="edit_star2" name="rating" value="2"><label for="edit_star2">★</label>
                <input type="radio" id="edit_star1" name="rating" value="1"><label for="edit_star1">★</label>
            </div>
            <label>Edita tu reseña</label>
            <textarea name="resena_texto_edit" id="resena_texto_edit" rows="6" style="width: 95%; padding: 10px; border: 2px solid #000; border-radius: 10px; resize: none;"></textarea>
            <div class="Conthcc" style="gap: 10px; margin-top: 15px;">
                <button type="submit" class="Bt4b">Aceptar</button>
                <button type="button" class="Bt4r" onclick="closeModals()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<hr style="border-top: 1px solid #ddd; margin-bottom: 50px;">

<section class="Contvtl" style="gap: 25px; margin-bottom: 50px; padding: 0 80px;">
    <h3 style="margin-bottom: 20px;">Reseñas de la comunidad</h3>
    <?php
    $sql_resenas = "SELECT r.*, u.nombre, u.avatar_url 
                    FROM resenas r 
                    JOIN usuarios u ON r.id_usuario = u.id_usuario 
                    WHERE r.id_libro = $id_libro 
                    ORDER BY r.id_resena DESC";
    $res_resenas = $conexion->query($sql_resenas);

    if ($res_resenas && $res_resenas->num_rows > 0):
        while($resena = $res_resenas->fetch_assoc()):
            $estrellas = str_repeat('⭐', $resena['calificacion']);
    ?>
        <div style="display: flex; align-items: flex-start; gap: 20px; margin-bottom: 30px;">
            <img src="<?= htmlspecialchars($resena['avatar_url'], ENT_QUOTES, 'UTF-8') ?>" alt="Usuario" class="user-profile-pic" style="flex-shrink: 0; width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
            <div class="user-review-box Brd20 Smbr2" style="padding: 25px; background: #fff; border: 1px solid #eee; width: fit-content; max-width: 650px;">
                <h4 style="margin: 0 0 10px 0; display: flex; align-items: center; gap: 15px;">
                    <?= htmlspecialchars($resena['nombre'], ENT_QUOTES, 'UTF-8') ?> <span style="font-size: 14px; color: #777;"><?= htmlspecialchars($estrellas, ENT_QUOTES, 'UTF-8') ?></span>
                </h4>
                <p style="font-size: 14px; color: #4b4b4b; margin: 0; line-height: 1.6;">
                    <?= htmlspecialchars($resena['comentario'], ENT_QUOTES, 'UTF-8') ?>
                </p>
            </div>
        </div>
    <?php endwhile; else: ?>
        <p>Aún no hay reseñas para este libro. ¡Sé el primero en opinar!</p>
    <?php endif; ?>
</section>

<script>
    function openModal(modalId) {
        document.getElementById('modalOverlay').style.display = 'flex';
        document.getElementById(modalId).style.display = 'flex';
    }

    function closeModals() {
        document.getElementById('modalOverlay').style.display = 'none';
        document.getElementById('modalEditarResena').style.display = 'none';
    }

    function prepararEdicion(id, rating, comentario) {
        document.getElementById('id_resena_edit').value = id;
        document.getElementById('resena_texto_edit').value = comentario;
        const star = document.getElementById('edit_star' + rating);
        if(star) star.checked = true;
        openModal('modalEditarResena');
    }

    function toggleReviewForm() {
        document.getElementById('review-textarea-block').style.display = 'block';
    }

    function validateReviewContent() {
        const txt = document.getElementById('user-review-text').value.trim();
        document.getElementById('send-review-btn').disabled = (txt.length === 0);
    }

    window.onclick = function(event) {
        if (event.target == document.getElementById('modalOverlay')) closeModals();
    }
</script>

<?php require_once 'views/footer.php'; ?>