
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>

<body>
<nav class="d-flex">
        <!-- Logo -->
        <div id="logo">
            <a href="dashboard.php">
                <img id="img" src="./src/logo.svg" alt="Logo">
            </a>
        </div>

        <!-- Menu Items -->
        <div id="menu">
            <!-- Menu Introduction -->
            <div class="menu-item menu-item-active">
                <a href="dashboard.php">
                    Home
                </a>
            </div>
            <!-- Courses -->
            <div class="menu-item">
                <a href="historico.php">
                    Histórico
                </a>
            </div>
        </div>
        <!-- User -->
        <div id="user">
            <div class="menu-item">
                <a href="logout.php" class="me-5">
                    Logout
                </a>
                <a href="profile.php">
                    <img src="./src/person.svg" id="userLogo">
                </a>
            </div>
        </div>
    </nav>

</body>
<script src=" https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>

</html>