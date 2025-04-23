<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Update Program</h1>
<form action="update-program/{{$program->id}}" method="POST">
    @csrf
    <div>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="{{$program->name}}" required>
    </div>
    <div>
        <label for="trainer_id">trainer_id:</label>
        <input type="integer" name="trainer_id" id="trainer_id" value="{{$program->trainer_id}}" required>
    </div>
    <div>
        <label for="description">description:</label>
        <input type="text" name="description" id="description" value="{{$program->description}}" required>
    </div>
    <div>
        <label for="duration">duration:</label>
        <input type="integer" name="duration" id="duration" value="{{$program->duration}}">
    </div>

    <button type="submit">Submit</button>
</form>

</body>
</html>