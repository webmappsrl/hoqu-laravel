<main class="flex-1 overflow-x-hidden overflow-y-auto bg-indigo-100" wire:poll.5s>
    <div class="container mx-auto px-6 py-8">
        <div class="mt-4">
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
                @include('livewire.skip')
            @endif
                @if($isTrello)
                    @include('livewire.trello')
                @endif
                @if($isTrelloBug)
                    @include('livewire.trelloBug')
                @endif
                @if($isReschedule)
                    @include('livewire.resk')
                @endif
            <div class="container m-auto p-8 text-grey-darkest">
                @if($task->process_status=='error' || $task->process_status=='done' || $task->process_status=='processing')
                    <div class="flex flex-wrap -mx-2 mb-4">
                        <div class="w-full sm:1/4 md:w-1/4 lg:w-1/4 px-2 mb-4">
                            <div class="h-12 text-sm text-grey-dark px-1 mb-1 flex items-center justify-center shadow-sm rounded-md bg-white">
                                <button id="editRes" data-toggle="modal" data-target="#updateModal" wire:click="editRes({{$task}})" class="bg-white text-gray-800 font-bold rounded border-b-2 border-green-500 hover:border-green-600 hover:bg-green-500  hover:text-white shadow-md py-2 px-6 inline-flex items-center">
                                    <span class="mr-1">Reschedule</span>
                                </button>
                            </div>
                        </div>
                        <div class="w-full sm:1/4 md:w-1/4 lg:w-1/4 px-2 mb-4">
                            <div class="h-12 text-sm text-grey-dark px-1 mb-1 flex items-center justify-center shadow-sm rounded-md bg-white">
                                <button id="editShow" data-toggle="modal" data-target="#updateModal" wire:click="edit({{$task}})" class="bg-white text-gray-800 font-bold rounded border-b-2 border-blue-500 hover:border-blue-600 hover:bg-blue-500  hover:text-white shadow-md py-2 px-6 inline-flex items-center">
                                    <span class="mr-1">Skip</span>
                                </button>
                            </div>
                        </div>
                        <div class="w-full sm:1/4 md:w-1/4 lg:w-1/4 px-2 mb-4">
                            <div class="h-12 text-sm text-grey-dark px-1 mb-1 flex items-center justify-center shadow-sm rounded-md bg-white">
                                <button id="editCard" data-toggle="modal" data-target="#updateModal" wire:click="setCardTrello({{$task}})" class="bg-white text-gray-800 font-bold rounded border-b-2 border-pink-500 hover:border-pink-600 hover:bg-pink-500  hover:text-white shadow-md py-2 px-6 inline-flex items-center">
                                    <span class="mr-1">Card</span>
                                </button>
                            </div>
                        </div>
                        <div class="w-full sm:1/4 md:w-1/4 lg:w-1/4 px-2 mb-4">
                            <div class="h-12 text-sm text-grey-dark px-1 mb-1 flex items-center justify-center shadow-sm rounded-md bg-white">
                                <button id="editCard" data-toggle="modal" data-target="#updateModal" wire:click="setCardTrelloBug({{$task}})" class="bg-white text-gray-800 font-bold rounded border-b-2 border-red-500 hover:border-red-600 hover:bg-red-500  hover:text-white shadow-md py-2 px-6 inline-flex items-center">
                                    <span class="mr-1">Bug</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex flex-wrap -mx-2 mb-4">
                        <div class="w-full sm:1/3 md:w-1/3 lg:w-1/3 px-2 mb-4">
                            <div class="h-12 text-sm text-grey-dark px-1 mb-1 flex items-center justify-center shadow-sm rounded-md bg-white">
                                <button id="editShow" data-toggle="modal" data-target="#updateModal" wire:click="edit({{$task}})" class="bg-white text-gray-800 font-bold rounded border-b-2 border-blue-500 hover:border-blue-600 hover:bg-blue-500  hover:text-white shadow-md py-2 px-6 inline-flex items-center">
                                    <span class="mr-1">Skip</span>
                                </button>
                            </div>
                        </div>
                        <div class="w-full sm:1/3 md:w-1/3 lg:w-1/3 px-2 mb-4">
                            <div class="h-12 text-sm text-grey-dark px-1 mb-1 flex items-center justify-center shadow-sm rounded-md bg-white">
                                <button id="editCard" data-toggle="modal" data-target="#updateModal" wire:click="setCardTrello({{$task}})" class="bg-white text-gray-800 font-bold rounded border-b-2 border-pink-500 hover:border-pink-600 hover:bg-pink-500  hover:text-white shadow-md py-2 px-6 inline-flex items-center">
                                    <span class="mr-1">Card</span>
                                </button>
                            </div>
                        </div>
                        <div class="w-full sm:1/3 md:w-1/3 lg:w-1/3 px-2 mb-4">
                            <div class="h-12 text-sm text-grey-dark px-1 mb-1 flex items-center justify-center shadow-sm rounded-md bg-white">
                                <button id="editCard" data-toggle="modal" data-target="#updateModal" wire:click="setCardTrelloBug({{$task}})" class="bg-white text-gray-800 font-bold rounded border-b-2 border-red-500 hover:border-red-600 hover:bg-red-500  hover:text-white shadow-md py-2 px-6 inline-flex items-center">
                                    <span class="mr-1">Bug</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="flex flex-wrap -mx-2 mb-8">
                    <div class="w-full sm:1/3 md:w-1/3 lg:w-2/6 px-2 mb-4">
                        <div class="h-12 text-sm text-grey-dark px-1 mb-1 flex items-center justify-center shadow-sm rounded-md bg-white">
                            <h4 class="md:text-lg lg:text-2xl font-semibold text-gray-700">ID:</h4>
                            <h4 id="idTask" class="md:text-lg lg:text-2xl font-semibold text-gray-700">{{$task->id}}</h4>
                        </div>
                    </div>
                    <div class="w-full sm:1/3 md:w-1/3 lg:w-2/6 px-2 mb-4">
                        <div class=" h-12 text-sm text-grey-dark px-1 mb-1 flex items-center justify-center shadow-sm rounded-md bg-white">
                            <h4 id="idServer" class="md:text-lg lg:text-2xl font-semibold text-gray-700">ID Server:{{$task->id_server}}</h4>
                        </div>
                    </div>
                    <div class="w-full sm:1/3 md:w-1/3 lg:w-2/6 px-2 mb-4">
                        <div class=" h-12 text-sm text-grey-dark px-1 mb-1 flex items-center justify-center shadow-sm rounded-md bg-white">
                            <h4 id="idServer" class="md:text-lg lg:text-2xl font-semibold text-gray-700">IP Server:{{$task->ip_server}}</h4>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 lg:w-2/4 px-2 mb-4">
                        <div class=" h-12 text-sm text-grey-dark px-1 mb-1 flex items-center justify-center shadow-sm rounded-md bg-white">
                            <h4 id="idInstance" class="md:text-lg lg:text-2xl font-semibold text-gray-700">Instance:{{$task->instance}}</h4>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 lg:w-2/4 px-2 mb-4">
                        <div class=" h-12 text-sm text-grey-dark px-1 mb-1 flex items-center justify-center shadow-sm rounded-md bg-white">
                            <h4 id="idJob" class="md:text-lg lg:text-2xl font-semibold text-gray-700">Job:{{$task->job}}</h4>
                        </div>
                    </div>
                    @if($task->process_status=='new')
                        <div class="w-full md:w-1/2 lg:w-2/4 px-2 mb-4">
                            <div class=" h-12 text-sm text-grey-dark px-2 mb-2 flex items-center justify-center shadow-sm rounded-md bg-white">
                                <h4 class="md:text-lg lg:text-2xl font-semibold text-gray-700">status: &nbsp</h4>
                                <h4 id="processStatus" class="md:text-lg lg:text-2xl font-semibold text-gray-700 bg-blue-200 rounded-lg" > &nbsp{{ $task->process_status }}&nbsp</h4>
                            </div>
                        </div>
                    @elseif($task->process_status=='processing')
                        <div class="w-full md:w-1/2 lg:w-2/4 px-2 mb-4">
                            <div class=" h-12 text-sm text-grey-dark px-2 mb-2 flex items-center justify-center shadow-sm rounded-md bg-white">
                                <h4 class="md:text-lg lg:text-2xl font-semibold text-gray-700">status: &nbsp</h4>
                                <h4 id="processStatus" class="md:text-lg lg:text-2xl font-semibold text-gray-700 bg-orange-200 rounded-lg" > &nbsp{{ $task->process_status }}&nbsp</h4>
                            </div>
                        </div>
                    @elseif($task->process_status=='error')
                        <div class="w-full md:w-1/2 lg:w-2/4 px-2 mb-4">
                            <div class=" h-12 text-sm text-grey-dark px-2 mb-2 flex items-center justify-center shadow-sm rounded-md bg-white">
                                <h4 class="md:text-lg lg:text-2xl font-semibold text-gray-700">status: &nbsp</h4>
                                <h4 id="processStatus" class="md:text-lg lg:text-2xl font-semibold text-gray-700 bg-red-200 rounded-lg" > &nbsp{{ $task->process_status }}&nbsp</h4>
                            </div>
                        </div>
                    @elseif($task->process_status=='done')
                        <div class="w-full md:w-1/2 lg:w-2/4 px-2 mb-4">
                            <div class=" h-12 text-sm text-grey-dark px-2 mb-2 flex items-center justify-center shadow-sm rounded-md bg-white">
                                <h4 class="md:text-lg lg:text-2xl font-semibold text-gray-700">status: &nbsp</h4>
                                <h4 id="processStatus" class="md:text-lg lg:text-2xl font-semibold text-gray-700 bg-green-200 rounded-lg" > &nbsp{{ $task->process_status }}&nbsp</h4>
                            </div>
                        </div>
                    @elseif($task->process_status=='duplicate')
                        <div class="w-full md:w-1/2 lg:w-2/4 px-2 mb-4">
                            <div class=" h-12 text-sm text-grey-dark px-2 mb-2 flex items-center justify-center shadow-sm rounded-md bg-white">
                                <h4 class="md:text-lg lg:text-2xl font-semibold text-gray-700">status: &nbsp</h4>
                                <h4 id="processStatus" class="md:text-lg lg:text-2xl font-semibold text-gray-700 bg-yellow-200 rounded-lg" > &nbsp{{ $task->process_status }}&nbsp</h4>
                            </div>
                        </div>
                    @elseif($task->process_status=='skip')
                        <div class="w-full md:w-1/2 lg:w-2/4 px-2 mb-4">
                            <div class=" h-12 text-sm text-grey-dark px-2 mb-2 flex items-center justify-center shadow-sm rounded-md bg-white">
                                <h4 class="md:text-lg lg:text-2xl font-semibold text-gray-700">status: &nbsp</h4>
                                <h4 id="processStatus" class="md:text-lg lg:text-2xl font-semibold text-gray-700 bg-indigo-200 rounded-lg" > &nbsp{{ $task->process_status }}&nbsp</h4>
                            </div>
                        </div>
                    @endif
                    <div class="w-full md:w-1/2 lg:w-2/4 px-2 mb-4">
                        <div class=" h-12 text-sm text-grey-dark px-2 mb-2 flex items-center justify-center shadow-sm rounded-md bg-white">
                            <h4 id="idParameters" class="md:text-lg lg:text-2xl font-semibold text-gray-700">parameters:  {{$task->parameters}}</h4>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 lg:w-2/4 px-2 mb-4">
                        <div class=" h-12 text-sm text-grey-dark px-2 mb-2 flex items-center justify-center shadow-sm rounded-md bg-white">
                            <h4 class="md:text-lg lg:text-2xl font-semibold text-gray-700">create:  {{$task->created_at}}</h4>
                        </div>
                    </div>
                    <div class="w-full md:w-1/2 lg:w-2/4 px-2 mb-4">
                        <div class=" h-12 text-sm text-grey-dark px-2 mb-2 flex items-center justify-center shadow-sm rounded-md bg-white">
                            <h4 class="md:text-lg lg:text-2xl font-semibold text-gray-700">worked:  {{$task->updated_at}}</h4>
                        </div>
                    </div>
                    <div class="w-full md:w-2/2 lg:w-4/4 px-2 mb-4">
                        <div class="h-12 text-sm text-grey-dark px-2 mb-2 flex items-center justify-center shadow-sm rounded-md bg-white">
                            <h4 class="md:text-md lg:text-lg font-semibold text-gray-700">process log:  {{$task->process_log}}</h4>
                        </div>
                    </div>
                    <div class="w-full md:w-2/2 lg:w-4/4 px-2 mb-4">
                        <div class="h-12 text-sm text-grey-dark px-2 mb-2 flex items-center justify-center shadow-sm rounded-md bg-white">
                            <h4 class="md:text-md lg:text-lg font-semibold text-gray-700">error log:  {{$task->error_log}}</h4>
                        </div>
                    </div>
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
