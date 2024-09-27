<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>ยินดีต้อนรับ!</h1>
    @if(session('token'))
        <p>คุณล็อกอินสำเร็จ!</p>
        <p>Token: {{ session('token') }}</p>
    @else
        <p>กรุณาล็อกอินเพื่อเข้าถึงข้อมูลนี้</p>
    @endif
</body>
</html>
