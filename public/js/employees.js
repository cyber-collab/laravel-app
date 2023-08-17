
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
        ]
    });
});
