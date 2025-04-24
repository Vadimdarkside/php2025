<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>New Trainer</h1>
<form action="create-trainer" method="POST">
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
        <label for="specialty">Specialty:</label>
        <input type="text" name="specialty" id="specialty" required>
    </div>
    <button type="submit">Submit</button>
</form>

<h1>Filter</h1>
    <form action="{{route('/trainers')}}" method="GET">
        <div>
            <label for="first_name">Filter by First Name:</label>
            <input type="text" name="first_name" id="first_name" value="{{ request('first_name') }}">
        </div>
        <div>
            <label for="last_name">Filter by Last Name:</label>
            <input type="text" name="last_name" id="last_name" value="{{ request('last_name') }}">
        </div>
        <div>
            <label for="email">Filter by Email:</label>
            <input type="email" name="email" id="email" value="{{ request('email') }}">
        </div>
        <div>
            <label for="specialty">Filter by specialty:</label>
            <input type="text" name="specialty" id="specialty" value="{{ request('specialty') }}">
        </div>
        <input type="hidden" name="filter" value="true">
        <button type="submit">Apply Filters</button>
    </form>

<table cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>Ім’я</th>
            <th>Прізвище</th>
            <th>Email</th>
            <th>Спеціальність</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @if ($trainers)
        @foreach($trainers as $trainer)
            <tr>
                <td>{{ $trainer->id }}</td>
                <td>{{ $trainer->first_name }}</td>
                <td>{{ $trainer->last_name }}</td>
                <td>{{ $trainer->email }}</td>
                <td>{{ $trainer->specialty }}</td>
                <td>
                    <p><a href="{{url('trainers/edit/' . $trainer->id)}}">Edit</a></p>
                    <form action="{{url('trainers/delete/' . $trainer->id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button>Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        @else
        <div>No clients</div>
       @endif
    </tbody>
</table>
</body>
</html>