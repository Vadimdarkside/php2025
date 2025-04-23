<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Update Client</h1>
<form action="update-client/{{$client->id}}" method="POST">
    @csrf
    <div>
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" value="{{$client->first_name}}" required>
    </div>
    <div>
        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" value="{{$client->last_name}}" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{$client->email}}" required>
    </div>
    <div>
        <label for="phone">Phone:</label>
        <input type="text" name="phone" id="phone" value="{{$client->phone}}">
    </div>

    <button type="submit">Submit</button>
</form>

</body>
</html>