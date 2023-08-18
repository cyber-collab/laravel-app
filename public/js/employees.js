$(document).ready(function() {
    let table = $('.employees-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('employees.index') }}",
        columns: [
            { data: 'name', name: 'name',
                render: function (data, type, row ) {
                    if (type === 'display') {
                        data = '<a href="/employees/show/' + row.id + '">' + data + '</a>';
                    }
                    return data;
                }
            },
            {data: 'position', name: 'position'},
            {data: 'hire_date', name: 'hire_date'},
            {data: 'phone_number', name: 'phone_number'},
            {data: 'email', name: 'email'},
            {data: 'salary', name: 'salary'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $('#create_record').click(function(){
        $('.modal-title').text('Add New Employee');
        $('#action_button').val('Add');
        $('#action').val('Add');
        $('#form_result').html('');

        $('#formModal').modal('show');
    });

    $('#sample_form').on('submit', function(event){
        event.preventDefault();
        let action_url = '';

        if($('#action').val() == 'Add')
        {
            action_url = "{{ route('employees.store') }}";
        }

        if($('#action').val() == 'Edit')
        {
            action_url = "{{ route('employees.update') }}";
        }

        $.ajax({
            type: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: action_url,
            data:$(this).serialize(),
            dataType: 'json',
            success: function(data) {
                let html = '';
                if(data.errors)
                {
                    html = '<div class="alert alert-danger">';
                    for(let count = 0; count < data.errors.length; count++)
                    {
                        html += '<p>' + data.errors[count] + '</p>';
                    }
                    html += '</div>';
                }
                if(data.success)
                {
                    html = '<div class="alert alert-success">' + data.success + '</div>';
                    $('#sample_form')[0].reset();
                    $('#employees-table').DataTable().ajax.reload();
                }
                $('#form_result').html(html);
            },
            error: function(data) {
                let errors = data.responseJSON;
                console.log(errors);
            }
        });
    });

    $(document).on('click', '.edit', function(event){
        event.preventDefault();
        let id = $(this).attr('id'); alert(id);
        $('#form_result').html('');

        $.ajax({
            url :"/employees/edit/" + id + "/",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dataType:"json",
            success:function(data)
            {
                console.log('success: '+data);
                $('#name').val(data.result.name);
                $('#email').val(data.result.email);
                $('#hidden_id').val(id);
                $('.modal-title').text('Edit Record');
                $('#action_button').val('Update');
                $('#action').val('Edit');
                $('.editpass').hide();
                $('#formModal').modal('show');
            },
            error: function(data) {
                let errors = data.responseJSON;
                console.log(errors);
            }
        })
    });

    let employee_id;

    $(document).on('click', '.delete', function(){
        employee_id = $(this).attr('id');
        $('#confirmModal').modal('show');
    });

    $('#ok_button').click(function(){
        $.ajax({
            url:"employees/destroy/" + employee_id,
            beforeSend:function(){
                $('#ok_button').text('Deleting...');
            },
            success:function(data)
            {
                setTimeout(function(){
                    $('#confirmModal').modal('hide');
                    $('#employees-table').DataTable().ajax.reload();
                    alert('Data Deleted');
                }, 2000);
            }
        })
    });
});
