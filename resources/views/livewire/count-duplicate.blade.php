<div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
    <div class="p-3 rounded-full bg-pink-600 bg-opacity-75">
       <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-node-plus" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M11 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8zM6.025 7.5a5 5 0 1 1 0 1H4A1.5 1.5 0 0 1 2.5 10h-1A1.5 1.5 0 0 1 0 8.5v-1A1.5 1.5 0 0 1 1.5 6h1A1.5 1.5 0 0 1 4 7.5h2.025zM11 5a.5.5 0 0 1 .5.5v2h2a.5.5 0 0 1 0 1h-2v2a.5.5 0 0 1-1 0v-2h-2a.5.5 0 0 1 0-1h2v-2A.5.5 0 0 1 11 5zM1.5 7a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1z"/>
       </svg>
    </div>
    <div class="mx-5" wire:poll.10s>
        <h4 class="text-2xl font-semibold text-gray-700">{{ $count_duplicate }}</h4>
       <div class="text-gray-500">Duplicate</div>
    </div>
 </div>
