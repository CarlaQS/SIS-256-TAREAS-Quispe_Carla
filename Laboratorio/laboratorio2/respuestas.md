# Laboratorio 2 — PHP del lado del servidor

**Materia:** SIS 256 — Tecnología y Desarrollo Web
**Docente:** Ing. Carlos David Montellano Barriga
**Integrantes:** [Nombre A] / [Nombre B]

---

## Preguntas de análisis

### 1. ¿Por qué el carrito se guarda en la sesión y no en una cookie?

- Las cookies solo guardan poco texto (unos 4 KB) y el carrito puede crecer con muchos productos.
- Las cookies se guardan en el navegador y el usuario las puede editar o borrar desde F12. La sesión vive en el servidor, así el usuario no puede alterar el carrito manualmente.

### 2. ¿Qué ocurre si se llama a setcookie() después de haber impreso HTML?

Sale el error **"headers already sent"** y la cookie no se crea. Esto pasa porque las cookies se envían en las cabeceras HTTP, y las cabeceras siempre deben ir antes de cualquier HTML. Por eso todos los `setcookie()` están al inicio de los archivos, antes del `<!DOCTYPE html>`.

### 3. ¿Por qué $_COOKIE todavía no la contiene en esa misma petición?

Porque `setcookie()` solo le dice al navegador "guarda esta cookie", pero no la agrega al instante al arreglo `$_COOKIE` de la página actual. La cookie recién aparece en `$_COOKIE` en la siguiente petición, cuando el navegador la envía de vuelta al servidor.

### 4. ¿Qué error aparece si se hace unserialize() sin incluir antes la clase Carrito?

Al probarlo, `unserialize()` no da error de inmediato, pero devuelve un objeto raro de tipo `__PHP_Incomplete_class`, que no tiene los métodos de la clase Carrito. El error real aparece al usar ese objeto, por ejemplo:

```
Fatal error: Uncaught Error: Call to a member function total() on incomplete object
```

Por eso hay que incluir `Carrito.php` con `require_once` **antes** de hacer `unserialize()`.

### 5. ¿Qué pasa si desde index.php se intenta escribir $p->precio = 0?

Sale este error y el programa se detiene:

```
Fatal error: Cannot access private property Producto::$precio
```

Esto pasa porque `$precio` es `private`, así que solo el código dentro de la propia clase puede modificarla. Esto es el **encapsulamiento**: la clase protege sus datos y obliga a usar los getters para leerlos, en vez de dejar que cualquier parte del programa los cambie directamente.