@push('micss')
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ secure_asset('assetsDashboard/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@endpush
@can('user_admin')
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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputName">Nombre Completo</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="exampleInputName" wire:model="name">
                                                @error('name')
                                                    <span class="error text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputEmail">Email</label>
                                                <input type="email" class="form-control form-control-sm"
                                                    id="exampleInputEmail" wire:model="email">
                                                @error('email')
                                                    <span class="error text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="exampleInputPassword">Contraseña</label>
                                                <input type="password" class="form-control form-control-sm"
                                                    id="exampleInputPassword" wire:model="password">
                                                @error('password')
                                                    <span class="error text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <label
                                        class="col-md-12 col-form-label ms-3 text-uppercase text-center fw-bold text-success">Actualizar
                                        rol a usuario</label>
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
                                                            <th class="text-center">ROLES</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($roles as $role)
                                                            <tr>
                                                                <td>
                                                                    <div class="icheck-primary d-inline">
                                                                        <input class="form-check-input" type="checkbox"
                                                                            id="checkboxRole{{ $role->id }}"
                                                                            data-checkboxes="mygroup" wire:model="assignRol"
                                                                            value="{{ $role->id }}">
                                                                        <label
                                                                            for="checkboxRole{{ $role->id }}"></label>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    {{ $role->name }}
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
                                    <a href="{{ route('users.index', ['search' => $search]) }}" wire:navigate
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
