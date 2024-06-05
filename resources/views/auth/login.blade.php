{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me"  name="remember huvu" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}


<x-guest-layout>
    <main class="wrapper">
        <!-- login starts -->
        <div class="loginSection d-flex align-items-center d-flex justify-content-center"
            style="background-image: url(images/loginBg.png);">
            <div class="container">
                @php if(\Cookie::get('login_email') != null && \Cookie::get('login_pass') != null)
                   {
                      $login_email = \Cookie::get('login_email');
                      $login_pass  = \Cookie::get('login_pass');
                      $is_remember = "checked='checked'";
                   }
                   else{
                      $login_email =old('email');
                      $login_pass = '';
                      $is_remember = "";
                    }
                   @endphp
                <div class="row">
                    <div class="col-lg-5 mx-auto">

                        <div class="loginSection__Form">
                            <x-validation-errors class="mb-4" />

                            @if (session('status'))
                                <div class="mb-4 font-medium text-sm text-green-600 text-center mt-3">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <div class="Form__Head text-center">
                                <img class="mb-3 mx-auto" src="images/mini-logo-green.svg" alt="Softuvo Logo"
                                    title="Softuvo Logo" />
                                <h4>Login</h4>
                                <p>Access to our dashboard</p>
                            </div>

                            <form method="POST" action="{{ route('login') }}" autocomplete="off" id="login-form">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Email Address <span class="text-red">*</span></label>
                                    <input id="email" class="form-control" placeholder="Email Address"
                                        type="email" name="email" value="{{$login_email}}" required autofocus
                                         autocomplete="off" />
                                 @error('email') <span class="text-danger">{{ $message }}</span> @enderror

                                </div>
                                <div class="form-group" >
                                    <label for="password"
                                        class="d-flex justify-content-between align-items-center" ><span>Password <span class="text-red">*</span></span>
                                        @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                                    @endif
                                        
                                    </label>
                                <input id="password" class="form-control" type="password"  name="password"    placeholder="Password" value="{{$login_pass}}" required
                                        autocomplete="new-password" />
                                 @error('password') <span class="text-danger">{{ $message }}</span> @enderror

                                    <span toggle="#password-field" 
                                        class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                                </div>
                                <div class="form-group mt-2">
                                    <label for="remember_me" class="form-check">
                                        <input type="checkbox" id="remember_me" name="remember"  class="form-check-input"  {{$is_remember}}/>
                                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-save">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- login ends -->
    </main>
</x-guest-layout>
<script>
    
$(".toggle-password").click(function() {
    $(this).toggleClass("fa-eye-slash fa-eye");
    var input = $('#password');
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
  </script>
