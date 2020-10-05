<x-app-layout>
    <x-slot name="header">
       <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('HOQU Archive') }}
       </h2>
    </x-slot>
    <div>
       <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
       <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
          <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>
          <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-gray-900 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0">
             <div class="flex items-center justify-center mt-8">
                <div class="flex items-center">
                   <span class="text-white text-2xl mx-2 font-semibold">Dashboard</span>
                </div>
             </div>
             <nav class="mt-10">
                <a class="flex items-center mt-4 py-2 px-6 border-l-4 border-gray-900 text-gray-500 hover:bg-gray-600 hover:bg-opacity-25 hover:text-gray-100" href="/" >
                   <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M2 10C2 5.58172 5.58172 2 10 2V10H18C18 14.4183 14.4183 18 10 18C5.58172 18 2 14.4183 2 10Z" fill="currentColor"/>
                      <path d="M12 2.25195C14.8113 2.97552 17.0245 5.18877 17.748 8.00004H12V2.25195Z" fill="currentColor"/>
                   </svg>
                   <span class="mx-4">Home</span>
                </a>
                <a class="flex items-center mt-4 py-2 px-6 border-l-4 bg-gray-600 bg-opacity-25 text-gray-100 border-gray-100" href="/archive" >
                   <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M5 3C3.89543 3 3 3.89543 3 5V7C3 8.10457 3.89543 9 5 9H7C8.10457 9 9 8.10457 9 7V5C9 3.89543 8.10457 3 7 3H5Z" fill="currentColor"/>
                      <path d="M5 11C3.89543 11 3 11.8954 3 13V15C3 16.1046 3.89543 17 5 17H7C8.10457 17 9 16.1046 9 15V13C9 11.8954 8.10457 11 7 11H5Z" fill="currentColor"/>
                      <path d="M11 5C11 3.89543 11.8954 3 13 3H15C16.1046 3 17 3.89543 17 5V7C17 8.10457 16.1046 9 15 9H13C11.8954 9 11 8.10457 11 7V5Z" fill="currentColor"/>
                      <path d="M11 13C11 11.8954 11.8954 11 13 11H15C16.1046 11 17 11.8954 17 13V15C17 16.1046 16.1046 17 15 17H13C11.8954 17 11 16.1046 11 15V13Z" fill="currentColor"/>
                   </svg>
                   <span id="link_archive" class="mx-4">Archive</span>
                </a>
                <a class="flex items-center mt-4 py-2 px-6 border-l-4 border-gray-900 text-gray-500 hover:bg-gray-600 hover:bg-opacity-25 hover:text-gray-100" href="/error" >
                   <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M7 3C6.44772 3 6 3.44772 6 4C6 4.55228 6.44772 5 7 5H13C13.5523 5 14 4.55228 14 4C14 3.44772 13.5523 3 13 3H7Z" fill="currentColor"/>
                      <path d="M4 7C4 6.44772 4.44772 6 5 6H15C15.5523 6 16 6.44772 16 7C16 7.55228 15.5523 8 15 8H5C4.44772 8 4 7.55228 4 7Z" fill="currentColor"/>
                      <path d="M2 11C2 9.89543 2.89543 9 4 9H16C17.1046 9 18 9.89543 18 11V15C18 16.1046 17.1046 17 16 17H4C2.89543 17 2 16.1046 2 15V11Z" fill="currentColor"/>
                   </svg>
                   <span id="link_error" class="mx-4">Error</span>
                </a>
             </nav>
          </div>
          <div class="bg-white flex-1 flex flex-col overflow-hidden shadow-xl">
             <main class="flex-1 overflow-x-hidden overflow-y-auto bg-white-200">
                <div class="container mx-auto px-6 py-2">
                   <div class="flex flex-col mt-8">
                      <div class=" overflow-hidden  sm:rounded-lg">
                         <table id="hometable" class="table-auto">
                            <thead>
                               <tr>
                                  <th class="px-4 py-6">id</th>
                                  <th class="px-4 py-6">instance</th>
                                  <th class="px-4 py-6">job</th>
                                  <th class="px-4 py-6">parameters</th>
                                  <th class="px-4 py-6">process_status</th>
                                  <th class="px-4 py-6">create</th>
                                  <th class="px-4 py-6">worked</th>
                                  <th class="px-4 py-6">elapsed time</th>
                               </tr>
                            </thead>
                            <tbody>
                               @foreach ($tasks as $index => $task)
                               @if ($index % 2)
                               <tr>
                                  @else
                               <tr class="bg-gray-100">
                                  @endif
                                  <td class="border-0 px-4 py-6"><a href="/{{$task->id }}/show">{{ $task->id }}</a></td>
                                  <td class="border-0 px-4 py-6"><a href="/{{$task->id }}/show">{{ $task->instance }}</a></td>
                                  <td class="border-0 px-4 py-6"><a href="/{{$task->id }}/show">{{ $task->job }}</a></td>
                                  <td class="border-0 px-4 py-6"><a href="/{{$task->id }}/show">{{ $task->parameters }}</a></td>
                                  <td class="border-0 px-4 py-6"><a href="/{{$task->id }}/show">{{ $task->process_status }}</a></td>
                                  <td class="border-0 px-4 py-6"><a href="/{{$task->id }}/show">{{ $task->created_at}}</a></td>
                                  <td class="border-0 px-4 py-6"><a href="/{{$task->id }}/show">{{ $task->updated_at}}</a></td>
                                  <td class="border-0 px-4 py-6"><a href="/{{$task->id }}/show">{{ $task->created_at->floatDiffInSeconds($task->updated_at) }}</a></td>
                               </tr>
                               @endforeach
                            </tbody>
                         </table>
                         {{ $tasks->render()}}
                      </div>
                   </div>
                </div>
             </main>
          </div>
       </div>
    </div>
 </x-app-layout>
