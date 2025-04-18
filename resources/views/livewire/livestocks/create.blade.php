@push('micss')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ secure_asset('assetsDashboard/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ secure_asset('assetsDashboard/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
@can('ganado_admin')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <div class="card card-primary">
                            <div class="card-header" style="display: flex; justify-content: center;">
                                <h3 class="card-title">REGISTRAR DATOS</h3>
                            </div>
                            <form>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group" wire:ignore>
                                                <label>Seleccione finca</label>
                                                <select class="form-control form-control-sm select2 selectPro0"
                                                    style="width: 100%;" wire:model="farms_id">
                                                    <option value="" selected>Selecciona una opción</option>
                                                    @foreach ($farms as $farm)
                                                        <option value="{{ $farm->id }}">
                                                            {{ $farm->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('farms_id')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" wire:ignore>
                                                <label>Tipo de ganado</label>
                                                <select class="form-control form-control-sm mp-2" style="width: 100%;"
                                                    wire:model="type_livestock">
                                                    <option value="" selected>Selecciona una opción</option>
                                                    <option value="VACA">Vaca</option>
                                                    <option value="NOVILLO">Novillo</option>
                                                    <option value="TERNERO">ternero</option>
                                                </select>
                                            </div>
                                            @error('type_livestock')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" wire:ignore>
                                                <label>Estado productivo</label>
                                                <select class="form-control form-control-sm mp-2" style="width: 100%;"
                                                    wire:model="state_productive">
                                                    <option value="" selected>Selecciona una opción</option>
                                                    <option value="INSEMINADO">Inseminado</option>
                                                    <option value="PALPADO">Palpado</option>
                                                    <option value="PARIDO">Parido</option>
                                                </select>
                                            </div>
                                            @error('state_productive')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Notas</label>
                                                <textarea class="form-control" wire:model="fast_notes" rows="4"></textarea>
                                            </div>
                                            @error('fast_notes')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-center mb-3">
                                    <button wire:click="store()" wire:loading.attr="disabled" wire:tarjet="store"
                                        type="button"
                                        class="btn btn-sm btn-primary">Guardar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="{{ route('livestock.index', ['search' => $search]) }}" wire:navigate
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
@push('mijs')
    <!-- Inicializar Select2 -->
    <script>
        $(document).ready(function() {
            $('.selectPro0').select2()
            $('.selectPro0').on('change', function() {
                @this.set('farms_id', $(this).val())
            })
        });
    </script>
@endpush
