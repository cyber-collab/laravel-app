<!DOCTYPE html>
<html lang="en">
<head>
    <title>Laravel Datatables Yajra Server Side</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" />
    <link href="{{ asset('css/employee.css') }}" rel="stylesheet">
</head>
<body>
<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">List of employees</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered employees-table" id="employees-table" data-url="{{ route('employees.index') }}">
                <thead>
                <tr>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Date of employment</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>The amount of wages</th>
                    <th>Current manager</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    @include('employees.modal');
    @include('employees.confirm_modal');
    @include('positions.create');
    @include('positions.edit_position');
    @include('positions.delete_position');
</div>
</body>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        let table = $('.employees-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('employees.index') }}",
            columns: [
                {data: 'photo', name: 'photo',
                    render: function(data) {
                        return "<img src='/images/" + data + "' height='50' class='employee-photo-list' />";
                    }
                },
                {data: 'name', name: 'name',
                    render: function (data, type, row ) {
                        if (type === 'display') {
                            data = '<a href="/employees/show/' + row.id + '">' + data + '</a>';
                        }
                        return data;
                    }
                },
                {data: 'position.name', name: 'position.name'},
                {data: 'hire_date', name: 'hire_date'},
                {data: 'phone_number', name: 'phone_number'},
                {data: 'email', name: 'email'},
                {data: 'salary', name: 'salary'},
                {data: 'manager_name', name: 'manager_name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });

        $('#create_record').click(function(){
            $('#name').val('');
            $('#email').val('');
            $('#hire_date').val('');
            $('#salary').val('');
            $('#phone_number').val('');
            $('#photo-preview').attr('src', '');

            $('.modal-title').text('Add New Employee');
            $('#action_button').val('Add');
            $('#action').val('Add');
            $('#form_result').html('');

            let storedData;

            $.ajax({
                url: "{{ route('positions.index') }}",
                dataType: "json",
                success: function(data) {
                    storedData = data;
                    const positionSelect = $('#position');
                    positionSelect.empty();
                    $.each(data, function(index, position) {
                        positionSelect.append(new Option(position.name, position.id));
                    });

                    $('#position').on('change', function() {
                        const selectedPositionId = $(this).val();
                        const selectedPosition = storedData.find(position => position.id == selectedPositionId);
                        if (selectedPosition) {
                            console.log("Selected Position:", selectedPosition.name);
                        }
                    });
                    $('#formModal').modal('show');
                },
                error: function(data) {
                    let errors = data.responseJSON;
                    console.log(errors);
                }
            });
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
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'post',
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
                dataType:"json",
                success:function(data)
                {
                    const positionSelect = $('#position');
                    positionSelect.empty();
                    $.each(data.positions, function(index, position) {
                        positionSelect.append(new Option(position.name, position.id));
                    });
                    positionSelect.val(data.current_position).change();

                    console.log('success: '+data);
                    $('#name').val(data.result.name);
                    $('#email').val(data.result.email);
                    $('#position').val(data.result.position_id);
                    $('#hire_date').val(data.result.hire_date);
                    $('#salary').val(data.result.salary);
                    $('#phone_number').val(data.result.phone_number);
                    if (data.result.photo) {
                        $('#photo-preview').attr('src', '{{ asset('images') }}/' + data.result.photo + '?rand=' + Math.random());
                    } else {
                        $('#photo-preview').attr('src', '');
                    }
                    $("#employee_id").val(data.result.id);
                    $("#employee_photo").val(data.result.photo);
                    $('#hidden_id').val(id);
                    $('.modal-title').text('Edit Record');
                    $('#action_button').val('Update');
                    $('#action').val('Edit');
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
</script>
</html>
