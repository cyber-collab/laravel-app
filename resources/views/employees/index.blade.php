<!DOCTYPE html>
<html>
<head>
    <title>Laravel 10 Implementing Yajra Datatables</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
</head>
<body>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Список співробітників</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered" id="employees-table">
            <thead>
            <tr>
                <th>ПІБ</th>
                <th>Посада</th>
                <th>Дата прийому на роботу</th>
                <th>Номер телефону</th>
                <th>Електронна пошта</th>
                <th>Розмір заробітної плати</th>
                <th>Дії</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
    <script>
        $(function () {
            var table = $('#employees-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('employees.index') }}",
                columns: [
                    {
                        data: 'first_name',
                        name: 'first_name',
                        render: function (data, type, row) {
                            return row.last_name + ' ' + row.surname + ' ' + row.first_name;
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
        });
    </script>
@endpush

@stack('scripts')
</body>
</html>
