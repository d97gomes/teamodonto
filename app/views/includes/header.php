<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'TeamOdonto'; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" 
        rel="stylesheet"
    >

    <!-- Google Fonts: Inter + Playfair Display -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link 
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,900;1,900&display=swap" 
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" 
        rel="stylesheet"
    >

    <!-- CSS CUSTOMIZADO DO PROJETO -->
    <link 
        href="/teamOdonto/public/css/custom.css" 
        rel="stylesheet"
    >

    <!-- Axios (para chamadas à API) -->
    <script 
        src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js" 
        >
    </script>
</head>
<body>