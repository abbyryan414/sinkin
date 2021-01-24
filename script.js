console.log("script file present")
function WordSearch(){
    leword = document.getElementById('searchword').value
    console.log(leword)
    console.log(321);
    fetch(`https://wordsapiv1.p.rapidapi.com/words/${leword}`, {
    //gets the word user inputted. There must be a better way to do this...
    "method": "GET",
    "headers": {
      "x-rapidapi-key": "9adf941a45mshca905293069e03bp180a5ajsn652a5848be6e",
      //Remember to conceal the api key!! Dont let the pirates get it!
      "x-rapidapi-host": "wordsapiv1.p.rapidapi.com"
    }
  })
//This is where crap hits the fan. GOAL: to display received api data on html. Format: list or table.

//METHOD 1
    .then((res) => res.json())
    //transforms api response to json
    .then((data)=>{
    let bruh = Object.values(data);
    console.log(bruh);
    var x = "";
    for(i in data.results){
        // x += "<h1>"+ bruh.results[i].definition + "</h1>";
        //x = "<h1>"+ bruh[1][i].definition + "</h1>";
        x += bruh[1][i].definition + "\n";
        //console.log(x);
        
        //console.log(bruh[1][1].definition);
        //loop thru the results tab and shows the definitions
        //ERROR: Uncaught (in promise) ReferenceError: x is not defined
        //Do not be fooled. X is defined. JS spits a reference error when it isn't returning something explicitly. Refer to the internet.
    }
    document.getElementById("definition_area").innerHTML = x;
    document.getElementById('card_info').value = x;
    $('#deck_or_card_title2').val(x);
    
    //console display all definitions
})

}   
