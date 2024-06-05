<div>
 <x-authentication-card>
        <x-slot name="logo">

        </x-slot>

        <x-validation-errors class="mb-4" />

        @if ($errors->any())
        <div class="error font-medium text-red-600 dark:text-red-400 p-2">
            {{ session('error') }}
        </div>
        @endif
        @if (session()->has('error'))
        <div class="error font-medium text-red-600 dark:text-red-400 p-2">
            <div class="error-inner">
                <a href="" type="button"><i class="fa-solid fa-xmark background"></i></a>
                <p class="message">
                    {{ session('error') }}
                </p>
            </div>
        </div>
        @endif
        @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ session('status') }}
        </div>
        @endif
        <form wire:submit.prevent="login">
            @csrf
            
            <div class="form-group">
                <label for="name">Email Address <span class="text-red">*</span></label>
                <input id="email" class="form-control"  wire:model="email" type="email" name="email" :value="old('email')" autofocus autocomplete="username" placeholder="Your Email"  required/>
            </div>
            
            
             <div class="form-group" >
                                    <label for="password"
                                        class="d-flex justify-content-between align-items-center" ><span>Password <span class="text-red">*</span></span>
                                        @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}">Forgot Password?</a>
                                    @endif
                                        
                                    </label>
                                    
                                    <input id="password" class="form-control" type="password" wire:model="password" name="password" autocomplete="current-password" placeholder="Password" required/>
								<span toggle="#password-field" 
                                        class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
                                </div>
            

<div class="form-group mt-2">
                                    <label for="remember_me" class="form-check">
                                        <input type="checkbox" id="remember_me" name="remember"  class="form-check-input" />
                                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                    </label>
                                </div>
           


             <button type="submit" class="btn btn-save">Login</button>
</form>
</x-authentication-card>

<script>
    $().ready(function() {
        $('#loginform').validate({
            rules: {
                patient_first_name: "required",
                patient_last_name: "required"
            },
            messages: {
                patient_first_name: "Please enter first name",
                patient_last_name: "Please enter last name"
    
            },
            submitHandler: function(form) {
                form.submit();
            }
    
            // any other options and/or rules
        });
    });
    </script>
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
</div>