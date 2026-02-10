@extends('layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">إنشاء خطة مالية ذكية (OpenAI)</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-stars"></i>
                        سيقوم الذكاء الاصطناعي (OpenAI) بتحليل دخلك ونفقاتك المتوقعة لهذا الشهر واقتراح خطة توفير واستثمار
                        ذكية.
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('plans.generate') }}" method="POST" id="ai-plan-form">
                        @csrf
                        <div id="setup-form">
                            <div class="mb-3">
                                <label for="month" class="form-label">الشهر (YYYY-MM)</label>
                                <input type="month" class="form-control form-control-lg" id="month" name="month"
                                    value="{{ date('Y-m') }}" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="bi bi-cpu"></i> توليد الخطة باستخدام OpenAI
                                </button>
                                <a href="{{ route('plans.index') }}" class="btn btn-outline-secondary">إلغاء</a>
                            </div>
                        </div>

                        <div id="loading-state" class="text-center py-5" style="display: none;">
                            <div class="spinner-border text-primary mb-3" role="status" style="width: 3rem; height: 3rem;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <h5>جارٍ التواصل مع OpenAI...</h5>
                            <p class="text-muted">يرجى الانتظار، قد يستغرق هذا بضع ثوانٍ.</p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('ai-plan-form').addEventListener('submit', function () {
            document.getElementById('setup-form').style.display = 'none';
            document.getElementById('loading-state').style.display = 'block';
        });
    </script>
@endsection