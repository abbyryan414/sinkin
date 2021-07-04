<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dictionary!</title>
    
    <script src="Js/script.js"></script>
</head>
<body>
    <div id="output"></div>
    <form name="SearchforWord">
    </form>

    <label for="wordstosearch">Search a word!:</label><br>
    <input type="text" id="searchword" name="searchword"><br>
    <button onclick="WordSearch()">Submit</button>
    Show Definitions:
    <input type="checkbox" id="Show Definitions" class="check">
    Show Examples:
    <input type="checkbox" id="Show Example" class="check">
    Show Synonyms:
    <input type="checkbox" id="Show Synonyms" class="check">
    Show Antonyms:
    <input type="checkbox" id="Show Antonyms" class="check">
    <h5 id="definition_area"></h5>
    <ol id="example_area"></ol>
    <ol id="definition_list"></ol>

</body>
</html>

<?php 
  require("addcard.php");
?>


