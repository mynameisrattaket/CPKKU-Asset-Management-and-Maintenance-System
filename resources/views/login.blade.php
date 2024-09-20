<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>เข้าสู่ระบบ</h1>
    <form action="{{ url('/login') }}" method="POST">
        @csrf <!-- ใส่ CSRF token สำหรับการรักษาความปลอดภัย -->
        <label for="email">อีเมล:</label>
        <input type="email" name="email" required>
        <br>
        <label for="password">รหัสผ่าน:</label>
        <input type="password" name="password" required>
        <br>
        <button type="submit">เข้าสู่ระบบ</button>
    </form>
</body>
</html>
