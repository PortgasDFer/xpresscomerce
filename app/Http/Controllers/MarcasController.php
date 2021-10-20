<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str as Str;
use App\Marca;
use Image;
use Alert;
use Redirect,Response;
use DataTables;

class MarcasController extends Controller
{
    /**
     * Display a datatable of the resource.
     *
     * @return \Illuminate\Http\Json
     */
    public function datatable()
    {
        $marcas=Marca::all();
        return DataTables::of($marcas)
                ->addColumn('edit','intAdmin.intMarcas.botones.edit')
                ->addColumn('statusBtn','intAdmin.intMarcas.botones.status')
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
        $noMarcas = Marca::all()->count();
        return view('intAdmin.intMarcas.index',compact('noMarcas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('intAdmin.intMarcas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $marca = new Marca();
        $marca->nombre_marca=$request->input('nombre');
        if($request->hasFile('imagen')){
            $file=$request->file('imagen');
            $foto=$marca->nombre_marca.$file->getClientOriginalExtension();
            $image= Image::make($file)->encode('webp',90)->save(public_path('/marcasimg/' . $foto.'.webp'));
            $marca->foto_marca=$foto.'.webp';
        }
        $marca->slug_marca=Str::slug($marca->nombre_marca.'-'.time());
        $marca->status="ACTIVO";
        $marca->save();
        alert()->success('XpressComerce', 'Marca registrada correctamente');
        return Redirect::to('/marca');
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
    public function edit($slug_marca)
    {
        $marca=Marca::where('slug_marca','=',$slug_marca)->firstOrFail();
        return view('intAdmin.intMarcas.edit',compact('marca'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug_marca)
    {
        $marca=Marca::where('slug_marca','=',$slug_marca)->firstOrFail();
        $marca->nombre_marca=$request->input('nombre');
        if($request->hasFile('imagen')){
            $file_path = public_path() . "/marcasimg/$marca->foto_marca";
            \File::delete($file_path);

            $file=$request->file('imagen');
            $foto=$marca->nombre_marca.$file->getClientOriginalExtension();
            $image= Image::make($file)->encode('webp',90)->save(public_path('/marcasimg/' . $foto.'.webp'));
            $marca->foto_marca=$foto.'.webp';
        }
        $marca->slug_marca=Str::slug($marca->nombre_marca.'-'.time());
        $marca->status="ACTIVO";
        $marca->save();
        alert()->success('XpressComerce', 'Marca editada correctamente');
        return Redirect::to('/marca');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug_marca)
    {
        $marca=Marca::where('slug_marca','=',$slug_marca)->firstOrFail();
        $marca->status="INACTIVO";
        $marca->save();
        alert()->warning('XpressComerce', 'Estado editado correctamente');
        return Redirect::to('/marca');
    }
}
