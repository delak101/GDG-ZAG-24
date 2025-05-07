<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiles</title>
    
</head>
<body>
    <h1>Profiles</h1>
    <ul>
        @foreach ($profiles as $profile)
            <li>
                <a href="/profiles/{{ $profile['id'] }}" class="profile-link">
                {{ $profile['name'] }} - {{ $profile['age'] }} years old
            </li>
        @endforeach
    </ul>
</body>
</html>
