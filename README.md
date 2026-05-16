# Sistema de Biblioteca Web

¡Bienvenido al repositorio del Sistema de Biblioteca Digital! Este es un proyecto robusto desarrollado en PHP Nativo y MySQL enfocado en proporcionar una plataforma fluida y segura para la exploración, lectura y descarga de libros en línea, complementado con un sistema completo de gestión de usuarios y reseñas.

El diseño del sistema se ha desarrollado priorizando la legibilidad del código, la seguridad y una estructura adaptativa (*responsive*) sin depender de frameworks externos extensos.

---

## Características Principales

### Gestión de Usuarios y Cuentas
* **Registro e Inicio de Sesión:** Sistema de autenticación seguro para el control de acceso.
* **Panel de Configuración de Cuenta:** Permite a los usuarios personalizar por completo su perfil:
    * Cambiar avatar (imagen de perfil).
    * Actualizar nombre de usuario, correo electrónico y contraseña.
* **Inhabilitación de Cuenta (Soft Delete):** Por buenas prácticas de integridad de datos, el sistema de borrado no elimina físicamente el registro de la base de datos. En su lugar, **inactiva las credenciales** del usuario, bloqueando su inicio de sesión futuro y reservando el correo electrónico para evitar que sea reutilizado en cuentas nuevas.

### Módulo de Libros y Catálogo
* **Exploración de Catálogo:** Interfaz intuitiva para navegar entre los libros disponibles.
* **Lectura en Línea y Descarga:** Los usuarios pueden consumir el contenido directamente desde el navegador o descargarlo para su lectura sin conexión.
* **Sistema de Reseñas:** Espacio interactivo donde los usuarios pueden escribir opiniones y gestionar sus propias valoraciones en cada libro.

### Administración del Sistema
* Para mantener un control directo y eficiente sobre la infraestructura de datos, el panel de administración se gestiona directamente a través de **phpMyAdmin**, interactuando de forma nativa con el script de la base de datos sin interfaces intermedias.

---

## Seguridad y Buenas Prácticas

El proyecto fue construido bajo un enfoque de desarrollo seguro (Secure by Design):
* **Protección de Credenciales:** Las contraseñas no se almacenan en texto plano; se implementó el algoritmo de encriptación hash **BCRYPT** de alta seguridad.
* **Prevención de Ataques XSS (Cross-Site Scripting):** Todos los campos de entrada de datos están estrictamente sanitizados antes de ser renderizados o procesados en el sistema.
* **Código Limpio:** Arquitectura legible, estructurada y completamente comentada para facilitar el mantenimiento y la escalabilidad del software.

---

## Tecnologías Utilizadas

* **Backend:** PHP Nativo (Gestión de lógica de negocio, sesiones y conexiones eficientes a la base de datos).
* **Base de Datos:** MySQL (para la creación de la base de datos).
* **Frontend:**
    * **HTML5** para la maquetación.
    * **CSS3** estructurado mediante contenedores adaptativos y optimización precisa con *media queries* dentro de los componentes para corregir inconsistencias visuales dinámicas.
    * **JavaScript** para añadir dinamismo e interactividad en el lado del cliente.

---

## Instalación Local

Sigue estos pasos para desplegar el entorno de desarrollo en tu máquina local utilizando **XAMPP**:

1.  **Instalar XAMPP:** Asegúrate de tener instalado XAMPP con los modulos de Apache y MySQL activos.
2.  **Clonar o Copiar el Proyecto:** Descarga el repositorio y coloca la carpeta principal llamada `biblioteca` dentro del directorio raíz de tu servidor local:
    ```bash
    C:\xampp\htdocs\biblioteca
    ```
3.  **Configurar la Base de Datos:**
    * Abre tu navegador e ingresa a `http://localhost/phpmyadmin/`.
    * Crea una nueva base de datos (se recomienda llamarla `db_biblioteca`).
    * Dirígete a la pestaña **Importar**.
    * Selecciona el archivo del script SQL que se encuentra en la siguiente ruta dentro del proyecto:
        ```text
        assets/database/db_biblioteca.sql
        ```
    * Haz clic en **Continuar** para ejecutar el script y estructurar las tablas.
4.  **Ejecutar la Aplicación:** Abre tu navegador y accede a:
    ```text
    http://localhost/biblioteca
    ```

---
Este proyecto representa una base sólida y esencial de ingeniería de software para sistemas web relacionales. Hecho con la convicción de mantener el control nativo del código y de los datos.
