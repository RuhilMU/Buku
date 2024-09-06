<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Mahasiwa</title>
</head>
<body>
    <table class="table table-stripped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Nim</th>
                <th>Jurusan</th>
                <th>Angkatan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($mahasiswa as $index => $maha)
                <tr>
                    <td>{{ $index+1 }}</td>
                    <td>{{ $maha->nama }}</td>
                    <td>{{ $maha->nim }}</td>
                    <td>{{ $maha->jurusan }}</td>
                    <td>{{ $maha->angkatan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>