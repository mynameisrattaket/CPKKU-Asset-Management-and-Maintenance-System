<!DOCTYPE html>
<html lang="th">
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
            width: 200px; /* กำหนดความกว้างให้แน่นอน */
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
        <h1>รายละเอียดการแจ้งซ่อม</h1>

        <div class="details">
            <p><span>ชื่อหรือประเภทของอุปกรณ์:</span> {{ $repairDetails['asset_name'] ?? 'N/A' }}</p>
            <p><span>รายละเอียดอาการเสีย:</span> {{ $repairDetails['symptom_detail'] ?? 'N/A' }}</p>
            <p><span>สถานที่:</span> {{ $repairDetails['location'] ?? 'N/A' }}</p>
            <p><span>หมายเลขครุภัณฑ์:</span> {{ $repairDetails['asset_number'] ?? 'N/A' }}</p>
            <p><span>วันที่แจ้งซ่อม:</span> {{ $requestRepairAt }}</p>
        </div>

        <div class="details">
            <p><span>ผู้แจ้ง:</span> {{ $reporter->name }} </p>
            <p><span>ช่างที่รับผิดชอบ:</span> {{ $technician->name }} </p>
        </div>

        <div class="footer">
            <p>หากคุณมีข้อสงสัยเพิ่มเติม กรุณาติดต่อเราที่ <a href="mailto:support@example.com">support@kkumail.com</a></p>
        </div>
    </div>
</body>
</html>
