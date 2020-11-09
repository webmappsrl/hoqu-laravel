 {{-- <div class="flex flex-col items-center relative">
    <input type="text"
class="form-input w-full h-16 px-3 my-2 rounded-lg text-xl px-8 shadow-lg"
placeholder="Search ID Task"
wire:model='query'
>


<table class="absolute shadow bg-white top-100 z-40 w-full lef-0 rounded max-h-select overflow-y-auto svelte-5uyqqj">
    <div class="flex flex-col w-full">
        <div class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-teal-100">

    @foreach ($tasks as $task)
    <tr>
        <td>
            <a href="/{{$task['id']}}/show"> {{ $task['id'] }}</a>
        </td>
    </tr>

    @endforeach
        </div>
    </div>
</table>



</div>


 --}}

 <div>
    <div class="mb-8">
        <label class="inline-block w-32 font-bold">Filter:</label>
        <select name="instance" class="border shadow p-2 bg-white" wire:model='instance'
        >
            <option value=''>Choose a Instance</option>
            @foreach($instances as $instance)
                <option value={{ $instance->id }}>{{ $instance->instance }}</option>
            @endforeach
        </select >
        <select name="job" class="border shadow p-2 bg-white" wire:model='job'
        >
            <option value=''>Choose a job</option>
            @foreach($jobs as $job)
                <option value={{ $job->id }}>{{ $job->job }}</option>
            @endforeach
        </select >
        <table class="absolute shadow bg-white top-100 z-40 w-full lef-0 rounded max-h-select overflow-y-auto svelte-5uyqqj">
            <div class="flex flex-col w-full">
                <div class="cursor-pointer w-full border-gray-100 rounded-t border-b hover:bg-teal-100">

            @foreach ($tasks as $task)
            <tr>
                <td>
                    <a href="/{{$task['id']}}/show"> {{ $task['id'] }}</a>
                </td>
                <td>
                    <a href="/{{$task['id']}}/show"> {{ $task['instance'] }}</a>
                </td>
                <td>
                    <a href="/{{$task['id']}}/show"> {{ $task['job'] }}</a>
                </td>
            </tr>

            @endforeach
                </div>
            </div>
        </table>
    {{-- </div>
    @if(count($cities) > 0)
        <div class="mb-8">
            <label class="inline-block w-32 font-bold">City:</label>
            <select name="city" wire:model="city"
                class="p-2 px-4 py-2 pr-8 leading-tight bg-white border border-gray-400 rounded shadow appearance-none hover:border-gray-500 focus:outline-none focus:shadow-outline">
                <option value=''>Choose a city</option>
                @foreach($cities as $city)
                    <option value={{ $city->id }}>{{ $city->name }}</option>
                @endforeach
            </select>
        </div>
    @endif
</div> --}}
