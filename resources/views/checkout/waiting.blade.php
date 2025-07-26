@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto py-10 text-center">
    <h1 class="text-2xl font-bold mb-4">Finalizing Your Order...</h1>
    <p class="text-gray-600">Hang tight! This usually takes just a few seconds.</p>
    <p class="text-sm mt-2">If nothing happens, please refresh this page in a few moments.</p>

    <script>
        setTimeout(() => {
            window.location.reload();
        }, 3000); // retry every 3 seconds
    </script>
</div>
@endsection
