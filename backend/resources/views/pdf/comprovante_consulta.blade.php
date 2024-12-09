<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprovante de Consulta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #dddddd;
            border-radius: 8px;
        }
        h1 {
            color: #0d6efd;
            font-size: 22px;
        }
        p, li {
            font-size: 14px;
            color: #333333;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            margin-bottom: 10px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777777;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Comprovante de Consulta</h1>
        <p><strong>Nome do Paciente:</strong> {{ $consulta->user->name }}</p>
        <p><strong>Título da Consulta:</strong> {{ $consulta->title }}</p>
        <p><strong>Horário:</strong> {{ $consulta->horario }}</p>
        <p><strong>Profissional:</strong> {{ $profissional->name }}</p>
        <p><strong>Especialidade:</strong> {{ $profissional->tipo }}</p>
        <div class="footer">
            <p>&copy; {{ date('Y') }} SimplificaMed. Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>
