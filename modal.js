// function to create squares for data visuals 
function dataVisual(statValue) {

    // take the stat and reduce the value between 1-10 range 
    statValue = Math.round( (Math.ceil(statValue + 1) / 10) );
    
    // declare variable for squares   
    let squares = [];
    
    /*
        if the value is beyond 10, append 10 solid squares
        else if the value below 10, ...
        append the appropriate amount of solid squares..
        and fill the remainder with empty squares
    */
    if (statValue > 10 ) {
        for (var i = 1; i <=10; i++) squares.push("<i class='fas fa-square'></i>&nbsp;");             
    } else {
        for (var i = statValue; i >= 1; i--) squares.push("<i class='fas fa-square'></i>&nbsp;");
        for (let i = (10 - statValue); i >= 1; i--) squares.push("<i class='far fa-square'></i>&nbsp;");
    }

    // return an array of squares
    return squares.join("");        

}

// when the user clicks on a specific Pokémon
$(".pokemon-card").click(function() {
    
    // get data from the card clicked
    var pokemonSprite = $(this).closest(".pokemon-card").children(".pokemon-sprite").attr("src"),  
        pokemonNumber = $(this).closest(".pokemon-card").children(".pokemon-number").text(),  
        pokemonName = $(this).closest(".pokemon-card").children(".pokemon-name").text(), 
        pokemonType = $(this).closest(".pokemon-card").children(".pokemon-type").text(), 
        pokemonStats = $(this).data("stats");
    
    // retreive values from stat array amd assign to specific stats variables 
    var speed = pokemonStats[0], 
        spDef = pokemonStats[1], 
        spAtk = pokemonStats[2], 
        def = pokemonStats[3], 
        atk = pokemonStats[4], 
        hp = pokemonStats[5];
    
    // created variables that return array showing square visuals for each stat  
    var pokemonSpeed = dataVisual(speed), 
        pokemonSpDef = dataVisual(spDef), 
        pokemonSpAtk = dataVisual(spAtk), 
        pokemonDef = dataVisual(def), 
        pokemonAtk = dataVisual(atk), 
        pokemonHp = dataVisual(hp);
    
    // appended html elements containing data to modal
    $(".modal-image").append("<img class='modal-sprite' alt='" + pokemonName + "' src='" + pokemonSprite + "'/>");
    $(".modal-identity").append("<span class='modal-number'>" + pokemonNumber + "</span>");                 
    $(".modal-identity").append("<span class='modal-name'>" + pokemonName + "</span>"); 
    $(".modal-types").append("<span class='modal-type'>Type: " + pokemonType + "</span>");    
    $(".modal-stats").append("<span class='modal-stat'>Speed: " + pokemonSpeed + "</span>");   
    $(".modal-stats").append("<span class='modal-stat'>Special Defense: " + pokemonSpDef + "</span>");   
    $(".modal-stats").append("<span class='modal-stat'>Special Attack: " + pokemonSpAtk + "</span>");   
    $(".modal-stats").append("<span class='modal-stat'>Defense: " + pokemonDef + "</span>");   
    $(".modal-stats").append("<span class='modal-stat'>Attack: " + pokemonAtk + "</span>");   
    $(".modal-stats").append("<span class='modal-stat'>HP: " + pokemonHp + "</span>");   
   
    // show the modal
    $("#details-modal").css("display", "block"); 

});

// when the user clicks the exit button in the modal
$(".close-button").click(function() {

    // remove all data inside modal
    $(".modal-identity").children().remove(".modal-name");  
    $(".modal-identity").children().remove(".modal-number");                 
    $(".modal-image").children().remove(".modal-sprite"); 
    $(".modal-types").children().remove(".modal-type");                 
    $(".modal-stats").children().remove(".modal-stat");                 

    // hide the modal 
    $("#details-modal").css("display", "none"); 

});      