<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test GET users</title>
</head>
<body>
    <h1>Liste des utilisateurs</h1>

    <ul>
        @foreach($users as $user)
            <li>
                {{ $user->email }} - {{ $user->firstname }} - {{ $user->lastname }} - {{ $user->username }} - {{ $user->role }} - {{ $user->password }} - {{ $user->last_login ??= 'NULL' }} - {{ $user->Google_token ??= 'NULL' }} - {{ $user->created_at ??= 'NULL' }} - {{ $user->updated_at ??= 'NULL' }}
            </li>
        @endforeach
    </ul>
</body>
</html>