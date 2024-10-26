<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление стран</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }
        h1 {
            color: #4382df;
            font-size: 24px;
            margin-bottom: 10px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }
        button {
            background-color: #4382df;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
            width: 100%;
        }
        button:hover {
            background-color: #4382df;
        }
        p {
            color: #333;
            font-size: 14px;
        }
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            margin-top: 10px;
            background-color: #fff;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Введите название страны</h1>

    <?php
    $message = '';
    $countryList = [];

    $dictionaryFile = 'dictionary.txt';
    $countriesFile = 'countries.txt';

    $dictionaryCountries = file($dictionaryFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if (file_exists($countriesFile)) {
        $countryList = file($countriesFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $country = trim($_POST['country']);

        if ($country === '') {
            $message = 'Поле страны не может быть пустым.';
        } elseif (!in_array($country, $dictionaryCountries)) {
            $message = 'Этой страны нет в эталонном списке.';
        } elseif (in_array($country, $countryList)) {
            $message = 'Эта страна уже добавлена.';
        } else {
            file_put_contents($countriesFile, $country . PHP_EOL, FILE_APPEND);
            $countryList[] = $country;
            $message = 'Страна успешно добавлена!';
        }
    }
    ?>

    <form action="index.php" method="post">
        <input type="text" name="country" placeholder="Название страны">
        <button type="submit">Добавить</button>
    </form>

    <p><?php echo htmlspecialchars($message); ?></p>

    <h2>Список стран:</h2>
    <select>
        <option disabled selected>Выберите страну</option>
        <?php foreach ($countryList as $country): ?>
            <option><?php echo htmlspecialchars($country); ?></option>
        <?php endforeach; ?>
    </select>
</div>
</body>
</html>
