@extends('layout.secondary')

@section('main-content')
    <div class="flex flex-col items-center ">

        <h1 class=" text-3xl font-semibold text-secondary-800 mb-6 text-center">
            Sign In NIC-Quiz
        </h1>

        <form action="{{ route('login.store') }}" method="POST" class="max-w-xl mx-auto w-full">
            @csrf
            <div
                class="bg-white font-semibold shadow-md px-32 py-10 mb-32 rounded-md text-secondary-700 border-t-4 border-secondary-400 ">

                <x-label for="username">Username</x-label>
                <x-form-input type="text" name="username" placeholder="Masukkan username" />


                <x-label for="password">Password</x-label>
                <x-form-input type="password" name="password" placeholder="Masukkan password" />

                <x-submit-button>Log In</x-submit-button>

            </div>

        </form>


        @if (session('error'))
            <div
                class=" px-3 py-2 bg-danger-500/50 rounded-md font-semibold text-md hover:bg-danger-500/30 hover:opacity-50">
                {{ session('error') }} <span class=" ml-4">x</span>
             </div>
        @endif

    </div>
@endsection
