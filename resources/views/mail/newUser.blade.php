<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Hello, {{ $name }}!</h1>
    <p>Your account has been created successfully. Here are your login details:</p>
    <p><strong>Email:</strong> {{ $email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>
    <p>Please keep this information secure and do not share it with anyone.</p>
    <p>Thank you!</p>
</body>

</html>
