<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css?5">
    <script src="./src/js/index.js?5"></script>
    <title>PDF READER</title>
</head>
<body>
    <div class="container">
        <div class="users_container">
            <button><a href="./users.php">Посмотреть пользователей</a></button>
            <button id="logs">Ошибки</button>
        </div>
        <div class="pdf_continer">
            <embed id="pdf_view" type="application/pdf" width="1000px" height="1000px">
        </div>
        <div class="btn_continer">
            <form action="edit.php" enctype="multipart/form-data" method="post">
                <label for="load_pdf">Загрузить PDF</label>
                <input required type="file" name="pdf" id="load_pdf" accept="application/pdf">
            </form>
        </div>
    </div>

    <?if(isset($_GET['error']) || isset($_GET['success'])):?>
        <div class="toaster toast_<?=isset($_GET['success']) ? "ok" : "false"?>">
            <p><?=isset($_GET['success']) ? $_GET['success'] : $_GET['error']?></p>
        </div>
    <?endif?>

</body>
</html>