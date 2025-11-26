<!-- resources/views/layouts/message.blade.php -->

@if (Session::has('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 relative" role="alert">
        <p class="font-bold">Éxito</p>
        <p>{{ Session::get('success') }}</p>
        <button type="button" class="absolute top-2 right-2 text-green-700 font-bold" onclick="this.parentElement.style.display='none';">
            &times;
        </button>
    </div>
@endif

@if (Session::has('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 relative" role="alert">
        <p class="font-bold">Error</p>
        <p>{{ Session::get('error') }}</p>
        <button type="button" class="absolute top-2 right-2 text-red-700 font-bold" onclick="this.parentElement.style.display='none';">
            &times;
        </button>
    </div>
@endif
