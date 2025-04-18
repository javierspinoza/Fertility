<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 mt-3">
                    <div class="card card-primary">
                        <div class="card-header" style="display: flex; justify-content: center;">
                            <h3 class="card-title">NOTIFICACIONES SIN LEER</h3>
                        </div>
                        <form>
                            <div class="card-body">
                                @if (count($unreadNotifications) > 0)
                                    <div class="row">
                                        @foreach ($unreadNotifications as $notification)
                                            <div class="col-md-4">
                                                <div class="card bg-gradient-light shadow-lg">
                                                    <span
                                                        class="badge rounded-pill bg-info w-30 mt-n2 mx-auto text-white">Notificaciones</span>
                                                    <div class="card-header text-center pt-4 pb-3 bg-transparent">
                                                        <h1 class="font-weight-bold mt-2 text-white">
                                                            <small class="text-lg mb-auto"></small><small
                                                                class="text-lg text-dark">Detalle</small>
                                                        </h1>
                                                    </div>
                                                    <div class="card-body text-lg-start text-center pt-0">
                                                        <div
                                                            class="d-flex justify-content-lg-start justify-content-center p-2">
                                                            <i class="fas fa-user-secret my-auto text-dark"></i>
                                                            <span class="ps-3 text-dark">&nbsp; N° Trabajo:
                                                                {{ $notification->data['work_number'] }} </span>
                                                        </div>
                                                        <div
                                                            class="d-flex justify-content-lg-start justify-content-center p-2">
                                                            <i class="fas fa-user-secret my-auto text-dark"></i>
                                                            <span class="ps-3 text-dark">&nbsp; Precio Trabajo:
                                                                {{ $notification->data['price_overall'] }} </span>
                                                        </div>
                                                        <div
                                                            class="d-flex justify-content-lg-start justify-content-center p-2">
                                                            <i class="fas fa-user-secret my-auto text-dark"></i>
                                                            <span class="ps-3 text-dark">&nbsp; Fecha recordatorio:
                                                                {{ date('Y-m-d h:i:s A', strtotime($notification->data['date_work'])) }}
                                                            </span>
                                                        </div>
                                                        <div
                                                            class="d-flex justify-content-lg-start justify-content-center p-2">
                                                            <i class="fas fa-user-secret my-auto text-dark"></i>
                                                            <span class="ps-3 text-dark">&nbsp; Estado:
                                                                {{ $notification->data['status'] }} </span>
                                                        </div>
                                                        <div
                                                            class="d-flex justify-content-lg-start justify-content-center p-2">
                                                            <i class="fas fa-user-secret my-auto text-dark"></i>
                                                            <span class="ps-3 text-dark">&nbsp; Finca:
                                                                {{ $notification->data['farm_name'] }} </span>
                                                        </div>
                                                        <div class="d-flex justify-content-center">
                                                            <button
                                                                wire:click.prevent="markAsReadOne('{{ $notification->id }}')"
                                                                class="btn btn-info mt-3"><i
                                                                    class="fas fa-arrow-alt-circle-left"></i>
                                                                Marcar Como Laída</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                        {{-- <button wire:click="markAllAsRead">Marcar todas como leídas</button> --}}
                                    </div>
                                @else
                                    <div class="text-center py-4">
                                        <h3>No tienes notificaciones</h3>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@push('mijs')
    {{-- sweetalert2 CDN --}}
    <script src="{{ asset('assetsDashboard/dist/js/sweetalert2.js') }}"></script>
    {{-- alerta para maracar notificaciones como leidas --}}
    @if (session('readok'))
        <script>
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'Notificación marcada como leída correctamente!!',
                showConfirmButton: false,
                timer: 1100
            })
        </script>
    @endif
@endpush
