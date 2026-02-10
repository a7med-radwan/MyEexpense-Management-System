@extends('layout')

@section('content')
    <div class="animate-fade-in-up">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0 fw-bold">سجل الدخل</h2>
                <p class="text-muted">إدارة مصادر دخلك الشهرية</p>
            </div>
            @if($month == $currentMonth)
                <div>
                    <a href="{{ route('incomes.create') }}"
                        class="btn btn-success d-flex align-items-center shadow-lg hover-lift">
                        <i class="bi bi-plus-lg me-2"></i> إضافة دخل جديد
                    </a>
                </div>
            @endif
        </div>

        <div class="card glass-panel mb-4 border-0">
            <div class="card-body">
                <form action="{{ route('incomes.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="month" class="form-label text-muted small text-uppercase ls-1">تصفية حسب الشهر</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 form-control-soft-grey"><i
                                    class="bi bi-calendar-month text-primary"></i></span>
                            <input type="month" class="form-control border-0 shadow-none ps-2 form-control-soft-grey" id="month" name="month"
                                value="{{ $month }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">عرض السجلات</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-primary">قائمة الدخل لشهر {{ $month }}</h5>
                <span class="badge badge-soft-primary rounded-pill px-3 py-2">
                    المجموع: {{ number_format($incomes->sum('amount'), 2) }}
                </span>
            </div>
            <div class="card-body p-0">
                @if($incomes->isEmpty())
                    <div class="text-center py-5">
                        <div class="mb-3 text-muted opacity-25"><i class="bi bi-cash-stack fs-1"></i></div>
                        <h5 class="text-muted">لا توجد سجلات دخل لهذا الشهر</h5>
                        <p class="text-muted small">قم بإضافة مصادر الدخل لحساب ميزانيتك بدقة.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">المصدر</th>
                                    <th>المبلغ</th>
                                    <th>تاريخ الإضافة</th>
                                    <th class="text-end pe-4">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($incomes as $income)
                                    <tr class="table-row-hover">
                                        <td class="ps-4 fw-bold text-dark">{{ $income->source }}</td>
                                        <td class="text-success fw-bold">+{{ number_format($income->amount, 2) }}</td>
                                        <td class="text-muted small font-monospace">{{ $income->created_at->format('Y-m-d') }}</td>
                                        <td class="text-end pe-4">
                                            @if($month == $currentMonth)
                                                <div class="btn-group">
                                                    <a href="{{ route('incomes.edit', $income) }}"
                                                        class="btn btn-sm btn-light text-primary" title="تعديل">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('incomes.destroy', $income) }}" method="POST"
                                                        class="d-inline-block"
                                                        onsubmit="return confirm('هل أنت متأكد من حذف هذا السجل؟')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-light text-danger" title="حذف">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="badge bg-light text-muted fw-normal">عرض فقط</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection