@extends('layout')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4 text-center">تسجيل الدخول</h2>
            <div class="card p-4">
                <form action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">البريد الإلكتروني</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required
                            autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">كلمة المرور</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">دخول</button>
                    </div>
                </form>
                <div class="mt-3 text-center">
                    <a href="{{ route('register') }}">ليس لديك حساب؟ سجل الآن</a>
                </div>
            </div>
        </div>
    </div>
@endsection