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
                            <label for="inputTask" class="form-label">Задача</label>
                            <input type="text" id="inputTask" class="form-control" name="task">
                            <button type="button" style="margin-top: 20px" class="btn btn-primary addTaskButton">Добавить</button>
                    </div>
                </div>
                <div class="card" style="margin-top: 20px">
                    <div class="card-header">
                        <h4>Список задач:</h4>
                    </div>
                    <div class="card-body tasks">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script src="{{ asset('js/index.js') }}"></script>
@endsection
