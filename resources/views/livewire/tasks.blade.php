<div>
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
       <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity lg:hidden"></div>
       <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-white overflow-y-auto lg:translate-x-0 lg:static lg:inset-0">
          <div class="flex items-center justify-center mt-8">
             <div class="flex items-center">
                <img class="object-contain h-13" src="/image/logo-webmapp.png" alt="Hoqu by Webmapp">
             </div>
          </div>
          <nav class="mt-10">
            <a class="flex items-center mt-4 py-2 px-6 border-l-4 border-gray-900 text-gray-500 hover:bg-gray-600 hover:bg-opacity-25 hover:text-gray-100" href="/" >
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-bar-chart-line-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2z"/>
                  </svg>
               <span class="mx-4">Dashboard</span>
            </a>
            <a class="flex items-center mt-4 py-2 px-6 border-l-4 border-gray-900 text-gray-500 hover:bg-gray-600 hover:bg-opacity-25 hover:text-gray-100" href="/todo" >
                <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2 10C2 5.58172 5.58172 2 10 2V10H18C18 14.4183 14.4183 18 10 18C5.58172 18 2 14.4183 2 10Z" fill="currentColor"/>
                    <path d="M12 2.25195C14.8113 2.97552 17.0245 5.18877 17.748 8.00004H12V2.25195Z" fill="currentColor"/>
                 </svg>
                <span id="link_todo" class="mx-4">Todo</span>
             </a>
            <a class="flex items-center mt-4 py-2 px-6 border-l-4 border-gray-900 text-gray-500 hover:bg-gray-600 hover:bg-opacity-25 hover:text-gray-100" href="/done" >
               <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M5 3C3.89543 3 3 3.89543 3 5V7C3 8.10457 3.89543 9 5 9H7C8.10457 9 9 8.10457 9 7V5C9 3.89543 8.10457 3 7 3H5Z" fill="currentColor"/>
                  <path d="M5 11C3.89543 11 3 11.8954 3 13V15C3 16.1046 3.89543 17 5 17H7C8.10457 17 9 16.1046 9 15V13C9 11.8954 8.10457 11 7 11H5Z" fill="currentColor"/>
                  <path d="M11 5C11 3.89543 11.8954 3 13 3H15C16.1046 3 17 3.89543 17 5V7C17 8.10457 16.1046 9 15 9H13C11.8954 9 11 8.10457 11 7V5Z" fill="currentColor"/>
                  <path d="M11 13C11 11.8954 11.8954 11 13 11H15C16.1046 11 17 11.8954 17 13V15C17 16.1046 16.1046 17 15 17H13C11.8954 17 11 16.1046 11 15V13Z" fill="currentColor"/>
               </svg>
               <span id="link_done" class="mx-4">Done</span>
            </a>
            <a class="flex items-center mt-4 py-2 px-6 border-l-4 bg-gray-600 bg-opacity-25 text-gray-100 border-gray-100" href="/error" >
               <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M7 3C6.44772 3 6 3.44772 6 4C6 4.55228 6.44772 5 7 5H13C13.5523 5 14 4.55228 14 4C14 3.44772 13.5523 3 13 3H7Z" fill="currentColor"/>
                  <path d="M4 7C4 6.44772 4.44772 6 5 6H15C15.5523 6 16 6.44772 16 7C16 7.55228 15.5523 8 15 8H5C4.44772 8 4 7.55228 4 7Z" fill="currentColor"/>
                  <path d="M2 11C2 9.89543 2.89543 9 4 9H16C17.1046 9 18 9.89543 18 11V15C18 16.1046 17.1046 17 16 17H4C2.89543 17 2 16.1046 2 15V11Z" fill="currentColor"/>
               </svg>
               <span id="link_error" class="mx-4">Error</span>
            </a>
            <a class="flex items-center mt-4 py-2 px-6 border-l-4 border-gray-900 text-gray-500 hover:bg-gray-600 hover:bg-opacity-25 hover:text-gray-100" href="/duplicate" >
               <svg class="h-5 w-5" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M5 3C3.89543 3 3 3.89543 3 5V7C3 8.10457 3.89543 9 5 9H7C8.10457 9 9 8.10457 9 7V5C9 3.89543 8.10457 3 7 3H5Z" fill="currentColor"/>
                  <path d="M5 11C3.89543 11 3 11.8954 3 13V15C3 16.1046 3.89543 17 5 17H7C8.10457 17 9 16.1046 9 15V13C9 11.8954 8.10457 11 7 11H5Z" fill="currentColor"/>
                  <path d="M11 5C11 3.89543 11.8954 3 13 3H15C16.1046 3 17 3.89543 17 5V7C17 8.10457 16.1046 9 15 9H13C11.8954 9 11 8.10457 11 7V5Z" fill="currentColor"/>
                  <path d="M11 13C11 11.8954 11.8954 11 13 11H15C16.1046 11 17 11.8954 17 13V15C17 16.1046 16.1046 17 15 17H13C11.8954 17 11 16.1046 11 15V13Z" fill="currentColor"/>
               </svg>
               <span id="link_duplicate" class="mx-4">Duplicate</span>
            </a>
            <a class="flex items-center mt-4 py-2 px-6 border-l-4 border-gray-900 text-gray-500 hover:bg-gray-600 hover:bg-opacity-25 hover:text-gray-100" href="/info" >
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-info-circle-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412l-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM8 5.5a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                  </svg>
                <span id="link_info" class="mx-4">Info</span>
             </a>
         </nav>
       </div>
       <div class="flex-1 flex flex-col overflow-hidden">
          <header class="flex justify-between items-center py-4 px-6 bg-white border-b-4 border-orange-600">
             <div class="flex items-center">
                <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none lg:hidden">
                   <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                         stroke-linejoin="round"></path>
                   </svg>
                </button>
                {{-- <div class="relative mx-4 lg:mx-0">
                   <span class="absolute inset-y-0 left-0 pl-3 flex items-center">
                      <svg class="h-5 w-5 text-gray-500" viewBox="0 0 24 24" fill="none">
                         <path
                            d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                         </path>
                      </svg>
                   </span>
                   <input class="form-input w-32 sm:w-64 rounded-md pl-10 pr-4 focus:border-indigo-600" type="text"
                      placeholder="Search">
                </div> --}}
             </div>
             <div class="flex items-center">
                <div x-data="{ dropdownOpen: false }" class="relative">
                   @livewire('navigation-dropdown')
                </div>
             </div>
          </header>
          <main class="flex-1 overflow-x-hidden overflow-y-auto bg-indigo-100">
             <div class="container mx-auto px-6 py-8">
                <div class="flex flex-col mt-8 ">
                   <div class=" py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-20">
                      <div
                         class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                         @if (session()->has('message'))
                         <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                            <div class="flex">
                               <div>
                                  <p class="text-lg">{{ session('message') }}</p>
                               </div>
                            </div>
                         </div>
                         @endif
                         @if($isOpen)
                         {{-- @include('livewire.create')
                         @include('livewire.reschedule') --}}
                         @include('livewire.skip')
                         @endif
                         <table id='hometable' class="min-w-full">
                            <thead>
                               <tr>
                                  <th
                                     class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                     Id
                                  </th>
                                  <th
                                     class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                     Instance
                                  </th>
                                  <th
                                     class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                     Job
                                  </th>
                                  <th
                                     class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                     Parameters
                                  </th>
                                  <th
                                     class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                     Status
                                  </th>
                                  <th
                                     class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                     Create
                                  </th>
                                  <th
                                     class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                     Worked
                                  </th>
                                  <th
                                     class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                     Elapsed time
                                  </th>
                                  <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                               </tr>
                            </thead>
                            <tbody class="bg-white">
                               @foreach ($tasks as $index => $task)
                               <tr>
                                  <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                     <div class="flex items-center">
                                        <div class="text-sm leading-5 text-gray-500"><a href="/{{$task->id }}/show">{{ $task->id }}</a></div>
                                     </div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                     <div class="text-sm leading-5 text-gray-900"><a href="/{{$task->id }}/show">{{ $task->instance }}</a></div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                     <div class="text-sm leading-5 text-gray-900"><a href="/{{$task->id }}/show">{{ $task->job }}</a></div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                     <div class="text-sm leading-5 text-gray-900"><a href="/{{$task->id }}/show">{{ $task->parameters }}</a></div>
                                  </td>
                                  <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                     @if($task->process_status=='new')
                                     <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-200 text-gray-900"><a href="/{{$task->id }}/show">{{ $task->process_status }}</a></span>
                                     @elseif($task->process_status=='processing')
                                     <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-200 text-gray-900"><a href="/{{$task->id }}/show">{{ $task->process_status }}</a></span>
                                     @elseif($task->process_status=='done')
                                     <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-200 text-gray-900"><a href="/{{$task->id }}/show">{{ $task->process_status }}</a></span>
                                     @elseif($task->process_status=='error')
                                     <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-200 text-gray-900"><a href="/{{$task->id }}/show">{{ $task->process_status }}</a></span>
                                     @elseif($task->process_status=='skip')
                                     @elseif($task->process_status=='skip')
                                     <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indingo-200 text-gray-900"><a href="/{{$task->id }}/show">{{ $task->process_status }}</a></span>
                                     @endif
                                  </td>
                                  <td
                                     class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                     <a href="/{{$task->id }}/show">{{ $task->created_at}}</a>
                                  </td>
                                  <td
                                     class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                     <a href="/{{$task->id }}/show">{{ $task->updated_at}}</a>
                                  </td>
                                  <td
                                     class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                                     <a href="/{{$task->id }}/show">{{ $task->created_at->floatDiffInSeconds($task->updated_at) }}</a>
                                  </td>
                                  <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                     <div class="flex justify-center bg-grey-lighter mb-1 text-sm leading-3 text-gray-900"> <button data-toggle="modal" data-target="#updateModal" wire:click="edit({{$task}})" class="bg-white text-gray-800 font-bold rounded border-b-2 border-indigo-500 hover:border-indigo-600 hover:bg-indigo-500  hover:text-white shadow-md py-2 px-6 inline-flex items-center">
                                        <span class="mr-1">Edit</span>
                                        </button>
                                     </div>
                                  </td>
                               </tr>
                               @endforeach
                            </tbody>
                         </table>
                         <ul class="w-7/12 px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                            {{ $posts->links() }}
                         </ul>
                      </div>
                   </div>
                </div>
             </div>
          </main>
       </div>
    </div>
 </div>
