@extends('layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 text-dark">إضافة تصنيف ميزانية</h4>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-right"></i> العودة
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="alert alert-info mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        تحديد ميزانية لكل تصنيف يساعدك على عدم تجاوز الحد المسموح به للصرف.
                    </div>

                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="name" class="form-label">اسم التصنيف <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name') }}"
                                placeholder="مثال: الطعام، المواصلات، الفواتير" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="expected_amount" class="form-label">الميزانية المخططة <span
                                        class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light text-muted"><i class="bi bi-wallet2"></i></span>
                                    <input type="number" step="0.01"
                                        class="form-control form-control-lg @error('expected_amount') is-invalid @enderror"
                                        id="expected_amount" name="expected_amount" value="{{ old('expected_amount') }}"
                                        placeholder="0.00" required>
                                </div>
                                <div class="form-text">المبلغ الأقصى المسموح به لهذا التصنيف.</div>
                                @error('expected_amount')
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
                                <div class="form-text text-muted">سيتم إنشاء التصنيف لهذا الشهر الحالي تلقائياً.</div>
                                @error('month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-plus-circle me-2"></i> إنشاء التصنيف
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection