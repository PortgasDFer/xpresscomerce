<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use App\Producto;
use App\Categoria;
use Image;
use Alert;
use Redirect,Response;
use DataTables;


class ProductosController extends Controller
{
    /**
     * Display a datatable of the resource.
     *
     * @return \Illuminate\Http\Json
     */
    public function datatable()
    {
        $productos=Producto::all();
        return DataTables::of($productos)
                ->addColumn('edit','intAdmin.intProductos.botones.edit')
                ->addColumn('statusBtn','intAdmin.intProductos.botones.statusBtn')
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
        $noProductos=Producto::all()->count();
        return view('intAdmin.intProductos.index', compact('noProductos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categorias=Categoria::where('status','=','ACTIVO')->get();
        return view('intAdmin.intProductos.create', compact('categorias'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tags= explode(',', $request->tags);
        $producto = new Producto();
        $producto->nombre_producto=$request->input('nombre');
        $producto->descrip_producto=$request->input('descripcion');
        $producto->precio=$request->input('precio');
        if($request->hasFile('imagen')){
            $file=$request->file('imagen');
            $foto=$producto->nombre_producto.$file->getClientOriginalExtension();
            $image= Image::make($file)->encode('webp',90)->save(public_path('/productosimg/' . $foto.'.webp'));
            $producto->foto_producto=$foto.'.webp';
        }
        $producto->slug_producto=Str::slug($producto->nombre_producto.'-'.time());
        $producto->disponibilidad=$request->input('disponibilidad');
        $producto->id_categoria=$request->input('categoria');
        $producto->id_marca=$request->input('id_marca');
        $producto->status="ACTIVO";
        $producto->save();
        $producto->tag($tags);
        alert()->success('XpressComerce', 'Producto registrado correctamente');
        return Redirect::to('/products');

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
    public function edit($slug_producto)
    {
        $producto=Producto::where('slug_producto','=',$slug_producto)->firstOrFail();
        $categorias=Categoria::where('status','=','ACTIVO')->get();
        return view('intAdmin.intProductos.edit',compact('producto','categorias'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug_producto)
    {
        $producto=Producto::where('slug_producto','=',$slug_producto)->firstOrFail();
        $producto->nombre_producto=$request->input('nombre');
        $producto->descrip_producto=$request->input('descripcion');
        $producto->precio=$request->input('precio');
        if($request->hasFile('imagen')){
            
            $file_path = public_path() . "/productosimg/$producto->foto_producto";
            \File::delete($file_path);

            $file=$request->file('imagen');
            $foto=$producto->nombre_producto.$file->getClientOriginalExtension();
            $image= Image::make($file)->encode('webp',90)->save(public_path('/productosimg/' . $foto.'.webp'));
            $producto->foto_producto=$foto.'.webp';

        }
        $producto->slug_producto=Str::slug($producto->nombre_producto.'-'.time());
        $producto->disponibilidad=$request->input('disponibilidad');
        $producto->id_categoria=$request->input('categoria');
        $producto->id_marca=$request->input('id_marca');
        $producto->status="ACTIVO";
        $producto->save();
        alert()->success('XpressComerce', 'Producto editado correctamente');
        return Redirect::to('/products');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug_producto)
    {
        $producto=Producto::where('slug_producto','=',$slug_producto)->firstOrFail();
         if($producto->status=="INACTIVO"){
            $producto->status="ACTIVO";
        }elseif($producto->status=="ACTIVO"){
            $producto->status="INACTIVO";
        }
        $producto->save();
        alert()->warning('XpressComerce', 'Estado editado correctamente');
        return Redirect::to('/products');
    }
}
