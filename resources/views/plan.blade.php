@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between">
            <a href="{{ route('home') }}" class="btn btn-secondary mb-4 d-flex gap-2 align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-backspace-fill" viewBox="0 0 16 16">
                    <path
                        d="M15.683 3a2 2 0 0 0-2-2h-7.08a2 2 0 0 0-1.519.698L.241 7.35a1 1 0 0 0 0 1.302l4.843 5.65A2 2 0 0 0 6.603 15h7.08a2 2 0 0 0 2-2zM5.829 5.854a.5.5 0 1 1 .707-.708l2.147 2.147 2.146-2.147a.5.5 0 1 1 .707.708L9.39 8l2.146 2.146a.5.5 0 0 1-.707.708L8.683 8.707l-2.147 2.147a.5.5 0 0 1-.707-.708L7.976 8z" />
                </svg>
                Kembali
            </a>

            @if (!$edit)
                <a href="{{ route('plans.show', ['plan' => $plan, 'edit' => true]) }}"
                    class="btn btn-warning mb-4 d-flex gap-2 align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor"
                        class="bi bi-pencil-square" viewBox="0 0 16 16">
                        <path
                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                        <path fill-rule="evenodd"
                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                    </svg>
                    Edit
                </a>
            @endif
        </div>

        <h2>Detail Plan {{ $plan->title }}</h2>
        <!-- plan detail -->
        <div class="card mt-3">
            <div class="modal-content">
                <div class="card-body bg-white">
                    <form action="{{ route('plans.update', $plan) }}" method="post" id="formEditPlan">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Plan</label>
                            <input type="text" class="form-control" id="title" name="title"
                                value="{{ $plan->title }}" @disabled(!$edit)>
                        </div>

                        <div class="mb-3">
                            <label for="target" class="form-label">Target</label>
                            <input type="number" class="form-control" id="target" name="target"
                                value="{{ $plan->target }}" @disabled(!$edit)>
                        </div>

                        <div>
                            <label for="target_date" class="form-label">Tanggal Target Tercapai</label>
                            <input type="date" class="form-control" id="target_date" name="target_date"
                                value="{{ $plan->target_date }}" @disabled(!$edit)>
                        </div>

                        @if ($edit)
                            <button type="submit" class="btn btn-primary mt-3">Simpan</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="mt-3 d-flex justify-content-between">
            <h2>Histori Simpanan</h2>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddSaving">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-plus"
                    viewBox="0 0 16 16">
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                </svg>
                Tambah
            </button>
        </div>

        <!-- saving history -->
        <div class="card mt-3">
            <div class="modal-content">
                <div class="card-body bg-white">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Jumlah Simpanan</th>
                                <th scope="col">Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plan->savings as $saving)
                                <tr>
                                    <td>{{ $saving->amount }}</td>
                                    <td>{{ $saving->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- modal add saving -->
        <div class="modal fade" id="modalAddSaving" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="modalAddSavingLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header px-3 pb-0 border-bottom-0">
                        <h1 class="modal-title fs-5" id="modalAddSavingLabel">
                            Tambah Simpanan
                        </h1>
                    </div>
                    <div class="modal-body px-3">
                        <!-- form add saving -->
                        <form action="{{ route('plans.saving.store', $plan) }}" method="post" id="addSavingForm">
                            @csrf

                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">

                            <input type="number" name="amount" placeholder="Jumlah" class="form-control mt-3">
                        </form>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="addSavingForm" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
