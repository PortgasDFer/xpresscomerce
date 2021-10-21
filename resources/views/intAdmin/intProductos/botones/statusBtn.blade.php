<form method="POST" action="/products/{{$slug_producto}}">
	@method('DELETE')
	@csrf
	<button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title='Delete'><i class="fa fa-toggle-off" aria-hidden="true"></i></button>
</form> 
