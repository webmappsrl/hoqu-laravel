<main class="flex-1 overflow-x-hidden overflow-y-auto bg-indigo-100">
    <div class="container mx-auto w-3/4 px-6 py-8">
        <div class="flex flex-col mt-8 ">
           <div class=" py-2 overflow-x-auto sm:-mx-6 sm:px-2 lg:-mx-20">

          <div class="my-2 py-2 overflow-x-auto">
            <div class="mb-8">
                <label class="inline-block w-32 font-bold">Filter:</label>
                <select id="selectInstance" class="border border-gray-300 rounded-full text-gray-600 h-10 pl-5 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none"name="instance" class="border shadow p-2 bg-white" wire:model='instance'
                >
                    <option value=''>Choose a Instance</option>
                    @foreach($instances as $instance)
                        <option value="{{ $instance->instance }}">{{ $instance->instance }}</option>
                    @endforeach
                </select >

                @if(count($jobs) > 0)

                <select id="selectJob" class="border border-gray-300 rounded-full text-gray-600 h-10 pl-5 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none"name="job" class="border shadow p-2 bg-white" wire:model='job'
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

             <div
                class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">

                <table id='hometable' class="min-w-full" wire:poll.5s>
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
                            Father
                         </th>
                      </tr>
                   </thead>
                   <tbody class="bg-white">
                      @foreach ($tasks as $index => $task)
                      <tr>
                         <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="flex items-center">
                               <div class="text-sm leading-5 text-gray-500"><a href="/{{$task->id }}/show_duplicate">{{ $task->id }}</a></div>
                            </div>
                         </td>
                         <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="text-sm leading-5 text-gray-900"><a href="/{{$task->id }}/show_duplicate">{{ $task->instance }}</a></div>
                         </td>
                         <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="text-sm leading-5 text-gray-900"><a href="/{{$task->id }}/show_duplicate">{{ $task->job }}</a></div>
                         </td>
                         <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <div class="text-sm leading-5 text-gray-900"><a href="/{{$task->id }}/show_duplicate">{{ $task->parameters }}</a></div>
                         </td>
                         <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            <span
                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-200 text-gray-900"><a href="/{{$task->id }}/show_duplicate">duplicate</a></span>
                         </td>
                         <td
                            class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                            <a href="/{{$task->id }}/show_duplicate">{{ $task->created_at}}</a>
                         </td>
                         <td
                            class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 text-sm leading-5 text-gray-500">
                            <a href="/{{$task->task_id }}/show">{{ $task->task_id}}</a>
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
