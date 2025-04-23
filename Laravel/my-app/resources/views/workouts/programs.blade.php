<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>New Program</h1>
<form action="create-program" method="POST">
    @csrf
    <div>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
    </div>
    <div>
        <label for="trainer_id">Trainer:</label>
        <input type="integer" name="trainer_id" id="trainer_id" required>
    </div>
    <div>
        <label for="description">Description:</label>
        <input type="description" name="description" id="description" required>
    </div>
    <div>
        <label for="duration">Duration:</label>
        <input type="integer" name="duration" id="duration" required>
    </div>
    <button type="submit">Submit</button>
</form>
<table cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>Тренер</th>
            <th>Назва</th>
            <th>Опис</th>
            <th>Тривалість</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($programs as $program)
            <tr>
                <td>{{ $program->id }}</td>
                <td>{{ $program->trainer_id }}</td>
                <td>{{ $program->name }}</td>
                <td>{{ $program->description }}</td>
                <td>{{ $program->duration }}</td>
                <td>
                    <p><a href="{{url('programs/edit/' . $program->id)}}">Edit</a></p>
                    <form action="{{url('programs/delete/' . $program->id)}}" method="POST">
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