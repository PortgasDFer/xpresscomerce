<form method="POST" action="/categories/{{$slug_categoria}}">
	@method('DELETE')
	@csrf
	<button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title='Delete'><i class="fa fa-toggle-off" aria-hidden="true"></i></button>
</form> 
