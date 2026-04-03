<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat - {{ $nama }}</title>
    <style>
        @page {
            margin: 0;
            padding: 0;
            size: A4 landscape;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica', 'Arial', sans-serif;
            width: 100%;
            height: 100%;
        }
        .background-container {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
        .background-container img {
            width: 100%;
            height: 100%;
        }
        .content {
            position: relative;
            width: 100%;
            height: 100%;
            text-align: center;
        }
        .name-container {
            position: absolute;
            top: 48%; /* Position under "Diberikan kepada" */
            left: 5%;
            width: 90%;
            height: 15%; 
            display: table;
            text-align: center;
        }
        .name {
            display: table-cell;
            vertical-align: middle;
            font-size: {{ strlen($nama) > 30 ? '38pt' : (strlen($nama) > 20 ? '48pt' : '58pt') }};
            font-family: 'Times-BoldItalic', 'Times New Roman', serif; /* Stable, looks professional */
            color: #1a237e;
            line-height: 1.1;
        }
        .info {
            position: absolute;
            top: 85%;
            left: 0;
            width: 100%;
            font-size: 14px;
            color: #4a5568;
        }
    </style>
</head>
<body>
    <div class="background-container">
        <img src="{{ public_path('images/sertifikat_batch2.jpg') }}" alt="background">
    </div>
    <div class="content">
        <div class="name-container" style="top: 44%;">
            <div class="name">{{ $nama }}</div>
        </div>
    </div>
</body>
</html>
