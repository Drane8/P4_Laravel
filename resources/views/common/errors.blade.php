@if (count($errors) > 0)
	<!-- Mostrar la lista de errores  -->
	<div class="alert alert-danger">
		<strong>¡¡Ha habido errores!!</strong>

		<br><br>

		<ul>
		@php ($errorAnterior = "")
			@foreach ($errors->all() as $error)
			<!--Comprobamos que el error no este repetido -->
				@if($errorAnterior != $error)
					<li>{{ $error }}</li>
				@endif
				@php ($errorAnterior = $error)
			@endforeach
		</ul>
	</div>
@endif
