<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller implements HasMiddleware
{

    // Implementamos para poder definir el middleware para cada las rutas que especificamos
    public static function middleware()
    {
        // Debemos retornar el middleware sobre el cual queremos proteger
        return [
            // Para poder aplicarlo a solo las rutas especificas
             new Middleware(
                // Especificamos el middleware con el que queremos protegerlo
                'admin',
                // Solo se aplicara a estos metodos
                only: ['index', 'edit'],
                // Con esto es para proteger todas las rutas excepto las que especifiquemos aqui
                // except: ['METODO', 'METODO']
             )
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Uso de los Gates a nivel de Controlador
        // Entre comillas le pasamos el nombre del Gate
        Gate::authorize('admin');

        // Recuperamos el listado de categorias y se lo pasamos a la vista
        // Cambiamos para que los mas nuevos registros aparescan primero
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Este metodo se activa cuando precionamos el boton submit del formulario
        $data = $request->validate([
            'name' => 'required|string|max:255|unique:categories'
        ]);
        // Creamos la categoria si pasa las validaciones
        Category::create($data);

        // Para mandarle los datos al sweetAlert
        // Nos creamos una variable de session que mantiene los datos entre las redirecciones de paginas
        // y el tipo "flash" es que una vez que se consume el valor ya se borra (Ademas asi el mensaje nos sale una vez)
        // "swal" es el nombre de la variable y el contenido es lo que le pasamos al Array
        session()->flash("swal", [
            'icon' => 'success',
            'title' => 'Categoria Creada!',
            'text' => 'La categoria se ha creado correctamente',
        ]);

        return redirect()->route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            // Aqui le concatenamos al final para que nos excluya de la validacion el registro que estamos editando
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $category->update($data);

        session()->flash("swal", [
            'icon' => 'success',
            'title' => 'Categoria Actualizada!',
            'text' => 'La categoria se ha actualizado correctamente',
        ]);

        return redirect()->route('admin.categories.edit', $category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash("swal", [
            'icon' => 'success',
            'title' => 'Categoria Eliminada!',
            'text' => 'La categoria se ha eliminado correctamente',
        ]);
        return redirect()->route('admin.categories.index', $category);
    }
}
