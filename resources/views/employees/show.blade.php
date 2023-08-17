<!DOCTYPE html>
<html>
<head>
    <title>{{ $employee->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Employee Details</h1>
    <hr>
    <div class="row">
        <div class="col-md-6">
            <h2>{{ $employee->name }}</h2>
            <p><strong>Position:</strong> {{ $employee->position }}</p>
            <p><strong>Date of Employment:</strong> {{ $employee->hire_date }}</p>
            <p><strong>Phone:</strong> {{ $employee->phone_number }}</p>
            <p><strong>Email:</strong> {{ $employee->email }}</p>
            <p><strong>Salary:</strong> {{ $employee->salary }}</p>
        </div>
    </div>
    <a href="{{ route('employees.index') }}" class="btn btn-primary">Back to List</a>
</div>
</body>
</html>
