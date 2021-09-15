@foreach($tasks as $task)
    <div class="card task">
        <div class="card-body">
            <p>@if($task -> is_done != 0) <s>{{ $task -> task }}</s> @else {{ $task -> task }} @endif</p>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-2">
                    @if($task -> is_done != 0)
                        <form action="{{ route('task.delete', $task -> id) }}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-danger">Удалить</button>
                        </form>
                    @else
                        <a href="{{ route('task.complete', $task -> id) }}" class="btn btn-success">Сделано</a>
                    @endif
                </div>
                <div class="col-md-10 text-center">
                    <p>Создатель: <b>{{ $task -> user -> name }}</b> | Дата создания: {{ \Carbon\Carbon::parse($task -> created_at)->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
@endforeach
{{ $tasks->links() }}

<script>
    $('.page-link').on('click', function (event){
        event.preventDefault();
        var page = $(this).text()
        getTasks(page);
        })
</script>
