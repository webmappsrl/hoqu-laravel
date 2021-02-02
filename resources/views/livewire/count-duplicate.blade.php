<div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
    <div class="p-3 rounded-full bg-yellow-300 bg-opacity-75">
        <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em"fill="currentColor" class="bi bi-back" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M0 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v2h2a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-2H2a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H2z"/>
        </svg>
    </div>
    <div class="mx-5" wire:poll.10s>
        <h4 class="text-2xl font-semibold text-gray-700">{{ $count_duplicate }}</h4>
       <div class="text-gray-500">Duplicate</div>
    </div>
 </div>
