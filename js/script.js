$(document).ready(function () {

    // Vision d'une video
    // Chargement du fichier de la vidéo
    $(".visionner").click(function(){
        $('#film').attr('src','https://www.youtube.com/embed/'+$(this).attr("id"));
        console.log($(this).attr("id"));                
    });

    // Fermeture de la fenetre de visualisation
    $('#closeFilm').click(function(){
        var film = $('#film').attr('src');
        // Pour arreter le player à la fermeture de la fenetre
        // On vide le film
        $('#film').attr('src','');
        // On le remet si on veut relire la vidéo
        $('#film').attr('src',film);
    });



    // Filtre recherche
    $("#recherche").click(function () {
		var nb = 0;
        // élément sélectionné
        var nom = $("#libRech").val();
//alert("Recherche JQuery : "+nom);        
        $("div .thumbnail").each(function () {			
            if ($(this).hasClass(nom)) {
                $(this).show();
				nb++;
            }else {
                $(this).hide();
            }
        });
		
		if(nb == 1){
			$("div .thumbnail").css("width","200px");
		}
    });

   // RAZ filtrage pour re affichage complet
    $("#raz").click(function() {
        $("div .thumbnail").show();
    });

});


