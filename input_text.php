<?php require_once 'autoload.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./style.css">
  <title>Form</title>
</head>
<body>

<?php

use Entities\TelegraphText;
use Entities\FileStorage;
use Entities\CharactersLong;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function handlerCharactersLong($error)
{
  echo '<div class="sentError">' .  $error -> getMessage();
  echo '<form method="POST" action="input_text.php">';
  echo '<button class="repeatAction" type="submit">Try again</button>';
  echo '</form>';
  echo '</div>';
}

set_exception_handler('handlerCharactersLong');

if(isset($_POST['author'], $_POST['text'])) {
  try {
    $author = $_POST['author'];
    $text = $_POST['text'];

    // объект
    $telegraphText = new TelegraphText($author, $author);

    // Проверка длинны
    try {
      $telegraphText -> editText($author, $text);
    } catch (CharactersLong $exception) {
      echo handlerCharactersLong($exception);
      return;
    }

    // проверка указан ли email
    if(isset($_POST['email']) && !empty($_POST['email'])) {
      $mail = new PHPMailer(true);

      try {
        $mail -> setFrom('test-email@bk.ru.com', 'TestText');
        $mail -> addAddress($_POST['email']);
        $mail -> Subject = 'Here is the subject';
        $mail -> Body = $text;
        $mail -> send();

        echo '<div class="sentMessage">Message has been sent</div>';
      } catch (Exception $exception) {
        echo '<div class="sentError">Message could not be sent. Mailer Error: ' . $mail -> ErrorInfo;
        echo '<form method="POST" action="input_text.php">';
        echo '<button class="repeatAction" type="submit">Try again</button>';
        echo '</form>';
        echo '</div>';
        return;
      }
    }

    // сохроняем в FileStorage после проверки на мыло чтобы текст при ошиьки не отправлялся в Storage папку
    $storagePath = __DIR__ . DIRECTORY_SEPARATOR  . 'storage';
    $fileStorage = new FileStorage($storagePath);
    $slug = $fileStorage -> create($telegraphText);

    echo '<div class="sentMessage">The text has been successfully added to the Telegraph with the ID: ' . htmlspecialchars($slug) . '.</div>';
  } catch (Exception $exception) {
    echo '<div class="sentError">Error: ' . $exception -> getMessage();
    echo '<form method="POST" action="input_text.php">';
    echo '<button class="repeatAction" type="submit">Try again</button>';
    echo '</form>';
    echo '</div>';
    return;
  }
}

?>

  <div class="container">
    <form class="form" method="POST" action="input_text.php">
      <label class="form__label" for="author">Author:</label>
      <input class="form__input" type="text" id="author" name="author" required>
      <label class="form__label" for="text">Text:</label>
      <textarea class="form__textarea" id="text" name="text" required></textarea>
      <label class="form__label" for="email">Email:</label>
      <input class="form__input" type="email" id="email" name="email">
      <button class="form__btn" type="submit">Send</button>
    </form>
  </div>
</body>
</html>
