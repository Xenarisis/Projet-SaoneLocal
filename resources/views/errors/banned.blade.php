<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compte Suspendu</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f3f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .banned-card {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        h1 {
            color: #dc2626;
            margin-bottom: 15px;
        }
        p {
            color: #4b5563;
            line-height: 1.5;
            margin-bottom: 25px;
        }
        .logout-btn {
            background-color: #1f2937;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .logout-btn:hover {
            background-color: #111827;
        }
    </style>
</head>
<body>
    <div class="banned-card">
        <h1>Accès Restreint</h1>
        <p>Votre compte a été suspendu par un administrateur et vous ne pouvez plus accéder à notre boutique.</p>
        <p>Si vous pensez qu'il s'agit d'une erreur, veuillez contacter le support par mail.</p>
    </div>
</body>
</html>