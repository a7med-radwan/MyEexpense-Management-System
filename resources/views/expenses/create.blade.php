@extends('layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 text-dark">تسجيل مصروف جديد لشهر {{ date('Y-m') }}</h4>
                <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-right"></i> إلغاء
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('expenses.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="date" class="form-label">تاريخ العملية (تلقائي) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text form-control-soft-grey text-muted"><i class="bi bi-calendar-event"></i></span>
                                <input type="text" class="form-control form-control-lg form-control-soft-grey @error('date') is-invalid @enderror"
                                    value="{{ \Carbon\Carbon::parse(date('Y-m-d'))->translatedFormat('d F Y') }}" readonly>
                            </div>
                            <input type="hidden" name="date" value="{{ date('Y-m-d') }}">
                            <div class="form-text text-muted">يتم تسجيل المصروف بتاريخ اليوم تلقائياً.</div>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="category_id" class="form-label">التصنيف <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg @error('category_id') is-invalid @enderror"
                                id="category_id" name="category_id" required>
                                <option value="" disabled selected>اختر نوع المصروف...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }} (الميزانية: {{ number_format($category->expected_amount, 2) }})
                                    </option>
                                @endforeach
                            </select>
                            @if($categories->isEmpty())
                                <div class="text-danger mt-2 small">
                                    <i class="bi bi-exclamation-circle text-danger"></i>
                                    تنبيه: لا توجد تصنيفات لهذا الشهر. <a href="{{ route('categories.create') }}">أضف تصنيفاً
                                        أولاً</a>.
                                </div>
                            @endif
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="amount" class="form-label">المبلغ المصروف <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01"
                                    class="form-control form-control-lg @error('amount') is-invalid @enderror" id="amount"
                                    name="amount" value="{{ old('amount') }}" placeholder="0.00" required>
                                <span class="input-group-text bg-light text-muted">ر.س</span>
                            </div>
                            @error('amount')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning text-dark btn-lg" {{ $categories->isEmpty() ? 'disabled' : '' }}>
                                <i class="bi bi-save me-2"></i> حفظ المصروف
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection