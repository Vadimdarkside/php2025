<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>New Client</h1>
<form action="create-client" method="POST">
    @csrf
    <div>
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" required>
    </div>
    <div>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" required>
    </div>

    <div>
        <label for="registration_date">Registration Date:</label>
        <input type="date" name="registration_date" id="registration_date" required>
    </div>

    <button type="submit">Submit</button>
</form>
<table cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>Ім’я</th>
            <th>Прізвище</th>
            <th>Email</th>
            <th>Телефон</th>
            <th>Дата реєстрації</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($clients as $client)
            <tr>
                <td>{{ $client->id }}</td>
                <td>{{ $client->first_name }}</td>
                <td>{{ $client->last_name }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->phone }}</td>
                <td>{{ $client->registration_date }}</td>
                <td>
                    <p><a href="{{url('clients/edit/' . $client->id)}}">Edit</a></p>
                    <form action="{{url('clients/delete/' . $client->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button>Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>