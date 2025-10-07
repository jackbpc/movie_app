@if(session('success'))
    <div class="mb-4 px-4 py-2 bg-green-100 border border-green-400 text-green-700 rounded-md">
        {{$slot}}
    </div>
    @endif