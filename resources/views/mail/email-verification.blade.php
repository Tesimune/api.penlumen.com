<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <h3>Dear {{$user->first_name}},</h3>
    <p>Welcome to Penlumen.</p>
    <p>T get started, click on the button below to verify your email</p>
    <a href="{{env("FRONTEND_URL")}}/auth/verify-email" style="padding: 10px; background:#000; color: aliceblue">
        Verify Email
    </a>
</body>
</html>
