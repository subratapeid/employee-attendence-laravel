<x-guest-layout>
    <!-- Session Status -->
    {{-- <x-auth-session-status class="mb-4" :status="session('status')" />
    <main>
        <div class="container">
            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="row justify-content-center w-100">
                    <div class="col-lg-4 col-md-6 col-sm-8 d-flex flex-column align-items-center justify-content-center">
                        <div class="card shadow-sm border-0 w-100 p-4">
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <a href="index.html" id="loginLogo"
                                        class="d-flex align-items-center justify-content-center">
                                        <img src="assets/img/logo.png" alt="Logo" class="img-fluid"
                                            style="max-width: 120px;">
                                    </a>
                                </div>
                                <h5 class="card-title text-center mb-3 fs-4">Login to Your Account</h5>

                                <form method="POST" action="{{ route('login') }}" class="row g-3 needs-validation"
                                    novalidate>
                                    @csrf

                                    <!-- Email Input -->
                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                            <input type="email" name="email" class="form-control" id="yourUsername"
                                                placeholder="Enter registered email" required>
                                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                            <div class="invalid-feedback">Please enter your email id.</div>
                                        </div>
                                    </div>

                                    <!-- Password Input -->
                                    <div class="col-12">
                                        <label for="yourPassword" class="form-label">Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="bx bxs-lock"></i></span>
                                            <input type="password" name="password" class="form-control"
                                                id="yourPassword" placeholder="Enter your password" required>
                                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                            <div class="invalid-feedback">Please enter your password!</div>
                                        </div>
                                    </div>

                                    <!-- Remember me checkbox and Forgot Password link -->
                                    <div class="col-12 d-flex justify-content-between align-items-center">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                value="true" id="rememberMe">
                                            <label class="form-check-label" for="rememberMe">Remember me</label>
                                        </div>
                                        <a href="{{ route('password.request') }}" class="small">Forgot Password?</a>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100" type="submit">Login</button>
                                    </div>

                                    <!-- Register Link -->
                                    <div class="col-12 text-center">
                                        <p class="small mb-0">Don't have an account? <a
                                                href="{{ route('register') }}">Register Now</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main> --}}


    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <style>
        .login-container {
            min-height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-card {
            border-radius: 10px;
            box-shadow: 0 8px 8px rgba(0, 0, 0, 0.144), 0 -8px 8px rgba(0, 0, 0, 0.144), 8px 0 8px rgba(0, 0, 0, 0.233), -4px 0 8px rgba(0, 0, 0, 0.233);
            padding: 30px;
            width: 100%;
            max-width: 400px;
        }

        .login-logo img {
            width: 100px;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
        }

        .btn-custom:hover {
            background-color: #004a99;
            color: #ffffff;
        }

        .form-label {
            font-weight: bold;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.25rem rgba(38, 143, 255, 0.25);
        }

        .small-text {
            font-size: 0.875rem;
        }
    </style>

    <div class="container-fluid login-container">
        <div class="login-card">
            <div class="text-center login-logo mb-4">
                <img src="assets/img/logo.png" alt="Logo" />
                <p>BCE Attendance Login</p>
            </div>
            {{-- <h4 class="text-center mb-4">Login</h4> --}}

            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                @csrf
                <!-- Email -->
                <div class="mb-3">
                    {{-- <label for="email" class="form-label">Email Address</label> --}}
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="Enter BCE Email ID" value="{{ old('email') }}" required autofocus
                            autocomplete="username" />
                    </div>
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    {{-- <label for="password" class="form-label">Password</label> --}}
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Enter your password" required autocomplete="current-password" />
                    </div>
                    <div class="invalid-feedback">Please enter your password.</div>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me Checkbox -->
                <div class="d-flex justify-content-between mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember" />
                        <label class="form-check-label" for="remember_me">Remember me</label>
                    </div>
                    <a href="{{ route('password.request') }}" class="small-text">Forgot Password?</a>
                </div>

                <!-- Submit Button -->
                <div class="mb-3">
                    <button type="submit" class="btn btn-custom w-100">Login</button>
                </div>

                <!-- Register Link -->
                {{-- <div class="text-center">
                    <p class="small-text mb-0">Don't have an account? <a href="{{ route('register') }}">Register Now</a>
                    </p>
                </div> --}}
            </form>
        </div>
    </div>

    <script>
        // Form validation
        (function() {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>

</x-guest-layout>
