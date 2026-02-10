@extends('layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 text-dark">تعديل المصروف</h4>
                <a href="{{ route('expenses.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-right"></i> إلغاء
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('expenses.update', $expense) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="date" class="form-label">تاريخ العملية (تلقائي) <span
                                    class="text-danger">*</span></label>
                            <input type="date"
                                class="form-control form-control-lg bg-light @error('date') is-invalid @enderror" id="date"
                                name="date" value="{{ old('date', $expense->date) }}" readonly required>
                            <div class="form-text text-muted">تاريخ العملية ثابت ولا يمكن تعديله.</div>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="category_id" class="form-label">التصنيف <span class="text-danger">*</span></label>
                            <select class="form-select form-select-lg @error('category_id') is-invalid @enderror"
                                id="category_id" name="category_id" required>
                                <option value="" disabled>اختر التصنيف</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id', $expense->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }} (الميزانية: {{ number_format($category->expected_amount, 2) }})
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="amount" class="form-label">المبلغ <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="number" step="0.01"
                                    class="form-control form-control-lg @error('amount') is-invalid @enderror" id="amount"
                                    name="amount" value="{{ old('amount', $expense->amount) }}" required>
                                <span class="input-group-text bg-light text-muted">ر.س</span>
                            </div>
                            @error('amount')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning text-dark btn-lg">
                                <i class="bi bi-pencil-square me-2"></i> تحديث المصروف
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection