@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-10 col-xl-8">
                <div class="row g-0 bg-white shadow rounded-4 overflow-hidden flex-md-row-reverse">
                    <!-- Image Side -->
                    <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center"
                        style="background-color: #f9f9fb;">
                        <img src="{{ asset('images/logo.png') }}" alt=".DEV Blog" class="img-fluid p-4"
                            style="max-height: 400px;" />
                    </div>

                    <!-- Form Side -->
                    <div class="col-md-6 p-4 p-md-5" style="background-color: #fff;">
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/logo.png') }}" alt=".DEV Blog Logo" class="mb-3"
                                style="height: 48px;" />
                            <h2 class="fw-bold" style="color: #e3342f;">Welcome Back 👋</h2>
                        </div>

                        @if (session('error'))
                            <div class="alert alert-danger text-center">{{ session('error') }}</div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold text-secondary">Email address</label>
                                <div class="position-relative">
                                    <i
                                        class="bi bi-envelope position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                                    <input id="email" type="email"
                                        class="form-control ps-5 fw-semibold @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                        style="border-color: #e3342f;">

                                    @error('email')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-bold text-secondary">Password</label>
                                <div class="position-relative">
                                    <i
                                        class="bi bi-lock position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                                    <input id="password" type="password"
                                        class="form-control ps-5 pe-5 fw-semibold @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="current-password"
                                        style="border-color: #e3342f;">
                                    <i class="bi bi-eye position-absolute top-50 end-0 translate-middle-y me-3 text-muted"
                                        id="eyeIcon" style="cursor: pointer;"></i>

                                    @error('password')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3 form-check">
                                <input class="form-check-input border-danger" type="checkbox" name="remember" id="remember"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold text-muted" for="remember">Remember Me</label>
                            </div>

                            <button type="submit" class="btn w-100 py-2 mb-3 text-white"
                                style="background-color: #e3342f;">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Login
                            </button>

                            <div class="text-center text-muted my-3">
                                <hr class="d-inline-block w-25"> Or
                                <hr class="d-inline-block w-25">
                            </div>

                            @if (Route::has('password.request'))
                                <div class="text-center">
                                    <a class="small text-decoration-none" href="{{ route('password.request') }}"
                                        style="color: #e3342f;">Forgot Your Password?</a>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Password show/hide toggle -->
    @push('scripts')
        <script>
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput && eyeIcon) {
                eyeIcon.addEventListener('click', () => {
                    const isPassword = passwordInput.type === 'password';
                    passwordInput.type = isPassword ? 'text' : 'password';
                    eyeIcon.classList.toggle('bi-eye');
                    eyeIcon.classList.toggle('bi-eye-slash');
                });
            }
        </script>
    @endpush
@endsection
