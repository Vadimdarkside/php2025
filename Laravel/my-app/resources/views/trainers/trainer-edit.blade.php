<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Update Trainer</h1>
<form action="update-trainer/{{$trainer->id}}" method="POST">
    @csrf
    <div>
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" value="{{$trainer->first_name}}" required>
    </div>
    <div>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" value="{{$trainer->last_name}}" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{$trainer->email}}" required>
    </div>
    <div>
        <label for="specialty">specialty:</label>
        <input type="text" name="specialty" id="specialty" value="{{$trainer->specialty}}">
    </div>

    <button type="submit">Submit</button>
</form>

</body>
</html>