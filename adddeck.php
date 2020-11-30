<?php

    $username =$_POST['username'];
    $currentpath=$_POST['pathway'];
    
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add a deck</title>
</head>
<body>
    <h1>Add a deck:</h1>
    <form method="post" action="adddeckcheck.php">
        <input name="Deck_or_card_title" value="<?php echo $username;?>" placeholder="deck name:" type="text">
        <button>confirm<button>
    </form>
    
</body>
</html>
