<ul class="list-group position-list">
    @foreach ($positions as $position)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <span class="position-name">{{ $position->name }}</span>
            <div class="btn-group">
                <button class="btn btn-xs btn-info edit_position_button" data-position-id="{{ $position->id }}"><i class="fas fa-edit"></i> Edit</button>
                <button class="btn btn-xs btn-danger delete_position_button" data-position-id="{{ $position->id }}"><i class="fas fa-trash"></i> Delete</button>
            </div>
        </li>
    @endforeach
</ul>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $(document).on('click', '.edit_position_button', function(event) {
            event.preventDefault();
            var positionId = $(this).attr('data-position-id');
            $('#editPositionForm')[0].reset();
            $.ajax({
                url: '/positions/' + positionId + '/edit',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('#editPositionId').val(data.position.id);
                    $('#editPositionName').val(data.position.name);
                    $('#editPositionModal').modal('show');
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $('#updatePositionButton').on('click', function() {
            var positionId = $('#editPositionId').val();
            var positionName = $('#editPositionName').val();

            $.ajax({
                url: '/positions/' + positionId,
                type: 'PUT',
                data: {
                    name: positionName,
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                dataType: 'json',
                success: function(data) {
                    $('#editPositionModal').modal('hide');
                    var positionListItem = $('.edit_position_button[data-position-id="' + positionId + '"]').closest('.list-group-item');
                    positionListItem.find('.position-name').text(positionName);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $(document).on('click', '.delete_position_button', function(event) {
            event.preventDefault();
            let positionId = $(this).data('position-id');
            $('#deletePositionId').val(positionId);
            $('#deletePositionModal').modal('show');
        });

        $('#confirmDeletePositionForm').on('submit', function(event) {
            event.preventDefault();
            let positionId = $('#deletePositionId').val();
            let originalButtonText = $('#confirmDeletePositionButton').text();
            console.debug(positionId);
            $.ajax({
                url: '/positions/' + positionId,
                type: 'POST',
                data: {
                    _method: 'DELETE',
                    _token: $('meta[name="csrf-token"]').attr('content'),
                },
                beforeSend:function(){
                    $('#confirmDeletePositionButton').text('Deleting...');
                },
                dataType: 'json',
                success: function(data) {
                    $('#confirmDeletePositionButton').text(originalButtonText);
                    if (data.error) {
                        $('#errorModal .modal-body').text(data.error);
                        $('#deletePositionModal').modal('hide');
                        $('#errorModal').modal('show');
                    } else {
                        setTimeout(function(){
                            $('#confirmModal').modal('hide');
                            updatePositionList();
                            alert('Data Deleted');
                        }, 2000);
                        $('#confirmDeletePositionButton').text(originalButtonText);
                        $('#deletePositionModal').modal('hide');
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        $('#create_position_record').click(function(){
            $('.modal-title').text('Add New Position');
            $('#position_action_button').val('Add');
            $('#position_form_result').html('');

            $('#positionFormModal').modal('show');
        });

        $('#position_form').on('submit', function(event){
            event.preventDefault();
            let action_url = $(this).data('url');

            $.ajax({
                type: 'post',
                url: action_url,
                data: $(this).serialize(),
                dataType: 'json',
                success: function(data) {
                    let html = '';
                    if (data.success) {
                        html = '<div class="alert alert-success">' + data.success + '</div>';
                        $('#position_form')[0].reset();
                        updatePositionList();
                    }
                    $('#position_form_result').html(html);
                },
                error: function(data) {
                    let errors = data.responseJSON;
                    console.log(errors);
                }
            });
        });

        function updatePositionList() {
            $.ajax({
                url: '{{ route('positions.index') }}',
                type: 'GET',
                dataType: 'html',
                success: function(data) {
                    $('.position-list').html(data);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    });
</script>
