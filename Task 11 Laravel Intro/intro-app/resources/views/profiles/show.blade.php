<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiles</title>
</head>
<body>
    <div>
        <h1>{{ $profile['name']}}</h1>
        <p><strong>age:</strong> {{ $profile['age'] }}</p>
        <p><strong>email:</strong> {{ $profile['email'] }}</p>
        <a href="/profiles" class="back-link">Back to all profiles</a>
    </div>
</body>
</html>