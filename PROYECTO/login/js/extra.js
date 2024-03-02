$(document).ready(function(){
 
	$('.ir-arriba').click(function(){
		$('body, html').animate({
			scrollTop: '0px'
		}, 2000);
	});
 
	$(window).scroll(function(){
		if( $(this).scrollTop() > 1000 ){
			$('.ir-arriba').slideDown(300);
		} else {
			$('.ir-arriba').slideUp(300);
		}
	});
/* var altura = $(document).height();
$(window).scroll(function(){
      if($(window).scrollTop() + $(window).height() == altura) {
            alert("Has llegado al final de la página");
      }

});*/

//para poner claro UNEFA
 /*$(window).scroll(function() {
        if ($("#menu-img").offset().top > 56 ) {
            $("#menu-img").addClass("img-transparente");
} else {
$("#menu-img").removeClass("img-transparente");
}

		
      });*/




});



