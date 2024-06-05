{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="block">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                                 @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Email Password Reset Link') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}
<x-guest-layout>

<main class="wrapper">
    <!-- login starts -->
    <div class="loginSection d-flex align-items-center d-flex justify-content-center" style="background-image: url(images/forgotBg.png);">
        <div class="container">
            <div class="row">
                <div class="col-lg-5 mx-auto">
                    
            
                    <div class="loginSection__Form">
                        
                        <div class="Form__Head text-center">
                            <img class="mb-3 mx-auto" src="images/mini-logo-green.svg" alt="Softuvo Logo" title="Softuvo Logo" />
                            <!-- <h4>Forgot Password?</h4>
                            <p>Enter your email to get a password reset link</p> -->
                        </div>

                        <span class="emailIcon">
                            <img src="{{asset ('images/email.gif')}}" />
                        </span>

                        <div class="messageSection">
                            <h2>Woo-hoo. Well done!</h2>
                            <p>You've got and email to reset your passowrd. Let's make it happen.</p>
                            <p class="mt-2">Remember password? <a href="{{url ('/login')}}">Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- login ends -->
</main>
</x-guest-layout>
<!-- JavaScript Libraries -->

