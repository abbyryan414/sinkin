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
    console.log(bruh)
    for(i in data.results){
        x += "<h1>"+ bruh.results[i].definition + "</h1>";
        //loop thru the results tab and shows the definitions
        //ERROR: Uncaught (in promise) ReferenceError: x is not defined
        //Do not be fooled. X is defined. JS spits a reference error when it isn't returning something explicitly. Refer to the internet.
    }
    console.log(x)
    //console display all definitions
})

/*
METHOD 2
    .then(res) => res.json()
    .then((data) => {
        let output = `<h2> ${leword}</h2>`
        data.forEach(function(result){
        //loops thru results
        //ERROR: data.forEach is not a function
        //This is caused because data is json and not an array.
        //forEach can only be used on an array.
            output += `
                <ul>
                    <li>Definition: ${result.definition}</li>
                </ul>
            `
        })
        console.log(output)
    })
*/


/*
METHOD 3
    .then((res) => res.json())
    //transforms api response to json
    .then((data)=>{
    let bruh = Object.values(data);
    console.log(bruh)
    bruh.array.forEach(function(result) {
        output += `
        <ul>
            <li>Definition: ${result.definition}</li>
        </ul>
    `
    });
        //loop thru results and shows the definitions
        //ERROR: Uncaught (in promise) TypeError: Cannot read property 'forEach' of undefined
        //No idea. 
        //This method is technically the same as method 2, only replacing the json with an array. 
        //I feel like this might be the ticket out. Just implementation problems on my side.
        

    console.log(output)
    //console display all definitions
*/

}   
