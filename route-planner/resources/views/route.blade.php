<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Route Planner</title>
</head>
<body>
    <h1>Route Planner</h1>

    <form action="/addresses" method="POST">
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
        </div>
        <button type="submit">Add Address</button>
    </form>

    <h2>Get Route</h2>
    <form action="/get-route" method="POST">
        @csrf
        <div id="address-fields">
            <div>
                <label for="addresses[]">Address:</label>
                <input type="text" name="addresses[]" required>
            </div>
        </div>
        <button type="button" onclick="addAddressField()">Add Another Address</button>
        <button type="submit">Get Route</button>
    </form>

    <script>
        function addAddressField() {
            var container = document.getElementById('address-fields');
            var newField = document.createElement('div');
            newField.innerHTML = '<label for="addresses[]">Address:</label><input type="text" name="addresses[]" required>';
            container.appendChild(newField);
        }
    </script>

    @if(isset($routeData))
        <h2>Route</h2>
        <pre>{{ json_encode($routeData, JSON_PRETTY_PRINT) }}</pre>
    @endif
</body>
</html>
