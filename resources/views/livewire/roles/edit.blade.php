@push('micss')
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ secure_asset('assetsDashboard/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush
@can('role_admin')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="card card-primary">
                            <div class="card-header" style="display: flex; justify-content: center;">
                                <h3 class="card-title">ACTUALIZAR DATOS</h3>
                            </div>
                            <form>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInput">Nombre</label>
                                                <input type="text" class="form-control form-control-sm" id="exampleInput"
                                                    wire:model="name">
                                                @error('name')
                                                    <span class="error text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label
                                        class="col-md-12 col-form-label ms-3 text-uppercase text-center fw-bold text-success">Asignar
                                        permisos a rol</label>
                                </div>
                                <div class="card-body px-0 mt-n4 tab-pane active">
                                    <div class="table-responsive p-0 d-flex justify-content-center"
                                        style="max-height: 250px; overflow-y: auto;">
                                        <div class="col-md-5">
                                            <div>
                                                <table
                                                    class="table table-bordered shadow-lg display nowrap table-striped mt-4"
                                                    style="width:100%">
                                                    <thead class="bg-info text-white">
                                                        <tr>
                                                            <th class="col-md-2">ACCIONES</th>
                                                            <th class="text-center">PERMISOS</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($permissions as $permission)
                                                            <tr>
                                                                <td style="padding-left: 25px">
                                                                    <div class="icheck-primary d-inline">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            id="checkboxPermission{{ $permission->id }}"
                                                                            data-checkboxes="mygroup"
                                                                            wire:model.live="selectedPermissions"
                                                                            value="{{ $permission->id }}"
                                                                            {{ in_array($permission->id, $selectedPermissions) ? 'checked' : '' }}>
                                                                        <label
                                                                            for="checkboxPermission{{ $permission->id }}"></label>
                                                                    </div>
                                                                </td>
                                                                <td style="padding-left: 25px">
                                                                    {{ $permission->name }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-center mb-3">
                                    <button wire:click="update" wire:loading.attr="disabled" wire:tarjet="update"
                                        type="button"
                                        class="btn btn-sm btn-danger">Actualizar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="{{ route('roles.index', ['search' => $search]) }}" wire:navigate
                                        class="btn btn-sm btn-success" role="button" aria-pressed="true">Regresar
                                        <i class="fas fa-arrow-left ms-1"></i></a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endcan
