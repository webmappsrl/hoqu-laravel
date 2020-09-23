<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('HOQU Status') }}
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-6">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg ">
                <table class="table-auto">
                    <thead>
                      <tr>
                        <th class="px-4 py-6">id</th>
                        <th class="px-4 py-6">instance</th>
                        <th class="px-4 py-6">job</th>
                        <th class="px-4 py-6">parameters</th>
                        <th class="px-4 py-6">process_status</th>
                        <th class="px-4 py-6">process_log</th>
                        <th class="px-4 py-6">create</th>
                        <th class="px-4 py-6">worked</th>

                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $index => $task)
                            @if ($index % 2)
                            <tr>
                            @else
                            <tr class="bg-gray-100">
                            @endif
                            <td class="border-0 px-4 py-6">{{ $task->id }}</td>
                            <td class="border-0 px-4 py-6">{{ $task->instance }}</td>
                            <td class="border-0 px-4 py-6">{{ $task->job}}</td>
                            <td class="border-0 px-4 py-6">{{ $task->parameters}}</td>
                            <td class="border-0 px-4 py-6">{{ $task->process_status}}</td>
                            <td class="border-0 px-4 py-6">{{ $task->process_log}}</td>
                            <td class="border-0 px-4 py-6">{{ $task->created_at}}</td>
                            <td class="border-0 px-4 py-6">{{ $task->updated_at}}</td>
                            </tr>

                        @endforeach

                    </tbody>
                  </table>
                  {{ $tasks->render()}}


            </div>
        </div>
    </div>
</x-app-layout>
