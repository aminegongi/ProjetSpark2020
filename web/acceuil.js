$(document).ready(function () {
    setTimeout(function () {
        $(".personageImage").css("display","flex");
    $(".personageImage").addClass("animate__animated").addClass("animate__flipInY");
    },200);
if(user ==""){
    $(".Disc").append("<div class='msg-left animate__animated animate__backInLeft'>Bonjour, je suis l'assistant Ukla.Souhaitez-vous que je vous aide?</div>");
    setTimeout(function(){     $(".Disc").append("<div class='msg-right  oui1 hvr-glow animate__animated animate__backInRight'>D'accord </div>");
        $( ".oui1" ).on( "click", function() {
            $( ".oui1" ).off();$( ".non1" ).off();
            $(".Disc").append("<div class='msg-left animate__animated animate__backInLeft'>Avez-vous des maladies liées à votre alimentation?</div>");
            $(".Disc").append("<div class='msg-right  oui2 hvr-glow animate__animated animate__backInRight'>Oui</div>");
            $(".Disc").append("<div class='msg-right  non2 hvr-glow animate__animated animate__backInRight'>Non, autant que je sache.</div>");

            $( ".oui2" ).on( "click", function() {
                $( ".oui2" ).off();$( ".non2" ).off();
                $(".Disc").append("<a href='"+profile+"'> <div class='msg-left animate__animated animate__backInLeft'>Alors faites-le nous savoir si vous soufrez de quelque chose. cliquez ici !</div></a>");

            });
            $( ".non2" ).on( "click", function() {
                $( ".oui2" ).off();$( ".non2" ).off();
                $(".Disc").append("<a href='"+pathRechAvac+"'> <div class='msg-left animate__animated animate__backInLeft'>Alors je vous porpose tout nos plats</div></a>");

            });
        });
    }, 400);
    setTimeout(function(){    $(".Disc").append("<div class='msg-right  non1 hvr-glow animate__animated animate__backInRight'>Non, je me débrouille tout seul.</div>");
        $( ".non1" ).on( "click", function() {
            $( ".oui1" ).off();$( ".non1" ).off();
            $(".Disc").append("<div class='msg-left animate__animated animate__backInLeft'>Okay! Je serai à votre disposition à tout moment </div>");


        });
    }, 800);


}
else{
    $(".Disc").append("<div class='msg-left animate__animated animate__backInLeft'>Bienvenue de nouveau  @"+user+"!  Que je puisse faire pour vous aujourd'hui ? </div>");
    $(".Disc").append("<a href='"+pathRechAvac+"'><div class='msg-right  hvr-glow animate__animated animate__backInRight'>Recherche Avancée</div></a>");
    $(".Disc").append("<a href='"+pathRechSm+"'><div class='msg-right  hvr-glow animate__animated animate__backInRight'>Recherche Simple</div></a>");

}





});
