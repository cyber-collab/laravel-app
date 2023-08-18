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
        let action_url = '';
        let method = '';

        if ($('#action').val() === 'Add') {
            action_url = "/employees";
            method = "POST";
        }

        if ($('#action').val() === 'Edit') {
            action_url = "/employees/" + $('#hidden_id').val();
            method = "PUT";
        }

        $.ajax({
            type: method,
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

            if (confirm('Are you sure you want to delete this employee?')) {
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
    });

    $(document).on('click', '.edit', function(event){
        event.preventDefault();
        let editButton = $(this);
        let id = editButton.data('id');

        $('#form_result').html('');

        $.ajax({
            url: "employees/" + id + "/edit",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType: "json",
            success: function(data) {
                console.log('success: ' + data);
                $('#name').val(data.result.name);
                $('#email').val(data.result.email);
                $('#hidden_id').val(id);
                $('.modal-title').text('Edit Record');
                $('#action_button').val('Update');
                $('#action').val('Edit');
                $('.editpass').hide();
                $('#formModal').modal('show');
                table.draw();
            },

            error: function(data) {
                let errors = data.responseJSON;
                console.log(errors);
            }
        });
    });
});
