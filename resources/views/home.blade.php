@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center fw-bold">Daftar Rencana</h2>

        <ul class="nav nav-tabs justify-content-center">
            <li class="nav-item">
                <a class="nav-link" href="/">Semua</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/?status=selesai">Selesai</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/?status=belum">Belum</a>
            </li>
        </ul>

        <!-- plans -->
        <div class="mt-3 d-flex flex-wrap justify-content-center align-item-center gap-4">
            @foreach ($plans as $plan)
                <div class="card" style="width: 18rem;">
                    <div class="position-relative">
                        <img src="{{ asset('storage/'.$plan->image) }}" class="card-img-top" alt="{{ $plan->title }}">
                        <span class="position-absolute top-0 start-0 p-2 badge bg-primary">{{ $plan->target_date }}</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">{{ $plan->title }}</h5>
                        <div>
                            @empty($plan->savings_sum_amount)
                                <p class="fw-bold fs-4">0 / {{ number_format($plan->target,0,',','.') }}</p>
                            @else
                                <p class="fw-bold fs-4">
                                    {{ number_format($plan->savings_sum_amount,0,',','.') }} / {{ number_format($plan->target,0,',','.') }}
                                </p>
                            @endempty
                            <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0"
                                aria-valuemin="0" aria-valuemax="100">
                                <div class="progress-bar"
                                    style="width: {{ ($plan->savings_sum_amount / $plan->target) * 100 }}%"></div>
                            </div>
                        </div>
                        <div class="mt-3 d-flex justify-content-center gap-2">
                            <button href="#" class="btn btn-success">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-plus-lg" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
                                </svg>
                            </button>
                            <a href="{{ route('plans.show', $plan) }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-eye-fill" viewBox="0 0 16 16">
                                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                    <path
                                        d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                                </svg>
                            </a>
                            <button type="submit" form="deletePlanForm{{ $plan->id }}" class="btn btn-danger">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                </svg>
                            </button>
                            
                            <form action="{{ route('plans.destroy', $plan) }}" method="post" id="deletePlanForm{{ $plan->id }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- modal add saving -->


        <!-- modal create plan -->
        <div class="modal fade" id="modalCreatePlan" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="modalCreatePlanLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header p-5 pb-2 border-bottom-0">
                        <h1 class="modal-title fs-5" id="modalCreatePlanLabel">
                            Buat Plan
                        </h1>
                    </div>
                    <div class="modal-body px-5">
                        <!-- create plan form -->
                        <form action="{{ route('plans.store') }}" method="post" id="createPlanForm" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <label for="image" class="form-label">Gambar</label>
                                <input type="file" name="image" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul Plan</label>
                                <input type="text" class="form-control" id="title" name="title">
                            </div>

                            <div class="mb-3">
                                <label for="target" class="form-label">Target</label>
                                <input type="number" class="form-control" id="target" name="target">
                            </div>

                            <div>
                                <label for="target_date" class="form-label">Tanggal Target Tercapai</label>
                                <input type="date" class="form-control" id="target_date" name="target_date">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" form="createPlanForm" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- floating button in right bottom -->
        <div class="position-relative">
            <!-- modal create plan trigger -->
            <button class="position-fixed btn btn-primary d-flex" style="bottom: 25px; right: 25px; "
                data-bs-toggle="modal" data-bs-target="#modalCreatePlan">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                    class="bi bi-plus" viewBox="0 0 16 16">
                    <path
                        d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                </svg>
                buat
            </button>
        </div>
    </div>
@endsection
