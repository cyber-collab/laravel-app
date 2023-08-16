<form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-group">
        <label for="name">ПІБ</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="position">Посада</label>
        <input type="text" id="position" name="position" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="hire_date">Дата прийому на роботу</label>
        <input type="date" id="hire_date" name="hire_date" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="phone_number">Номер телефону</label>
        <input type="tel" id="phone_number" name="phone_number" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="email">Електронна пошта</label>
        <input type="email" id="email" name="email" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="salary">Розмір заробітної плати</label>
        <input type="number" step="0.01" id="salary" name="salary" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="photo">Фотографія</label>
        <input type="file" id="photo" name="photo" class="form-control-file">
    </div>

    <button type="submit" class="btn btn-primary">Зберегти</button>
</form>
