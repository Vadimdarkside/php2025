<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>New Enrollment</h1>
<form action="create-enroll" method="POST">
    @csrf
    <div>
        <label for="client_id">Client_id:</label>
        <input type="integer" name="client_id" id="client_id" required>
    </div>
    <div>
        <label for="program_id">program_id:</label>
        <input type="integer" name="program_id" id="program_id" required>
    </div>
    <div>
        <label for="start_date">start_date:</label>
        <input type="date" name="start_date" id="start_date" required>
    </div>
    <div>
        <label for="status">status:</label>
        <input type="text" name="status" id="status" required>
    </div>
    <button type="submit">Submit</button>
</form>
<table cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>client id</th>
            <th>program id</th>
            <th>start date</th>
            <th>status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($enrolls as $enroll)
            <tr>
                <td>{{ $enroll->id }}</td>
                <td>{{ $enroll->client_id }}</td>
                <td>{{ $enroll->program_id }}</td>
                <td>{{ $enroll->start_date }}</td>
                <td>{{ $enroll->status }}</td>
                <td>
                    <p><a href="{{url('enrolls/edit/' . $enroll->id)}}">Edit</a></p>
                    <form action="{{url('enrolls/delete/' . $enroll->id)}}" method="POST">
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