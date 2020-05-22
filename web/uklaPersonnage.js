//function ukla
function ukla(msg,gif,timePlay){
    if(isClosed){
        //alert(isClosed);
        isClosed=false;
        $('.ukla').show();
        $('.ukla.animate__animated').addClass('animate__bounceInRight');
        $('.uklaBody').append("<img  src='"+gif+"'>");
        $('.uklaMsg').append(msg);
        setTimeout(() => {
            //Disappear all
            isClosed=true;
            $('.ukla.animate__animated').removeClass('animate__bounceInRight').addClass('animate__bounceOutRight');
            // empty elements after the end of the animation
            setTimeout(() => {$('.uklaBody').empty();$('.uklaMsg').empty(); $('.ukla').hide();$('.ukla.animate__animated').removeClass('animate__bounceOutRight');}, 1000);
        }, timePlay * 1000);
    return true;
    }
    return false;
}
$('.uklaClose').click(function (e) {

    $('.ukla.animate__animated').removeClass('animate__bounceInRight').addClass('animate__bounceOutRight');
    // empty elements after the end of the animation
    setTimeout(() => {$('.uklaBody').empty();$('.uklaMsg').empty(); $('.ukla').hide();$('.ukla.animate__animated').removeClass('animate__bounceOutRight'); isClosed=true;}, 1000);

});


