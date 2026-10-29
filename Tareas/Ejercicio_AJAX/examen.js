var idActual = 0;

function pregunta4()
{
    var contenedor;
	contenedor = document.getElementById('contenido');
	fetch('catalogo.php')
		.then(response => response.text())
		.then(data => contenedor.innerHTML=data);

}
function abrirmodal(id){
   idActual = id;
   var contenedor = document.getElementById('contenido-modal');
   fetch('datos-receta.php?id='+id)
		.then(response => response.text())
		.then(data => contenedor.innerHTML=data);

   document.querySelector(".modal").style.display="block";
}
function cerrarmodal(){
    document.querySelector(".modal").style.display="none";
}
function eliminar(){
    if (confirm("¿Seguro que desea eliminar la receta?")) {
        fetch('eliminar.php?id='+idActual, {method: 'DELETE'})
            .then(response => response.text())
            .then(data => {
                cerrarmodal();
                pregunta4();
            });
    }
}
