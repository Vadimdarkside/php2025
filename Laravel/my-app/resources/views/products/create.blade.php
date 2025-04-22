<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
</head>
<body>
    <h1>Create New Product</h1>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required>
        <br>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" required>
        <br>

        <label for="category">Category:</label>
        <input type="text" name="category" id="category" required>
        <br>

        <button type="submit">Create</button>
    </form>
    <br>
    <a href="{{ route('products.index') }}">Back to Products List</a>
</body>
</html>
