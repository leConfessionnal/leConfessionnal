<?php
    require("classes/class.Playlist.php");
	
    // Lecture paramètres
    $parametres = parse_ini_file("param/param.ini");
    $key = $parametres['key'];
    $channelId = $parametres['channel'];
    $adresse = $parametres['adresse'];

    // Requete Youtube
    // Dcoumentations : https://developers.google.com/youtube/v3/docs/
    $requete = $adresse."playlists?part=snippet&channelId=".$channelId."&maxResults=50&key=".$key;
//echo $requete."<br/>";    
    $response = file_get_contents($requete);
 
    $tableau = json_decode($response, true);
/*    
echo "<pre>";
print_r($tableau);
echo "</pre>";
*/
    // Mise sous forme d'un tableau de liste d'objets de la classe Playlist
    $liste = array();
    for($i=0;$i<count($tableau["items"]); $i++){    
        $playlist = new Playlist();
        if(isset($tableau["items"][$i]["id"])){
            $playlist->setId($tableau["items"][$i]["id"]);
            $playlist->setTitre($tableau["items"][$i]["snippet"]["title"]);
            // enle ver T et Z de la date
            $date = str_replace("T", " ", $tableau["items"][$i]["snippet"]["publishedAt"]);
            $date = str_replace("Z", "", $date);
            $date = str_replace(".000", "", $date);
            $playlist->setDate($date);
            $playlist->setMiniature($tableau["items"][$i]["snippet"]["thumbnails"]);

            // Ajout playlist à la liste
            $liste[] = $playlist;
        }
    }
    

    $param["liste"] = $liste;

?>