@extends('layout')

@section('content')
    <div class="animate-fade-in-up">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="mb-0 fw-bold">تصنيفات الميزانية</h2>
                <p class="text-muted">توزيع ميزانيتك على الفئات المختلفة</p>
            </div>
            <div>
                <a href="{{ route('categories.create') }}"
                    class="btn btn-primary d-flex align-items-center shadow-lg hover-lift">
                    <i class="bi bi-plus-lg me-2"></i> إضافة تصنيف جديد
                </a>
            </div>
        </div>

        <div class="card glass-panel mb-4 border-0">
            <div class="card-body">
                <form action="{{ route('categories.index') }}" method="GET" class="row g-3 align-items-end">
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
                        <button type="submit" class="btn btn-secondary w-100">عرض التصنيفات</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-primary">الميزانية لشهر {{ $month }}</h5>
                <span class="badge badge-soft-info rounded-pill px-3 py-2 text-dark">
                    إجمالي المخطط: {{ number_format($categories->sum('expected_amount'), 2) }}
                </span>
            </div>
            <div class="card-body p-0">
                @if($categories->isEmpty())
                    <div class="text-center py-5">
                        <div class="mb-3 text-muted opacity-25"><i class="bi bi-tags fs-1"></i></div>
                        <h5 class="text-muted">لا توجد تصنيفات معرفة</h5>
                        <p class="text-muted small">ابدأ بإضافة تصنيفات (مثل: طعام، مواصلات) لتنظيم مصروفاتك.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">اسم التصنيف</th>
                                    <th>الميزانية المخططة</th>
                                    <th>المصروف الفعلي</th>
                                    <th>المبلغ المتبقي</th>
                                    <th class="text-end pe-4">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($categories as $category)
                                    <tr class="table-row-hover">
                                        <td class="ps-4">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3 text-primary d-flex align-items-center justify-content-center"
                                                    style="width: 35px; height: 35px;">
                                                    <i class="bi bi-tag-fill"></i>
                                                </div>
                                                <span class="fw-bold text-dark">{{ $category->name }}</span>
                                            </div>
                                        </td>
                                        <td class="fw-bold">{{ number_format($category->expected_amount, 2) }}</td>
                                        <td class="text-primary fw-bold">{{ number_format($category->spent_amount, 2) }}</td>
                                        <td class="fw-bold {{ $category->remaining_amount < 0 ? 'text-danger' : 'text-success' }}">
                                            {{ number_format($category->remaining_amount, 2) }}
                                        </td>
                                        <td class="text-end pe-4">
                                            @if($month == $currentMonth)
                                                <div class="btn-group">
                                                    <a href="{{ route('categories.edit', $category) }}"
                                                        class="btn btn-sm btn-light text-primary" title="تعديل">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('categories.destroy', $category) }}" method="POST"
                                                        class="d-inline-block"
                                                        onsubmit="return confirm('هل أنت متأكد؟ ستحذف جميع المصروفات المرتبطة بهذا التصنيف!')">
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