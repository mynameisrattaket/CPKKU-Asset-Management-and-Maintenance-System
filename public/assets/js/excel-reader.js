document.getElementById('file-input').addEventListener('change', function(e) {
    var file = e.target.files[0];
    var reader = new FileReader();

    reader.onload = function(e) {
        var data = new Uint8Array(e.target.result);
        var workbook = XLSX.read(data, {type: 'array'});

        var jsonData = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[0]]);
        sendDataToServer(jsonData);
    };

    reader.readAsArrayBuffer(file);
});

function sendDataToServer(data) {
    fetch('/import', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ data: data })
    })
    .then(response => response.json())
    .then(result => {
        console.log(result);
    })
    .catch(error => console.error('Error:', error));
}
