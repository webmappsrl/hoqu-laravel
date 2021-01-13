<x-app-layout>
    <div>
       <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-200">
          <div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false" class="fixed z-20 inset-0 bg-black opacity-50 transition-opacity 2xl:hidden"></div>
          <div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'" class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-white overflow-y-auto 2xl:translate-x-0 2xl:static 2xl:inset-0">
             <div class="flex items-center justify-center mt-8">
                <div class="flex items-center">
                   <img class="object-contain h-13" src="/image/logo-webmapp.png" alt="Hoqu by Webmapp">
                </div>
             </div>
              @livewire('menu-done')
          </div>
          <div class="flex-1 flex flex-col overflow-hidden">
             <header class="flex justify-between items-center py-4 px-6 bg-white border-b-4 border-orange-600">
                <div class="flex items-center">
                   <button @click="sidebarOpen = true" class="text-gray-500 focus:outline-none 2xl:hidden">
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
                 <div class="flex items-center justify-between">
                     <div class="flex items-center justify-center">
                         <div class="flex items-center justify-center text-3xl font-bold text-true-gray-800">
                             DONE
                         </div>
                     </div>
                 </div>
                <div class="flex items-center">
                   <div x-data="{ dropdownOpen: false }" class="relative">
                      @livewire('navigation-dropdown')
                   </div>
                </div>
             </header>
              @livewire('table-done',['instance'=>$tasks['instance'], 'job'=>$tasks['job'],'created_at'=>$tasks['created_at'],'num_page'=>$tasks['num_page']])

    </div>
       </div>
    </div>
 </x-app-layout>
