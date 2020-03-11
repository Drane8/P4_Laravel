@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-md-center">
		<div class="col-md-10 ">
			<div class="card my-4">
				<div class="card-header">
					Consultar inventario/s
				</div>

				<div class="card-body">
					<!-- Mostrar errores de validación -->
					{{-- @include('common.errors') --}}


					<!-- Formulario para consultar inventarios -->
					<form action="{{url('/consultar')}}" method="POST">
						<!-- Evitar XSS Cross Site Scripting -->
						{{csrf_field()}}

						<div class="form-row justify-content-center">
							<div class="form-group col-md-6">
								<!--Instalaciones-->
								@if (count($instalaciones) > 0)
									<div class="container">
										<div class="selectionator">
											<span class="search">
												<span class="shadow"></span>
												<span class="overlay"></span>
												SELECCIONE AULA
											</span>
											<div class="menu">
												<ul class="optgroup">
													@foreach ($instalaciones as $instalacion)
													@php ($aula = $instalacion->clave_instalacion)
													<li>
														<input type="checkbox" name="aulas[]" value="{{$aula}}" id="{{$aula}}" {{ ( old( "aulas" ) == $aula ? "selected":"" ) }} />
														<label for="{{$aula}}">{{$aula}}</label>
													</li>
													@endforeach
												</ul>
											</div>
											@endif
										</div>
										<div class=" search form-control errorConsultar 
												@if($errors->has('aulas')) 
													is-invalid 
												@elseif(count($errors) > 0) 
													is-valid 
												@endif"></div>
										<div class="mensajeError invalid-feedback">
												{{$errors->first('aulas')}}
											</div>
									</div>
									<!--Boton para consultar inventarios -->
									<div class="form-group row justify-content-center">
										<button type="submit" class="btn btn-info">
											<i class="fa fa-plus"></i> Consultar
										</button>
									</div>
					</form>
				</div>
			</div>
		</div>

		</div>
		
		<!-- Tabla con los inventarios -->
		@if (isset($inventarios) && count($inventarios) > 0)
		<div class="card">
			<div class="card-header">
				Inventario Actual
			</div>

			<div class="card-body">
				<table class="table table-responsive-lg table-striped table-borderless">
				<thead class="bg-info">
						<tr>
						<th>Aula</th>
						<th>Cod. Art.</th>
						<th>Articulo</th>
						<th>Cantidad</th>
						<th>Fecha</th>
						<th>Observaciones</th>
						<th></th>
						</tr>
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
@endsection