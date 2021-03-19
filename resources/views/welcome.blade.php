
        
        @extends("layouts.app")
        
        @section("content")
        @if (Auth::check())
            {{ Auth::user()->name }}
         @else
        <div class="center jumbotron">
        <div class="text-center">
            <h1>Welcome tasklist</h1>
            {{-- ユーザ登録ページへのリンク --}}
            {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
        @endif
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
        </div>
        </div>
        </div>
            @endif
            @endsection
