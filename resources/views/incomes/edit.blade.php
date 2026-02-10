@extends('layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 text-dark">تعديل الدخل</h4>
                <a href="{{ route('incomes.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-right"></i> إلغاء
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('incomes.update', $income) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="source" class="form-label">مصدر الدخل <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg @error('source') is-invalid @enderror"
                                id="source" name="source" value="{{ old('source', $income->source) }}" required>
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
                                        id="amount" name="amount" value="{{ old('amount', $income->amount) }}" required>
                                    <span class="input-group-text bg-light text-muted">ر.س</span>
                                </div>
                                @error('amount')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="month" class="form-label">الشهر <span class="text-danger">*</span></label>
                                <input type="month"
                                    class="form-control form-control-lg @error('month') is-invalid @enderror" id="month"
                                    name="month" value="{{ old('month', $income->month) }}" required>
                                @error('month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-save me-2"></i> حفظ التعديلات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection