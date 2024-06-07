$(document).ready(function() {
    $('#upload-form').on('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: '/import',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log('Success:', response);
                // อัปเดตข้อมูลบนหน้าเว็บไซต์
                updateUserData(response.users);
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });

    function updateUserData(users) {
        // ลบข้อมูลผู้ใช้เก่า
        $('#user-table tbody').empty();
        
        // เพิ่มข้อมูลผู้ใช้ใหม่
        users.forEach(function(user) {
            $('#user-table tbody').append(`
                <tr>
                    <td>${user.name}</td>
                    <td>${user.email}</td>
                    <td>${user.phone}</td>
                </tr>
            `);
        });
    }
});
