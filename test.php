<?php
    $requete = "https://www.googleapis.com/youtube/v3/playlists?part=snippet&channelId=UCPbr4ZejUf5y4R5yb_Iqtdg&key=AIzaSyD2AzCTy1I-eA7Wpx6cyxN_MfH9XySqVHM";
    $file = file_get_contents($requete);
    


?>

<!doctype html>
<html>
<head>
<title>Set and retrieve localized metadata for a playlist</title>
</head>
<body>
    <?php
    echo "<pre>";
    print_r($file);
    echo "</pre>";
    ?>
</body>
</html>
