<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dictionary!</title>
    <link rel="stylesheet" href="css_files/dictionary.css">
    <script src="Js/script.js"></script>
</head>
<body>
  <div id="logo-div">
    <img id="logo" src="images/logo.png" alt="">
  </div>
  <div id="container-div">
    <div id="search-div">
      <h2 id="search_label">Search a Word!</h2>
      <input type="text" id="searchword" name="searchword"><br>
      <button id="submit_button" onclick="WordSearch()">Submit</button>

      <div class="checkbox-div">
        <h3>Show Definitions:&nbsp</h3>
        <input type="checkbox" id="Show Definitions" class="check">
      </div>
      <div class="checkbox-div">
        <h3>Show Examples: &nbsp</h3>
        <input type="checkbox" id="Show Example" class="check">
      </div>
      <div class="checkbox-div">
        <h3>Show Synonyms: &nbsp</h3>
        <input type="checkbox" id="Show Synonyms" class="check">
      </div>
      <div class="checkbox-div">
        <h3>Show Antonyms: &nbsp</h3>
        <input type="checkbox" id="Show Antonyms" class="check">
      </div>

    </div>
  

  


    <div id="add_card_section">
      <?php 
        require("addcard.php");
      ?>
    </div>
    
  </div>

</body>
</html>




