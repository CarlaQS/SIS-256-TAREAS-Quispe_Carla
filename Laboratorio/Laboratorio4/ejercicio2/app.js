const contenido = document.querySelector("#contenido");
const mensajes = document.querySelector("#mensajes");
const botonesMenu = document.querySelectorAll("[data-vista]");
const modal = document.querySelector("#modal");
const modalTitulo = document.querySelector("#modalTitulo");
const modalCuerpo = document.querySelector("#modalCuerpo");
const modalPie = document.querySelector("#modalPie");

let txtBuscar = null;
let selCategoria = null;
let grilla = null;
let temporizador = null;       
let tarjetaAEliminar = null;    

function escapar(texto) {
    return String(texto)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#39;");
}
function avisoError(mensaje) {
    return `<div class="aviso aviso-error">${escapar(mensaje)}</div>`;
}
function listaErrores(errores) {
    const items = errores.map((e) => `<li>${escapar(e)}</li>`).join("");
    return `<div class="aviso aviso-error">Corrija lo siguiente:<ul class="lista-errores">${items}</ul></div>`;
}
botonesMenu.forEach((boton) => {
    boton.addEventListener("click", () => {
        botonesMenu.forEach((b) => b.classList.remove("activo"));
        boton.classList.add("activo");
        abrirVista(boton.dataset.vista);
    });
});

async function abrirVista(vista) {
    mensajes.innerHTML = "";
    if (vista === "inicio") {
        await cargarVista("inicio.html");
    } else if (vista === "menu") {
        await mostrarMenu();
    } else if (vista === "nuevo") {
        const ok = await cargarVista("form_producto.html");
        if (ok) {
            await llenarCategorias(document.querySelector("#categoria_id"));
        }
    }
}


async function cargarVista(url) {
    contenido.innerHTML = '<p class="cargando">Cargando...</p>';
    try {
        const resp = await fetch(url);
        if (!resp.ok) throw new Error("HTTP " + resp.status); 
        const html = await resp.text();
        contenido.innerHTML = html;
        return true;
    } catch (error) {
        contenido.innerHTML = avisoError(error.message);
        return false;
    }
}

async function llenarCategorias(select) {
    try {
        const resp = await fetch("categorias.php");
        if (!resp.ok) throw new Error("HTTP " + resp.status);
        const categorias = await resp.json();
        categorias.forEach((c) => {
            const opcion = document.createElement("option");
            opcion.value = c.id;
            opcion.textContent = c.nombre;
            select.appendChild(opcion);
        });
    } catch (error) {
        mensajes.innerHTML = avisoError("No se pudieron cargar las categorías: " + error.message);
    }
}

async function mostrarMenu() {
    contenido.innerHTML = `
        <h2>Menú <span class="contador" id="contadorMenu">0</span></h2>
        <div class="barra">
            <div class="campo">
                <label for="txtBuscar">Buscar (mientras escribe)</label>
                <input type="search" id="txtBuscar" placeholder="Ej.: pollo">
            </div>
            <div class="campo">
                <label for="selCategoria">Categoría</label>
                <select id="selCategoria">
                    <option value="0">Todas</option>
                </select>
            </div>
        </div>
        <div class="grilla" id="grilla"></div>`;

    txtBuscar = document.querySelector("#txtBuscar");
    selCategoria = document.querySelector("#selCategoria");
    grilla = document.querySelector("#grilla");

    txtBuscar.addEventListener("input", () => {
        clearTimeout(temporizador);
        temporizador = setTimeout(cargarProductos, 300);
    });
    selCategoria.addEventListener("change", cargarProductos);

    await llenarCategorias(selCategoria);
    await cargarProductos();
}
async function cargarProductos() {
    const params = new URLSearchParams({ buscar: txtBuscar.value.trim(), categoria: selCategoria.value });
    grilla.innerHTML = '<p class="cargando">Cargando productos...</p>';  
    try {
        const resp = await fetch(`productos.php?${params}`);
        if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
        const productos = await resp.json();                           
        document.querySelector("#contadorMenu").textContent = productos.length;
        if (productos.length === 0) {
            grilla.innerHTML = '<p class="vacio">No se encontraron productos.</p>';
            return;
        }
        grilla.innerHTML = productos.map((p) => {
            const clase = p.disponible ? "producto" : "producto agotado";
            let foto = '<div class="sin-imagen">SIN FOTO</div>';
            if (p.imagen) {
                foto = `<img src="../images/${escapar(p.imagen)}" alt="${escapar(p.nombre)}">`;
            }
            let etiquetaAgotado = "";
            if (!p.disponible) {
                etiquetaAgotado = '<span class="etiqueta et-agotado">Agotado</span>';
            }
            return `<article class="${clase}" data-id="${p.id}" data-nombre="${escapar(p.nombre)}">
                ${foto}
                <div class="cuerpo">
                    <span class="etiqueta et-${escapar(p.categoria.toLowerCase())}">${escapar(p.categoria)}</span>
                    <h4>${escapar(p.nombre)}</h4>
                    <div class="precio">Bs ${p.precio.toFixed(2)}</div>
                    ${etiquetaAgotado}
                    <div class="acciones">
                        <button class="boton mini btn-detalle" data-id="${p.id}">Detalle</button>
                        <button class="boton boton-no mini btn-eliminar">Eliminar</button>
                    </div>
                </div>
            </article>`;
        }).join("");
    } catch (error) {
        grilla.innerHTML = avisoError(error.message);
    }
}

contenido.addEventListener("click", (e) => {
    if (e.target.matches(".btn-detalle")) {
        verDetalle(e.target.dataset.id);
    }
    if (e.target.matches(".btn-eliminar")) {
        pedirConfirmacion(e.target.closest(".producto"));
    }
});

contenido.addEventListener("submit", (e) => {
    if (e.target.matches("#formProducto")) {
        e.preventDefault();
        guardarProducto(e.target);
    }
});

function abrirModal() {
    modal.classList.add("abierto");
}

function cerrarModal() {
    modal.classList.remove("abierto");
}

modal.addEventListener("click", (e) => {
    if (e.target === modal || e.target.matches(".btn-cerrar")) {
        cerrarModal();
    }
    if (e.target.matches(".btn-confirmar")) {
        eliminarProducto();
    }
});

document.addEventListener("keydown", (e) => {
    if (e.key === "Escape") {
        cerrarModal();
    }
});

async function verDetalle(id) {
    try {
        const resp = await fetch("producto.php?id=" + id);
        if (!resp.ok) throw new Error("HTTP " + resp.status);
        const p = await resp.json();

        modalTitulo.textContent = p.nombre;
        let foto = "";
        if (p.imagen) {
            foto = `<img src="../images/${escapar(p.imagen)}" alt="${escapar(p.nombre)}">`;
        }
        modalCuerpo.innerHTML = `
            ${foto}
            <p><span class="etiqueta et-${escapar(p.categoria.toLowerCase())}">${escapar(p.categoria)}</span></p>
            <p>${escapar(p.descripcion)}</p>
            <p>Precio: Bs ${p.precio.toFixed(2)}</p>`;
        modalPie.innerHTML = '<button class="boton boton-sec btn-cerrar">Cerrar</button>';
        abrirModal();
    } catch (error) {
        mensajes.innerHTML = avisoError("No se pudo cargar el detalle: " + error.message);
    }
}

function pedirConfirmacion(tarjeta) {
    tarjetaAEliminar = tarjeta;
    modalTitulo.textContent = "Confirmar eliminación";
    modalCuerpo.innerHTML = `<p>¿Está seguro de eliminar <strong>${escapar(tarjeta.dataset.nombre)}</strong>? Esta acción no se puede deshacer.</p>`;
    modalPie.innerHTML = `
        <button class="boton boton-sec btn-cerrar">Cancelar</button>
        <button class="boton boton-no btn-confirmar">Eliminar</button>`;
    abrirModal();
}

async function eliminarProducto() {
    const datos = new FormData();
    datos.append("id", tarjetaAEliminar.dataset.id);
    try {
        const resp = await fetch("eliminar.php", { method: "POST", body: datos });
        const resultado = await resp.json();
        if (!resp.ok) throw new Error(resultado.mensaje || "HTTP " + resp.status);
        tarjetaAEliminar.remove();
        const contador = document.querySelector("#contadorMenu");
        contador.textContent = Number(contador.textContent) - 1;
        mensajes.innerHTML = `<div class="aviso">${escapar(resultado.mensaje)}</div>`;
    } catch (error) {
        mensajes.innerHTML = avisoError(error.message);
    }
    cerrarModal();
}

async function guardarProducto(form) {
    const divMensaje = document.querySelector("#mensajeForm");
    const errores = [];
    const nombreOk = form.nombre.value.trim().length >= 3;
    const categoriaOk = form.categoria_id.value !== "";
    const precioOk = parseFloat(form.precio.value) > 0;

    form.nombre.classList.toggle("no valido", !nombreOk);
    form.categoria_id.classList.toggle("no valido", !categoriaOk);
    form.precio.classList.toggle("invalido", !precioOk);

    if (!nombreOk) errores.push("El nombre debe tener al menos 3 caracteres.");
    if (!categoriaOk) errores.push("Seleccione ");
    if (!precioOk) errores.push("No valido");
    if (errores.length > 0) {
        divMensaje.innerHTML = listaErrores(errores);
        return;    
    }
    const boton = document.querySelector("#btnGuardar");
    boton.disabled = true;
    boton.textContent = "Guardando...";

    try {
        const resp = await fetch("insertar.php", { method: "POST", body: new FormData(form) });
        const resultado = await resp.json();
        if (resp.status === 201) {
            divMensaje.innerHTML = `<div class="aviso">${escapar(resultado.mensaje)}</div>`;
            form.reset();
        } else if (resp.status === 422) {
            divMensaje.innerHTML = listaErrores(resultado.errores);
        } else {
            throw new Error(resultado.mensaje || "HTTP " + resp.status);
        }
    } catch (error) {
        divMensaje.innerHTML = avisoError(error.message);
    } finally {
        boton.disabled = false;
        boton.textContent = "Guardar producto";
    }
}

document.addEventListener("DOMContentLoaded", () => {
    cargarVista("index.html");
});
