@extends('layout')

@section('content')
    <div class="row align-items-center justify-content-between py-4 animate-fade-in-up">
        <div class="col-lg-5 text-center text-lg-end order-lg-first">
            <span class="badge badge-soft-primary mb-2 px-3 py-2 rounded-pill ls-1 text-uppercase fw-bold">
                <i class="bi bi-stars me-1"></i>
                التطبيق المالي الذكي
            </span>
            <h1 class="display-4 fw-bolder mb-3 lh-base text-dark">
                تحكم في <span class="text-gradient">مستقبلك المالي</span> <br>بكل ذكاء
            </h1>
            <p class="lead text-muted mb-4 lh-lg">
                منصة "مصروفاتي" تساعدك على تتبع نفقاتك، إدارة دخلك، والحصول على خطط ميزانية دقيقة مدعومة بالذكاء الاصطناعي
                لتحقيق أهدافك.
            </p>
            <div class="d-flex gap-2 justify-content-center justify-content-lg-end mb-4">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4 rounded-pill shadow-lg hover-lift">
                    <i class="bi bi-person-plus me-2"></i> ابدأ الآن
                </a>
                <a href="{{ route('login') }}" class="btn btn-white btn-lg px-4 rounded-pill shadow-sm hover-lift">
                    تسجيل الدخول
                </a>
            </div>

            <div class="row mt-4 pt-3 border-top g-0 text-center">
                <div class="col-4">
                    <h4 class="fw-bolder text-dark mb-0">+500</h4>
                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem">مستخدم</small>
                </div>
                <div class="col-4 border-end border-start">
                    <h4 class="fw-bolder text-dark mb-0">100%</h4>
                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem">آمن</small>
                </div>
                <div class="col-4">
                    <h4 class="fw-bolder text-dark mb-0">AI</h4>
                    <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem">تحليل ذكي</small>
                </div>
            </div>
        </div>

        <div class="col-lg-6 order-lg-last mb-5 mb-lg-0">
            <div class="position-relative p-4">
                <!-- Abstract blobs -->
                <div class="position-absolute top-50 start-50 translate-middle w-75 h-75 bg-primary opacity-20 rounded-circle blur-3xl"
                    style="filter: blur(100px); z-index: -1;"></div>

                <!-- Main Glass Card -->
                <div class="card glass border-0 shadow-lg mb-4 position-relative z-1 hover-lift main-card-rotate">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary rounded-circle p-2 text-white me-3 animate-pulse">
                                    <i class="bi bi-wallet2 fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">رصيد الحساب</h6>
                                    <small class="text-muted">نظرة عامة</small>
                                </div>
                            </div>
                            <span class="badge badge-soft-success rounded-pill">+2.5%</span>
                        </div>
                        <h2 class="fw-bold mb-3 ls-n1">12,450.00</h2>
                        <div class="progress" style="height: 8px; border-radius: 10px;">
                            <div class="progress-bar bg-gradient-primary" role="progressbar"
                                style="width: 75%; border-radius: 10px;"></div>
                        </div>
                    </div>
                </div>

                <!-- Floating Card 1 -->
                <div class="card glass border-0 shadow-lg card-body p-3 w-60 position-absolute top-0 end-0 z-2 hover-lift"
                    style="margin-top: -30px; margin-left: -80px; transform: translateY(-50%);">
                    <div class="d-flex align-items-center">
                        <div class="bg-success bg-opacity-10 text-success p-2 rounded-circle me-3">
                            <i class="bi bi-arrow-down-left"></i>
                        </div>
                        <div>
                            <small class="d-block text-muted text-uppercase fw-bold" style="font-size: 0.65rem;">دخل
                                جديد</small>
                            <span class="fw-bold text-dark">+ 3,200.00</span>
                        </div>
                    </div>
                </div>

                <!-- Floating Card 2 -->
                <div class="card glass border-0 shadow-lg card-body p-3 w-60 position-absolute bottom-0 start-0 z-2 hover-lift"
                    style="margin-bottom: -60px; margin-right: -50px;">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning bg-opacity-10 text-warning p-2 rounded-circle me-3">
                            <i class="bi bi-stars"></i>
                        </div>
                        <div>
                            <small class="d-block text-muted text-uppercase fw-bold" style="font-size: 0.65rem;">نصيحة
                                AI</small>
                            <span class="fw-bold text-dark fs-6">توفير ممتاز!</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="row g-4 pb-5 mt-2">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-hover bg-white p-1">
                <div class="card-body text-center p-4">
                    <div class="d-inline-flex p-3 rounded-circle bg-primary bg-opacity-10 text-primary mb-3">
                        <i class="bi bi-pie-chart fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-2">تتبع شامل</h5>
                    <p class="text-muted small">
                        راقب مصاريفك بدقة من خلال لوحات بيانات تفاعلية ورسوم بيانية سهلة الفهم.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-hover bg-white p-1">
                <div class="card-body text-center p-4">
                    <div class="d-inline-flex p-3 rounded-circle bg-success bg-opacity-10 text-success mb-3">
                        <i class="bi bi-wallet2 fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-2">إدارة الميزانية</h5>
                    <p class="text-muted small">
                        تحكم في حدود إنفاقك مع ميزانيات مرنة وتنبيهات فورية لتجنب التجاوز.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-hover ai-card p-1">
                <div class="card-body text-center p-4 position-relative z-1">
                    <div class="d-inline-flex p-3 rounded-circle bg-white shadow-sm text-secondary mb-3">
                        <i class="bi bi-robot fs-3 text-gradient"></i>
                    </div>
                    <h5 class="fw-bold mb-2">مستشارك الذكي</h5>
                    <p class="text-muted small">
                        احصل على توصيات مالية شخصية مدعومة بالذكاء الاصطناعي لتحسين خططك.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection