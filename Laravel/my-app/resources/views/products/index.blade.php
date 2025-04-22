<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
</head>
<body>
    <h1>Products</h1>

    <a href="{{ route('products.create') }}">Add New Product</a>

    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Name</th><th>Price</th><th>Category</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->category }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product) }}">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
