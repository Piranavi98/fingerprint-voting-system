<!DOCTYPE html>
<html>
<head>
    <title>Voting System Credentials</title>
</head>
<body>

<h2>Hello {{ $name }}</h2>

<p>Your voter account has been created successfully.</p>

<p><strong>Email:</strong> {{ $email }}</p>
<p><strong>Password:</strong> {{ $password }}</p>

<p>You can login using the following link:</p>

<a href="{{ url('/login') }}">Login to Voting System</a>

</body>
</html>