<main class="flex-1 overflow-x-hidden overflow-y-auto bg-indigo-100">
    <div class="container mx-auto px-6 py-8">
       <div class="flex flex-col mt-8 ">
          <div class=" py-2 overflow-x-auto sm:-mx-6 sm:px-2 lg:-mx-20">
             <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                @if (session()->has('message'))
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
                   <div class="flex">
                      <div>
                         <p class="text-sm">{{ session('message') }}</p>
                      </div>
                   </div>
                </div>
                @endif
                <div class="mb-8">
                   <label class="inline-block w-32 font-bold">Filter:</label>
                   <select class="border border-gray-300 rounded-full text-gray-600 h-10 pl-5 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none"name="instance" class="border shadow p-2 bg-white" wire:model='instance'
                      >
                      <option value=''>Choose a Instance</option>
                      @foreach($instances as $instance)
                      <option value={{ $instance->instance }}>{{ $instance->instance }}</option>
                      @endforeach
                   </select >
                   <select class="border border-gray-300 rounded-full text-gray-600 h-10 pl-5 pr-10 bg-white hover:border-gray-400 focus:outline-none appearance-none"name="job" class="border shadow p-2 bg-white" wire:model='job'
                      >
                      <option value=''>Choose a job</option>
                      @foreach($jobs as $job)
                      <option value={{ $job->job}}>{{ $job->job }}</option>
                      @endforeach
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
                               Worked
                            </th>
                            <th
                               class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                               Elapsed time
                            </th>
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
