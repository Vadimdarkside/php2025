<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    <h1>Edit Product</h1>

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required>
        <br>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" required>
        <br>

        <label for="category">Category:</label>
        <input type="text" name="category" id="category" value="{{ old('category', $product->category) }}" required>
        <br>

        <button type="submit">Update</button>
    </form>
    <br>
    <a href="{{ route('products.index') }}">Back to Products List</a>
</body>
</html>
