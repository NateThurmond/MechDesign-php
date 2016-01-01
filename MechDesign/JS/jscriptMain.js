
$(document).ready(function() {
    
    $('div').removeClass('highlighted');

    var pageWidth = $(window).width();
    var pageHeight = $(window).height();
    
    if (pageWidth > 1266) {
        $('#navBar').css('width', pageWidth-236);
        $('#footer').css('width', pageWidth-15);
        $('#main').css('width', pageWidth-245);
    }
    
    if (pageHeight > 816) {
        $('body').css('height', pageHeight);
        $('#sidebar').css('height', 700+(pageHeight-816));
        $('#main').css('height', 698+(pageHeight-816));
    }
    
    if ( $('#loginInfo').css('display') === 'block' ) {
        
        setTimeout(function() {
            
            $('#loginInfo').toggle('slow');
        },6000); 
    }
    
    $('.registerButton').click(function() {

        $( "#registerBox" ).fadeToggle( "slow");
        
        $('input[type=text]').each(function(){
          $('#registerName').val('');
          $('#myusername').val('');
          $('#registerEmail').val('');
          $('#registerPassword').val('');
          $('#mypassword').val('');
          $('#confirmPassword').val('');
          $('.registerError').empty();
      });        
    });
    
     $('.navBarLink').hover(
        function() {
            if (!$('#navBar').hasClass('blur') ) {
                $(this).addClass('highlighted'); }
        },
        function() {
            if (!$('#navBar').hasClass('blur') ) {
                $(this).removeClass('highlighted'); }
        }
    );
    
    $('.navButtons').mouseenter(function() {
        
        if (!$('#navBar').hasClass('blur') ) { 
            $(this).addClass('highlighted'); 
        }
    });
    
    $('.navButtons').mouseleave(function() {
        $(this).removeClass('highlighted');
    });
     
    /*  I MAY NOT NEED THIS - TAKING IT OUT FOR NOW
    $('.navButtons').mouseleave(function() {
        $(this).removeClass('highlighted');
    }); */
   
   $('.nav0').mouseenter(function() {
       if (!$('#navBar').hasClass('blur') ) {
        $('.ul-1').hide(0);
        $('.ul-2').hide(0); }
    });
   $('.nav1').mouseenter(function() {
        if (!$('#navBar').hasClass('blur') ) { 
        $('.ul-1').slideToggle(0);    // Speed at which the drop down tabs come out - May change later.
        $('.ul-2').hide(0); }
    });
    $('.nav2').mouseenter(function() {
        if (!$('#navBar').hasClass('blur') ) { 
        $('.ul-2').slideToggle(0);    // Speed at which the drop down tabs come out - May change later.
        $('.ul-1').hide(0); }
    });
    $('.nav3').mouseenter(function() {
        $('.ul-1').hide(0);
        $('.ul-2').hide(0);
    });
    $('.nav4').mouseenter(function() {
        $('.ul-1').hide(0);
        $('.ul-2').hide(0);
    });
    $('#navBar').mouseleave(function() {
        $('.ul-1').hide(0);
        $('.ul-2').hide(0);
    });
    
    $('.ul-1').mouseleave(function() {
        $('.ul-1').hide(0);
    });
    $('.ul-2').mouseleave(function() {
        $('.ul-2').hide(0); 
    });
    
    
    $('.tabLinks').hover(
        function() {
            $(this).children().addClass('linkHighlight');
        },
        function() {
            $(this).children().removeClass('linkHighlight');
        }
    );
    
    $('#commentSubmit').click(function() {
        
        var d = new Date();
        var n = d.getDate();
        var y = d.getFullYear();
        var m = d.getMonth();
        var h = d.getHours();
        var min = d.getMinutes();
        
        if (min < 9) {
            min = "0" + min;
        }
        
        var comments = $('textarea[name=comments]').val();
        $('#commentArea').append('<div class="individualComments">' + m + "-" + n + "-" + y + " at " + 
        h + ":" + min + "&nbsp;" + "&nbsp;" + "&nbsp;" + "&nbsp;" + comments + '</div>');

    });
    
});
