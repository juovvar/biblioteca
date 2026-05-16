<?php
  session_start();
  require_once 'config/parameters.php';
  require_once 'views/header_publico.php';
?>
<style>
    html {
        height: 100%;
    }
    body {
        min-height: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
    }
    .Contptc {
        flex: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    footer {
        margin-top: auto;
    }
</style>
<div class="Contptc Frm1">
  <form action="<?=base_url?>backend/registroadd.php" class="Contvcc Frm2 Brd15"
    method="post" style="margin-top: 40px;" id="registroForm">
    
    <br><h4>Registro</h4><br>

    <?php if (isset($_SESSION['error_registro'])): ?>
        <p style="color: #ff4d4d; background: #ffe6e6; padding: 10px; border-radius: 5px; font-size: 14px; text-align: center; width: 80%;">
            <?php 
                echo htmlspecialchars($_SESSION['error_registro'], ENT_QUOTES, 'UTF-8'); 
                unset($_SESSION['error_registro']); 
            ?>
        </p>
    <?php endif; ?>

    <input type="text" name="nombre" placeholder="Nombre del usuario" required>
    
    <input type="email" name="correo" placeholder="Correo Electronico" required>
    <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña" required>
    <input type="password" name="contrasena2" id="contrasena2" placeholder="Reingrese contraseña" required>
    
    <p id="password-validation-error" style="color: #ff4d4d; font-size: 13px; margin: 5px 0; text-align: center;"></p>

    <br>
    <div style="display: flex; flex-direction: column; width: 100%; gap: 10px; margin-top: 15px; align-items: center;">
      <input type="submit" id="btn-submit" class="Bt4b" value="Registrarse" style="width: 90%; max-width: 220px; margin: 0;" disabled>
      <input type="button" class="Bt4r" value="Cancelar" style="width: 90%; max-width: 220px; margin: 0;"
        onclick="location.href='<?=base_url?>index.php'">
    </div>
  </form>
</div>

<script>
    const pass1 = document.getElementById('contrasena');
    const pass2 = document.getElementById('contrasena2');
    const submitBtn = document.getElementById('btn-submit');
    const validationError = document.getElementById('password-validation-error');

    function validateInputs() {
        const p1 = pass1.value;
        const p2 = pass2.value;

        if (p1.length === 0 || p2.length === 0) {
            submitBtn.disabled = true;
            validationError.textContent = "";
            return;
        }

        if (p1.length < 12 || p1.length > 64) {
            submitBtn.disabled = true;
            validationError.textContent = "La contraseña debe tener entre 12 y 64 caracteres.";
            return;
        }

        if (p1 !== p2) {
            submitBtn.disabled = true;
            validationError.textContent = "Las contraseñas no coinciden.";
            return;
        }

        submitBtn.disabled = false;
        validationError.textContent = "";
    }

    pass1.addEventListener('input', validateInputs);
    pass2.addEventListener('input', validateInputs);
</script>

<?php 
  require_once 'views/footer.php'; 
?>