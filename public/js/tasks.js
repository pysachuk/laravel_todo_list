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
                url: "/task/complete",
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
                url: "/task/delete",
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
