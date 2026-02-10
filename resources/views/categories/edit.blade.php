@extends('layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="mb-0 text-dark">تعديل التصنيف</h4>
                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-right"></i> إلغاء
                </a>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label">اسم التصنيف <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                id="name" name="name" value="{{ old('name', $category->name) }}" required>
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
                                        id="expected_amount" name="expected_amount"
                                        value="{{ old('expected_amount', $category->expected_amount) }}" required>
                                </div>
                                @error('expected_amount')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="month" class="form-label">الشهر <span class="text-danger">*</span></label>
                                <input type="month"
                                    class="form-control form-control-lg @error('month') is-invalid @enderror" id="month"
                                    name="month" value="{{ old('month', $category->month) }}" required>
                                @error('month')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-check-circle me-2"></i> تحديث التصنيف
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection