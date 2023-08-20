<div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data" data-url="{{ route('employees.store') }}">
                @csrf
                <input type="hidden" name="employee_photo" id="employee_photo">
                <input type="hidden" name="employee_id" id="employee_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Add New Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span id="form_result"></span>
                    <div class="form-group">
                        <label>Name:</label>
                        <input type="text" name="name" id="name" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Position:</label>
                        <select name="position" id="position" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Date of Employment:</label>
                        <input type="date" name="hire_date" id="hire_date" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Phone:</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Email:</label>
                        <input type="email" name="email" id="email" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Salary:</label>
                        <input type="text" name="salary" id="salary" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Photo:</label>
                        <div class="photo-preview-container">
                            <img id="photo-preview" src="" width="100" class="img-fluid img-thumbnail" />
                        </div>
                        <input type="file" name="photo" id="photo" class="form-control" />
                    </div>
                    <input type="hidden" name="action" id="action" value="Add" />
                    <input type="hidden" name="hidden_id" id="hidden_id" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" name="action_button" id="action_button" value="Add" class="btn btn-info" />
                </div>
            </form>
        </div>
    </div>
</div>
