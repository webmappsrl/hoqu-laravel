<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('HOQU Detail Task') }}
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg ">

                <div class="max-w-sm rounded overflow-hidden shadow-lg">
                    <div class="px-6 py-4">
                      <div class="font-bold text-xl mb-2">ID: {{$task->id}} </div>
                      <p class="text-gray-700 text-base">
                        Instance: {{$task->instance}}
                      </p>
                      <p class="text-gray-700 text-base">
                        Job: {{$task->job}}
                      </p>
                      <p class="text-gray-700 text-base">
                        Parameters: {{$task->parameters}}
                      </p>
                      <p class="text-gray-700 text-base">
                        Status: {{$task->process_status}}
                      </p>
                      <p class="text-gray-700 text-base">
                        Log: {{$task->process_log}}
                      </p>
                      <p class="text-gray-700 text-base">
                        Create: {{$task->created_at}}
                      </p>
                      <p class="text-gray-700 text-base">
                        Worked: {{$task->updated_at}}
                      </p>
                    </div>
                  </div>



            </div>
        </div>
    </div>
</x-app-layout>
