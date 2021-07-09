
console.log("script file present")
var definitions = "";
var examples = "";
var antonyms = "";
var synonyms = "";
function WordSearch() {
  leword = document.getElementById('searchword').value
  document.getElementById("deck_or_card_title_area").value = leword;
  if (document.getElementById('Show Definitions').checked == false) {
    get_examples();
  } else {
    fetch(`https://wordsapiv1.p.rapidapi.com/words/${leword}`, {
      //gets the word user inputted. There must be a better way to do this...
      "method": "GET",
      "headers": {
        "x-rapidapi-key": "9adf941a45mshca905293069e03bp180a5ajsn652a5848be6e",
        //Remember to conceal the api key!! Dont let the pirates get it!
        "x-rapidapi-host": "wordsapiv1.p.rapidapi.com"

      }
    })


      //    Checks for status code: 200 ok
      .then((res => {
        if (!res.ok) {
          document.getElementById("definition_list").innerHTML = "No such word!";
          document.getElementById("example_area").innerHTML = "Invalid!"
          throw new Error('No word found')
        }
        return res;
      }))

      .then((res) => res.json())

      //transforms api response to json
      .then((data) => {
        let bruh = Object.values(data);
        console.log(bruh);
        var x = "";
        for (i in data.results) {
          number = parseInt(i) + 1;
          x += number.toString() + ") " + bruh[1][i].definition + "\r\n";
        }
        definitions = x;
        get_examples();
      })
      .catch((error) => {
        console.error("error:", error);
      })
  }

  
}

function get_examples() {
  if (document.getElementById('Show Example').checked == false) {
    get_antonyms();
  } else {
    fetch(`https://wordsapiv1.p.rapidapi.com/words/${leword}/examples`, {
      //gets the word user inputted. There must be a better way to do this...
      "method": "GET",
      "headers": {
        "x-rapidapi-key": "9adf941a45mshca905293069e03bp180a5ajsn652a5848be6e",
        //Remember to conceal the api key!! Dont let the pirates get it!
        "x-rapidapi-host": "wordsapiv1.p.rapidapi.com"
      }
    })

      .then((res) => res.json())
      //transforms api response to json
      .then((data) => {
        let hey = Object.values(data);
        console.log(hey);
        var y = "";
        var ia = hey[1];
        if (ia == 0) {
          y = "There doesn't seem to be any examples available for this word!";
        }
        else {
          for (i in hey[1]) {
            number = parseInt(i) + 1;
            y += number.toString() + ") " + hey[1][i] + "\n";
          }
        }
        examples = y;
        get_antonyms();
      })
  }
  
}

function get_antonyms() {
  if (document.getElementById('Show Antonyms').checked == false) {
    get_synonyms();
  } else {
    fetch(`https://wordsapiv1.p.rapidapi.com/words/${leword}/antonyms`, {
      //gets the word user inputted. There must be a better way to do this...
      "method": "GET",
      "headers": {
        "x-rapidapi-key": "9adf941a45mshca905293069e03bp180a5ajsn652a5848be6e",
        //Remember to conceal the api key!! Dont let the pirates get it!
        "x-rapidapi-host": "wordsapiv1.p.rapidapi.com"
      }
    })
      .then((res) => res.json())
      //transforms api response to json
      .then((data) => {
        let hey = Object.values(data);
        console.log(hey);
        var y = "";
        var ia = hey[1];
        if (ia == 0) {
          y = "There doesn't seem to be any antonyms available for this word!";
        }

        for (i in hey[1]) {
          y += hey[1][i] + "\n";
          console.log(y);
        }
        antonyms = y;
        get_synonyms();
      })
  }
  
}

function get_synonyms() {
  if (document.getElementById('Show Synonyms').checked == false) {
    present_data();
  } else {
    fetch(`https://wordsapiv1.p.rapidapi.com/words/${leword}/synonyms`, {
      //gets the word user inputted. There must be a better way to do this...
      "method": "GET",
      "headers": {
        "x-rapidapi-key": "9adf941a45mshca905293069e03bp180a5ajsn652a5848be6e",
        //Remember to conceal the api key!! Dont let the pirates get it!
        "x-rapidapi-host": "wordsapiv1.p.rapidapi.com"
      }
    })
      .then((res) => res.json())
      //transforms api response to json
      .then((data) => {
        let hey = Object.values(data);
        console.log(hey);
        var y = "";
        var ia = hey[1];
        if (ia == 0) {
          y = "There doesn't seem to be any synonyms available for this word!";
        }

        for (i in hey[1]) {
          y += hey[1][i] + "\n";
        }
        synonyms = y;
        console.log("Definitions: " + definitions);
        console.log("Examples: " + examples);
        console.log("Antonyms: " + antonyms);
        console.log("Synonyms: " + synonyms);
        present_data();
        
      })
  }
}


function present_data() {
  if (document.getElementById('Show Definitions').checked == false) {
    definitions = "";
  }
  if (document.getElementById('Show Example').checked == false) {
    examples = "";
  }
  if (document.getElementById('Show Synonyms').checked == false) {
    synonyms = "";
  }
  if (document.getElementById('Show Antonyms').checked == false) {
    antonyms = "";
  }

  document.getElementById("card_info_area").value = "Definition: \r\n" + definitions + "\r\nExamples: \r\n"+ examples + synonyms + antonyms;
}
