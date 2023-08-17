
let csrfToken = $('meta[name="csrf-token"]').attr('content');
$(function () {
    let table = $('#employees-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: $('#employees-table').data('url'),
        columns: [
            { data: 'name', name: 'name' },
            { data: 'position', name: 'position' },
            { data: 'hire_date', name: 'hire_date' },
            { data: 'phone_number', name: 'phone_number' },
            { data: 'email', name: 'email' },
            { data: 'salary', name: 'salary' },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    $('#employees-table').on('click', '.delete', function () {
        let employeeId = $(this).data('id');

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
    });
});
