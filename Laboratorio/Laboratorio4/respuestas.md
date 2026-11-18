SIS-256 - Laboratorio 4 - Preguntas de análisis

Integrantes: Carla Quispe Serrano

---

1. ¿Qué diferencia hay entre 'textContent' e 'innerHTML' ? ¿Por qué los datos del servidor pasan por 'escapar()' y qué ataque se evita?

'textContent' inserta texto plano sin interpretar etiquetas. 'innerHTML' interpreta el texto como HTML y renderiza elementos o scripts. Los datos pasan por 'escapar()' para transformar caracteres especiales y evitar ataques de inyección de código XSS.

2. Explique la delegación de eventos. ¿Qué ocurriría con los botones Agregar si el listener se registrara en cada botón y luego el usuario filtrara el catálogo?

Consiste en colocar un único listener en un contenedor fijo y detectar el clic mediante 'e.target.matches()'. Si el listener estuviera en cada botón, al filtrar el catálogo se crearían elementos nuevos que perderían el evento. Con la delegación, como el contenedor no se destruye, los nuevos elementos siguen respondiendo.

3. 'fetch()' no rechaza la promesa con un 404 o un 500. ¿Cómo lo detecta su código? ¿En qué casos sí se ejecuta el 'catch'?

Se detecta revisando 'response.ok', lanzando un error manual si es falso. El 'catch' se ejecuta solo ante fallos absolutos de red, errores de CORS, caídas del servidor o errores lanzados manualmente.

4. Escriba 'cargarVista(url)' con 'XMLHttpRequest' y compárela con la versión de 'fetch' + 'async/await'

Con XMLHttpRequest:

function cargarVista(url) {
contenido.innerHTML = 'Cargando...';
const xhr = new XMLHttpRequest();
xhr.open("GET", url);
xhr.onload = function () {
if (xhr.status === 200) {
contenido.innerHTML = xhr.responseText;
} else {
contenido.innerHTML = 'HTTP ' + xhr.status + '';
}
};
xhr.onerror = function () {
contenido.innerHTML = 'Error de red';
};
xhr.send();
}

Con fetch + async/await:

async function cargarVista(url) {
contenido.innerHTML = 'Cargando...';
try {
const resp = await fetch(url);
if (!resp.ok) throw new Error("HTTP " + resp.status);
contenido.innerHTML = await resp.text();
} catch (error) {
contenido.innerHTML = '' + error.message + '';
}
}

Comparación: XHR requiere manejar eventos separados y códigos manuales, fragmentando el código. Fetch con async/await ofrece un flujo secuencial más limpio y centraliza los errores en un solo bloque.

5. ¿Por qué no se debe fijar 'Content-Type' al enviar un 'FormData' con un archivo? ¿Qué pasa en '$_POST' y '$_FILES' si se pone "application/json"?

Porque el navegador genera automáticamente el 'boundary' necesario para separar los campos del archivo. Si se fija manualmente, se pierde ese separador y PHP recibe '$_POST' y '$_FILES' completamente vacíos al no reconocer el formato.

6. Si JavaScript ya valida el formulario, ¿por qué 'insertar.php' vuelve a validar? Relacione con la prueba 7.

Porque el cliente puede alterar o saltarse la validación de JavaScript. En la prueba 7 se envía un formulario vacío directo mediante fetch, demostrando que el backend debe validar siempre para proteger la base de datos.

7. Compare 'localStorage', 'sessionStorage' y la cookie del Laboratorio 2

* localStorage: Persiste indefinidamente en el cliente, capacidad de 5 MB, útil para guardar datos duraderos entre sesiones.
* sessionStorage: Dura solo mientras la pestaña esté abierta, capacidad de 5 MB, útil para datos temporales de navegación.
* Cookie: Tiene fecha de expiración configurable, viaja automáticamente al servidor en cada petición y mide cerca de 4 KB, ideal para sesiones y preferencias del backend.

8. ¿Qué es el debounce? ¿Cuántas peticiones se enviarían al escribir "pollo" sin él, y por qué importa con muchos usuarios?

Es una pausa que retrasa la ejecución hasta que el usuario deja de escribir. Sin debounce, escribir "pollo" enviaría 5 peticiones independientes, saturando el servidor y la base de datos si muchos usuarios hacen lo mismo de forma simultánea.