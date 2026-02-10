@extends('layout')

@section('content')
    <div class="animate-fade-in-up">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0 fw-bold">سجل المصروفات</h2>
                <p class="text-muted">متابعة نفقاتك اليومية</p>
            </div>
            @if($month == $currentMonth)
                <div>
                    <a href="{{ route('expenses.create') }}"
                        class="btn btn-warning text-dark d-flex align-items-center shadow-lg hover-lift">
                        <i class="bi bi-receipt me-2"></i> تسجيل مصروف
                    </a>
                </div>
            @endif
        </div>

        <div class="card glass-panel mb-4 border-0">
            <div class="card-body">
                <form action="{{ route('expenses.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="month" class="form-label text-muted small text-uppercase ls-1">تصفية حسب الشهر</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 form-control-soft-grey"><i
                                    class="bi bi-calendar-month text-primary"></i></span>
                            <input type="month" class="form-control border-0 shadow-none ps-2 form-control-soft-grey"
                                id="month" name="month" value="{{ $month }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">عرض المصروفات</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">المصروفات لشهر {{ $month }}</h5>
                <span class="badge badge-soft-danger rounded-pill px-3 py-2">
                    إجمالي المنفق: {{ number_format($expenses->sum('amount'), 2) }}
                </span>
            </div>
            <div class="card-body p-0">
                @if($expenses->isEmpty())
                    <div class="text-center py-5">
                        <div class="mb-3 text-muted opacity-25"><i class="bi bi-receipt-cutoff fs-1"></i></div>
                        <h5 class="text-muted">لا توجد مصروفات مسجلة</h5>
                        <p class="text-muted small">سجل مصروفاتك اليومية لتتبع أين تذهب أموالك.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">التاريخ</th>
                                    <th>التصنيف</th>
                                    <th>المبلغ</th>
                                    <th class="text-end pe-4">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expenses as $expense)
                                    <tr class="table-row-hover">
                                        <td class="ps-4 text-muted font-monospace">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-light rounded p-1 me-2 text-center" style="min-width: 40px;">
                                                    <small
                                                        class="d-block fw-bold text-dark">{{ \Carbon\Carbon::parse($expense->date)->format('d') }}</small>
                                                    <small class="d-block text-muted"
                                                        style="font-size: 0.6rem;">{{ \Carbon\Carbon::parse($expense->date)->format('M') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-soft-primary fw-normal">
                                                {{ $expense->category->name }}
                                            </span>
                                        </td>
                                        <td class="fw-bold text-danger">-{{ number_format($expense->amount, 2) }}</td>
                                        <td class="text-end pe-4">
                                            @if($month == $currentMonth)
                                                <div class="btn-group">
                                                    <a href="{{ route('expenses.edit', $expense) }}"
                                                        class="btn btn-sm btn-light text-primary" title="تعديل">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST"
                                                        class="d-inline-block" onsubmit="return confirm('هل أنت متأكد؟')">
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