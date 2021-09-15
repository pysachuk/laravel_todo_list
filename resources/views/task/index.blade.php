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
    <script>
        function getTasks(page = 1)
        {
            $.ajax({
                url: "/getTasks?page="+page,
                type: "GET",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: (data) => {
                    $('.tasks').html(data);
                }
            });
        }
        $(document).ready(function (){
            getTasks();
            $('.addTaskButton').on('click', function (){
                var task = $('#inputTask').val();
                new swal({
                    text: "Добавить задачу?",
                    type: 'warning',
                    showCancelButton: true,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Да',
                    cancelButtonText: 'Нет'
                }).then((result) => {
                    if (result.value)
                    {
                        new swal({
                            title: 'Пожалуйста подождите..!',
                            text: 'Добавление задачи...',
                            allowOutsideClick: false,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            showConfirmButton: false,
                            onOpen: () => {
                                swal.showLoading()
                            }
                        })
                        $.ajax({
                            url: "{{ route('task.store') }}",
                            type: "POST",
                            data: {
                                task: task,
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: (data) => {
                                if(data['OK'])
                                {
                                    $('#inputTask').val('');
                                    swal.hideLoading()
                                    new swal(
                                        'Успех!',
                                        'Задача успешно добавлена.',
                                        'success'
                                    )
                                }
                            },
                            error: (data) => {
                                swal.hideLoading()
                                new swal(
                                    'Ошибка',
                                    data.responseJSON.message,
                                    'error'
                                )
                            }
                        });
                    }
                });
            })
        })
    </script>
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
        // Initiate the Pusher JS library
        var pusher = new Pusher('da00bb7b7e66cc556c6c', {
            cluster: 'eu',
            encrypted: true
        });
        // Subscribe to the channel we specified in our Laravel Event
        var channelAdded = pusher.subscribe('task-added');

        // Bind a function to a Event (the full Laravel class)
        channelAdded.bind('App\\Events\\TaskAdded', function(data) {
            if(data.message)
            {
                Toast.fire({
                    icon: 'success',
                    title: data.message
                })
                var page = $('.active span').text();
                getTasks(page);
            }
            // this is called when the event notification is received...
        });
        var channelCompleted = pusher.subscribe('task-completed');
        channelCompleted.bind('App\\Events\\TaskCompleted', function(data) {
            if(data.message)
            {
                Toast.fire({
                    icon: 'success',
                    title: data.message
                })
                var page = $('.active span').text();
                getTasks(page);
            }
            // this is called when the event notification is received...
        });
        var channelDeleted = pusher.subscribe('task-deleted');
        channelDeleted.bind('App\\Events\\TaskDeleted', function(data) {
            if(data.message)
            {
                Toast.fire({
                    icon: 'info',
                    title: data.message
                })
                var page = $('.active span').text();
                getTasks(page);
            }
            // this is called when the event notification is received...
        });

    </script>
@endsection
