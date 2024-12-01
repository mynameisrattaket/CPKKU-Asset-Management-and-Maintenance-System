<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333333;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .details {
            margin-bottom: 20px;
        }
        .details p {
            margin: 5px 0;
        }
        .details span {
            font-weight: bold;
            display: inline-block;
            width: 200px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888888;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>แจ้งเตือนการอัปเดตสถานะการซ่อม</h1>
        <div class="details">
            <p><span>ชื่อผู้แจ้ง:</span> {{ $emailData['reporter_name'] }}</p>
            <p><span>สถานะการซ่อม:</span> {{ $emailData['repair_status_id'] }}</p>
            <p><span>หมายเหตุ:</span> {{ $emailData['request_repair_note'] ?? 'ไม่มีหมายเหตุเพิ่มเติม' }}</p>
            <p><span>วันที่อัปเดต:</span> {{ $emailData['update_status_at'] }}</p>
            <p><span>ช่างที่รับผิดชอบ:</span> {{ $emailData['technician_name'] }}</p>
        </div>
        <p class="footer">โปรดติดต่อทีมสนับสนุนหากคุณมีคำถามเพิ่มเติม</p>
    </div>
</body>
</html>
