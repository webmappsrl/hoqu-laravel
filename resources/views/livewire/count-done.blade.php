<div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
    <div class="p-3 rounded-full bg-green-600 bg-opacity-75">
       <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-check-circle" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
          <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
       </svg>
    </div>
    <div class="mx-5" wire:poll.10s>
        <h4 class="text-2xl font-semibold text-gray-700">{{ $count_done }}</h4>
       <div class="text-gray-500">Done</div>
    </div>
 </div>
