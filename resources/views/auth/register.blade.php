<x-guest-layout>
    {{-- <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">



                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <div class="d-flex justify-content-center">
                                            <a href="index.html" id="loginLogo"
                                                class="d-flex align-items-center w-auto">
                                                <img src="assets/img/logo.png" alt="">
                                                <span class="d-none d-lg-block"></span>
                                            </a>
                                        </div><!-- End Logo -->
                                        <!-- <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p> -->
                                    </div>

                                    <form method="POST" action="{{ route('login') }}" class="row g-3 needs-validation"
                                        novalidate>
                                        @csrf
                                        <div class="col-12">
                                            <label for="fullName" class="form-label">Full Name</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend"><i
                                                        class="bx bxs-user"></i></span>
                                                <input type="text" name="email" class="form-control" id="fullName"
                                                    placeholder="enter your full name" required>
                                                <x-input-error :messages="$errors->get('fullName')" class="mt-2" />
                                                <div class="invalid-feedback">Please enter your full name.</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Email</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend"><i
                                                        class="bx bxs-user"></i></span>
                                                <input type="text" name="email" class="form-control"
                                                    id="yourUsername" placeholder="enter your email id" required>
                                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                                <div class="invalid-feedback">Please enter your email id.</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend"><i
                                                        class="bx bxs-lock"></i></span>
                                                <input type="password" name="password" class="form-control"
                                                    id="yourPassword" placeholder="enter your password" required>
                                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                                <div class="invalid-feedback">Please enter your password!</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="password_confirmation" class="form-label">Confirm
                                                Password</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend"><i
                                                        class="bx bxs-lock"></i></span>
                                                <input type="password" name="password_confirmation" class="form-control"
                                                    id="password_confirmation" placeholder="re-enter your password"
                                                    required>
                                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                                <div class="invalid-feedback">Please confirm your password!</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Register</button>
                                        </div>
                                        <div class="col-12">
                                            <p class="small mb-0">Already Registered? <a
                                                    href="{{ route('login') }}">Login
                                                    Now</a></p>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <!-- <div class="credits">
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
              </div> -->

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main --> --}}



    <style>
        .register-container {
            min-height: 80vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .register-card {
            border-radius: 10px;
            box-shadow: 0 8px 8px rgba(0, 0, 0, 0.144), 0 -8px 8px rgba(0, 0, 0, 0.144), 8px 0 8px rgba(0, 0, 0, 0.233), -4px 0 8px rgba(0, 0, 0, 0.233);
            padding: 30px;
            width: 100%;
            max-width: 400px;
        }

        .register-logo img {
            max-width: 100px;
        }

        .btn-custom {
            background-color: #007bff;
            color: white;
        }

        .btn-custom:hover {
            background-color: #004a99;
            color: white;
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

    <div class="container-fluid register-container">
        <div class="register-card">
            <div class="text-center register-logo mb-4">
                <img src="assets/img/logo.png" alt="Logo" />
            </div>
            <h4 class="text-center mb-4">Create Your Account</h4>

            <form action="{{ route('register') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                <!-- Full Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" id="name" name="name" class="form-control"
                            placeholder="Enter your full name" value="{{ old('name') }}" required />
                    </div>
                    <div class="invalid-feedback">Please enter your name.</div>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" id="email" name="email" class="form-control"
                            placeholder="Enter your email" value="{{ old('email') }}" required />
                    </div>
                    <div class="invalid-feedback">Please enter a valid email address.</div>
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" class="form-control"
                            placeholder="Enter your password" required />
                    </div>
                    <div class="invalid-feedback">Please enter a password.</div>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="form-control" placeholder="Confirm your password" required />
                    </div>
                    <div class="invalid-feedback">Please confirm your password.</div>
                    @error('password_confirmation')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Terms and Conditions -->
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="terms" name="terms" required />
                    <label class="form-check-label" for="terms">I agree to the <a href="#">Terms and
                            Conditions</a></label>
                    <div class="invalid-feedback">You must agree to the terms and conditions.</div>
                    @error('terms')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Register Button -->
                <div class="mb-3">
                    <button type="submit" class="btn btn-custom w-100">Register</button>
                </div>

                <!-- Login Link -->
                <div class="text-center">
                    <p class="small-text mb-0">Already have an account? <a href="{{ route('login') }}">Login Now</a></p>
                </div>
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
