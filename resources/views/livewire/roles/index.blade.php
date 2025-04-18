@can('role_admin')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 mt-3">
                        <div class="card card-primary">
                            <div class="card-header" style="display: flex; justify-content: center;">
                                <h3 class="card-title">ROLES REGISTRADOS</h3>
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-end mb-n4">
                                    <a href="{{ route('roles.create', ['search' => $search]) }}" wire:navigate
                                        class="btn btn-sm btn-warning me-3 mt-3" role="button"
                                        aria-pressed="true">NUEVO</a>
                                </div>
                            </div>
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
                                    @if ($roles->count())
                                        <div class="row table-responsive">
                                            <table class="table table-sm table-bordered">
                                                <thead class="bg-primary text-white">
                                                    <th>OPCIONES</th>
                                                    <th role="button" wire:click="order('name')">NOMBRE ROL<i
                                                            class="fas fa-sort"></i>
                                                    </th>
                                                    <th role="button" wire:click="order('created_at')">FECHA CREACIÓN <i
                                                            class="fas fa-sort"></i>
                                                    </th>
                                                    <th>VER PERMISOS ASIGNADOS</th>
                                                </thead>
                                                <tbody>
                                                    @foreach ($roles as $role)
                                                        <tr>
                                                            <td class="td-actions text-center">
                                                                <a href="{{ route('roles.edit', ['id' => $role->id, 'search' => $search, 'page' => $roles->currentPage()]) }}"
                                                                    wire:navigate
                                                                    class="btn btn-sm btn-success btn btn-warning btn-icon-only rounded-circle"
                                                                    title="Editar permiso">
                                                                    <span class="btn-inner--icon">
                                                                        <i style="font-size: 16px"
                                                                            class="fas fa-pencil-alt"></i>
                                                                    </span>
                                                                </a>
                                                                <button wire:click="confirmRemoved({{ $role->id }})"
                                                                    class="btn btn-sm btn-danger btn-icon-only rounded-circle"
                                                                    title="Eliminar">
                                                                    <span class="btn-inner--icon"><i style="font-size: 13px"
                                                                            class="fas fa-trash"></i></span>
                                                                </button>
                                                            </td>
                                                            <td style="padding-left: 25px">{{ $role->name }}</td>
                                                            <td style="padding-left: 25px">
                                                                {{ $role->created_at->toFormattedDateString() }}</td>
                                                            <td style="padding-left: 25px">
                                                                <a href="{{ route('roles.show', ['role_id' => $role->id, 'search' => $search, 'page' => $roles->currentPage()]) }}"
                                                                    wire:navigate
                                                                    class="btn btn-success btn-sm btn-icon-only rounded-circle"
                                                                    title="Ver permisos asignados">
                                                                    <i style="font-size: 12px" class="fas fa-eye-slash"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        @if ($roles->hasPages())
                                            <div class="pagination-container">
                                                {{ $roles->links() }}
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
@endcan
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
                    @this.deleteRole();
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
