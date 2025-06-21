// Tenemos que hacer que esta funcion tenga alcance global por eso almacenamos en una variable y con "window."
// Asi podemos llamar esta funcion desde cualquier parte de la aplicacion pero siempre y cuando la vista tenga
// en la plantilla que esta usando (En este caso admin.blade.php la compilacion de @vite['resources/js/app'])

// Cuando recibamos el valor del input como el input
window.string_to_slug = (str, querySelector) => {
    // Eliminar espacios al inicio y final
    str = str.replace(/^\s+|\s+$/g, '');

    // Convertir todo a minúsculas
    str = str.toLowerCase();

    // Definir caracteres especiales y sus reemplazos
    const from = "àáäâèéëêìíïîòóöôùúüûñç·/_,:;";
    const to = "aaaaeeeeiiiioooouuuunc------";

    // Reemplazar caracteres especiales por los correspondientes en 'to'
    for (let i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
    }

    // Eliminar caracteres no alfanuméricos y reemplazar espacios por guiones
    str = str.replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-');

    // Asignar el slug generado al campo de entrada correspondiente
    document.querySelector(querySelector).value = str;
}
// Todos los archivo que creemos para ser usados tenemos que importarlos en el archivo "app" que tenemos
// esto es tanto para JS como para CSS
