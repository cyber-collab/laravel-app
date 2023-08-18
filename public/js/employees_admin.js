
let csrfToken = $('meta[name="csrf-token"]').attr('content');
$(function () {
    let table = $('#employees-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: $('#employees-table').data('url'),
        columns: [
            { data: 'name', name: 'name',
                render: function (data, type, row ) {
                    if (type === 'display') {
                        data = '<a href="/employees/' + row.id + '">' + data + '</a>';
                    }
                    return data;
                }
            },
            { data: 'position', name: 'position' },
            { data: 'hire_date', name: 'hire_date' },
            { data: 'phone_number', name: 'phone_number' },
            { data: 'email', name: 'email' },
            { data: 'salary', name: 'salary' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    $('#create_record').click(function () {
        $('.modal-title').text('Add New Employee');
        $('#action_button').val('Add');
        $('#action').val('Add');
        $('#form_result').html('');
        $('#name').val('');
        $('#position').val('');

        $('#formModal').modal('show');
    });

    $('#sample_form').on('submit', function (event) {
        event.preventDefault();
        let action_url = $('#sample_form').data('url');
        $.ajax({
            type: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: action_url,
            data: $(this).serialize(),
            dataType: 'json',
            success: function (data) {
                var html = '';
                if (data.errors) {
                    html = '<div class="alert alert-danger">';
                    for (var count = 0; count < data.errors.length; count++) {
                        html += '<p>' + data.errors[count] + '</p>';
                    }
                    html += '</div>';
                }
                if (data.success) {
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    $('#sample_form')[0].reset();
                    $('#employees-table').DataTable().ajax.reload();
                    $('#formModal').modal('hide');
                }
                $('#form_result').html(html);
            },
            error: function (data) {
                var errors = data.responseJSON;
                console.log(errors);
            }
        });
    });


    $('#employees-table').on('click', '.delete', function () {
        let employeeId = $(this).data('id');
        if (adminlte) {
            if (confirm('Ви впевнені, що хочете видалити цього співробітника?')) {
                $.ajax({
                    url: '/employees/' + employeeId,
                    type: 'DELETE',
                    data: {
                        "_token": csrfToken,
                    },
                    success: function (data) {
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        }
    });

    $('#employees-table').on('click', '.edit', function () {
        let employeeId = $(this).data('id');

        $.ajax({
            url: '/employees/' + employeeId + '/edit',
            type: 'GET',
            success: function (data) {
                $('#editEmployeeModal .modal-content').html(data);
                $('#editEmployeeModal').modal('show');
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

});
