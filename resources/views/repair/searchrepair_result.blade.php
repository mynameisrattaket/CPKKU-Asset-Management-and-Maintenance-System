@foreach($search as $repair)
<tr>
    <td>{{ $repair->request_detail_id }}</td>
    <td>{{ $repair->asset_name }}</td>
    <td>{{ $repair->asset_number }}</td>
    <td>{{ $repair->asset_symptom_detail }}</td>
    <td>{{ $repair->location }}</td>
    <td>{{ $repair->request_repair_note }}</td>
</tr>
@endforeach

@if($search->isEmpty())
<tr>
    <td colspan="6" class="text-center">ไม่พบข้อมูล</td>
</tr>
@endif
ฟ
