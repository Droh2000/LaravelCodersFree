// Funcion para hacer que cuando seleccionamos y la subamos podemos verla ya previsualizada en la pagina
window.preview_image = (event, querySelector) => {

	//Recuperamos el input que desencadeno la acción
	const input = event.target;

	//Recuperamos la etiqueta img donde cargaremos la imagen
	let imgPreview = document.querySelector(querySelector);

	// Verificamos si existe una imagen seleccionada
	if(!input.files.length) return

	//Recuperamos el archivo subido
	const file = input.files[0];

	//Creamos la url
	const objectURL = URL.createObjectURL(file);

	//Modificamos el atributo src de la etiqueta img
	imgPreview.src = objectURL;

}
