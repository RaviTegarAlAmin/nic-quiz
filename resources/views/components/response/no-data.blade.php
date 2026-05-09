@props(['message' => 'Tida Ada Data'])

<div class=" md:w-64 w-48 px-auto mx-auto">
    <img class=" w-full" src="{{ asset('Assets/images/illustrations/no-data.svg') }}" alt="no-data">
    <p class=" md:text-2xl text-lg ml-12 mt-2 text-gray-300 hover:text-gray-400 cursor-pointer">
        {{ $message }}
    </p>
</div>
