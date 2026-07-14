<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>KasKos</title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>

<body class="bg-white">

<div
class="flex flex-col items-center justify-center h-screen animate-pulse">

    <div class="flex justify-center">
            <div class="w-14 h-14 rounded-xl bg-[#E84855] flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M4 21V7a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v14M14 21V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v17" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M7 9h1M7 12h1M7 15h1M10 9h1M10 12h1M10 15h1M17 6h1M17 9h1M17 12h1M17 15h1" stroke-linecap="round"/>
                    <path d="M4 21h16" stroke-linecap="round"/>
                </svg>
            </div>
        </div>

    <h1 class="mt-8 text-4xl font-bold text-[#C3323E]">

        KasKos

    </h1>

    <p class="mt-2 text-gray-500">

        Sistem Informasi Kas Kos

    </p>

    <div
    class="mt-10 h-1 w-40 bg-gray-200 rounded-full overflow-hidden">

        <div
        class="h-full bg-[#C3323E] animate-[loading_2s_linear_forwards]">
        </div>

    </div>

</div>

<style>

@keyframes loading{

from{
width:0%;
}

to{
width:100%;
}

}

</style>

<script>

setTimeout(function(){

@if (Route::has('login'))

window.location.href="{{ route('login') }}";

@endif

},5000);

</script>

</body>
</html>
