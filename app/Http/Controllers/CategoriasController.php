<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use App\Categoria;
use Image;
use Alert;
use Redirect,Response;
use DataTables;


class CategoriasController extends Controller
{
    /**
     * Display a datatable of the resource.
     *
     * @return \Illuminate\Http\Json
     */
    public function datatable()
    {
        $categorias=Categoria::all();
        return DataTables::of($categorias)
                ->addColumn('edit','intAdmin.intCategorias.botones.edit')
                ->addColumn('statusBtn','intAdmin.intCategorias.botones.status')
                ->rawColumns(['edit','statusBtn'])
                ->toJson(); 
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noCategorias=Categoria::all()->count();
        return view('intAdmin.intCategorias.index',compact('noCategorias'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('intAdmin.intCategorias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoria=new Categoria();
        $categoria->nombre_categoria=$request->input('nombre');
        if($request->hasFile('imagen')){
            $file=$request->file('imagen');
            $foto=$categoria->nombre_categoria.$file->getClientOriginalExtension();
            $image= Image::make($file)->encode('webp',90)->save(public_path('/categoriasimg/' . $foto.'.webp'));
            $categoria->foto_categoria=$foto.'.webp';
        }
        $categoria->slug_categoria=Str::slug($categoria->nombre_categoria.'-'.time());
        $categoria->status="ACTIVO";
        $categoria->save();
        alert()->success('XpressComerce', 'Categoria registrada correctamente');
        return Redirect::to('/categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug_categoria)
    {
        $categoria=Categoria::where('slug_categoria','=', $slug_categoria)->firstOrFail();
        return view('intAdmin.intCategorias.edit',compact('categoria'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug_categoria)
    {
        $categoria=Categoria::where('slug_categoria','=', $slug_categoria)->firstOrFail();
        $categoria->nombre_categoria=$request->input('nombre');
        if($request->hasFile('imagen')){
            $file_path = public_path() . "/categoriasimg/$categoria->foto_categoria";
            \File::delete($file_path);
            $file=$request->file('imagen');
            $foto=$categoria->nombre_categoria.$file->getClientOriginalExtension();
            $image= Image::make($file)->encode('webp',90)->save(public_path('/categoriasimg/' . $foto.'.webp'));
            $categoria->foto_categoria=$foto.'.webp';
        }
        $categoria->slug_categoria=Str::slug($categoria->nombre_categoria.'-'.time());
        $categoria->status="ACTIVO";
        $categoria->save();
        alert()->success('XpressComerce', 'Categoria editada correctamente');
        return Redirect::to('/categories');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug_categoria)
    {
        $categoria=Categoria::where('slug_categoria','=', $slug_categoria)->firstOrFail();
        $categoria->status="INACTIVO";
        $categoria->save();
        alert()->warning('XpressComerce', 'Estado editado correctamente');
        return Redirect::to('/categories');
    }
}
