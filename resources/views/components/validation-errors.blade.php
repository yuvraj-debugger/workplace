@if ($errors->any())
    <div {{ $attributes }}>
        <!-- <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div> -->
@if(!Route::is('login') && !Request::is('/'))
        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $k =>$error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        @endif
    </div>
@endif
