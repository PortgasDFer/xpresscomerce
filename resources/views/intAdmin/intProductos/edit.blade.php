@extends('layouts.admin')
@section('content')
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Productos</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="/">Home</a></li>
            <li class="breadcrumb-item"><a href="/products">Listado de productos</a></li>
            <li class="breadcrumb-item active">Editar Producto {{$producto->nombre_producto}}</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-9 mx-auto">
          <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Editar Producto {{$producto->nombre_producto}}</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form action="/products/{{$producto->slug_producto}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" value="{{$producto->nombre_producto}}">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Descripción</label>
                    <input type="text" class="form-control" id="descripcion" name="descripcion" value="{{$producto->descrip_producto}}" >
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Precio</label>
                    <input type="text" class="form-control" id="precio" name="precio" value="{{$producto->precio}}">
                  </div>
                  <div class="form-group">
                    <label for="">Foto actual</label>
                    <img src="/productosimg/{{$producto->foto_producto}}" alt="" class="img-fluid">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputFile">Cambiar foto del producto</label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="exampleInputFile" name="imagen">
                        <label class="custom-file-label" for="exampleInputFile">Examinar</label>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="">Disponibilidad</label>
                    <select id="inputState" class="form-control" name="disponibilidad">
                      <option selected value="{{$producto->disponibilidad}}">{{$producto->disponibilidad}}</option>
                      <option disabled="">Seleccione</option>
                      <option value="INMEDIATA">Inmediata</option>
                      <option value="INDEFINIDA">Consulte disponibilidad</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="">Categoria</label>
                    <select id="inputState" class="form-control" name="categoria">
                      <option selected value="{{$producto->id_categoria}}">Conservar en la misma categoría</option>
                      @foreach($categorias as $cat)
                        <option value="{{$cat->id_categoria}}"> {{$cat->nombre_categoria}}</option>
                      @endforeach
                    </select>
                  </div>    
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                </div>
              </form>
            </div>
            <!-- /.card -->
        </div>
      </div>
    </div>
  </section>
@endsection