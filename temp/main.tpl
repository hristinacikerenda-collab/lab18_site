<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>%title%</title>
    <meta name="description" content="%meta_desc%">
    <meta name="keywords" content="%meta_key%">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background-color: #f3edf7;
            color: #2f263d;
            line-height: 1.55;
        }

        header {
            background-color: #d8c8eb;
            color: #362849;
            padding: 24px 20px;
            text-align: center;
        }

        header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        nav {
            background-color: #f7d6cb;
            padding: 12px 16px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-bottom: 1px solid #ecc2b4;
        }

        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
            justify-content: center;
        }

        nav a.nav-pill,
        nav a {
            display: inline-block;
            color: #2f243d;
            text-decoration: none;
            font-size: 14.5px;
            font-weight: 600;
            padding: 7px 18px;
            border-radius: 999px;
            background-color: #e6d8f5;
            border: 1px solid #d1bce8;
            transition: background-color 0.2s ease, border-color 0.2s ease, transform 0.15s ease;
        }

        nav a.nav-pill:hover,
        nav a:hover {
            background-color: #fff5f0;
            border-color: #e5b8a8;
            transform: translateY(-1px);
        }

        .wrapper {
            max-width: 1120px;
            margin: 26px auto;
            padding: 0 18px;
            display: flex;
            gap: 24px;
            align-items: stretch;
        }

        main {
            flex: 1;
            min-width: 0;
            background-color: #faf7f0;
            border: 1px solid #e7dfd6;
            border-radius: 16px;
            padding: 26px 28px;
            box-shadow: 0 4px 16px rgba(78, 59, 102, 0.06);
        }

        main h1 {
            margin: 0 0 10px;
            font-size: 24px;
            color: #2c2238;
        }

        main h2 {
            margin: 0 0 8px;
            font-size: 21px;
            color: #2c2238;
        }

        main p {
            margin: 0 0 10px;
            color: #3f354d;
            font-size: 15px;
        }

        .article {
            padding-bottom: 20px;
            margin-bottom: 22px;
            border-bottom: 1px solid #ebe4dc;
        }

        .article:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .article-header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 6px;
        }

        .article small,
        .article-date {
            flex-shrink: 0;
            display: inline-block;
            background-color: #ece6f4;
            color: #5b4d6e;
            font-size: 12.5px;
            padding: 3px 10px;
            border-radius: 999px;
            margin-top: 2px;
        }

        aside {
            width: 290px;
            flex-shrink: 0;
            background-color: #faf7f0;
            border: 1px solid #e7dfd6;
            border-radius: 16px;
            padding: 22px 20px;
            box-shadow: 0 4px 16px rgba(78, 59, 102, 0.06);
        }

        aside h2,
        aside h3 {
            margin: 0 0 14px;
            font-size: 19px;
            font-weight: 600;
            color: #2c2238;
        }

        aside input[type="text"],
        aside input[type="password"] {
            width: 100%;
            padding: 9px 12px;
            margin-bottom: 10px;
            border: 1px solid #e2d8d2;
            border-radius: 8px;
            background-color: #ebe6ee;
            color: #362c42;
            font-size: 14px;
            outline: none;
            transition: border-color 0.2s ease, background-color 0.2s ease;
        }

        aside input[type="text"]:focus,
        aside input[type="password"]:focus {
            border-color: #bfa9dc;
            background-color: #ffffff;
        }

        aside button,
        aside input[type="submit"] {
            width: 100%;
            background-color: #f6cfc2;
            color: #3b2a35;
            border: 1px solid #eab9a9;
            border-radius: 8px;
            padding: 9px 14px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            margin-bottom: 20px;
            transition: background-color 0.2s ease;
        }

        aside button:hover,
        aside input[type="submit"]:hover {
            background-color: #f0bfaf;
        }

        .banner-item {
            background-color: #dfd0ee;
            border: 1px solid #cbb6e3;
            border-radius: 10px;
            padding: 12px 14px;
            margin-bottom: 12px;
            color: #342647;
            font-size: 14px;
            font-weight: 500;
            line-height: 1.4;
            transition: transform 0.15s ease, background-color 0.2s ease;
        }

        .banner-item:hover {
            background-color: #d7c5ea;
            transform: translateY(-1px);
        }

        .banner-item:last-child {
            margin-bottom: 0;
        }

        footer {
            text-align: center;
            padding: 16px;
            margin-top: 28px;
            color: #4f4261;
            font-size: 13.5px;
        }

        main a {
            color: #6a4a9c;
        }

        .pagination {
            display: flex;
            gap: 8px;
            justify-content: center;
            margin-top: 22px;
        }

        .pagination a {
            display: inline-block;
            min-width: 34px;
            text-align: center;
            padding: 5px 10px;
            border-radius: 999px;
            background-color: #ece6f4;
            border: 1px solid #d1bce8;
            color: #3f2c5c;
            text-decoration: none;
            font-weight: 600;
        }

        .pagination a:hover {
            background-color: #f7d6cb;
        }

        .form-row {
            margin-bottom: 12px;
        }

        .form-row label {
            display: block;
            margin-bottom: 4px;
            font-weight: 600;
            font-size: 14px;
        }

        main input[type="text"],
        main input[type="password"] {
            width: 100%;
            max-width: 340px;
            padding: 9px 12px;
            border: 1px solid #e2d8d2;
            border-radius: 8px;
            background-color: #ebe6ee;
            font-size: 14px;
        }

        main button {
            background-color: #f6cfc2;
            border: 1px solid #eab9a9;
            border-radius: 8px;
            padding: 9px 18px;
            font-weight: 600;
            cursor: pointer;
        }

        .captcha-img {
            display: block;
            margin-bottom: 8px;
            border-radius: 6px;
        }

        .msg-error {
            color: #b3263e;
            font-weight: 600;
        }

        .search-list li {
            margin-bottom: 6px;
        }

        aside form {
            margin: 0;
        }

        aside form a {
            color: #6a4a9c;
            font-size: 13.5px;
        }

        @media (max-width: 820px) {
            .wrapper {
                flex-direction: column;
            }

            aside {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Довідник по PHP</h1>
    </header>

    <nav>
        <ul>
            %menu%
        </ul>
    </nav>

    <div class="wrapper">
        <main>
            %top%
            %middle%
            %bottom%
        </main>

        <aside>
            <form class="search-form" method="get" action="%address%">
                <h3>Пошук</h3>
                <input type="hidden" name="view" value="search">
                <input type="text" name="words" placeholder="Що шукаємо?">
                <button type="submit" name="search" value="1">Здійснити пошук</button>
            </form>

            %auth_user%
            <h3>Рекламний блок</h3>
            %banners%
        </aside>
    </div>

    <footer>
        &copy; 2026 Власний шаблонізатор PHP
    </footer>
</body>
</html>
