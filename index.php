<?php
session_start();

// Подключение к базе данных (замените данными вашей БД)
$servername = "164.132.206.179";
$username = "gs216868";
$password = "ihyjG56Aad49";
$dbname = "gs216868";

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения к базе данных: " . $conn->connect_error);
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nickname = $_POST["nickname"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $sex = $_POST["sex"];
    $age = $_POST["age"];
    $skinColor = $_POST["skinColor"];
    $nationality = $_POST["nationality"];
    $role = $_POST["role"];
    $active = 1; // Установка uActive на 1
    $money = 100000000; // Установка uMoney на 100.000.000
    $country = 1;

    // Защита от SQL-инъекций
    $nickname = mysqli_real_escape_string($conn, $nickname);
    $password = mysqli_real_escape_string($conn, $password);
    $email = mysqli_real_escape_string($conn, $email);

    // SQL-запрос для вставки данных в таблицу
    $sql = "INSERT INTO gb_users (uName, uPass, uEmail, uSex, uAge, uMoney, uColor, uNation, uRole, uActive) 
      VALUES ('$nickname', '$password', '$email', '$sex', '$age', '$money', '$skinColor', '$nationality', '$role', '$active')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Аккаунт успешно создан!";
    } else {
        if (strpos($conn->error, 'Duplicate entry') !== false) {
            $_SESSION['error'] = "Аккаунт с данным Ник-Неймом уже создан!";
        } else {
            $_SESSION['error'] = "Ошибка: " . $conn->error;
        }
    }
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Закрытие подключения
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Создание игрового аккаунта</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('img/header_bg.jpg');
            background-size: cover; /* Растянуть изображение на всю область */
        background-position: center; /* Позиция изображения по центру */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;  /* ширина окна */
    }
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"],
        input[type="submit"],
        select {
            padding: 10px; /* высота выборочных менюшек */
            margin-bottom: 1px; /* отступ */
            border-radius: 5px; /* скругление */
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            text-align: center;
        }

        .message {
            color: green;
            font-size: 12px;
            margin-top: 5px;
            text-align: center;
        }


    </style>
</head>
<body>

<div class="container">
    <h2>Форма создания игрового аккаунта</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        Никнейм: <input type="text" name="nickname" required><br><br>
        Пароль: <input type="password" name="password" required><br><br>
        Электронная почта: <input type="email" name="email" required><br><br>
        Пол:
        <select name="sex">
            <option value="1">Мужской</option>
            <option value="2">Женский</option>
        </select><br><br>
        Возраст: <input type="number" name="age" min="15" max="90" required><br><br>
        Цвет кожи:
        <select name="skinColor">
            <option value="2">Светлый</option>
            <option value="1">Черный</option>
        </select><br><br>
        Национальность:
        <select name="nationality">
            <option value="1">Американец</option>
            <option value="2">Латиноамериканец</option>
            <option value="3">Русский</option>
            <option value="4">Француз</option>
            <option value="5">Итальянец</option>
            <option value="6">Испанец</option>
        </select><br><br>
        Роль:
        <select name="role">
            <option value="1">Обычный житель</option>
            <option value="2">Бездомный</option>
            <option value="3">Прилетевший</option>
            <option value="4">Приплывший</option>
            <option value="5">Сельский житель</option>
            <option value="6">Осужденный</option>
        </select><br><br>
        <input type="submit" value="Создать аккаунт">
        <?php if (!empty($_SESSION['error'])): ?>
            <div class="error-message"><?php echo $_SESSION['error']; ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
        <?php if (!empty($_SESSION['message'])): ?>
        <div class="message"><?php echo $_SESSION['message']; ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>
    </form>
</div>

</body>
</html>