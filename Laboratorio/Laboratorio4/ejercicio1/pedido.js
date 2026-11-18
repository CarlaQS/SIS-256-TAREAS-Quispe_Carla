const productos = [
    { id: 1, nombre: "Empanadas de queso",  categoria: "Salados", precio: 6,  imagen: "empanadas.jpg" },
    { id: 2, nombre: "Papas fritas",        categoria: "Salados", precio: 8,  imagen: "papas.jpg" },
    { id: 3, nombre: "Hamburguesa clásica", categoria: "Salados", precio: 18, imagen: "hamburguesa.jpg" },
    { id: 4, nombre: "Sopa de pollo",       categoria: "Platos",  precio: 12, imagen: "sopa.jpg" },
    { id: 5, nombre: "Pollo al horno",      categoria: "Platos",  precio: 22, imagen: "pollo.jpg" },
    { id: 6, nombre: "Spaghetti carbonara", categoria: "Platos",  precio: 20, imagen: "espagueti.jpg" },
    { id: 7, nombre: "Flan casero",         categoria: "Postres", precio: 7,  imagen: "flan.jpg" },
    { id: 8, nombre: "Tiramisú",            categoria: "Postres", precio: 12, imagen: "tiramisu.jpg" },
    { id: 9, nombre: "Helado de vainilla",  categoria: "Postres", precio: 8,  imagen: "vainilla.jpg" }
];

let pedido = [];
const catalogo = document.querySelector("#catalogo");
const resumen = document.querySelector("#resumen");
const txtBuscar = document.querySelector("#buscar");
const selCategoria = document.querySelector("#categoria");
const detalle = document.querySelector("#detalle");
const spanTotal = document.querySelector("#total");
const spanContador = document.querySelector("#contador");
const btnVaciar = document.querySelector("#btnVaciar");
const formPedido = document.querySelector("#formPedido");
const selEntrega = document.querySelector("#entrega");
const campoAula = document.querySelector("#campoAula");
const divErrores = document.querySelector("#errores");
const divAvisos = document.querySelector("#avisos");

function mostrarProductos(lista) {
    catalogo.textContent = "";

    lista.forEach((p) => {
        const tarjeta = document.createElement("article");
        tarjeta.classList.add("producto");

        const img = document.createElement("img");
        img.src = "../images/" + p.imagen;
        img.alt = p.nombre;

        const cuerpo = document.createElement("div");
        cuerpo.classList.add("cuerpo");

        const etiqueta = document.createElement("span");
        etiqueta.classList.add("etiqueta");
        etiqueta.classList.add("et-" + p.categoria.toLowerCase());
        etiqueta.textContent = p.categoria;

        const titulo = document.createElement("h4");
        titulo.textContent = p.nombre;

        const precio = document.createElement("div");
        precio.classList.add("precio");
        precio.textContent = "Bs " + p.precio.toFixed(2);

        const acciones = document.createElement("div");
        acciones.classList.add("acciones");

        const boton = document.createElement("button");
        boton.classList.add("boton");
        boton.classList.add("mini");
        boton.classList.add("btn-agregar");
        boton.dataset.id = p.id;        
        boton.textContent = "Agregar";
        acciones.appendChild(boton);
        cuerpo.appendChild(etiqueta);
        cuerpo.appendChild(titulo);
        cuerpo.appendChild(precio);
        cuerpo.appendChild(acciones);
        tarjeta.appendChild(img);
        tarjeta.appendChild(cuerpo);
        catalogo.appendChild(tarjeta);
    });
    if (lista.length === 0) {
        resumen.className = "aviso aviso-error";
        resumen.textContent = "No valido";
    } else {
        resumen.className = "vacio";
        resumen.textContent = "Mostrando " + lista.length + " de " + productos.length + " productos";
    }
}
function filtrar() {
    const texto = txtBuscar.value.toLowerCase().trim();
    const categoria = selCategoria.value;

    const resultado = productos.filter((p) => {
        const coincideNombre = p.nombre.toLowerCase().includes(texto);
        const coincideCategoria = categoria === "Todas" || p.categoria === categoria;
        return coincideNombre && coincideCategoria;
    });

    mostrarProductos(resultado);
}

txtBuscar.addEventListener("input", filtrar);
selCategoria.addEventListener("change", filtrar);

function calcularTotal() {
    return pedido.reduce((suma, item) => suma + item.precio * item.cantidad, 0);
}
function actualizarPedido() {
    if (pedido.length === 0) {
        detalle.innerHTML = '<tr><td colspan="4" class="vacio">Aún no agregó productos.</td></tr>';
    } else {
        detalle.innerHTML = pedido.map((item) => {
            return `<tr>
                <td>${item.nombre}</td>
                <td class="num">${item.cantidad}</td>
                <td class="num">Bs ${(item.precio * item.cantidad).toFixed(2)}</td>
                <td><button class="boton boton-no mini btn-quitar" data-id="${item.id}">−</button></td>
            </tr>`;
        }).join("");
    }

    spanTotal.textContent = "Bs " + calcularTotal().toFixed(2);
    spanContador.textContent = pedido.reduce((suma, item) => suma + item.cantidad, 0);
    localStorage.setItem("pedidoCafeteria", JSON.stringify(pedido));
}
function agregar(id) {
    const producto = productos.find((p) => p.id === id);
    const item = pedido.find((i) => i.id === id);

    if (item) {
        item.cantidad++;
    } else {
        pedido.push({ id: producto.id, nombre: producto.nombre, precio: producto.precio, cantidad: 1 });
    }
    actualizarPedido();
}
function quitar(id) {
    const indice = pedido.findIndex((i) => i.id === id);
    if (indice === -1) return;

    if (pedido[indice].cantidad > 1) {
        pedido[indice].cantidad--;
    } else {
        pedido.splice(indice, 1);
    }
    actualizarPedido();
}

catalogo.addEventListener("click", (e) => {
    if (e.target.matches(".btn-agregar")) {
        agregar(Number(e.target.dataset.id));
    }
});

detalle.addEventListener("click", (e) => {
    if (e.target.matches(".btn-quitar")) {
        quitar(Number(e.target.dataset.id));
    }
});

btnVaciar.addEventListener("click", () => {
    pedido = [];
    actualizarPedido();
});

const regexNombre = /^[A-Za-zÁÉÍÓÚáéíóúÑñ ]{3,50}$/;
const regexCelular = /^[67]\d{7}$/;
const regexAula = /^[A-Z]-\d{1,3}$/;
function validarCampo(campo, regex, divMensaje, mensaje) {
    const esValido = regex.test(campo.value.trim());
    campo.classList.toggle("invalido", !esValido);
    campo.classList.toggle("valido", esValido);
    divMensaje.textContent = esValido ? "" : mensaje;
    return esValido;
}

selEntrega.addEventListener("change", () => {
    campoAula.classList.toggle("oculto", selEntrega.value !== "Llevar al aula");
});

formPedido.addEventListener("submit", (e) => {
    e.preventDefault(); 

    const errores = [];
    divErrores.textContent = "";

    if (!validarCampo(formPedido.nombre, regexNombre, document.querySelector("#errNombre"), "Solo letras y espacios (3 a 50).")) {
        errores.push("Revise el nombre");
    }
    if (!validarCampo(formPedido.celular, regexCelular, document.querySelector("#errCelular"), "8 dígitos, empieza con 6 o 7.")) {
        errores.push("Revise el celular");
    }
    if (selEntrega.value === "Llevar al aula") {
        if (!validarCampo(formPedido.aula, regexAula, document.querySelector("#errAula"), "Formato letra-número, ej. A-12.")) {
            errores.push("Revise el aula");
        }
    }
    if (pedido.length === 0) {
        errores.push("Esta vacio");
    }

    if (errores.length > 0) {
        const aviso = document.createElement("div");
        aviso.classList.add("aviso");
        aviso.classList.add("aviso-error");
        aviso.textContent = "No se puede confirmar:";

        const lista = document.createElement("ul");
        lista.classList.add("lista-errores");
        errores.forEach((mensaje) => {
            const li = document.createElement("li");
            li.textContent = mensaje;
            lista.appendChild(li);
        });
        aviso.appendChild(lista);
        divErrores.appendChild(aviso);
        return;
    }
    const datos = Object.fromEntries(new FormData(formPedido));
    const numero = Math.floor(Math.random() * 90000) + 10000;
    const total = calcularTotal();
    let destino = "caja";
    if (datos.entrega === "Llevar al aula") {
        destino = "aula " + datos.aula;
    }

    const aviso = document.createElement("div");
    aviso.classList.add("aviso");
    aviso.textContent = "Pedido N.º " + numero + " confirmado para " + datos.nombre + " (" + datos.celular + "). Total Bs " + total.toFixed(2) + ". Entrega en " + destino + ".";
    divAvisos.textContent = "";
    divAvisos.appendChild(aviso);

    console.log(JSON.stringify({ numero: numero, cliente: datos, pedido: pedido, total: total }));
    pedido = [];
    actualizarPedido();
    formPedido.reset();
    campoAula.classList.add("oculto");
    document.querySelectorAll("#formPedido input").forEach((campo) => {
        campo.classList.remove("invalido");
        campo.classList.remove("valido");
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const guardado = localStorage.getItem("pedidoCafeteria");
    if (guardado) {
        pedido = JSON.parse(guardado);   
    }
    mostrarProductos(productos);
    actualizarPedido();
});