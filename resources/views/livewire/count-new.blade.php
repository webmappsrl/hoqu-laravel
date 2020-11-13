<div class="flex items-center px-5 py-6 shadow-sm rounded-md bg-white">
    <div class="p-3 rounded-full bg-blue-600 bg-opacity-75">
       <svg width="2em" height="2em" viewBox="0 0 16 16" class="bi bi-box" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5 8 5.961 14.154 3.5 8.186 1.113zM15 4.239l-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z"/>
       </svg>
    </div>
    <div class="mx-5" wire:poll.10s>
       <h4 class="text-2xl font-semibold text-gray-700">{{ $count_new }}</h4>
       <div class="text-gray-500">New</div>
    </div>
 </div>
