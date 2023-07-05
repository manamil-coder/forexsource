
$(document).ready(function () {
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
});


//scroll down to fixed top navbar
$(document).ready(function () {
    $(window).bind('scroll', function () {

        if ($(window).scrollTop() > 100) {
            $('.main-nav').addClass('fixed-top');
            document.getElementById("my-div").style.backgroundColor = "white";
        } else {
            $('.main-nav').removeClass('fixed-top');
        }
    });
});
$(document).on('show.bs.modal', '.modal', function () {
	$(this).appendTo('body');
});
//navigation bar
$(document).ready(function () {
    $('.menu').click(function () {
        $('.navs').toggleClass('show');
        $('.mirror').toggleClass('show');
    });
    $('.user').click(function () {
        $('.drop').toggleClass('show');
    });
    $('.show-contacts').click(function () {
        $('.res-contact').toggleClass('d-none');
    });
    $('.noti').click(function () {
        $('.dropy').toggleClass('d-none');
    });


    /* dropdown show on top when table responsive */

    $('.table-responsive').on('show.bs.dropdown', function () {
        $('.table-responsive').css("overflow", "inherit");
    });

    $('.table-responsive').on('hide.bs.dropdown', function () {
        $('.table-responsive').css("overflow", "auto");
    })
	// input from history clear javescript
	// $(window).on('load', function () {
	// 	var delayMs = 100; // delay in milliseconds
	
	// 	setTimeout(function () {
	// 		$('#myModal').modal('show');
	// 	}, delayMs);
	// });

});
