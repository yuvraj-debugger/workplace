{{--
<x-guest-layout> <x-authentication-card> <x-slot name="logo"> <x-authentication-card-logo />
</x-slot> <x-validation-errors class="mb-4" /> @if (session('status'))
<div class="mb-4 font-medium text-sm text-green-600">{{
	session('status') }}</div>
@endif

<form method="POST" action="{{ route('login') }}">
	@csrf

	<div>
		<x-label for="email" value="{{ __('Email') }}" />
		<x-input id="email" class="block mt-1 w-full" type="email"
			name="email" :value="old('email')" required autofocus
			autocomplete="username" />
	</div>

	<div class="mt-4">
		<x-label for="password" value="{{ __('Password') }}" />
		<x-input id="password" class="block mt-1 w-full" type="password"
			name="password" required autocomplete="current-password" />
	</div>

	<div class="block mt-4">
		<label for="remember_me" class="flex items-center"> <x-checkbox
				id="remember_me" name="remember huvu" /> <span
			class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
		</label>
	</div>

	<div class="flex items-center justify-end mt-4">
		@if (Route::has('password.request')) <a
			class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
			href="{{ route('password.request') }}"> {{ __('Forgot your
			password?') }} </a> @endif

		<x-button class="ml-4"> {{ __('Log in') }} </x-button>
	</div>
</form>
</x-authentication-card> </x-guest-layout>
--}}


<x-guest-layout>
<main class="wrapper">
	<!-- login starts -->
	<div
		class="loginSection d-flex align-items-center d-flex justify-content-center"
		style="background-image: url(/images/loginBg.png);">
		<div class="container">
			@php if(\Cookie::get('login_email') != null &&
			\Cookie::get('login_pass') != null) { $login_email =
			\Cookie::get('login_email'); $login_pass =
			\Cookie::get('login_pass'); $is_remember = "checked='checked'"; }
			else{ $login_email =old('email'); $login_pass = ''; $is_remember =
			""; } @endphp
			<div class="row">
				<div class="col-lg-5 mx-auto">

					<div class="loginSection__Form">
						<x-validation-errors class="mb-4" />

						@if (session('status'))
						<div
							class="mb-4 font-medium text-sm text-green-600 text-center mt-3">
							{{ session('status') }}</div>
						@endif

						<div class="Form__Head text-center">
							<img class="mb-3 mx-auto" src="/images/mini-logo-green.svg"
								alt="Softuvo Logo" title="Softuvo Logo" />
							<h4>Reset Password</h4>
							<p>Access to our dashboard</p>
						</div>

						<form method="POST" action="{{ route('password.update') }}">
							@csrf <input type="hidden" name="token"
								value="{{ $request->route('token') }}">


							<div class="form-group">
								<label for="email">Email<span class="text-red">*</span></label>
								<input id="email" class="form-control" type="email"
									name="email" value="{{old('email', $request->email)}}" required
									autofocus autocomplete="username" />
								@error('email') <span class="text-danger">{{ $message }}</span>
								@enderror

							</div>

							<div class="form-group">
								<label for="password">Password<span class="text-red">*</span></label>
								<input id="password" class="form-control" type="password"
									name="password" required autocomplete="new-password" />
								@error('password') <span class="text-danger">{{ $message }}</span>
								@enderror

							</div>

							<div class="form-group">
							<label for="password_confirmation">Confirm Password<span class="text-red">*</span></label>
								<input id="password_confirmation" class="form-control"
									type="password" name="password_confirmation" required
									autocomplete="new-password" />
								@error('password_confirmation') <span class="text-danger">{{
									$message }}</span> @enderror

							</div>

							<div class="flex items-center justify-end mt-4">
							                                <button type="submit" class="btn btn-save">Reset Password</button>
							</div>
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
