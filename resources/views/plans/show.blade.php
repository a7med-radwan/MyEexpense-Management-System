@extends('layout')

@section('content')
    <div class="animate-fade-in-up">
        <div class="d-flex justify-content-between align-items-center mb-5 border-bottom pb-4">
            <div>
                <span class="badge badge-soft-primary px-3 py-2 rounded-pill ls-1 mb-2">
                    <i class="bi bi-stars me-1"></i> AI Generated
                </span>
                <h2 class="mb-1 fw-bold">تفاصيل الخطة المقترحة</h2>
                <div class="d-flex align-items-center text-muted small">
                    <span class="me-3"><i class="bi bi-calendar-event me-1"></i> الخطة لشهر:
                        <strong>{{ $plan->month }}</strong></span>
                    <span><i class="bi bi-clock me-1"></i> تم التوليد: {{ $plan->created_at->format('Y-m-d H:i') }}</span>
                </div>
            </div>
            <div>
                <a href="{{ route('plans.index') }}" class="btn btn-outline-primary d-flex align-items-center">
                    <i class="bi bi-arrow-right me-2"></i> عودة للقائمة
                </a>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card glass-panel border-0 mb-4">
                    <div
                        class="card-header bg-white py-3 border-bottom border-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-success"><i class="bi bi-pie-chart me-2"></i> التوزيع المقترح للميزانية
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-custom table-hover align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="ps-4">التصنيف</th>
                                        <th>الميزانية المقترحة</th>
                                        <th>السبب / التعليل</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($planData as $item)
                                        <tr class="table-row-hover">
                                            <td class="ps-4 fw-bold text-dark">{{ $item['name'] }}</td>
                                            <td>
                                                <span class="badge badge-soft-success fs-6 fw-normal">
                                                    {{ number_format($item['suggested_amount'], 2) }}
                                                </span>
                                            </td>
                                            <td class="text-muted small">{{ $item['reason'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="alert alert-warning border-0 shadow-sm d-flex align-items-start mb-4 bg-warning bg-opacity-10">
                    <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-warning"></i>
                    <div>
                        <h6 class="alert-heading fw-bold text-dark">تنبيه هام</h6>
                        <p class="mb-0 text-dark opacity-75 small">عند تطبيق هذه الخطة، سيتم تحديث ميزانيات التصنيفات
                            الحالية في قاعدة البيانات لتطابق القيم المقترحة أعلاه بشكل نهائي.</p>
                    </div>
                </div>

                <form action="{{ route('plans.update', $plan) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-primary btn-lg w-100 shadow-lg hover-lift py-3 mb-5">
                        <i class="bi bi-check-circle-fill me-2"></i> تطبيق الخطة واعتماد الميزانية
                    </button>
                </form>
            </div>

            <div class="col-lg-4">
                <div class="card ai-card border-0 shadow-sm h-100">
                    <div class="card-body p-4 position-relative z-1">
                        <div class="d-inline-flex p-3 rounded-circle bg-white shadow-sm mb-4 text-primary">
                            <i class="bi bi-robot fs-2"></i>
                        </div>
                        <h5 class="card-title fw-bold mb-3">رؤية الذكاء الاصطناعي</h5>
                        <p class="card-text text-muted mb-4">
                            قام النظام بتحليل مصادر دخلك وأنماط إنفاقك المتوقعة لإنشاء هذه الخطة المخصصة. يهدف هذا التوزيع
                            إلى تحقيق التوازن المالي وتعزيز التوفير.
                        </p>

                        <div class="p-3 bg-white rounded-3 shadow-sm border border-light">
                            <h6 class="fw-bold text-dark mb-2 small text-uppercase ls-1">نصيحة سريعة</h6>
                            <p class="mb-0 text-muted small">حاول الالتزام بالميزانيات المقترحة للأسبوع الأول لضمان نجاح
                                الخطة الشهرية.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection