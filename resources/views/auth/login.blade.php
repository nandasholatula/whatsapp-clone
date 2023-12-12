@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 h-96 grid items-center">
                <div
                    class="card h-72 rounded-lg shadow-md border-2 border-opacity-0 hover:border-opacity-100 border-green_cus-300 items-center">

                    <div class="card-body items-center">
                        <form class="grid h-full" method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row">

                                <div class="col d-flex mx-auto justify-center items-center space-x-4">
                                    <svg class="fill-current text-brown_cus-500" width="24" height="24"
                                        xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                        <path
                                            d="M24 21h-24v-18h24v18zm-23-16.477v15.477h22v-15.477l-10.999 10-11.001-10zm21.089-.523h-20.176l10.088 9.171 10.088-9.171z" />
                                    </svg>
                                    <input
                                        class="border-none shadow-md border-transparent focus:outline-none focus:ring-2 focus:ring-green_cus-300 focus:border-transparent p-3 rounded-md md:w-80 sm:w-64"
                                        id="email" type="email" placeholder="Your Email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">

                                <div class="col d-flex mx-auto justify-center items-center space-x-4">
                                    <svg class="fill-current text-brown_cus-500" width="24" height="24"
                                        xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                        <path
                                            d="M16 1c-4.418 0-8 3.582-8 8 0 .585.063 1.155.182 1.704l-8.182 7.296v5h6v-2h2v-2h2l3.066-2.556c.909.359 1.898.556 2.934.556 4.418 0 8-3.582 8-8s-3.582-8-8-8zm-6.362 17l3.244-2.703c.417.164 1.513.703 3.118.703 3.859 0 7-3.14 7-7s-3.141-7-7-7c-3.86 0-7 3.14-7 7 0 .853.139 1.398.283 2.062l-8.283 7.386v3.552h4v-2h2v-2h2.638zm.168-4l-.667-.745-7.139 6.402v1.343l7.806-7zm10.194-7c0-1.104-.896-2-2-2s-2 .896-2 2 .896 2 2 2 2-.896 2-2zm-1 0c0-.552-.448-1-1-1s-1 .448-1 1 .448 1 1 1 1-.448 1-1z" />
                                    </svg>
                                    <input
                                        class="border-none shadow-md border-transparent focus:outline-none focus:ring-2 focus:ring-green_cus-300 focus:border-transparent p-3 rounded-md md:w-80 sm:w-64"
                                        id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Your Password" required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col justify-center text-center self-center">
                                    <button type="submit" class="btn bg-green_cus-300 hover:bg-green_cus-400 text-white">
                                        {{ __('Login') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link text-brown_cus-600" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
