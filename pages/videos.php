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
    
// PLAYLISTS DU CHANNEL -----------------------------
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
    
    
  
// VIDEOS DES PLAYLISTS -----------------------------
    // Recherche des vidéos de chaque playlist
    $listeVideo = array();   
    for($i=0;$i<count($liste); $i++){    
 
        $requete2 = $adresse."playlistItems?part=snippet&maxResults=50&playlistId=".$liste[$i]->getId()."&key=".$key;
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
            $date = str_replace(".000", "", $date);
            $video->setDate($date);
            $video->setDescription($tabVideo["items"][$j]["snippet"]["description"]);
            $video->setMiniature($tabVideo["items"][$j]["snippet"]["thumbnails"]);
            $video->setPlaylist($tabVideo["items"][$j]["snippet"]["playlistId"]);
            $video->setChannel($tabVideo["items"][$j]["snippet"]["channelId"]);
//echo $video->getTitre()." - Date : ".$video->getDate()."<br>";  
            $listeVideo[] = $video;
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
    
/*          
echo "<pre>";
print_r($listeVideo);
echo "</pre>";
echo "================================<br/>"; 
*/    
$param["liste"] = $listeVideo;

?>