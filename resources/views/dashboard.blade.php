@extends('layout')

@section('content')
    <div class="animate-fade-in-up">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h6 class="text-primary text-uppercase letter-spacing-2 mb-1">لوحة التحكم</h6>
                <h1 class="display-5 fw-bold text-dark mt-0">نظرة عامة مالية</h1>
                <p class="text-muted mb-0">تقرير شهر <strong>{{ $month }}</strong></p>
            </div>
            <div class="glass-panel p-2 rounded-3 shadow-sm">
                <form action="{{ route('dashboard') }}" method="GET" class="d-flex align-items-center gap-2">
                    <div class="input-group">
                        <span class="input-group-text border-0 bg-transparent ps-3"><i
                                class="bi bi-calendar4-week"></i></span>
                        <input type="month" name="month" class="form-control border-0 bg-transparent shadow-none"
                            value="{{ $month }}">
                    </div>
                    <button type="submit" class="btn btn-primary px-4">
                        تحديث
                    </button>
                </form>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div
                    class="card stat-card h-100 bg-white shadow-hover border-bottom border-4 border-success animate-delay-1">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">
                            <div class="stat-icon text-success bg-success bg-opacity-10">
                                <i class="bi bi-arrow-down-left"></i>
                            </div>
                            <span class="badge badge-soft-success">+12%</span>
                        </div>
                        <h3 class="fw-bold mb-1">{{ number_format($totalIncome, 2) }}</h3>
                        <p class="text-muted small mb-0 text-uppercase ls-1">إجمالي الدخل</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div
                    class="card stat-card h-100 bg-white shadow-hover border-bottom border-4 border-primary animate-delay-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">
                            <div class="stat-icon text-primary bg-primary bg-opacity-10">
                                <i class="bi bi-calculator"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-1">{{ number_format($totalBudgeted, 2) }}</h3>
                        <p class="text-muted small mb-0 text-uppercase ls-1">الميزانية المخططة</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div
                    class="card stat-card h-100 bg-white shadow-hover border-bottom border-4 border-warning animate-delay-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">
                            <div class="stat-icon text-warning bg-warning bg-opacity-10">
                                <i class="bi bi-arrow-up-right"></i>
                            </div>
                            <span class="badge badge-soft-warning">-5%</span>
                        </div>
                        <h3 class="fw-bold mb-1">{{ number_format($totalSpent, 2) }}</h3>
                        <p class="text-muted small mb-0 text-uppercase ls-1">إجمالي المصروفات</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @php
                    $isPositive = $totalRemaining >= 0;
                    $balanceColor = $isPositive ? 'success' : 'danger';
                    $balanceIcon = $isPositive ? 'bi-wallet2' : 'bi-exclamation-octagon';
                @endphp
                <div class="card stat-card h-100 shadow-hover border-bottom border-4 border-{{ $balanceColor }} animate-delay-3"
                    style="background-color: #f8f9fa;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-4">
                            <div class="stat-icon text-{{ $balanceColor }} bg-{{ $balanceColor }} bg-opacity-10">
                                <i class="bi {{ $balanceIcon }}"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mb-1">{{ number_format($totalRemaining, 2) }}</h3>
                        <p class="text-muted small mb-0 text-uppercase ls-1">الميزانية المتبقية</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- AI Optimization Section -->
            <div class="col-lg-4">
                <div class="card ai-card h-100 shadow-lg border-0">
                    <div class="card-body p-4 position-relative z-1">
                        <div class="mb-4">
                            <div class="d-inline-flex p-3 rounded-circle bg-white shadow-sm mb-3">
                                <i class="bi bi-stars text-gradient fs-2"></i>
                            </div>
                            <h4 class="fw-bold">المحلل الذكي</h4>
                            <p class="text-muted">
                                اسمح للذكاء الاصطناعي بتحليل أنماط إنفاقك وتقديم توصيات مخصصة لتوفير ما يصل إلى 20% من
                                ميزانيتك.
                            </p>
                        </div>

                        <div class="d-grid gap-3">
                            <a href="{{ route('plans.index') }}"
                                class="btn btn-primary d-flex justify-content-between align-items-center">
                                <span>ابدأ تحليل الميزانية</span>
                                <i class="bi bi-arrow-left"></i>
                            </a>
                        </div>

                        @if(request()->input('ai_generated'))
                            <div class="alert alert-success bg-white border-0 shadow-sm mt-3 mb-0 d-flex align-items-center">
                                <i class="bi bi-check-circle-fill text-success fs-5 me-2"></i>
                                <div>
                                    <small class="fw-bold d-block text-dark">تم التحليل بنجاح!</small>
                                    <small class="text-muted">راجع خطتك الجديدة الآن.</small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Categories Table -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-white py-4 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold">تفاصيل الميزانية حسب الفئات</h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('incomes.create') }}"
                                class="btn btn-sm btn-outline-success border-2 rounded-pill px-3">
                                <i class="bi bi-plus-lg"></i> دخل
                            </a>
                            <a href="{{ route('categories.create') }}"
                                class="btn btn-sm btn-outline-primary border-2 rounded-pill px-3">
                                <i class="bi bi-plus-lg"></i> تصنيف
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if($categoryData->isEmpty())
                            <div class="text-center py-5">
                                <div class="bg-light rounded-circle p-4 d-inline-block mb-3">
                                    <i class="bi bi-inbox fs-1 text-muted"></i>
                                </div>
                                <h6 class="text-muted fw-bold">لا توجد بيانات متاحة</h6>
                                <p class="text-muted small mb-0">ابدأ بإضافة تصنيفات ومعاملات لهذا الشهر.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-custom table-hover align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-4">الفئة</th>
                                            <th>المخطط</th>
                                            <th>المصروف</th>
                                            <th>المتبقي</th>
                                            <th>الحالة</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categoryData as $data)
                                            @php
                                                $percent = $data['expected'] > 0 ? ($data['spent'] / $data['expected']) * 100 : 0;
                                            @endphp
                                            <tr class="table-row-hover">
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="rounded-circle bg-light p-2 me-3"
                                                            style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                            <span
                                                                class="fw-bold text-primary">{{ mb_substr($data['name'], 0, 1) }}</span>
                                                        </div>
                                                        <span class="fw-bold text-dark">{{ $data['name'] }}</span>
                                                    </div>
                                                </td>
                                                <td class="text-muted">{{ number_format($data['expected'], 2) }}</td>
                                                <td class="fw-bold text-dark">{{ number_format($data['spent'], 2) }}</td>
                                                <td>
                                                    <span
                                                        class="{{ $data['remaining'] < 0 ? 'text-danger fw-bold' : 'text-success fw-bold' }}">
                                                        {{ number_format($data['remaining'], 2) }}
                                                    </span>
                                                    <div class="progress mt-1" style="height: 4px; width: 80px;">
                                                        <div class="progress-bar {{ $percent > 100 ? 'bg-danger' : ($percent > 75 ? 'bg-warning' : 'bg-success') }}"
                                                            role="progressbar" style="width: {{ min($percent, 100) }}%"></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($data['remaining'] < 0)
                                                        <span class="badge badge-soft-danger rounded-pill">تجاوز</span>
                                                    @elseif($percent > 80)
                                                        <span class="badge badge-soft-warning rounded-pill">تحذير</span>
                                                    @else
                                                        <span class="badge badge-soft-success rounded-pill">ممتاز</span>
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
        </div>
    </div>
@endsection