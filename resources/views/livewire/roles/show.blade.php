@can('role_admin')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="card card-primary">
                            <div class="card-header" style="display: flex; justify-content: center;">
                                <h3 class="card-title">PERMISOS ASIGANDOS A ROL</h3>
                            </div>
                            <form>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="card bg-gradient-light shadow-lg">
                                            <span
                                                class="badge rounded-pill bg-info w-30 mt-n2 mx-auto text-white">Detalle</span>
                                            <div class="card-header text-center pt-4 pb-3 bg-transparent">
                                                <h1 class="font-weight-bold mt-2 text-white">
                                                    <small class="text-lg mb-auto"></small><small
                                                        class="text-lg text-dark">Rol
                                                        : {{ $name }}</small>
                                                </h1>
                                            </div>
                                            <div class="card-body text-lg-start text-center pt-0">
                                                <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                                    <i class="fas fa-user-secret my-auto text-dark"></i>
                                                    <span class="ps-3 fw-bold text-dark">&nbsp; Estos son los permisos
                                                        asignados a tu
                                                        rol</span>
                                                </div>
                                                <div class="d-flex justify-content-lg-start justify-content-center p-2">
                                                    <i class="fas fa-user-secret my-auto text-dark"></i>
                                                    <span class="ps-3 text-dark">&nbsp; Permisos asignados:</span>
                                                </div>
                                                <span class="ps-3 text-white">
                                                    @forelse ($selectedPermissions as $permission)
                                                        <span
                                                            class="badge rounded-pill bg-success text-white mt-2">{{ $permission }}</span>
                                                    @empty
                                                        <span class="badge bg-danger">No tiene permisos
                                                            asignados</span>
                                                    @endforelse
                                                </span>
                                                <div class="d-flex justify-content-center">
                                                    <a href="{{ route('roles.index', ['search' => $search]) }}"
                                                        class="btn btn-info mt-3"><i
                                                            class="fas fa-arrow-alt-circle-left"></i>
                                                        Regresar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endcan
