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
					<form action="{{url('/inventario')}}" method="POST">
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

							<div class="form-group col-md-6">
								<!--Articulos-->
								@if (count($articulos) > 0)
								<select id="articulo" name="articulo" class="form-control 
								@if($errors->has('articulo')) 
									is-invalid 
								@elseif(count($errors) > 0) 
									is-valid 
								@endif">
									<option value="" hidden>--SELECCIONE ARTICULO--</option>
									@foreach ($articulos as $articulo)
									@php ($nombre = $articulo->articulo)
									@php ($codigo = $articulo->codigo)
									<option value="{{$codigo}}|{{$nombre}}" {{ ( old( "articulo" ) == "$codigo|$nombre" ? "selected":"" ) }}> {{$nombre}} </option>
									@endforeach
								</select>
								<div class="invalid-feedback">
								{{$errors->first('articulo')}}
								</div>
								@endif
							</div>
						</div>

						<div class="form-group">
							<!--Cantidad-->
							<label for="cantidadArticulos">Cantidad</label><br>
							<div class="range-slider form-control py-1 @if($errors->has('cantidadArticulos')) 
									is-invalid 
								@elseif(count($errors) > 0) 
									is-valid 
								@endif">
								<input type="range" min="-10" max="120" value="{{old('cantidadArticulos','1')}}" id="cantidadArticulos" name="cantidadArticulos" class="range-slider__range">
								<span class="range-slider__value">0</span>
							</div>
							<div class="invalid-feedback">
								{{$errors->first('cantidadArticulos')}}
								</div>
						</div>


						<div class="form-row">


							<div class="form-group col-md-6">
								<!--Observaciones-->
								<label for="observaciones">Observaciones:</label><br />
								<textarea id="observaciones" name="observaciones" rows="6" style="min-width: 100%" class="form-control 
								@if($errors->has('observaciones')) 
									is-invalid 
								@elseif(count($errors) > 0) 
									is-valid 
								@endif">{{old('observaciones')}}</textarea>
								<div class="invalid-feedback">
									Introduzca menos de 250 caracteres
								</div>
							</div>

							<div class="form-group col-md-6">
								<!--Fecha-->
								<label for="fecha">Fecha compra: </label><br />
								<input type="date" id="fecha" name="fecha" value="{{old('fecha')}}" class="form-control 
								@if($errors->has('fecha')) 
									is-invalid 
								@elseif(count($errors) > 0) 
									is-valid 
								@endif" />
								<div class="invalid-feedback">
									Seleccione una fecha anterior a hoy
								</div>
							</div>

						</div>
						<!-- Add Actividad Button -->
						<div class="form-group row justify-content-center">
							<button type="submit" class="btn btn-info">
								<i class="fa fa-plus"></i> Añadir Inventario
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