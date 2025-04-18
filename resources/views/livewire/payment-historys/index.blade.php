<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card card-primary">
                        <div class="card-header" style="display: flex; justify-content: center;">
                            <h3 class="card-title">REGISTRO DE PAGOS</h3>
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
                                @if ($paymentHistorys->count())
                                    <div class="row table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead class="bg-primary text-white">
                                                <tr>
                                                    @can('pagos_admin')
                                                        <th>OPCIONES</th>
                                                    @endcan
                                                    <th>FECHA DE PAGO</th>
                                                    <th>FINCA</th>
                                                    <th>N° DE TRABAJO</th>
                                                    <th>TOTAL DE TRABAJO</th>
                                                    <th>ESTADO</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($paymentHistorys as $paymentHistory)
                                                    <tr>
                                                        @can('pagos_admin')
                                                            <td class="td-actions text-center">
                                                                <a href="{{ route('paymentHistorys.edit', ['id' => $paymentHistory->id, 'search' => $search, 'page' => $paymentHistorys->currentPage()]) }}"
                                                                    wire:navigate
                                                                    class="btn btn-sm btn-success btn btn-warning btn-icon-only rounded-circle"
                                                                    title="Editar pago">
                                                                    <span class="btn-inner--icon">
                                                                        <i style="font-size: 12px"
                                                                            class="fas fa-pencil-alt"></i>
                                                                    </span>
                                                                </a>
                                                            </td>
                                                        @endcan
                                                        <td>
                                                            @if ($paymentHistory->payment_receipt_date == null)
                                                                <h6>PENDIENTE</h6>
                                                            @else
                                                                <h6>
                                                                    {{ $paymentHistory->payment_receipt_date }}
                                                                </h6>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $paymentHistory->farms->name }}
                                                        </td>
                                                        <td>
                                                            {{ $paymentHistory->works->work_number }}</td>
                                                        <td>$
                                                            {{ number_format($paymentHistory->total_work_balance, 0, ',', '.') }}
                                                        </td>
                                                        <td>
                                                            @if ($paymentHistory->outstanding_balance == 0)
                                                                <span class="badge bg-info mt-2"> PAGO COMPLETADO</span>
                                                            @else
                                                                <span class="badge bg-danger mt-2"> AÚN DEBE </span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    @if ($paymentHistorys->hasPages())
                                        <div class="pagination-container">
                                            {{ $paymentHistorys->links() }}
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
