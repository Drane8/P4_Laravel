<!--COMPLETA: extiende el layout -->
@extends('layouts.app')
<!--COMPLETA: empieza la sección -->
@section('content')
<div class="container">
	<div class="row justify-content-md-center">
		<div class="col-md-10 ">

			<!-- En este punto IRA el formulario para añadir una nueva actividad -->
			<div class="card my-4">
				<div class="card-header">
					Nuevo Inventario
				</div>

				<div class="card-body">
					<!-- Mostrar errores de validación -->
					@include('common.errors')


					<!-- Formulario para añadir una actividad -->
					<form action="{{url('/consultar')}}" method="POST">
						<!-- Evitar XSS Cross Site Scripting -->
						{{csrf_field()}}

						<div class="form-row">
							<div class="form-group col-md-6">
								<!--Instalaciones-->
								@if (count($instalaciones) > 0)
								<select id="aula" name="aula" class="form-control 
								@if($errors->has('aula')) 
									is-invalid 
								@elseif(count($errors) > 0) 
									is-valid 
								@endif">
									<option value="" hidden>--SELECCIONE AULA--</option>
									@foreach ($instalaciones as $instalacion)
									@php ($aula = $instalacion->clave_instalacion)
									<option value="{{$aula}}" {{ ( old( "aula" ) == $aula ? "selected":"" ) }}> {{$aula}} </option>
									@endforeach
								</select>
								<div class="invalid-feedback">
									{{$errors->first('aula')}}
								</div>
								@endif
							</div>

						</div>

						<!-- Add Actividad Button -->
						<div class="form-group row justify-content-center">
							<button type="submit" class="btn btn-info">
								<i class="fa fa-plus"></i> Consultar
							</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<!-- Actividades Actuales -->
		@if (count($inventarios) > 0)
		<div class="card">
			<div class="card-header">
				Inventario Actual
			</div>

			<div class="card-body">
				<table class="table table-striped task-table">
					<thead>
						<th>Instalacion</th>
						<th>Codigo Articulo</th>
						<th>Articulo</th>
						<th>Cantidad</th>
						<th>Fecha</th>
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
								<div>{{ $inventario->fecha_compra == null ? "" : date('d-m-Y', strtotime($inventario->fecha_compra))}}</div>
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