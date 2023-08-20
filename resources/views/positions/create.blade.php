<div class="modal fade" id="positionFormModal" tabindex="-1" aria-labelledby="PositionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="position_form" class="form-horizontal" data-url="{{ route('positions.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="PositionModalLabel">Add New Position</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span id="position_form_result"></span>
                    <div class="form-group">
                        <label>Position Name:</label>
                        <input type="text" name="name" id="position_name" class="form-control" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="position_action_button" id="position_action_button" value="Add" class="btn btn-info" />
                </div>
            </form>
        </div>
    </div>
</div>
