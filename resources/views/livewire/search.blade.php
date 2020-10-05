<input type="text"
class="form-input w-full h-16 px-3 my-2 rounded-lg text-xl px-8 shadow-lg"
placeholder="Search ID Task"
wire:model='query'

>
<table class="table table-bordered" style="margin: 10px 0 10px 0;">

    @foreach ($tasks as $task)
    <tr>
        <td>
            <a href="/{{$task['id']}}/show"> {{ $task['id'] }}</a>
        </td>
        <td>
            <a href="/{{$task['id'] }}/show"> {{ $task['job'] }}</a>
        </td>
    </tr>
    @endforeach
</table>
