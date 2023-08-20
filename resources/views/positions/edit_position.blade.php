<div class="modal fade" id="editPositionModal" tabindex="-1" aria-labelledby="editPositionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPositionModalLabel">Edit Position</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="editPositionForm" class="form-horizontal" data-url="{{ route('positions.store') }}">
                    @csrf
                    <div class="modal-body">
                        <span id="position_form_result"></span>
                        <input type="hidden" name="id" id="editPositionId" value="" />
                        <div class="form-group">
                            <label>Position Name:</label>
                            <input type="text" name="name" id="editPositionName" class="form-control" />
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="updatePositionButton">Update</button>
            </div>
        </div>
    </div>
</div>
