<?php
  session_start(); // Necesario para leer los errores del login
  require_once 'config/parameters.php';
  require_once 'views/header_publico.php'; //Muestra el header_publico, porque aun no ha iniciado sesion el usuario.
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
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    footer {
        margin-top: auto;
    }
</style>
<div class="Contptc Frm1">
  
  <?php if (isset($_GET['success']) && $_GET['success'] == 'cuenta_eliminada'): ?>
      <p style="color: #28a745; background: #e6ffe6; padding: 10px; border-radius: 5px; font-size: 13px; text-align: center; width: 80%; max-width: 400px; margin-bottom: 20px;">
          Tu cuenta ha sido eliminada correctamente. No podrás volver a registrarte con este correo.
      </p>
  <?php endif; ?>

  <form action="<?=base_url?>backend/loginuser.php" class="Contvcc Frm2 Brd15"
    method="post" style="margin-top: 20px;">
    
    <br><h4>Iniciar Sesión</h4><br>

    <?php if (isset($_SESSION['error_login'])): ?>
        <p style="color: #ff4d4d; background: #ffe6e6; padding: 5px; border-radius: 5px; font-size: 13px; text-align: center; width: 80%;">
            <?php 
                echo htmlspecialchars($_SESSION['error_login'], ENT_QUOTES, 'UTF-8'); 
                unset($_SESSION['error_login']); 
            ?>
        </p>
    <?php endif; ?>

    <input type="text" name="correo" placeholder="Correo Electrónico" required>
    <input type="password" name="contrasena" placeholder="Contraseña" required>
    
    <div class="Conthcj" style="width: 65%; height: 60px; margin-top:20px;">
      <input type="submit" class="Bt4b" value="Aceptar">
      <input type="button" class="Bt4r" value="Cancelar"
        onclick="location.href='<?=base_url?>index.php'">
    </div>
    
    <br>
    <br>
    <p>¿No estás registrado?</p>
    <h6><a href="<?=base_url?>registro.php">Regístrate Aquí</a></h6>
    <br>
  </form>
</div>
<?php 
  require_once 'views/footer.php'; 
?>