<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Update Enroll</h1>
<form action="update-enroll/{{$enroll->id}}" method="POST">
    @csrf
    <div>
        <label for="client_id">client_id:</label>
        <input type="integer" name="client_id" id="client_id" value="{{$enroll->client_id}}" required>
    </div>
    <div>
        <label for="program_id">program_id:</label>
        <input type="integer" name="program_id" id="program_id" value="{{$enroll->program_id}}" required>
    </div>
    <div>
        <label for="start_date">start_date:</label>
        <input type="date" name="start_date" id="start_date" value="{{$enroll->start_date}}" required>
    </div>
    <div>
        <label for="status">status:</label>
        <input type="text" name="status" id="status" value="{{$enroll->status}}">
    </div>

    <button type="submit">Submit</button>
</form>

</body>
</html>