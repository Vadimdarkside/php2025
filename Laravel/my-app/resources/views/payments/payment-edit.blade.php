<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Update Payment</h1>
<form action="update-payment/{{$payment->id}}" method="POST">
    @csrf
    <div>
        <label for="client_id">client_id:</label>
        <input type="integer" name="client_id" id="client_id" value="{{$payment->client_id}}" required>
    </div>
    <div>
        <label for="amount">amount:</label>
        <input type="integer" name="amount" id="amount" value="{{$payment->amount}}" required>
    </div>
    <div>
        <label for="payment_date">payment_date:</label>
        <input type="date" name="payment_date" id="payment_date" value="{{$payment->payment_date}}" required>
    </div>
    <div>
        <label for="method">method:</label>
        <input type="text" name="method" id="method" value="{{$payment->method}}">
    </div>

    <button type="submit">Submit</button>
</form>

</body>
</html>