(function ($) {
  "use strict";

  // Variables declarations	
	var $wrapper = $('.main-wrapper');
	var $pageWrapper = $('.page-wrapper');
	var $slimScrolls = $('.slimscroll');


  //Header scroll class
  $(window).scroll(function () {
    if ($(this).scrollTop() > 0) {
      $('#header, body').addClass('sticky');
    } else {
      $('#header, body').removeClass('sticky');
    }
  });
  if ($(window).scrollTop() > 100) {
    $('#header, body').addClass('sticky');
  }

  //Menu Icon
  $(document).ready(function () {
    $(".menuIcon").click(function () {
      $(this).toggleClass("active");
      $('body').toggleClass("scroll");
      $('.navbar__inner').toggleClass("toggle");
      $('.navbar__menu').toggleClass("navanimate");
    });
    //Mobile Nav Dropdown
    $(".navbar__menuCarot").click(function () {
      $(this).parent().siblings().find(".navbar__menuCarot").removeClass("active");
      $(this).parent().siblings().find(".dropdownMenu").slideUp(350);
      $(this).parent().find(".dropdownMenu").slideToggle(350);
      $(this).toggleClass("active");
    });
  });


  //Tooltip
  const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
  const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))


  // Page Content Height
	var pHeight = $(window).height();
	$pageWrapper.css('min-height', pHeight);
	$(window).resize(function() {
		var prHeight = $(window).height();
		$pageWrapper.css('min-height', prHeight);
	});
  
  //Sidebar Function
  $(document).on('click', '#toggle_btn', function() {
		if($('body').hasClass('mini-sidebar')) {
			$('body').removeClass('mini-sidebar');
			$('.subdrop + ul').slideDown();
		} else {
			$('body').addClass('mini-sidebar');
			$('.subdrop + ul').slideUp();
		}
		return false;
	});

	$(document).on('mouseover', function(e) {
		e.stopPropagation();
		if($('body').hasClass('mini-sidebar') && $('#toggle_btn').is(':visible')) {
			var targ = $(e.target).closest('.sidebar').length;
			if(targ) {
				$('body').addClass('expand-menu');
				$('.subdrop + ul').slideDown();
			} else {
				$('body').removeClass('expand-menu');
				$('.subdrop + ul').slideUp();
			}
			return false;
		}
	});

  // Sidebar Slimscroll
	if($slimScrolls.length > 0) {
		$slimScrolls.slimScroll({
			height: 'auto',
			width: '100%',
			position: 'right',
			size: '7px',
			color: '#ccc',
			wheelStep: 10,
			touchScrollStep: 100
		});
		var wHeight = $(window).height() - 60;
		$slimScrolls.height(wHeight);
		$('.sidebar .slimScrollDiv').height(wHeight);
		$(window).resize(function() {
			var rHeight = $(window).height() - 60;
			$slimScrolls.height(rHeight);
			$('.sidebar .slimScrollDiv').height(rHeight);
		});
	}

  // Mobile menu sidebar overlay	
	$('body').append('<div class="sidebar-overlay"></div>');
	$(document).on('click', '#mobile_btn', function() {
		$wrapper.toggleClass('slide-nav');
		$('.sidebar-overlay').toggleClass('opened');
		$('html').addClass('menu-opened');
		$('#task_window').removeClass('opened');
		return false;
	});	
	$(".sidebar-overlay").on("click", function () {
			$('html').removeClass('menu-opened');
			$(this).removeClass('opened');
			$wrapper.removeClass('slide-nav');
			$('.sidebar-overlay').removeClass('opened');
			$('#task_window').removeClass('opened');
	});

	// Chat sidebar overlay	
	$(document).on('click', '#task_chat', function() {
		$('.sidebar-overlay').toggleClass('opened');
		$('#task_window').addClass('opened');
		return false;
	});

  




  //Preloader (if the #preloader div exists)
  $(window).on('load', function () {
    if ($('#preloader').length) {
      $('#preloader').delay(100).fadeOut('slow', function () {
        $(this).remove();
      });
    }
  });

  //Back to top button
  var btn = $('.backToTop');
  $(window).scroll(function () {
    var top = 100;
    if ($(window).scrollTop() >= top) {
      btn.addClass('show');
    } else {
      btn.removeClass('show');
    }
  });
  btn.on('click', function (e) {
    e.preventDefault();
    $('html, body').animate({ scrollTop: 0 }, '300');
  });

})(jQuery);



// show password starts
$(".toggle-password").click(function() {
  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
  input.attr("type", "text");
  } else {
  input.attr("type", "password");
  }
});
// show password ends


// date picker
// $(function() {
//   $( ".datepicker" ).datepicker();
// });
// $(function() {
//   $( "#dateJoin" ).datepicker();
// });
if($('.datePicker').length > 0){
  $(function () {
    $(".datePicker").datepicker({ 
          autoclose: true, 
          todayHighlight: true
    })
  //   .datepicker('update', new Date());
  });
}




// manager dropdown
function formatState (state) {
  if (!state.id) { return state.text; }
  var $state = $(
    '<span><img src="' + $(state.element).attr('data-src') + '" class="img-flag" /> ' + state.text + '</span>'
  );
  return $state;
};
if($('.manager').length > 0){
  $('.manager').select2({
    minimumResultsForSearch: Infinity,
    templateResult: formatState,
    templateSelection: formatState
  });
}
if($('.country').length > 0){
  $(".country").select2();
}
// manager dropdown


$('.leaveList ul li a').click(function(){
  $('html, body').animate({
      scrollTop: $( $(this).attr('href') ).offset().top
  }, 500);
  return false;
});



// validations starts
$(document).ready(function($) {
        
  $(".commonForm").validate({
          rules: {
            name: "required",                  
            password: {
                required: true,
                minlength: 6
            },
            Confirmpassword: {
              required: true,
              minlength: 6
            },
            email: {
              required: true,
              email: true,
            },
            date: {
              required: true,
            },
            dapartment: {
              required: true,
            },
            designation: {
              required: true,
            },
            gender: {
              required: true,
            },
            // WhatsApp: {
            //   required: true,
            // },
            WhatsApp: "required",
            city: "required",
           
          },
          messages: {
              name: "Please enter your name",                   
              password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 8 characters long"
              },
              email: "Please enter your email",
              city: "Please enter your city",
              date: "Please select Date",
              dapartment: "Please select department",
              designation: "Please select designation",
              gender: "Please select gender",
              // WhatsApp: "Please Enter Whatsapp number",
          },
           errorPlacement: function(error, element) 
  {
      if ( element.is(":radio") ) 
      {
          error.appendTo( element.parents('.form-group') );
      }
      else 
      { 
          error.insertAfter( element );
      }
   },
          submitHandler: function(form) {
              form.submit();
          }
          
      });
});


$(document).ready(function($) {
        
  $(".personalForm").validate({
          rules: {
            
            gender: {
              required: true,
            },
            // WhatsApp: {
            //   required: true,
            // },
            WhatsApp: "required",
            email: "required",
            city: "required",
            nationality: "required",
            bloodGroup: "required",
            martialStatus: "required",
            martialStatus: "required",
            city: "required",
            state: "required",
            country: "required",
            address: "required",
           
          },
          messages: {
            
              gender: "Please select gender",
              WhatsApp: "Please enter Whatsapp number",
              email: "Please enter email",
              nationality: "Please enter nationality",
              bloodGroup: "Please enter blood group",
              martialStatus: "Please enter martial status",
              city: "Please enter city",
              state: "Please enter state",
              country: "Please select country",
              address: "Please enter address",
          },
           errorPlacement: function(error, element) 
  {
      if ( element.is(":radio") ) 
      {
          error.appendTo( element.parents('.form-group') );
      }
      else 
      { 
          error.insertAfter( element );
      }
   },
          submitHandler: function(form) {
              form.submit();
          }
          
      });
});


$(document).ready(function($) {
        
  $(".emergencyForm").validate({
          rules: {
            name: "required",
            relationship: "required",
            phone: "required",
            email: {
              required: true,
              email: true,
            },
           
          },
          messages: {
            
              name: "Please enter name",
              relationship: "Please enter relationship",
              phone: "Please enter pnone number",
              email: "Please enter email",
          },
           errorPlacement: function(error, element) 
  {
      if ( element.is(":radio") ) 
      {
          error.appendTo( element.parents('.form-group') );
      }
      else 
      { 
          error.insertAfter( element );
      }
   },
          submitHandler: function(form) {
              form.submit();
          }
          
      });
});


$(document).ready(function($) {
        
  $(".joinForm").validate({
          rules: {
            date: "required",
            noticePeriod: "required",
            probationPeriod: "required",
           
          },
          messages: {
            
              date: "Please enter confirmation date",
              noticePeriod: "Please enter notice period",
              probationPeriod: "Please enter probation period",
          },
           errorPlacement: function(error, element) 
  {
      if ( element.is(":radio") ) 
      {
          error.appendTo( element.parents('.form-group') );
      }
      else 
      { 
          error.insertAfter( element );
      }
   },
          submitHandler: function(form) {
              form.submit();
          }
          
      });
});


$(document).ready(function($) {
        
  $(".officialContact").validate({
          rules: {
            redmine: "required",
            discord: "required",
            skype: "required",
           
          },
          messages: {
            
            redmine: "Please enter redmine username",
            discord: "Please enter discord username",
            skype: "Please enter skype id",
          },
           errorPlacement: function(error, element) 
  {
      if ( element.is(":radio") ) 
      {
          error.appendTo( element.parents('.form-group') );
      }
      else 
      { 
          error.insertAfter( element );
      }
   },
      submitHandler: function(form) {
          form.submit();
      }
          
  });
});


$(document).ready(function($) {
        
  $(".familyForm").validate({
          rules: {
            name: "required",
            relation: "required",
            phone: "required",
            address: "required",
           
          },
          messages: {
            
            name: "Please enter name",
            relation: "Please enter relation",
            phone: "Please enter phone no.",
            address: "Please enter address",
          },
           errorPlacement: function(error, element) 
  {
      if ( element.is(":radio") ) 
      {
          error.appendTo( element.parents('.form-group') );
      }
      else 
      { 
          error.insertAfter( element );
      }
   },
      submitHandler: function(form) {
          form.submit();
      }
          
  });
});


$(document).ready(function($) {
        
  $(".educationForm").validate({
          rules: {
            institute: "required",
            startDate: "required",
            completeDate: "required",
            degree: "required",
           
          },
          messages: {
            
            institute: "Please enter institute name",
            startDate: "Please enter starting date",
            completeDate: "Please enter complete date",
            degree: "Please select degree",
          },
           errorPlacement: function(error, element) 
  {
      if ( element.is(":radio") ) 
      {
          error.appendTo( element.parents('.form-group') );
      }
      else 
      { 
          error.insertAfter( element );
      }
   },
      submitHandler: function(form) {
          form.submit();
      }
          
  });
});


$(document).ready(function($) {
  $(document).on('click', '#pills-tab button', function() {
console.log('test');
  });


});
$(document).ready(function($) {
        
  $(".bankForm").validate({
          rules: {
            name: "required",
            bankName: "required",
            account: "required",
            ifsc: "required",
            pan: "required",
           
          },
          messages: {
            
            name: "Please enter name",
            bankName: "Please enter bank name",
            account: "Please enter bank account no.",
            ifsc: "Please enter ifsc code",
            pan: "Please enter PAN card number",
          },
           errorPlacement: function(error, element) 
  {
      if ( element.is(":radio") ) 
      {
          error.appendTo( element.parents('.form-group') );
      }
      else 
      { 
          error.insertAfter( element );
      }
   },
      submitHandler: function(form) {
          form.submit();
      }
          
  });
});



// validations ends







