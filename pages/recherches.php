<?php
    require("classes/class.Playlist.php");
    require("classes/class.Video.php");
	
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
    $liste = array();
    $listeVideo = array(); 
    // Recherche des playlists pour affichage des choix 
    for($i=0;$i<count($tableau["items"]); $i++){    
        $playlist = new Playlist();
        if(isset($tableau["items"][$i]["id"])){
            $playlist->setId($tableau["items"][$i]["id"]);
            $playlist->setTitre($tableau["items"][$i]["snippet"]["title"]);
            // enle ver T et Z de la date
            $date = str_replace("T", " ", $tableau["items"][$i]["snippet"]["publishedAt"]);
            $date = str_replace("Z", "", $date);
            $playlist->setDate($date);
            $playlist->setMiniature($tableau["items"][$i]["snippet"]["thumbnails"]);

            // Ajout playlist à la liste
            $liste[] = $playlist;
        }
    }
 
    // Validation recherche
    if(isset($_POST["valider"])){
        $listeTag = array();

        foreach ($_POST as $clef => $valeur){
            if($valeur == "on"){
//echo "key : ".$clef." - ".$valeur."<br/>";
                $listeTag[] = $clef;
            }            
        }
/*        
echo "<pre>";
print_r($listeTag);
echo "</pre>";       
*/        
        // Recherche des vidéos à partir des playlists sélectionnées
        // VIDEOS DES PLAYLISTS -----------------------------
        $requete = "";
        for($i=0;$i<count($listeTag); $i++){    
//echo "playlistId : ".$liste[$i]->getId()."<br/>";  
            if($i == count($listeTag)-1){
                $requete .= $listeTag[$i];                
            }else{
                $requete .= $listeTag[$i]." & ";                                
            }
        } 
//echo "Requete : ".$requete."<BR/>";  

       
        for($i=0;$i<count($listeTag); $i++){    
            $requete2 = $adresse."playlistItems?part=snippet&maxResults=50&playlistId=".$listeTag[$i]."&key=".$key;
            $response2 = file_get_contents($requete2);
 
            $tabVideo = json_decode($response2, true);
/*        
echo "<pre>";
print_r($tabVideo);
echo "</pre>";           
*/
            for($j=0;$j<count($tabVideo["items"]); $j++){    
                $video = new Video();

                $video->setId($tabVideo["items"][$j]["snippet"]["resourceId"]["videoId"]);
                $video->setTitre($tabVideo["items"][$j]["snippet"]["title"]);
                // enlever T et Z de la date
                $date = str_replace("T", " ", $tabVideo["items"][$j]["snippet"]["publishedAt"]);
                $date = str_replace("Z", "", $date);
                $video->setDate($date);
                $video->setDescription($tabVideo["items"][$j]["snippet"]["description"]);
                $video->setMiniature($tabVideo["items"][$j]["snippet"]["thumbnails"]);
                $video->setPlaylist($tabVideo["items"][$j]["snippet"]["playlistId"]);
                $video->setChannel($tabVideo["items"][$j]["snippet"]["channelId"]);

                $listeVideo[] = $video;
            }
        }
        
          // Comme les vidéos peuvent être sur plusieurs playlist, on élimine les doublones
            $temp = array();
            $cpt=0;
            for($j=0;$j<count($listeVideo); $j++){   

                $trouve = false;
                for($k=0;$k<count($temp); $k++){   
                    if($temp[$k]->getId() == $listeVideo[$j]->getId()){
                        $trouve = true;
                    }
                }
                if(!$trouve){
                    $temp[$cpt] = $listeVideo[$j];
                    $cpt++;
                }

            }

            $listeVideo = $temp;
        
    }
    
    $param["liste"] = $liste;
    $param["listeVideo"] = $listeVideo;


 ?>