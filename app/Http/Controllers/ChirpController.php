<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View //indicamos el tipo de retorno y sear una vista
    {
        //obtenermos todos con el metodo dd 
        //dd(Chirp::with('user')->latest()->get());
       
        //retornamos una vista pero tambien un array de datos
        //pasamos una variable llamada 'chirps' del modelo Chirp con el usuario incluido (latest() ordenalos todos de manera desnedente), get() los  obtenemos 
        return view('chirps.index', [
            'chirps' => Chirp::with('user')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    /*Request $request: es toda la informacion que nos llega desde cualquier parate incluido un formulario  */
    /* definimos el tipo de respusta a retornar sera: RedirectResponse (hara una redireccion) */
    public function store(Request $request)
    {
        //llevamos acabo la validacion (el campo message 'name=message')
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        //usamos la funcion dd paramos para mostrar informacion 
        //dd($validated);

        //del usuario sus chirps vamos a crear uno (con los datos validados)
        $request->user()->chirps()->create($validated);

        //retornamos una respuesta que es una redireccion a la pagina de chirsp.index
        return redirect(route('chirps.index'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    /* 
    Este es un método edit en un controlador de Laravel. El método acepta un parámetro $chirp que es una instancia del modelo Chirp. El método llama al método authorize en el objeto $this, pasando 'update' y $chirp como argumentos. Esto verifica si el usuario actual tiene permiso para actualizar el chirrido especificado.
    Si el usuario está autorizado, el método devuelve una vista llamada 'chirps.edit' y pasa un array con una clave 'chirp' y un valor de $chirp. Esto permite que la vista acceda a la instancia del modelo Chirp y muestre su contenido para su edición.
    */
    public function edit(Chirp $chirp)
    {
        $this->authorize('update', $chirp);
        /* El primer argumento que se pasa al método authorize es el nombre de la acción que se está autorizando y el segundo argumento es el modelo o recurso relevante para la acción. En este caso, el método authorize está verificando si el usuario actual tiene permiso para actualizar el modelo $chirp. */

        return view('chirps.edit', [
            'chirp' => $chirp
        ]);
        /* 
         cuando pasas una instancia del modelo Chirp a la vista edit utilizando el código 
         'chirp' => $chirp, estás pasando los datos de esa fila en particular a la vista. En la vista, puedes acceder a los datos de 
         la instancia del modelo utilizando la variable $chirp. Por ejemplo, si quieres mostrar el valor del campo message en un formulario de edición, puedes hacer algo como esto: <input type="text" 
         name="message" value="{{ $chirp->message }}">
        */
    }

    /**
     * Update the specified resource in storage.
     */
   /* 
   el parámetro Chirp $chirp en el método update se utiliza para especificar qué registro de la tabla chirps se va a actualizar. Laravel utiliza la técnica de inyección de dependencias para pasar automáticamente una instancia del modelo Chirp que corresponde al registro especificado en la ruta. Por ejemplo, si la ruta es /chirps/1, Laravel buscará un registro en la tabla chirps con un id de 1 y pasará una instancia del modelo Chirp que representa ese registro al método update. De esta manera, puedes acceder a los datos del registro y actualizarlos utilizando los métodos de Eloquent.
   */
     public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        $this->authorize('update', $chirp);

        $validated = $request->validate([
            'message' => 'required|string|max:255' 
        ]);

        $chirp->update($validated); //utilizamos update de eloquent (encontramos el chirp y le pasamos el request)

        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        //tendra permiso siempre que sea eñ autor
        $this->authorize('delete', $chirp);

        $chirp->delete();

        return redirect(route('chirps.index'));
    }
}
 