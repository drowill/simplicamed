<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Cadastrada</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: auto;
        }
        h1 {
            color: #0d6efd;
            font-size: 24px;
        }
        p {
            font-size: 16px;
            color: #333333;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #f9f9f9;
            margin-bottom: 10px;
            padding: 10px;
            border-left: 4px solid #0d6efd;
            font-size: 16px;
        }
        .footer {
            text-align: center;
            color: #777777;
            font-size: 12px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Consulta Confirmada com Sucesso!</h1>
        <p>Olá <strong>{{ $consulta->user->name }}</strong>,</p>
        <p>Sua consulta foi confirmada com sucesso. Veja abaixo os detalhes:</p>
        <ul>
            <li><strong>Título da Consulta:</strong> {{ $consulta->title }}</li>
            <li><strong>Horário:</strong> {{ $consulta->horario }}</li>
            <li><strong>Profissional:</strong> {{ $profissional->name }}</li>
            <li><strong>Especialidade:</strong> {{ $profissional->tipo }}</li>
        </ul>
        <p>Por favor, baixe o PDF em anexo junto a este email e leve no dia da consulta</p>
    </div>
    <div class="footer">
        <p>&copy; {{ date('Y') }} SimplificaMed. Todos os direitos reservados.</p>
    </div>
</body>
</html>
