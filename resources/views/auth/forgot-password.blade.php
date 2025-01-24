<x-guest-layout>
    <div class="container">
        <section class="section register  d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">
                        <div class="card mb-3 register-card">
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    <h5 class="card-title">Forgot Your Password?</h5>
                                    <p class="text-muted">Enter your email address to receive a password reset link.</p>
                                </div>

                                <form method="POST" action="{{ route('password.email') }}">
                                    @csrf

                                    <!-- Email Address -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input id="email" class="form-control" type="email" name="email"
                                            :value="old('email')" required autofocus />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="d-flex justify-content-between align-items-center">
                                        <button type="submit" class="btn btn-primary w-100">Send Password Reset
                                            Link</button>
                                    </div>
                                </form>

                                <!-- Session Status Message -->
                                <div class="mt-4">
                                    <x-auth-session-status class="mb-4" :status="session('status')" />
                                </div>

                                <!-- Go to Login Link -->
                                <div class="mt-3 text-center">
                                    <p class="small mb-0">Remember your password? <a href="{{ route('login') }}"
                                            class="text-primary">Go to Login</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</x-guest-layout>
