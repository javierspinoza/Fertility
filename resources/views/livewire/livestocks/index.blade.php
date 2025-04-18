<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card card-primary">
                        <div class="card-header" style="display: flex; justify-content: center;">
                            <h3 class="card-title">DATOS DE FINCA REGISTRADOS</h3>
                        </div>
                        @can('ganado_admin')
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-end mb-n4">
                                    <a href="{{ route('livestock.create', ['search' => $search]) }}" wire:navigate
                                        class="btn btn-sm btn-warning me-3 mt-3" role="button"
                                        aria-pressed="true">NUEVO</a>
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
                                @if ($livestocks->count())
                                    <div class="row table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    @can('ganado_admin')
                                                        <th>OPCIONES</th>
                                                    @endcan
                                                    <th>FINCA</th>
                                                    <th>TIPO DE GANADO</th>
                                                    <th>ESTADO PRODUCTIVO</th>
                                                    <th role="button" wire:click="order('created_at')">FECHA CREACIÓN
                                                        <i class="fas fa-sort"></i>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($livestocks as $livestock)
                                                    <tr>
                                                        @can('ganado_admin')
                                                            <td class="td-actions text-center">
                                                                <a href="{{ route('livestock.edit', ['id' => $livestock->id, 'search' => $search, 'page' => $livestocks->currentPage()]) }}"
                                                                    wire:navigate
                                                                    class="btn btn-sm btn-success btn btn-warning btn-icon-only rounded-circle"
                                                                    title="Editar permiso">
                                                                    <span class="btn-inner--icon">
                                                                        <i style="font-size: 12px"
                                                                            class="fas fa-pencil-alt"></i>
                                                                    </span>
                                                                </a>
                                                                &nbsp;&nbsp;&nbsp;
                                                                <button wire:click="confirmRemoved({{ $livestock->id }})"
                                                                    class="btn btn-sm btn-danger btn-icon-only rounded-circle"
                                                                    title="Eliminar">
                                                                    <span class="btn-inner--icon"><i style="font-size: 12px"
                                                                            class="fas fa-trash"></i></span>
                                                                </button>
                                                            </td>
                                                        @endcan
                                                        <td>{{ $livestock->farms->name }}
                                                        </td>
                                                        <td>{{ $livestock->type_livestock }}
                                                        </td>
                                                        <td>
                                                            {{ $livestock->state_productive }}
                                                        </td>
                                                        <td>
                                                            {{ $livestock->created_at->toFormattedDateString() }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @if ($livestocks->hasPages())
                                        <div class="pagination-container">
                                            {{ $livestocks->links() }}
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
    <script src="{{ asset('assetsDashboard/dist/js/sweetalert2.js') }}"></script>
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
                    @this.deleteLivestock();
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
