<x-guest-layout>
    <!-- Session Status -->
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
    </main><!-- End #main -->

</x-guest-layout>
