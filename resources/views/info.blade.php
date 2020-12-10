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
              @livewire('menu-info')

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
                   {{--
                   <div class="relative mx-4 lg:mx-0">
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
                   </div>
                   --}}
                </div>
                <div class="flex items-center">
                   <div x-data="{ dropdownOpen: false }" class="relative">
                      @livewire('navigation-dropdown')
                   </div>
                </div>
             </header>

             <main class="flex-1 overflow-x-hidden overflow-y-auto bg-indigo-100">
                <div class="container mx-auto px-6 py-8">
                   <div class="flex flex-col mt-12 ">
                      <div class=" py-2 overflow-x-auto sm:mx-6 sm:px-2 lg:mx-20">

                        <div class="grid grid-cols-2 gap-12 mb-12 mt-12">
                            <!-- component -->
<div class="w-full sm:w-2/2 md:w-3/3 justify-center  px-8 py-6 shadow-sm rounded-md bg-red-100" >
    <h1 class="font-mono text-lg text-gray-800 justify-center">Menu:</h1>

    <br>

    <p class="font-mono text-sm text-gray-800 justify-center mb-3">Dashboard: overview sullo stato generale dei task elaborati ed in processing da HOQU.</p>
    <p class="font-mono text-sm text-gray-800 justify-center mb-3">Todo: in questa pagina troviamo solo i task in stato New e Processing</p>
    <p class="font-mono text-sm text-gray-800 justify-center mb-3">Done: in questa pagina troviamo solo i task in stato Done e Skip</p>
    <p class="font-mono text-sm text-gray-800 justify-center mb-3">Error: in questa pagina troviamo solo i task in stato Error</p>
    <p class="font-mono text-sm text-gray-800 justify-center mb-3">Duplicate: in questa pagina troviamo solo i task in stato Duplicate</p>
    <p class="font-mono text-sm text-gray-800 justify-center mb-3">Info: documentazione</p>
  </div>
  <!-- component -->
<div class="w-full sm:w-2/2 md:w-3/3 justify-center  px-4 py-6 shadow-sm rounded-md bg-orange-100" >
    <h1 class="font-mono text-lg text-gray-800 justify-center">campo PROCESS_STATUS puo assumere i seguenti valori:</h1>

    <br>

    <p class="font-mono text-sm text-gray-800 justify-center mb-3">New: valore che assume task appena viene inserito nel sistema da una Istanza, oppure in modalita manuale dall'Admin attraverso il bottone Reschedule presente in pagina Done ed Error</p>
    <p class="font-mono text-sm text-gray-800 justify-center mb-3">Processing: un task preso in carico da un Server, in fase di elaborazione</p>
    <p class="font-mono text-sm text-gray-800 justify-center mb-3">Error: un task assume questo valore di stato quando l'elaborazione da parte del server e terminata e non andata a buon fine</p>
    <p class="font-mono text-sm text-gray-800 justify-center mb-3">Done: un task assume questo valore di stato quando l'elaborazione da parte del server e terminata ed e andata a buon fine</p>
    <p class="font-mono text-sm text-gray-800 justify-center mb-3">Duplicate: questo valore di stato viene assegnato da HOQU quando e gia presente un altro task in stato New e con gli stessi valori nei campi instance, job e parameters</p>
    <p class="font-mono text-sm text-gray-800 justify-center mb-3">Skip: questo valore di stato viene assegnato dall'Admin quando un task si trova in uno stato di errore che non e risolvibile</p>



  </div>
  <div class="w-full sm:w-2/2 md:w-3/3 justify-center  px-4 py-6 shadow-sm rounded-md bg-orange-100" >
    <h1 class="font-mono text-lg text-gray-800 justify-center">campo PROCESS_LOG:</h1>

    <br>

    <p class="font-mono text-sm text-gray-800 justify-center mb-3">Su questo campo viene assegnato errore di log dal Server quando l'elaborazione non ha avuto successo</p>



  </div>
                         </div>
                      </div>




                      </div>
                   </div>
                </div>
             </main>
          </div>
       </div>
    </div>
 </x-app-layout>
