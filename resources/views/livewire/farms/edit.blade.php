@push('micss')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('assetsDashboard/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assetsDashboard/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush
@can('fincas_admin')
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
                                                <label for="exampleInput">Nombre de Finca</label>
                                                <input type="text" class="form-control form-control-sm" id="exampleInput"
                                                    wire:model="name" autofocus>
                                                @error('name')
                                                    <span class="error text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" wire:ignore>
                                                <label>Seleccione dueño de finca</label>
                                                <select class="form-control form-control-sm select2 selectPro0"
                                                    style="width: 100%;" wire:model="user_owner_id">
                                                    <option value="" selected>Selecciona una opción</option>
                                                    @foreach ($userFarms as $userFarm)
                                                        <option value="{{ $userFarm->id }}">
                                                            {{ $userFarm->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('user_owner_id')
                                                <span class="error text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group" wire:ignore>
                                                <label>Seleccione veterinario asignado</label>
                                                <select class="form-control form-control-sm select2 selectPro1 mp-2"
                                                    style="width: 100%;" wire:model="user_veterinarian_charge_id">
                                                    <option value="" selected>Selecciona una opción</option>
                                                    @foreach ($userVeterinarians as $userVeterinarian)
                                                        <option value="{{ $userVeterinarian->id }}">
                                                            {{ $userVeterinarian->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @error('user_veterinarian_charge_id')
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
                                    <button wire:click="update" wire:loading.attr="disabled" wire:tarjet="update"
                                        type="button"
                                        class="btn btn-sm btn-primary">Actualizar</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="{{ route('farm.index', ['search' => $search]) }}" wire:navigate
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
                @this.set('user_owner_id', $(this).val())
            })
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.selectPro1').select2()
            $('.selectPro1').on('change', function() {
                @this.set('user_veterinarian_charge_id', $(this).val())
            })
        });
    </script>
@endpush
