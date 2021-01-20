<main class="flex-1 overflow-x-hidden overflow-y-auto bg-indigo-100">
    <div class="container mx-auto w-3/4 px-6 py-8">
        <div class="flex flex-col mt-8 ">
           <div class=" py-2 overflow-x-auto sm:-mx-6 sm:px-2 lg:-mx-20">

          <div class="my-2 py-2 overflow-x-auto">
              <div class="mb-8 ml-4 flex flex-wrap mx-2 mb-4">
              <label class="inline-block w-32 font-bold">Filter:</label>
                <select id="selectInstance"  class="border border-gray-300 rounded-full text-gray-600 h-10 pl-5 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none" name="instance" class="border shadow p-2 bg-white" wire:model='instance'
                >
                    <option value=''>Choose a Instance</option>
                    @foreach($instances as $instance)
                        <option value="{{$instance->instance}}">{{ $instance->instance }}</option>
                    @endforeach
                </select >

                @if(count($jobs) > 0)

                <select id="selectJob" class="border border-gray-300 rounded-full text-gray-600 h-10 pl-5 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none" name="job" class="border shadow p-2 bg-white" wire:model='job'
                >
                    <option value=''>Choose a job</option>
                    @foreach($jobs as $job)
                        <option value="{{ $job->job}}">{{ $job->job }}</option>
                    @endforeach
                </select >
                @endif
                <select id="dataAsc" class="border border-gray-300 rounded-full text-gray-600 h-10 pl-5 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none" name="created_at" class="border shadow p-2 bg-white" wire:model='created_at'
                >
                    <option value=''>Order Data</option>
                        <option id="A1" value='asc'>asc</option>
                        <option id="D1" value='desc'>desc</option>
                </select >
                <select id="pageNumber" class="border border-gray-300 rounded-full text-gray-600 h-10 pl-5 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none" name="num_page" class="border shadow p-2 bg-white" wire:model='num_page'
                >
                    <option value=''>#Page</option>
                    <option id="p10" value='10'>10</option>
                    <option id="p25" value='25'>25</option>
                    <option id="p50" value='50'>50</option>
                    <option id="p100" value='100'>100</option>
                </select >

            </div>
              @if(count($selectedErrors) > 0 && count(array_keys($selectedErrors, false)) != count($selectedErrors))
                  <div class="mb-2 flex flex-wrap mx-2 mb-4">
                      <label class="sm:1/4 md:w-1/4 lg:w-1/4 px-2 mb-4 inline-block w-32 font-bold">Bulk Action:</label>
                      <button id="bulkRes" wire:click="editAllRes()" data-toggle="modal" data-target="#updateModalAllRes" class="w-full sm:1/4 md:w-1/4 lg:w-1/4 px-2 mb-4 mr-3 bg-white text-gray-800 font-bold rounded border-b-2 border-green-500 hover:border-green-600 hover:bg-green-500  hover:text-white shadow-md py-2 px-6 inline-flex items-center text-center">
                          <span class="mr-1">Reschedule</span>
                      </button>
                      <button id="bulkSkip" wire:click="editAllSkip()" data-toggle="modal" data-target="#updateModalAllSkip" class="w-full sm:1/4 md:w-1/4 lg:w-1/4 px-2 mb-4 bg-white text-gray-800 font-bold rounded border-b-2 border-blue-500 hover:border-blue-600 hover:bg-blue-500  hover:text-white shadow-md py-2 px-6 inline-flex items-center text-center">
                          <span class="mr-1">Skip</span>
                      </button>
                  </div>
              @endif

            <div
            class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
            @if (session()->has('message'))
            <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
               <div class="flex">
                  <div>
                     <p class="text-lg">{!!session('message') !!}</p>
                  </div>
               </div>
            </div>
            @endif
            @if($isOpen)
            @include('livewire.done-new')
            @endif
                @if($isOpenResAll)
                    @include('livewire.skipBulkRes')
                @endif
                @if($isOpenSkipAll)
                    @include('livewire.skipBulkSkip')
                @endif
                <table id='hometable' class="min-w-full" wire:poll.5s>
               <thead>
                  <tr>
                      <th class="px-2 py-3 border-b border-gray-200 bg-gray-50"></th>
                      <th
                          class="px-2 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
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
                     </th
                         >
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
                          <label class="inline-flex items-center mt-3">
                              <input type="checkbox" class="form-checkbox h-5 w-5 text-green-600" value="{{$task->id }}" wire:model="selectedErrors.{{$task->id }}" >
                          </label>
                      </td>
                      <td class="px-2 py-4 whitespace-no-wrap border-b border-gray-200">
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
                             <span
                                 class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-200 text-gray-900"><a href="/{{$task->id }}/show">{{ $task->process_status }}</a></span>
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
            <ul id="paginationDone" class="w-7/12 px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
               {{ $tasks->links() }}
            </ul>
         </div>
          </div>
       </div>
        </div>
    </div>
 </main>
