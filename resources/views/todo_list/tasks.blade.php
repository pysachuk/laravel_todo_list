@foreach($tasks as $task)
    <div class="card task">
        <div class="card-body">
            <p>@if($task -> is_done != 0) <s>{{ $task -> task }}</s> @else {{ $task -> task }} @endif</p>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-md-2">
                    @if($task -> is_done != 0)
                            <button type="button" data-id="{{ $task -> id }}" class="btn btn-danger deleteTask">Удалить</button>
                    @else
                        <a href="{{ route('task.complete', $task -> id) }}" data-id="{{ $task -> id }}" class="btn btn-success completeTask">Сделано</a>
                    @endif
                </div>
                <div class="col-md-10 text-center">
                    <p>Создатель: <b>{{ $task -> user -> name }}</b> | Дата создания: {{ \Carbon\Carbon::parse($task -> created_at)->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
@endforeach
<br>
{{ $tasks->links() }}
<script src="{{ asset('js/tasks.js') }}"></script>

