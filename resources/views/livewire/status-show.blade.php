


<div class="flex items-center px-8 py-6 shadow-sm rounded-md bg-white" >
    <h4 class="text-2xl font-semibold text-gray-700">status: &nbsp</h4>
    <h4 class="text-2xl font-semibold text-gray-700 bg-blue-200 rounded-lg" > &nbsp{{ $task->process_status }}&nbsp</h4>
 </div>

 {{-- @if($task->process_status=='new')
                                        <span
                                           class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-200 text-gray-900"><a href="/{{$task->id }}/show">{{ $task->process_status }}</a></span>
                                           @elseif($task->process_status=='processing')

                                           <span
                                           class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-200 text-gray-900"><a href="/{{$task->id }}/show">{{ $task->process_status }}</a></span>
                                           @endif --}}
