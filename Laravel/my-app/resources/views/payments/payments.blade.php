<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>New Payment</h1>
<form action="create-payment" method="POST">
    @csrf
    <div>
        <label for="client_id">Client_id:</label>
        <input type="integer" name="client_id" id="client_id" required>
    </div>
    <div>
        <label for="amount">amount:</label>
        <input type="integer" name="amount" id="amount" required>
    </div>
    <div>
        <label for="payment_date">payment_date:</label>
        <input type="date" name="payment_date" id="payment_date" required>
    </div>
    <div>
        <label for="method">method:</label>
        <input type="text" name="method" id="method" required>
    </div>
    <button type="submit">Submit</button>
</form>
<table cellpadding="10">
    <thead>
        <tr>
            <th>ID</th>
            <th>client id</th>
            <th>amount</th>
            <th>payment_date</th>
            <th>method</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $payment)
            <tr>
                <td>{{ $payment->id }}</td>
                <td>{{ $payment->client_id }}</td>
                <td>{{ $payment->amount }}</td>
                <td>{{ $payment->payment_date }}</td>
                <td>{{ $payment->method }}</td>
                <td>
                    <p><a href="{{url('payments/edit/' . $payment->id)}}">Edit</a></p>
                    <form action="{{url('payments/delete/' . $payment->id)}}" method="POST">
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