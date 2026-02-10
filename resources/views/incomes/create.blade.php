@extends('layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 text-dark">تسجيل دخل جديد</h4>
                <a href="{{ route('incomes.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-right"></i> العودة
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('incomes.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="source" class="form-label">مصدر الدخل <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg @error('source') is-invalid @enderror"
                                id="source" name="source" value="{{ old('source') }}" placeholder="مثال: راتب شهري، عمل حر"
                                required autofocus>
                            @error('source')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="amount" class="form-label">المبلغ <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" step="0.01"
                                        class="form-control form-control-lg @error('amount') is-invalid @enderror"
                                        id="amount" name="amount" value="{{ old('amount') }}" placeholder="0.00" required>
                                    <span class="input-group-text bg-light text-muted">ر.س</span>
                                </div>
                                @error('amount')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="month" class="form-label">الشهر <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i
                                            class="bi bi-calendar3"></i></span>
                                    <input type="text"
                                        class="form-control form-control-lg bg-light @error('month') is-invalid @enderror"
                                        value="{{ \Carbon\Carbon::parse(old('month', date('Y-m')))->translatedFormat('F Y') }}"
                                        readonly>
                                </div>
                                <input type="hidden" name="month" value="{{ old('month', date('Y-m')) }}">
                                <div class="form-text text-muted">يتم تسجيل الدخل لهذا الشهر الحالي تلقائياً.</div>
                                @error('month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-check-lg me-2"></i> حفظ الدخل
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection