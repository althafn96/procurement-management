<x-guest-layout>

    <x-slot name="title">
        Client Area - Sign In
    </x-slot>

    <div class="login-signin">
        <div class="mb-20">
            <h3>Sign In To {{ config('app.name') }}</h3>
            <p class="opacity-60 font-weight-bold">Enter your details to login to your account:</p>
        </div>

        <!--begin::Form-->
        <form method="POST" class="form" id="kt_login_singin_form" action="{{ url('login') }}">
            @csrf
            <!--begin::Form group-->
            <div class="form-group">
                <input id="email" class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8 mb-5  @error('email') is-invalid @enderror" type="email" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus />

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <!--end::Form group-->
            <!--begin::Form group-->
            <div class="form-group">
                <input id="password" class="form-control h-auto text-white placeholder-white opacity-70 bg-dark-o-70 rounded-pill border-0 py-4 px-8 mb-5  @error('password') is-invalid @enderror" placeholder="Password" type="password" name="password" required autocomplete="off" />
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <!--end::Form group-->
            <!--begin::Form group-->
            <div class="form-group d-flex flex-wrap justify-content-between align-items-center px-8">
                <div class="checkbox-inline">
                    <label for="remember_me" class="checkbox checkbox-outline checkbox-white text-white m-0">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span></span>{{ __('Remember me') }}</label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" id="kt_login_forgot" class="text-white font-weight-bold">{{ __('Forgot your password?') }}</a>
                @endif
            </div>
            <!--end::Form group-->
            <!--begin::Action-->
            <div class="form-group text-center mt-10">
                <button id="kt_login_singin_form_submit_button" class="btn btn-pill btn-outline-white font-weight-bold opacity-90 px-15 py-3" type="submit">{{ __('Sign In') }}</button>
                <!--<button id="kt_login_signin_submit" class="btn btn-pill btn-outline-white font-weight-bold opacity-90 px-15 py-3">Sign In</button>-->
            </div>
            <!--end::Action-->
        </form>
        <!--end::Form-->
        {{-- <div class="mt-10">
            <span class="opacity-70 mr-4">Don't have an account yet?</span>
            <a href="javascript:;" id="kt_login_signup" class="text-white font-weight-bold">Sign Up</a>
        </div> --}}
    </div>
</x-guest-layout>
