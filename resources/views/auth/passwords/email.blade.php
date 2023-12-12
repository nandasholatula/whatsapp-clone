@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div
                    class="card h-72 rounded-lg shadow-md border-2 border-opacity-0 hover:border-opacity-100 border-green_cus-300 items-center">

                    <div class="card-body items-center">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form class="grid h-full" method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <div class="row">

                                <div class="col d-flex mx-auto justify-center items-center space-x-4">
                                    <svg class="fill-current text-brown_cus-500" width="24" height="24"
                                        xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                                        <path
                                            d="M24 21h-24v-18h24v18zm-23-16.477v15.477h22v-15.477l-10.999 10-11.001-10zm21.089-.523h-20.176l10.088 9.171 10.088-9.171z" />
                                    </svg>
                                    <input id="email" type="email"
                                        class="border-none shadow-md border-transparent focus:outline-none focus:ring-2 focus:ring-green_cus-300 focus:border-transparent p-3 rounded-md md:w-80 sm:w-64 @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email"
                                        placeholder="Your Email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col justify-center text-center self-center">
                                    <button type="submit" class="btn bg-green_cus-300 hover:bg-green_cus-400 text-white">
                                        {{ __('Send Password Reset Link') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
