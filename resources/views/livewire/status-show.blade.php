<main class="flex-1 overflow-x-hidden overflow-y-auto bg-indigo-100" wire:poll.5s>
    <div class="container mx-auto px-6 py-8">
       <div class="mt-4">
          <div class="flex flex-wrap">
             <div class="grid grid-cols-4 gap-12 mb-12 mt-12">
                <div class="flex justify-center items-center px-8 py-6 shadow-sm rounded-md bg-white" >
                    <h4 class="text-2xl font-semibold text-gray-700">ID:</h4>
                    <h4 id="idTask"class="text-2xl font-semibold text-gray-700">{{$task->id}}</h4>
                </div>
                <div class="flex justify-center items-center px-8 py-6 shadow-sm rounded-md bg-white" >
                   <h4 id="idServer"class="text-2xl font-semibold text-gray-700">ID Server:  {{$task->id_server}}</h4>
                </div>
                <div class="flex justify-center items-center px-8 py-6 shadow-sm rounded-md bg-white" >
                   <h4 id="idInstance" class="text-2xl font-semibold text-gray-700">Instance:  {{$task->instance}}</h4>
                </div>
                <div class="flex justify-center items-center px-8 py-6 shadow-sm rounded-md bg-white" >
                   <h4 id="idJob"class="text-2xl font-semibold text-gray-700">Job: <br> {{$task->job}}</h4>
                </div>
             </div>
          </div>
          <div class="grid grid-cols-2 gap-6 mb-16 mt-2">
             @if($task->process_status=='new')
             <div class="flex justify-center items-center px-8 py-6 shadow-sm rounded-md bg-white" >
                <h4 class="text-2xl font-semibold text-gray-700">status: &nbsp</h4>
                <h4 id="processStatus" class="text-2xl font-semibold text-gray-700 bg-blue-200 rounded-lg" > &nbsp{{ $task->process_status }}&nbsp</h4>
             </div>
             @elseif($task->process_status=='processing')
             <div class="flex justify-center items-center px-8 py-6 shadow-sm rounded-md bg-white" >
                <h4 class="text-2xl font-semibold text-gray-700">status: &nbsp</h4>
                <h4 id="processStatus" class="text-2xl font-semibold text-gray-700 bg-orange-200 rounded-lg" > &nbsp{{ $task->process_status }}&nbsp</h4>
             </div>
             @elseif($task->process_status=='error')
             <div class="flex justify-center items-center px-8 py-6 shadow-sm rounded-md bg-white" >
                <h4 class="text-2xl font-semibold text-gray-700">status: &nbsp</h4>
                <h4 id="processStatus" class="text-2xl font-semibold text-gray-700 bg-red-200 rounded-lg" > &nbsp{{ $task->process_status }}&nbsp</h4>
             </div>
             @elseif($task->process_status=='done')
             <div class="flex justify-center items-center px-8 py-6 shadow-sm rounded-md bg-white" >
                <h4 class="text-2xl font-semibold text-gray-700">status: &nbsp</h4>
                <h4 id="processStatus" class="text-2xl font-semibold text-gray-700 bg-green-200 rounded-lg" > &nbsp{{ $task->process_status }}&nbsp</h4>
             </div>
             @elseif($task->process_status=='duplicate')
             <div class="flex justify-center items-center px-8 py-6 shadow-sm rounded-md bg-white" >
                <h4 class="text-2xl font-semibold text-gray-700">status: &nbsp</h4>
                <h4 id="processStatus" class="text-2xl font-semibold text-gray-700 bg-yellow-200 rounded-lg" > &nbsp{{ $task->process_status }}&nbsp</h4>
             </div>
             @elseif($task->process_status=='skip')
             <div class="flex justify-center items-center px-8 py-6 shadow-sm rounded-md bg-white" >
                <h4 class="text-2xl font-semibold text-gray-700">status: &nbsp</h4>
                <h4 id="processStatus" class="text-2xl font-semibold text-gray-700 bg-indigo-200 rounded-lg" > &nbsp{{ $task->process_status }}&nbsp</h4>
             </div>
             @endif
             <div class="flex justify-center items-center px-8 py-6 shadow-sm rounded-md bg-white" >
                <h4 id="idParameters" class="text-2xl font-semibold text-gray-700">parameters:  {{$task->parameters}}</h4>
             </div>
          </div>
          <div class="grid grid-cols-2 gap-6 mb-16">
             <div class="flex justify-center items-center px-8 py-6 shadow-sm rounded-md bg-white " >
                <h4 class="text-2xl font-semibold text-gray-700">create:  {{$task->created_at}}</h4>
             </div>
             <div class="flex justify-center items-center px-8 py-6 shadow-sm rounded-md bg-white" >
                <h4 class="text-2xl font-semibold text-gray-700">worked:  {{$task->updated_at}}</h4>
             </div>
          </div>
          <div class="grid grid-cols-1 gap-6 ">
             <div class="flex justify-center items-center px-8 py-6 shadow-sm rounded-md bg-white " >
                <h4 class="text-2xl font-semibold text-gray-700">log:  {{$task->process_log}}</h4>
             </div>
          </div>
       </div>
       <div class="mt-8">
       </div>
       <div class="flex flex-col mt-8 ">
          <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
          </div>
       </div>
    </div>
    </div>
    </div>
 </main>
