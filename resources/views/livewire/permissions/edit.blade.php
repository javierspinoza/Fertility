@can('permission_admin')
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
                                <div class="card-footer d-flex justify-content-center mb-3">
                                    <button wire:click="update" wire:loading.attr="disabled" wire:tarjet="update"
                                        type="button"
                                        class="btn btn-sm btn-danger">Actualizar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="{{ route('permissions.index', ['search' => $search]) }}" wire:navigate
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
