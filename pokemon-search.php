<!DOCTYPE html>
<html lang="en">
   
<head>

    <!-- METADATA -->
    <meta charset="UTF-8">
    <title>Assignment01 - Pokemon Search</title>
    <meta name="description" content="This assignment will introduce students to working with a dataset without yet adding the complexity of SQL and a database.">
    <meta name="author" content="Alyssa Galinato">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- STYLING -->
    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link href="style.css" type="text/css" rel="stylesheet">      
    <link href="./img/empty-pokemon.png" type="image/png" rel="icon">
    <script src="https://kit.fontawesome.com/05c38091a4.js" crossorigin="anonymous"></script>

    <!-- SCRIPTS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>
    
<body>

    <!-- CONTAINER for title & search form -->
    <div class="hero-container">

        <h1 class="title">Pokemon Search</h1>
        <p class="cta-phrase">Search your favourite Pokemon from the first 150 Generation I Pokemon!</p>

        <!-- form to search Pokémon -->
        <form class="pokemon-form" action="pokemon-search.php" method="get">
            <input class="pokemon-input" type="text" name="userInput" placeholder="Find Pokemon by name or number">
            <input class="pokemon-submit" type="submit">                               
        </form>      

    </div>    

    <!-- CONTAINER for all Pokémon -->
    <div class='pokemon-container'>

        <?php 

            // declare variable for user input
            $input = $_GET["userInput"];

            // if there is no user input or it was empty
            if (empty($input)) {

                // loop through 150 times
                for ($i = 1; $i <= 150; $i++) {

                    /* 
                        set the PokémonID to the counter...
                        concatenate the PokéAPI URL with PokémonID
                    */                    
                    $pokemonID = $i;
                    $pokemonLink = "https://pokeapi.co/api/v2/pokemon/" . $pokemonID; 
                    
                    /* 
                        read the file into a string...
                        take a JSON encoded string and converts it into a PHP variable
                    */                                     
                    $pokemonResponse = file_get_contents($pokemonLink);
                    $pokemonJSON = json_decode($pokemonResponse, true);

                    // get Pokémon name
                    $name = $pokemonJSON["name"];

                    /* 
                        get Pokémon image... 
                        and if there is no image associated with Pokémon, 
                        replace the image with a default...
                        else if there is an image associated with Pokémon, 
                        keep the image the same
                    */
                    $sprite = $pokemonJSON["sprites"]["front_default"];
                    if ($sprite == "") $sprite = "./img/empty-pokemon.png"; 
                    else $sprite = $sprite; 

                    /* 
                        get the type array...
                        and loop through the inner array to get the type 
                    */       
                    $typeArray = $pokemonJSON["types"];
                    foreach ($typeArray as $key => $value) $type = $value["type"]["name"];                          
                    
                    /* 
                        create an empty array...
                        get the stats arrary from JSON....
                        loop though the stats to get values of the speed, special defense, special attack, defense, attack & hp...
                        return the JSON representation of a value and set it to a variable 
                    */                           
                    $baseStats = []; 
                    $stats = $pokemonJSON["stats"];
                    foreach ($stats as $key => $value) {
                        $singleStat = $value["base_stat"];
                        $baseStats[] = $singleStat;                    
                    }                    
                    $pokemonStats = json_encode($baseStats);
                    
                    // create HTML elements with retrieved data                
                    echo "<div class='pokemon-card' data-stats='$pokemonStats'>
                        <img class='pokemon-sprite' src='$sprite' alt='$name'>
                        <span class='pokemon-number'>#$pokemonID</span>
                        <span class='pokemon-name'>$name</span>
                        <span class='pokemon-type'>$type</span>             
                    </div>";        

                }

            // if user enters a string of letters only or digits equal or less than 150
            } elseif (preg_match("/^[a-zA-Z]+$/", $input) || (
                (preg_match("/^[0-9]+$/", $input) && $input <= 150))) {

                /* 
                    concatenate PokéAPI URL with user's input...
                    read the file into a string...
                    take a JSON encoded string and converts it into a variable
                */                                        
                $pokemonLink = "https://pokeapi.co/api/v2/pokemon/" . $input; 
                $pokemonResponse = file_get_contents($pokemonLink);
                $pokemonJSON = json_decode($pokemonResponse, true);

                /* 
                    if the JSON is empty or returns null,
                    display the error message on DOM...
                    else if there is something inside the JSON,...                    
                */  
                if (empty($pokemonJSON)) {
                    echo "<span class='error-message'>No Pokemon found. Please try again.</span>";    
                } else {

                    // get Pokémon name, ID number & image from data
                    $name = $pokemonJSON["name"];
                    $pokemonID = $pokemonJSON["id"];    
                    $sprite = $pokemonJSON["sprites"]["front_default"];

                    /* 
                        get the type array...
                        and loop through the inner array to get the type 
                    */  
                    $typeArray = $pokemonJSON["types"];  
                    foreach ($typeArray as $key => $value) $type = $value["type"]["name"];      

                    /* 
                        create an empty array...
                        get the stats arrary from JSON....
                        loop though the stats to get values of the speed, special defense, special attack, defense, attack & hp...
                        return the JSON representation of a value and set it to a variable 
                    */                           
                    $baseStats = []; 
                    $stats = $pokemonJSON["stats"];
                    foreach ($stats as $key => $value) {
                        $singleStat = $value["base_stat"];
                        $baseStats[] = $singleStat;                    
                    }                    
                    $pokemonStats = json_encode($baseStats);
                    
                    /* 
                       create HTML elements with retrieved data
                       store hidden data for modal in data attribute for jQuery
                    */                                    
                    echo "<div class='pokemon-card' data-stats='$pokemonStats'>
                        <img class='pokemon-sprite' src='$sprite' alt='$name'>
                        <span class='pokemon-number'>#$pokemonID</span>
                        <span class='pokemon-name'>$name</span>
                        <span class='pokemon-type'>$type</span>             
                    </div>";   
                    
                }

            // if users entered incorrectly
            } else {

                // display the following message
                echo "<span class='error-message'>No Pokemon found. Please try again.</span>";

            }

        ?>           

    </div>

    <!-- MODAL for Pokémon details -->
    <div id="details-modal" class="modal">

        <span class="close-button">&times;</span>

        <!-- modal content -->
        <div class="modal-content">
           <div class="modal-left">
              <div class="modal-image"></div>                 
              <div class="modal-identity"></div>
           </div>
           <div class="modal-right">
              <div class="modal-types"></div> 
              <div class="modal-stats"></div>
           </div>               

        </div>

    </div>         

    <!-- JAVASCRIPT for modal -->
    <script src="modal.js"></script> 

</body>

</html>