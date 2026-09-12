# Registro de Mejoras y Correcciones (FIXES)

Detalle cronológico de las optimizaciones, correcciones de errores y parches de seguridad aplicados sobre el código base del proyecto.

---

### 1. Control de Flujo, Sesiones y Redirecciones

* **Solución de error `headers already sent`:**  
  Se reordenó el inicio de ejecución en `index.php`, `nueva.php`, `perfil.php` y `trabajo.php`. La llamada a `session_start()` y la validación de credenciales (`!isset($_SESSION['email'])`) ahora se ejecutan en la primera línea del script, antes de cualquier include o salida HTML.
* **Agregado de `exit;` defensivo:**  
  Se incorporó `exit;` inmediatamente después de cada sentencia `header('Location: ...')` para interrumpir la ejecución del script y prevenir ejecuciones en segundo plano de páginas privadas.
* **Eliminación de debug en subida de proyectos:**  
  Se removió la llamada `print_r($_SESSION);` en `postCrear.php`, la cual emitía texto crudo por pantalla y bloqueaba la redirección automática al home tras publicar.
* **Prevención de sesiones duplicadas:**  
  Se normalizó la llamada a sesiones en componentes compartidos para evitar advertencias de sesión ya activa en entornos PHP 8.

---

### 2. Base de Datos e Integridad de Datos

* **Corrección de registros duplicados en registro:**  
  Se eliminó el bloque de código redundante en `registro.php` que volvía a ejecutar la consulta `INSERT`, eliminando el problema por el cual cada nuevo usuario se daba de alta dos veces con IDs consecutivos.
* **Normalización de consulta de perfil:**  
  En `perfil.php` se implementó un `INNER JOIN` entre la tabla `usuarios` y la tabla `niveles`. Esto reemplazó el texto estático `(Visitante)` que se imprimía por defecto, reflejando dinámicamente el rol real (`Administrador` o `Visitante`).
* **Blindaje de parámetros por URL:**  
  En `trabajo.php` y `guardar.php` se añadió casteo explícito a entero `(int)$_GET['id_trabajos']`. Si el parámetro no existe, es menor o igual a 0, o la consulta no devuelve registros, el script redirige de inmediato a `index.php` en lugar de generar errores de índice indefinido (`undefined array key`).

---

### 3. Maquetación, Responsive y Estructura DOM

* **Limpieza de template duplicado en `template/footer.php`:**  
  Se removió la repetición de `<!DOCTYPE html>`, `<html>`, `<head>` y `<body>` dentro del archivo footer, dejando únicamente la etiqueta semántica `<footer>` y el cierre `</body></html>`.
* **Unificación de templates parciales:**  
  Se estandarizó la inclusión de `template/footer.php` en `nueva.php` y `perfil.php`, eliminando cierres manuales de etiquetas desalineados.
* **Grilla responsiva en el catálogo principal (`index.php`):**  
  Se reemplazó la clase estática `row-cols-3` por el sistema escalonado de Bootstrap `row-cols-1 row-cols-md-2 row-cols-lg-3 g-4`. La grilla ahora se adapta a una columna en móviles y tres en pantallas de escritorio.
* **Adaptabilidad en vista de detalle (`trabajo.php`):**  
  Se modificó la disposición de imagen y descripción de `row-cols-2` fijo a `row-cols-1 row-cols-md-2`, permitiendo que en pantallas reducidas el texto se ubique cómodamente debajo de la imagen.

---

### 4. Sanitización y Seguridad Básica

* **Mitigación de SQL Injection:**  
  Se aplicó `mysqli_real_escape_string()` y saneamiento de espacios (`trim`) en todos los puntos de entrada de datos:
  * Formulario de autenticación (`login.php`).
  * Formulario de registro de usuarios (`registro.php`).
  * Creación de proyectos y portfolios (`postCrear.php`).
  * Envío de comentarios (`guardar.php`).
* **Protección contra Cross-Site Scripting (XSS Stored y Reflected):**  
  Se envolvieron todas las impresiones directas de variables provenientes de la base de datos con `htmlspecialchars(..., ENT_QUOTES, 'UTF-8')`:
  * Títulos y fechas de tarjetas en la grilla principal (`index.php`).
  * Título, descripción y comentarios de usuarios en el detalle del trabajo (`trabajo.php`).
  * Nombre de usuario en el saludo de la barra de navegación (`template/header.php`).
  * Nombre, email y rol en el panel de perfil (`perfil.php`).