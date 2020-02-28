<!--COMPLETA: extiende el layout -->
@extends('layouts.app')
<!--COMPLETA: empieza la sección -->
@section('content')
<div class="container">
	<div class="col-sm-offset-2 col-sm-8">

		<!-- En este punto IRA el formulario para añadir una nueva actividad -->
		<div class="panel panel-default">
			<div class="panel-heading">
				Nueva Actividad
			</div>

			<div class="panel-body">
				<!-- Mostrar errores de validación -->
				@include('common.errors')


				<!-- Formulario para añadir una actividad -->
				<form action="{{url('/inventario')}}" method="POST" class="form-horizontal">
					<!-- Evitar XSS Cross Site Scripting -->
					{{csrf_field()}}

					<!--Instalaciones-->
					@if (count($instalaciones) > 0)
					<select id="aula" name="aula">
						<option value="" hidden>--SELECCIONE AULA--</option>
						@foreach ($instalaciones as $instalacion)
						@php ($aula = $instalacion->clave_instalacion)
						<option value="{{$aula}}" {{ ( old( "aula" ) == $aula ? "selected":"" ) }}> {{$aula}} </option>
						@endforeach
					</select>
					@endif

					<!--Articulos-->
					@if (count($articulos) > 0)
					<select id="articulo" name="articulo">
						<option value="" hidden>--SELECCIONE ARTICULO--</option>
						@foreach ($articulos as $articulo)
						@php ($nombre = $articulo->articulo)
						@php ($codigo = $articulo->codigo)
						<option value="{{$codigo}}|{{$nombre}}" {{ ( old( "articulo" ) == "$codigo|$nombre" ? "selected":"" ) }}> {{$nombre}} </option>
						@endforeach
					</select>
					@endif

					<!--Cantidad-->
					<input type="range" min="1" value="{{old('cantidadArticulos','1')}}" id="cantidadArticulos" name="cantidadArticulos">

					<!--Fecha-->
					<label for="fecha">Fecha compra: </label><br />
					<input type="date" id="fecha" name="fecha" value="{{old('fecha')}}" /><br />

					<!--Observaciones-->
					<label for="observaciones">Observaciones:</label><br />
					<textarea id="observaciones" name="observaciones" rows="6" cols="40" maxlength="250">{{old('observaciones')}}</textarea><br />

					<!-- Add Actividad Button -->
					<div class="form-group">
						<div class="col-sm-offset-3 col-sm-6">
							<button type="submit" class="btn btn-default">
								<i class="fa fa-plus"></i>Nuevo Inventario
							</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<!-- Actividades Actuales -->
		@if (count($inventarios) > 0)
		<div class="panel panel-default">
			<div class="panel-heading">
				Inventario Actual
			</div>

			<div class="panel-body">
				<table class="table table-striped task-table">
					<thead>
						<th>Instalacion</th>
						<th>Codigo Articulo</th>
						<th>Articulo</th>
						<th>Cantidad</th>
						<th>Observaciones</th>
					</thead>
					<tbody>
						@foreach ($inventarios as $inventario)
						<tr>
							<td class="table-text">
								<div>{{ $inventario['clave_instalacion'] }}</div>
							</td>
							<td class="table-text">
								<div>{{ $inventario->codigo_articulo }}</div>
							</td>
							<td class="table-text">
								<div>{{ $inventario->articulo }}</div>
							</td>
							<td class="table-text">
								<div>{{ $inventario->cantidad }}</div>
							</td>
							<td class="table-text">
								<div>{{ date('d-m-Y', strtotime($inventario->fecha_compra))}}</div>
							</td>
							<td class="table-text">
								<div>{{ $inventario->observaciones }}</div>
							</td>
							<td>
								<form action="{{url('/inventario/borrarinventario')}}" method="POST">
									{{ csrf_field() }}
									<!--{{ method_field('DELETE') }}-->
									<input type="hidden" name="clave_instalacion" value="{{$inventario->clave_instalacion}}" />
									<input type="hidden" name="codigo_articulo" value="{{$inventario->codigo_articulo}}" />
									<button type="submit" class="btn btn-danger">
										<i class="fa fa-trash"></i>Eliminar
									</button>
								</form>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
		@endif
	</div>
</div>

<!--COMPLETA: termina la sección -->
@endsection