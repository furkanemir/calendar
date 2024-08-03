<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Etkinlikler</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
<h1>ETKINLIKLER</h1>
<table>
    <thead>
    <tr>
        <th>#</th>
        <th>ISIM</th>
        <th>BASLIK</th>
        <th>ACIKLAMA</th>
        <th>BASLAMA TARIHI</th>
        <th>BITIS TARIHI</th>
    </tr>
    </thead>
    <tbody>
    @foreach($events as $index => $event)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $event->userList->name }}</td>
            <td>{{ $event->title }}</td>
            <td>{{ $event->description }}</td>
            <td>{{ $event->start }}</td>
            <td>{{ $event->end }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
