<?php
session_start();
require_once 'config/parameters.php'; 
require_once 'config/conexion.php'; 

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

require_once 'views/header.php';

$id_user = $_SESSION['id_usuario'];
$res_user = $conexion->query("SELECT * FROM usuarios WHERE id_usuario = $id_user");
$user_data = $res_user->fetch_assoc();
?>

<section style="padding: 20px 80px; background-color: #fcfcfc;">
    <a href="<?=base_url?>index.php" class="Bt4b" style="text-decoration: none; display: inline-block; line-height: 40px; padding: 0 20px; border-radius: 5px;">← Volver al Inicio</a>
</section>

<section class="Conthcl" style="gap: 50px; padding: 20px 80px 40px 80px; background-color: #fcfcfc; flex-direction: row !important; flex-wrap: wrap;">
    
    <?php if (isset($_GET['error'])): ?>
        <div style="width: 100%; margin-bottom: 20px;">
            <p style="color: #ff4d4d; background: #ffe6e6; padding: 10px; border-radius: 5px; font-size: 14px; text-align: center; margin: 0 auto; max-width: 600px;">
                <?php 
                    if ($_GET['error'] == 'same_email') {
                        echo 'El nuevo correo no puede ser igual al actual.';
                    } elseif ($_GET['error'] == 'same_password') {
                        echo 'La nueva contraseña no puede ser igual a la actual.';
                    } elseif ($_GET['error'] == 'email_mismatch') {
                        echo 'Los correos electrónicos no coinciden.';
                    } elseif ($_GET['error'] == 'pass_mismatch') {
                        echo 'Las contraseñas no coinciden.';
                    } elseif ($_GET['error'] == 'wrong_current_pass') {
                        echo 'La contraseña actual es incorrecta.';
                    } elseif ($_GET['error'] == 'same_name') {
                        echo 'El nombre de usuario es el mismo actual.';
                    } elseif ($_GET['error'] == 'upload') {
                        echo 'Error al subir la imagen.';
                    } elseif ($_GET['error'] == 'email_exists') {
                        echo 'El correo electronico que tratas de usar ya esta en uso.';
                    }
                ?>
            </p>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div style="width: 100%; margin-bottom: 20px;">
            <p style="color: #28a745; background: #e6ffe6; padding: 10px; border-radius: 5px; font-size: 14px; text-align: center; margin: 0 auto; max-width: 600px;">
                <?php 
                    if ($_GET['success'] == 'correo' || $_GET['success'] == 'password') {
                        echo 'Datos actualizados exitosamente. Por favor, vuelve a iniciar sesión.';
                    } elseif ($_GET['success'] == 'nombre') {
                        echo 'Nombre actualizado correctamente.';
                    } elseif ($_GET['success'] == 'avatar') {
                        echo 'Avatar actualizado correctamente.';
                    } elseif ($_GET['success'] == 'edit') {
                        echo 'Reseña editada correctamente.';
                    }
                ?>
            </p>
        </div>
    <?php endif; ?>

    <div class="Contvtc" style="gap: 15px;">
        <img src="<?= htmlspecialchars($user_data['avatar_url'], ENT_QUOTES, 'UTF-8'); ?>" alt="Avatar" class="user-profile-pic" style="width: 150px; height: 150px; border: 4px solid #a180f5; border-radius: 50%; object-fit: cover;">
        
        <form action="backend/procesar_cuenta.php" method="POST" enctype="multipart/form-data" id="formAvatar">
            <input type="file" name="nuevo_avatar" id="inputAvatar" style="display: none;" onchange="document.getElementById('formAvatar').submit();">
            <button type="button" class="Bt2" style="width: 120px;" onclick="document.getElementById('inputAvatar').click();">Cambiar avatar</button>
        </form>
        
        <div class="Contvcc" style="margin-top: 10px;">
            <h4 style="margin: 0;"><?= htmlspecialchars($user_data['nombre'], ENT_QUOTES, 'UTF-8'); ?></h4>
            <p style="color: #777;"><?= htmlspecialchars($user_data['correo'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    </div>

    <div class="Contvtl" style="gap: 15px; justify-content: center;">
        <button class="Bt4b" onclick="openModal('modalNombre')" style="width: 250px;">Cambiar nombre de usuario</button>
        <button class="Bt4b" onclick="openModal('modalCorreo')" style="width: 250px;">Cambiar correo electrónico</button>
        <button class="Bt4b" onclick="openModal('modalPass')" style="width: 250px;">Cambiar contraseña</button>
        <button class="Bt4b" onclick="openModal('modalDelete')" style="width: 250px;">Eliminar cuenta</button>
    </div>
</section>

<hr style="border: 0; border-top: 2px solid #eee; margin: 0 80px;">

<section class="Contvtl" style="gap: 25px; margin-top: 30px; margin-bottom: 50px; padding: 0 80px;">
    <h3>Mis Reseñas</h3>

    <?php
    $sql_res = "SELECT r.*, l.titulo FROM resenas r JOIN libros l ON r.id_libro = l.id_libro WHERE r.id_usuario = $id_user ORDER BY r.id_resena DESC";
    $res_resenas = $conexion->query($sql_res);
    
    if ($res_resenas && $res_resenas->num_rows > 0):
        while($row = $res_resenas->fetch_assoc()): 
            $estrellas = str_repeat('⭐', $row['calificacion']);
            $comentario_js = addslashes(str_replace(["\r", "\n"], ' ', $row['comentario']));
    ?>
        <div class="Conthcl" style="gap: 20px; margin-bottom: 30px; width: 100%; position: relative; align-items: flex-start; flex-direction: row !important; flex-wrap: nowrap !important;">
            <img src="<?= htmlspecialchars($user_data['avatar_url'], ENT_QUOTES, 'UTF-8'); ?>" alt="Usuario" style="flex-shrink: 0; width: 60px; height: 60px; border-radius: 50%; object-fit: cover;">
            
            <div class="user-review-box Brd20 Smbr2" style="padding: 25px; background: #fff; border: 1px solid #eee; flex: 1; max-width: 1000px; position: relative; z-index: 1;">
                <h4 style="margin: 0 0 10px 0; display: flex; align-items: center; gap: 15px;">
                    <?= htmlspecialchars($row['titulo'], ENT_QUOTES, 'UTF-8'); ?> <span style="font-size: 14px; color: #FFD700;"><?= htmlspecialchars($estrellas, ENT_QUOTES, 'UTF-8'); ?></span>
                </h4>
                <p style="font-size: 14px; color: #4b4b4b; margin: 0; line-height: 1.6; padding-right: 100px;">
                    <?= htmlspecialchars($row['comentario'], ENT_QUOTES, 'UTF-8'); ?>
                </p>
                
                <div style="position: absolute; top: 15px; right: 15px; display: flex; gap: 10px; z-index: 999; pointer-events: auto;">
                    <button type="button" class="Bt2" 
                            onclick="console.log('Click editar'); prepararEdicion(<?= htmlspecialchars($row['id_resena'], ENT_QUOTES, 'UTF-8'); ?>, <?= htmlspecialchars($row['calificacion'], ENT_QUOTES, 'UTF-8'); ?>, '<?= htmlspecialchars($comentario_js, ENT_QUOTES, 'UTF-8'); ?>')" 
                            style="cursor: pointer; border: none; background: none; padding: 5px;">
                       <img src="assets/images/editarcomentario.png" style="width:20px; height:20px;" alt="E">
                    </button>
                    
                    <button type="button" class="Bt2r" 
                            onclick="console.log('Click eliminar'); prepararEliminacion(<?= htmlspecialchars($row['id_resena'], ENT_QUOTES, 'UTF-8'); ?>)" 
                            style="cursor: pointer; border: none; background: none; padding: 5px;">
                       <img src="assets/images/eliminarcomentario.png" style="width:20px; height:20px;" alt="B">
                    </button>
                </div>
            </div>
        </div>
    <?php 
        endwhile; 
    else:
        echo "<p style='color: #777;'>Aún no has escrito ninguna reseña.</p>";
    endif;
    ?>
</section>

<div id="modalOverlay" class="modal-overlay" style="display:none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 2000; justify-content: center; align-items: center;">
    
    <div id="modalNombre" class="modal-content Frm2" style="display:none;">
        <form action="backend/procesar_cuenta.php" method="POST" class="Contvcc" style="gap: 15px; width: 100%;">
            <h7>Nombre de usuario</h7>
            <input type="text" name="nuevo_nombre" placeholder="<?= htmlspecialchars($user_data['nombre'], ENT_QUOTES, 'UTF-8'); ?>" required style="width: 90%;">
            <div class="Conthcc" style="gap: 10px; display: flex !important; flex-direction: row !important; flex-wrap: nowrap !important; width: 100%; justify-content: center;">
                <button type="submit" class="Bt4b">Aceptar</button>
                <button type="button" class="Bt4r" onclick="closeModals()">Cancelar</button>
            </div>
        </form>
    </div>

    <div id="modalCorreo" class="modal-content Frm2" style="display:none;">
        <form action="backend/procesar_cuenta.php" method="POST" class="Contvcc" style="gap: 10px; width: 100%;">
            <label>Correo electrónico nuevo</label>
            <input type="email" name="email_nuevo" required style="width: 90%;">
            <label>Repite el correo electrónico</label>
            <input type="email" name="email_repita" required style="width: 90%;">
            <div class="Conthcc" style="gap: 10px; margin-top: 10px; display: flex !important; flex-direction: row !important; flex-wrap: nowrap !important; width: 100%; justify-content: center;">
                <button type="submit" class="Bt4b">Aceptar</button>
                <button type="button" class="Bt4r" onclick="closeModals()">Cancelar</button>
            </div>
        </form>
    </div>

    <div id="modalPass" class="modal-content Frm2" style="display:none;">
        <form action="backend/procesar_cuenta.php" method="POST" class="Contvcc" style="gap: 10px; width: 100%;">
            <label>Contraseña actual</label>
            <input type="password" name="pass_actual" required style="width: 90%;">
            <label>Nueva Contraseña</label>
            <input type="password" name="pass_nueva" required style="width: 90%;">
            <label>Repite la nueva contraseña</label>
            <input type="password" name="pass_repita" required style="width: 90%;">
            <div class="Conthcc" style="gap: 10px; margin-top: 10px; display: flex !important; flex-direction: row !important; flex-wrap: nowrap !important; width: 100%; justify-content: center;">
                <button type="submit" class="Bt4b">Aceptar</button>
                <button type="button" class="Bt4r" onclick="closeModals()">Cancelar</button>
            </div>
        </form>
    </div>

    <div id="modalDelete" class="modal-content Frm2" style="display:none; text-align: center;">
        <div class="Contvcc" style="gap: 20px; padding: 20px;">
            <p style="font-weight: bold; font-size: 18px;">Esta acción es irreversible</p>
            <form action="backend/procesar_cuenta.php" method="POST" id="formEliminarCuenta">
                <input type="hidden" name="accion" value="eliminar_cuenta">
                
                <label>Contraseña actual</label>
                <input type="password" name="pass_actual" id="del_pass_actual" required style="width: 90%;">
                
                <label>Repite la contraseña</label>
                <input type="password" name="pass_repita" id="del_pass_repita" required style="width: 90%;">
                
                <p id="delete-validation-error" style="color: #ff4d4d; font-size: 13px; margin: 5px 0; text-align: center;"></p>

                <div class="Conthcc" style="gap: 15px; margin-top: 15px; display: flex !important; flex-direction: row !important; flex-wrap: nowrap !important; width: 100%; justify-content: center;">
                    <button type="submit" id="btnConfirmarEliminarCuenta" class="Bt4b" style="line-height: 40px; text-align:center; border:none; cursor:pointer;" disabled>Aceptar</button>
                    <button type="button" class="Bt4r" onclick="closeModals()">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEliminar" class="modal-content Frm2" style="display:none; text-align: center;">
        <div class="Contvcc" style="gap: 20px; padding: 20px;">
            <p style="font-weight: bold; font-size: 18px;">Esta acción es irreversible</p>
            <div class="Conthcc" style="gap: 15px; display: flex !important; flex-direction: row !important; flex-wrap: nowrap !important; width: 100%; justify-content: center;">
                <a href="#" id="btnConfirmarEliminar" class="Bt4b" style="text-decoration: none; line-height: 40px; text-align:center;">Aceptar</a>
                <button class="Bt4r" onclick="closeModals()">Cancelar</button>
            </div>
        </div>
    </div>

    <div id="modalEditarResena" class="modal-content Frm2" style="display:none;">
        <form action="backend/procesar_cuenta.php" method="POST" class="Contvcc" style="gap: 10px; width: 100%;">
            <input type="hidden" name="id_resena_edit" id="id_resena_edit">
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
            <div class="Conthcc" style="gap: 10px; margin-top: 15px; display: flex !important; flex-direction: row !important; flex-wrap: nowrap !important; width: 100%; justify-content: center;">
                <button type="submit" class="Bt4b">Aceptar</button>
                <button type="button" class="Bt4r" onclick="closeModals()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(modalId) {
        const overlay = document.getElementById('modalOverlay');
        overlay.style.display = 'flex';
        
        const contents = document.querySelectorAll('.modal-content');
        contents.forEach(c => c.style.display = 'none');
        
        const target = document.getElementById(modalId);
        if (target) target.style.display = 'flex';
    }

    function closeModals() {
        document.getElementById('modalOverlay').style.display = 'none';
    }

    function prepararEliminacion(id) {
        document.getElementById('btnConfirmarEliminar').href = 'backend/eliminar_resena.php?id=' + id;
        openModal('modalEliminar');
    }

    function prepararEdicion(id, rating, comentario) {
        document.getElementById('id_resena_edit').value = id;
        document.getElementById('resena_texto_edit').value = comentario;
        const star = document.getElementById('edit_star' + rating);
        if(star) star.checked = true;
        openModal('modalEditarResena');
    }

    function windowOnClick(event) {
        let overlay = document.getElementById('modalOverlay');
        if (event.target == overlay) {
            closeModals();
        }
    }
    window.onclick = windowOnClick;

    // Validación de contraseñas para eliminar cuenta
    const delPass1 = document.getElementById('del_pass_actual');
    const delPass2 = document.getElementById('del_pass_repita');
    const delSubmitBtn = document.getElementById('btnConfirmarEliminarCuenta');
    const delValidationError = document.getElementById('delete-validation-error');

    function validateDeleteInputs() {
        if (!delPass1 || !delPass2) return;
        const p1 = delPass1.value;
        const p2 = delPass2.value;

        if (p1.length === 0 || p2.length === 0) {
            delSubmitBtn.disabled = true;
            delValidationError.textContent = "";
            return;
        }

        if (p1 !== p2) {
            delSubmitBtn.disabled = true;
            delValidationError.textContent = "Las contraseñas no coinciden.";
            return;
        }

        delSubmitBtn.disabled = false;
        delValidationError.textContent = "";
    }

    if (delPass1 && delPass2) {
        delPass1.addEventListener('input', validateDeleteInputs);
        delPass2.addEventListener('input', validateDeleteInputs);
    }
</script>

<?php require_once 'views/footer.php'; ?>