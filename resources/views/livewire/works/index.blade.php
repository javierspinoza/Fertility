<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card card-primary">
                        <div class="card-header" style="display: flex; justify-content: center;">
                            <h3 class="card-title">TRABAJOS REGISTRADOS</h3>
                        </div>
                        @can('trabajo_admin')
                            <div class="row no-gutters">
                                <div class="col-sm-6 col-md-8">
                                    <form method="POST" action="{{ route('trabajos-agendados.pdf') }}" target="_blank">
                                        @csrf
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInput">Fecha Trabajo</label>
                                                <input type="date" class="form-control form-control-sm" id="exampleInput"
                                                    name="date_trabajo">
                                                @if ($errors->has('date_trabajo'))
                                                    <span class="error text-danger"
                                                        for="input-date_trabajo">{{ $errors->first('date_trabajo') }}</span>
                                                @endif
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i style="font-size: 22px" class="far fa-file-pdf"></i> Descargar PDF
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-6 col-md-4 d-flex justify-content-end mt-3 pr-1">
                                    <div>
                                        <a href="{{ route('work.create', ['search' => $search]) }}" wire:navigate
                                            class="btn btn-sm btn-warning me-3 mt-3" role="button"
                                            aria-pressed="true">Nuevo Trabajo</a>
                                    </div>
                                </div>
                            </div>
                        @endcan
                        <div class="card-body">
                            <div class="col-md-12 container">
                                <div class="row">
                                    <div class="col-md-9">
                                        <div class="input-group input-group-static my-4 mb-n1">
                                            <div class="d-flex justify-content-start">
                                                <label class="mb-n2 me-1">Mostrar &nbsp;</label>
                                                <select class="select-pagination" wire:model.live="cant"
                                                    id="choices-state">
                                                    <option value="5">5</option>
                                                    <option value="10">10</option>
                                                    <option value="30">30</option>
                                                    <option value="100">100</option>
                                                </select>
                                                <label class="mb-n2 ms-1">&nbsp; registros por pagina</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 ms-auto">
                                        <div class="form-group">
                                            <label for="exampleInput">Buscar</label>
                                            <input type="search" class="form-control form-control-sm"
                                                wire:model.live="search">
                                        </div>
                                    </div>
                                </div>
                                @if ($works->count())
                                    <div class="row table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    @can('trabajo_admin')
                                                        <th>OPCIONES</th>
                                                    @endcan
                                                    <th>N° TRABAJO</th>
                                                    <th>FINCA</th>
                                                    <th>FECHA TRABAJO</th>
                                                    <th>PRECIO TOTAL</th>
                                                    <th>ESTADO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($works as $work)
                                                    <tr>
                                                        @can('trabajo_admin')
                                                            <td class="td-actions text-center">
                                                                <a href="{{ route('work.edit', ['id' => $work->id, 'search' => $search, 'page' => $works->currentPage()]) }}"
                                                                    wire:navigate
                                                                    class="btn btn-sm btn-success btn btn-warning btn-icon-only rounded-circle"
                                                                    title="Editar finca">
                                                                    <span class="btn-inner--icon">
                                                                        <i style="font-size: 12px"
                                                                            class="fas fa-pencil-alt"></i>
                                                                    </span>
                                                                </a>
                                                                <button wire:click="confirmRemoved({{ $work->id }})"
                                                                    class="btn btn-sm btn-danger btn-icon-only rounded-circle"
                                                                    title="Eliminar">
                                                                    <span class="btn-inner--icon"><i style="font-size: 12px"
                                                                            class="fas fa-trash"></i></span>
                                                                </button>
                                                            </td>
                                                        @endcan
                                                        <td>{{ $work->work_number }}</td>
                                                        <td>{{ $work->farms->name }}</td>
                                                        <td>
                                                            {{ date('Y-m-d h:i:s A', strtotime($work->date_work)) }}
                                                        </td>
                                                        <td>$
                                                            {{ number_format($work->price_overall, 0, ',', '.') }}</td>
                                                        <td>
                                                            @if ($work->status == 'TRABAJO PENDIENTE')
                                                                <span class="badge bg-danger mt-2"> TRABAJO
                                                                    PENDIENTE</span>
                                                            @else
                                                                <span class="badge bg-info mt-2"> TRABAJO
                                                                    COMPLETADO</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @if ($works->hasPages())
                                        <div class="pagination-container">
                                            {{ $works->links() }}
                                        </div>
                                    @endif
                                @else
                                    <div class="d-flex justify-content-center mb-3">
                                        <div class="p-2">No existe ningún registro</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@push('mijs')
    {{-- sweetalert2 CDN --}}
    <script src="{{ secure_asset('assetsDashboard/dist/js/sweetalert2.js') }}"></script>
    {{-- alerta para eliminar registros --}}
    <script>
        window.addEventListener('confirmDeletion', function() {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '¡Sí, bórralo!',
                cancelButtonText: '¡Cancelar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.deleteWork();
                }
            });
        });

        window.addEventListener('deleted', function() {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '¡Registro eliminado exitosamente!',
                showConfirmButton: false,
                timer: 1100
            })
        });

        window.addEventListener('errordeleted', function() {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: '¡No puedes eliminar este registro porque está asociado a otros datos!',
                showConfirmButton: false,
                timer: 1100
            })
        });

        window.addEventListener('MatchErrorData', function() {
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: '¡Ha ocurrido un error, vuelve a intentarlo!',
                showConfirmButton: false,
                timer: 1100
            })
        });
    </script>

    @if (session('crearRegistro'))
        <script>
            Swal.fire({
                title: '{{ session('crearRegistro') }}',
                // text: '{{ session('crearRegistro') }}',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar',
                showConfirmButton: false,
                timer: 1400
            });
        </script>
    @endif

    @if (session('actualizar'))
        <script>
            Swal.fire({
                title: '{{ session('actualizar') }}',
                // text: '{{ session('actualizar') }}',
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Aceptar',
                showConfirmButton: false,
                timer: 1400
            });
        </script>
    @endif
@endpush
