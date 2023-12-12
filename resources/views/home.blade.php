@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <?php $user = App\Models\UserCred::where('user_id', auth()->id())->first(); ?>
        @if (isset($user) && $user->active)
            <main-component></main-component>
        @else
            <?php
            $creds = App\Models\Credential::all();
            $user_cred = App\Models\UserCred::where('user_id', auth()->id())->first();
            ?>
            <div class="container flex justify-center">
                <div class="card w-max border-0 shadow-md p-8">
                    <div class="card-body">
                        <div class="home-status capitalize">
                            @if ($user_cred)
                                Menunggu admin untuk konfirmasi
                            @else
                                pengajuan akun WA
                            @endif
                        </div>
                        <div class="mt-4 mb-3 text-lg text-center">
                            Silahkan pilih akun WA yang ingin digunakan:
                        </div>
                        <form action="{{ route('assign.cred') }}" method="POST" class="flex justify-center">
                            @csrf
                            <select class="form-select w-60" name="cred">
                                <option disabled @if (!$user_cred) selected @endif>Select Credential</option>
                                @foreach ($creds as $cred)
                                    <option @if (isset($user_cred) && $user_cred->credential_id == $cred->id) selected @endif value="{{ $cred->id }}">
                                        {{ $cred->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button
                                class="btn ml-3 bg-green_cus-300 hover:bg-green_cus-400 cursor-pointer text-white">Kirim</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
