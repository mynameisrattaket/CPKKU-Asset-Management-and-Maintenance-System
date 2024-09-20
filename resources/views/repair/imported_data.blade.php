<!-- resources/views/repair/imported_data.blade.php -->
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ข้อมูลที่นำเข้า</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>ข้อมูลที่นำเข้าจาก Google Sheets</h1>
        <table>
            <thead>
                <tr>
                    <th>วันที่</th>
                    <th>ชื่อผู้รายงาน</th>
                    <th>หมายเลขทรัพย์สิน</th>
                    <th>ชื่อทรัพย์สิน</th>
                    <th>รายละเอียดอาการ</th>
                    <th>ตำแหน่ง</th>
                    <th>สถานะ</th>
                    <th>หมายเหตุ</th>
                    <th>วันที่อัปเดต</th>
                </tr>
            </thead>
            <tbody>
                @foreach($repairs as $repair)
                    <tr>
                        <td>{{ $repairs->timestamp }}</td>
                        <td>{{ $repairs->reporter_name }}</td>
                        <td>{{ $repairs->asset_number }}</td>
                        <td>{{ $repairs->asset_name }}</td>
                        <td>{{ $repairs->symptom_detail }}</td>
                        <td>{{ $repairs->location }}</td>
                        <td>
                            @if($repairs->status == 1) รอดำเนินการ
                            @elseif($repairs->status == 2) กำลังดำเนินการ
                            @elseif($repairs->status == 3) รออะไหล่
                            @elseif($repairs->status == 4) ดำเนินการเสร็จสิ้น
                            @elseif($repairs->status == 5) ซ่อมไม่ได้
                            @endif
                        </td>
                        <td>{{ $repairs->note }}</td>
                        <td>{{ $repairs->updated_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
