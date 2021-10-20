@extends('layouts.admin')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Marcas</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active">Listado de marcas</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <section class="content">
    	<div class="container-fluid">
    		<div class="row">
    			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    				<div class="small-box bg-primary">
		              <div class="inner">
		                <h3>Registrar</h3>

		                <p>Nueva Marca</p>
		              </div>
		              <div class="icon">
		                <i class="fa fa-child" aria-hidden="true"></i>
		              </div>
		              <a href="/marca/create" class="small-box-footer">Click aquí <i class="fas fa-arrow-circle-right"></i></a>
		            </div>
    			</div>
    			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    				<div class="small-box bg-indigo">
		              <div class="inner">
		                <h3>{{$noMarcas}}</h3>
		                <p>Registradas</p>
		              </div>
		              <div class="icon">
		                <i class="ion ion-bag"></i>
		              </div>
		            </div>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-12 col-sm-12 col-md-12">
    				<div class="table-responsive">
    					<table class="table table-bordered" id="marcas">
 							<thead>
							    <tr>
							      <th scope="col">Nombre</th>
							      <th scope="col">Estado</th>
							      <th scope="col">Editar</th>
							      <th scope="col">Cambiar Estado</th>
							    </tr>
  							</thead>
  							<tbody>
  								
  							</tbody>
  						</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </section>
@endsection
@section('scripts')
<script>
$(document).ready( function () {
    $('#marcas').DataTable({
        "processing": true,
        "serverSide": true,
        "autoWidth": false,
        "ajax": "/obtenerMarcas",
        "columns": [
            {data:'nombre_marca'},
            {data:'status'},
            {data:'edit',orderable:false, searchable:false},
            {data:'statusBtn',orderable:false, searchable:false}
        ],
        language: {
          "decimal": "",
          "emptyTable": "No hay información",
          "info": "Mostrando _START_ a _END_ de _TOTAL_ Registros",
          "infoEmpty": "Mostrando 0 to 0 of 0 Documentos",
          "infoFiltered": "(Filtrado de _MAX_ total entradas)",
          "infoPostFix": "",
          "thousands": ",",
          "lengthMenu": "Mostrar _MENU_ Registros",
          "loadingRecords": "Cargando...",
          "processing": "Procesando...",
          "search": "Buscar:",
          "zeroRecords": "Sin resultados encontrados",
          "paginate": {
              "first": "Primero",
              "last": "Ultimo",
              "next": "Siguiente",
              "previous": "Anterior"
          }
        }
    });
});
</script>
@endsection