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

<script>
    $('.page-link').on('click', function (event){
        event.preventDefault();
        var page = $(this).text()
        getTasks(page);
        })
    $('.completeTask').on('click', function (event){
        event.preventDefault();
        const task_id = $(this).attr('data-id');
        new swal({
            text: "Задача выполнена?",
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
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false,
                    onOpen: () => {
                        swal.showLoading()
                    }
                })
                $.ajax({
                    url: "{{ route('task.complete') }}",
                    type: "POST",
                    data: {
                        task_id: task_id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (data) => {
                        if(data['OK'])
                        {
                            swal.hideLoading()
                            new swal(
                                'Успех!',
                                'Задача успешно выполнена.',
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

    $('.deleteTask').on('click', function (event){
        event.preventDefault();
        const task_id = $(this).attr('data-id');
        new swal({
            text: "Удалить задачу?",
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
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false,
                    onOpen: () => {
                        swal.showLoading()
                    }
                })
                $.ajax({
                    url: "{{ route('task.delete') }}",
                    type: "DELETE",
                    data: {
                        task_id: task_id,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: (data) => {
                        if(data['OK'])
                        {
                            swal.hideLoading()
                            new swal(
                                'Успех!',
                                'Задача успешно удалена.',
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
</script>
