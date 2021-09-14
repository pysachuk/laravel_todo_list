@extends('task.layouts.app')
@section('title', 'Task List')
@section('content')
    <div class="container">
        <div class="row">
            @include('task.flash-message')
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Создание задачи:</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('task.store') }}" method="POST">
                            @csrf
                            <label for="inputTask" class="form-label">Задача</label>
                            <input type="text" id="inputTask" class="form-control" name="task">
                            <button type="submit" style="margin-top: 20px" class="btn btn-primary">Добавить</button>
                        </form>
                    </div>
                </div>
                <div class="card" style="margin-top: 20px">
                    <div class="card-header">
                        <h4>Список задач:</h4>
                    </div>
                    <div class="card-body">
                        @foreach($tasks as $task)
                            <div class="card">
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
                    </div>
                    <div class="card-footer">
                        {{ $tasks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
