<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Welcome, {{ $employee->name }}</title>
</head>
<body>
    <h1>Hello <strong>{{ $employee->name }} {{ $employee->surname }}</strong>,</h1>
    <p>
        Welcome to <strong>{{ $employee?->company?->name ?? $defaultCompanyName }}</strong>!  
        We’re glad to have you on board <strong>{{ $employee->name }} {{ $employee->surname }}</strong>!
    </p>

    <p>
        Your registered email: {{ $employee->email }} <br>
        Phone number: {{ $employee->phone }}
    </p>
</body>
</html>