@extends('layout')

@section('content')
    <div class="animate-fade-in-up">
        <!-- AI Generator Section -->
        <div class="card ai-card border-0 shadow-lg mb-5 overflow-hidden">
            <div class="card-body p-4 p-lg-5 position-relative">
                <div class="row align-items-center position-relative z-1">
                    <div class="col-md-7 mb-4 mb-md-0">
                        <span class="badge badge-soft-primary mb-3 px-3 py-2 rounded-pill ls-1">
                            <i class="bi bi-stars me-1"></i>
                            BETA
                        </span>
                        <h2 class="display-6 fw-bold mb-3">تحسين الميزانية الذكي</h2>
                        <p class="lead text-muted mb-4 opacity-75">
                            دع الذكاء الاصطناعي يحلل بياناتك ويقترح خطة مثالية لتقليل النفقات وزيادة التوفير.
                        </p>

                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <div class="input-group" style="max-width: 300px;">
                                <span class="input-group-text bg-white border-0 shadow-sm ps-3"><i
                                        class="bi bi-calendar2-range text-primary"></i></span>
                                <input type="month" class="form-control border-0 shadow-sm" id="monthInput" name="month"
                                    value="{{ date('Y-m') }}" required>
                            </div>
                            <button type="button" id="generateBtn"
                                class="btn btn-primary d-flex align-items-center shadow-lg hover-lift px-4">
                                <i class="bi bi-magic me-2"></i> توليد خطة ذكية
                            </button>
                        </div>

                        <div id="loadingIndicator" class="mt-3 text-primary small d-none d-flex align-items-center">
                            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                            جاري تحليل البيانات المالية وإنشاء الخطة بواسطة OpenAI...
                        </div>
                    </div>
                    <div class="col-md-5 text-center d-none d-md-block">
                        <i class="bi bi-robot text-primary opacity-10" style="font-size: 10rem;"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- History Section -->
        <div class="card border-0 shadow-sm glass-panel">
            <div class="card-header bg-white py-3 border-bottom border-light">
                <h5 class="mb-0 fw-bold">سجل الخطط المقترحة</h5>
            </div>
            <div class="card-body p-0">
                @if($plans->isEmpty())
                    <div class="text-center py-5">
                        <div class="mb-3 text-muted opacity-25"><i class="bi bi-cpu fs-1"></i></div>
                        <h5 class="text-muted">لم يتم توليد أي خطط بعد</h5>
                        <p class="text-muted small">اختر الشهر واضغط على "توليد خطة ذكية" للحصول على مقترحات.</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-custom table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">الشهر المستهدف</th>
                                    <th>تاريخ الإنشاء</th>
                                    <th class="text-end pe-4">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($plans as $plan)
                                    <tr class="table-row-hover">
                                        <td class="ps-4 fw-bold text-primary">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary bg-opacity-10 p-2 rounded-circle me-3 text-primary d-flex align-items-center justify-content-center"
                                                    style="width: 35px; height: 35px;">
                                                    <i class="bi bi-calendar-check"></i>
                                                </div>
                                                {{ $plan->month }}
                                            </div>
                                        </td>
                                        <td class="text-muted small font-monospace">{{ $plan->created_at->format('Y-m-d H:i') }}
                                        </td>
                                        <td class="text-end pe-4">
                                            <div class="btn-group">
                                                <a href="{{ route('plans.show', $plan) }}" class="btn btn-sm btn-light text-primary"
                                                    title="عرض التفاصيل">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <form action="{{ route('plans.destroy', $plan) }}" method="POST"
                                                    class="d-inline-block" onsubmit="return confirm('حذف هذه الخطة؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-light text-danger" title="حذف">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
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

    <script>
        document.getElementById('generateBtn').addEventListener('click', async function () {
            const month = document.getElementById('monthInput').value;
            if (!month) {
                alert('يرجى اختيار الشهر');
                return;
            }

            if (!confirm('سيتم إرسال بياناتك المالية للتحليل بواسطة OpenAI. المتابعة؟')) return;

            const btn = this;
            const indicator = document.getElementById('loadingIndicator');

            btn.disabled = true;
            btn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i> جاري المعالجة...';
            indicator.classList.remove('d-none');
            indicator.innerHTML = '<div class="spinner-border spinner-border-sm me-2" role="status"></div> جاري تحليل البيانات المالية وإنشاء الخطة بواسطة OpenAI...';

            try {
                // Call Backend Generate
                const response = await fetch('{{ route('plans.generate') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        month: month
                    })
                });

                const result = await response.json();

                if (result.success) {
                    window.location.href = result.redirect_url;
                } else {
                    throw new Error(result.message || 'فشل توليد الخطة');
                }

            } catch (error) {
                console.error(error);
                alert('حدث خطأ أثناء المعالجة: ' + error.message);
                btn.innerHTML = '<i class="bi bi-magic me-2"></i> توليد خطة ذكية';
            } finally {
                btn.disabled = false;
                indicator.classList.add('d-none');
            }
        });
    </script>
@endsection