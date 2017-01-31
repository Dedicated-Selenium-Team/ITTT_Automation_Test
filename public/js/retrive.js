$(document).ready(function () { 
//  $(window).scroll(function(){ 
//   if ($(this).scrollTop() > 100) { 
//     $('#scroll').fadeIn(); 
//   } else { 
//     $('#scroll').fadeOut(); 
//   }  
// }); 

$('.dt-buttons').append('<span>Download</span>');

$('#scroll').click(function(){ 
  $("html, body").animate({ scrollTop: 0 }, 600); 
  return false; 
}); 
$( function() {
  $( "#sortable1, #sortable2" ).sortable({
    connectWith: ".connectedSortable"
  }).disableSelection();
} );

$( "#tabs" ).tabs();

  // This will make Input Disabled for Estimation and Planning Page for user
  $(".user input:not(.warranty-text)").prop('disabled', true);

  $(".user .estimation input").addClass('background-inherit');
  
  $("body").addClass("remove-padding");

  $(".login-form-wrapper").closest('main').parent('body').addClass('login-form-page');

  // code for changing the color of first option of select starts here //
  if($('#select_project').val() != 0) {
    $('#select_project').addClass('color-nonzero');
  }
  else {
    $('#select_project').removeClass('color-nonzero');
  }

  $('select').on('change', function(){
    var $this = $(this);
    if ($this.val() != 0) {
      $this.addClass('noValue');

    } else {
      $this.removeClass('noValue');
      $this.removeClass('color-nonzero');
    }
  });
  // code for changing the color of first option of select ends here //

  // code for adding note on click input field //
  $('.helper').on('focus',function(){
    $(this).siblings('.note').addClass('disp-note');
  });
  $('.helper').on('focusout',function(){
    $(this).siblings('.note').removeClass('disp-note');
  });
  // code for adding note on click input field //

  // On Hamburger open Menu functionality starts here
  $('.hamb-cross').hide();
  $('.hamb').on('click',function(e){
    e.preventDefault();
    $('.navigation-menu').addClass("displayBlock");
    $('.navigation-menu').removeClass("display");
    $('.hamb-cross').show();
    $(this).hide();
    $(this).parent().parent().addClass("menu-shadow");
  });
  // On Hamburger open Menu functionality Ends here
  
  // On Cross Button Hide Menu functionality starts here
  $('.hamb-cross').on('click',function(e){
    e.preventDefault();
    $('hamb-cross').hide();
    $('.navigation-menu').addClass("display");
    $('.navigation-menu').removeClass("displayBlock");
    $('.hamb').show();
    $(this).hide();
    $(this).parent().parent().removeClass("menu-shadow");
  });
  // On Cross Button Hide Menu functionality Ends here

  // Hide menu on Eascape Button functionality Starts here
  document.onkeydown = function( evt ) {
    if (evt.keyCode == 27) {
      $(".hamb-cross").trigger("click");
    }
  }
  // Hide menu on Eascape Button functionality Ends here

  // Active state for timesheet today's date is starts here //
  var input_date = $(".input-read-only").val();
  var get_Date = new Date(input_date);
  var get_date_str = get_Date.toDateString();
  var get_Today = new Date();
  var get_today_str = get_Today.toDateString();

  if(get_date_str == get_today_str){
    $(".timesheet-header-right .today").addClass("today-hover");
  }

  // Active state for timesheet today's date is ends here //

  // disabled the edit button on timesheet starts here
  var yesterday = new Date(get_Today.getFullYear(), get_Today.getMonth(), get_Today.getDate()-1);
  if(Date.parse(get_Date) <= Date.parse(yesterday)){
    $(".day-table #edit-day-time").prop('disabled', true);
    $(".day-table #delete-day-time").prop('disabled', true);
    $(".day-timesheet #daily-add").prop('disabled', true);
    $(".day-timesheet #daily-add").addClass('disabled');
  }
  else {
    $(".day-table #edit-day-time").prop('disabled', false);
    $(".day-table #delete-day-time").prop('disabled', false);
    $(".day-timesheet #daily-add").prop('disabled', false);
    $(".day-timesheet #daily-add").removeClass('disabled');
  }
  // disabled the edit button on timesheet endss here

  // Active state for navigation is starts here //
  current_page = document.location.href            
  if (current_page.match(/store_project/)) {
    $(".navigation-menu .all-projects a").addClass('nav-active');
  } else if (current_page.match(/admin/)) {
    $(".navigation-menu .user").addClass('nav-active');
  } else if (current_page.match(/time-management/)) {
    $(".navigation-menu .time-sheet a").addClass('nav-active');
  } else if (current_page.match(/my-projects/)) {
    $(".navigation-menu .my-projects a").addClass('nav-active');
  } else if (current_page.match(/project-designation/)) {
    $(".navigation-menu .all-projects a").addClass('nav-active');
  }else if (current_page.match(/myself/)) {
    $(".navigation-menu .all-projects a").addClass('nav-active');
  } else { 
    $(".navigation-menu  li a").removeClass('nav-active');
  };
  // Active state for navigation is ends here //

  // Add tooltip to span inside all projects tab ends here// 

  // This will triger during edit planning and Edit Estimation page 
  // Starts here
  if ($('.edit-estimation-form').length > 0) {
    $("#resources").trigger("keyup");
    $(".warranty_period").trigger("keyup");
    $(".require_gather").trigger("keyup");
    $(".design").trigger("keyup");
    $(".backend_development").trigger("keyup");
    $(".frontend_development").trigger("keyup");
    $(".testing").trigger("keyup");
    $(".final_development").trigger("keyup");
    $(".deployment").trigger("keyup");
    $(".timelineDays").trigger("keyup");
    $(".wtot").trigger("keyup");

  }
  // Ends here

  // This will now allow user to enter chareter in input box 
  // Starts here
  $('.numericValidation input').keypress(function (e) {
   $(this).attr('maxlength','4');
   if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
    event.preventDefault();
  }
});

  // Ends here
    // This will calculate the larges height of project LI
    var max = -1;
    $(".wrap-project").each(function() {
      var wrap_project_height = $(this).children('.count_name').height();
      max = wrap_project_height > max ? wrap_project_height : max;
    });
    $('.wrap-project .count_name').css('height',max);

  // Code to restrict the dates selection on estimation and planning pages starts here //
  $( ".datepicker" ).datepicker({ 
   dateFormat: 'dd/mm/yy',
   changeMonth: true,
   changeYear: true
 });

  var start_date = $('#project-start-date').val();
  $('#phase-I-end-date').datepicker('option', 'minDate', start_date);
  $('#phase-II-end-date').datepicker('option', 'minDate', start_date);
  // Code to restrict the dates selection on estimation and planning pages starts here //
  
  // this will restrict the user on enter button
  $('.addProject').on({
    focus: function () {
      $(this).blur();
    }
  });   
  var hours = dayTotalHrs(2,'.day-table');
  $('.table-timesheet .time-details .tot-hours').text(hours['total_hrs']);
  $('.table-timesheet .time-details .free-time').text(hours['free_time']);

  $( ".count_name" ).hover(
    function() {
      $( this ).parent('.wrap-project').addClass( "shadow-hover" );
    }, function() {
      $( this ).parent('.wrap-project').removeClass( "shadow-hover" );
    }
    );

});

$( window ).load(function() {
  $("#chkWarranty").trigger("change");
});

$(document).mouseup(function (e)
{
  var container = $(".nav-content");
    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
      $('.hamb-cross').hide();
      $('.hamb').show();
      $('.navigation-menu').addClass("display");
      $('.nav-content').removeClass("menu-shadow");
    }
  });


///////////////////////////////////////////////////////////////////////////
///// Validation strats here
///////////////////////////////////////////////////////////////////////////
$( document ).ready(function() {
 /* Form validation start */
 var validation = {
  'email': {
    'required': true
    , 'regX': /^[^?<>*{}]+(?:\.[^?<>*{}]+)*@(?:[^?<>*{}]+\.)+[a-zA-Z ]{1,}$/
  }
  , 'password': {
    'required': true
    , 'regX': /^[^?<>*]*$/
    ,'minlen': 6
    ,'maxlen': 20
  }
  , 'fname': {
    'required': true
    , 'regX': /^[^?<>*]*$/
  }
  , 'lname': {
    'required': true
    , 'regX': /^[^?<>*]*$/
  }
  , 'designation': {
    'required': true
    , 'dropdown': 0
  }
  , 'qualification': {
    'required': true
    , 'regX': /^[^?<>*]*$/
  }
  , 'address': {
    'required': true
    , 'regX': /^[^?<>*]*$/
  }
  , 'mobile_no': {
    'required': true
    , 'regX': /^[^?<>*a-zA-Z]*$/
    ,'minlen':6
    ,'maxlen':20
  }
  , 'alt_no': {
    'required': true
    , 'regX': /^[^?<>*a-zA-Z]*$/
    ,'minlen':6
    ,'maxlen':20
  }
  , 're-password': {
    'required': true
    , 'matchWith': '#password'
    ,'regX': /^(?=.*[A-Za-z])(?=.*\d)(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{4,}$/
  }
  , 'role': {
    'required': true
    , 'dropdown': 0
  }
  , 'joining_date': {
    'required': true
    , 'regex': /^[^?<>*]*$/
  }
  , 'client_name': {
    'required': true,
    'regX': /^[^?<>*]*$/
  }
  , 'project_name1': {
    'required': true,
    'regX': /^[^?<>*]*$/
  }
  , 'project': {
    'required': true
    , 'dropdown': 0
    // , 'regex': /^[^?<>*]*$/
  }
  , 'project_desig': {
    'required': true
    , 'dropdown': 0
    // , 'regex': /^[^?<>*]*$/
  }
  , 'comments': {
    'maxlen':1000
  }
  , 'select_project': {
    'required': true
    , 'dropdown': 0
    // , 'regex': /^[^?<>*]*$/
  }
  , 'select_designation': {
    'required': true
    , 'dropdown': 0
    // , 'regex': /^[^?<>*]*$/
  }
  , 'project_name': {
    'required': true
    , 'dropdown': 0
    // , 'regex': /^[^?<>*]*$/
  }
}
var errorMessage = {
  'email': {
    'required': 'Please enter your email address'
    , 'regX': 'Please enter a valid email address'
  }
  , 'password': {
    'required': 'Please enter your password'
    , 'regX': 'Please enter a valid Password'
    ,'minlen': 'Password should contain at least 6 characters'
    ,'maxlen':'Password should not contain more than 20 characters'
  }
  , 'fname': {
    'required': 'Please enter your first name'
    , 'regX': 'Please enter a valid first name'
  }
  , 'lname': {
    'required': 'Please enter your last name',
    'regX': 'Please enter a valid last name'
  }
  , 'designation': {
    'required': 'Please select your designation'
    , 'dropdown': 'Please select your designation'
  }
  , 'qualification': {
    // 'required': 'Please enter your qualification',
    'regX': 'Please enter a valid qualification'
  }
  , 'address': {
    // 'required': 'This is required field',
    'regX': 'Please enter a valid address'
  }
  , 'mobile_no': {
    // 'required': 'Please enter your phone number',
    'regX': 'Please enter a valid phone number'
    ,'minlen':'Contact number should contain at least 6 numbers'
    ,'maxlen':'Contact number should not contain more than 20 numbers'
  }
  , 'alt_no': {
    // 'required': 'Please enter your phone number',
    'regX': 'Please enter a valid phone number'
    ,'minlen':'Alternate number should contain at least 6 numbers'
    ,'maxlen':'Alternate number should not contain more than 20 numbers'
  }
  , 're-password': {
    'required': 'Please confirm your password'
    , 'matchWith': 'The passwords entered do not match'
  }
  , 'role': {
    'required': 'Please select role'
    , 'dropdown': 'Please select role'
  }
  ,'joining_date': {
    'required': 'Please select the date and time'
  }
  , 'client_name': {
    'required': 'Please enter client name',
    'regX': 'Please enter valid client name'
  }
  , 'project_name1': {
    'required': 'Please enter project name',
    'regX': 'Please enter valid project name'
  }
  , 'project': {
    'required': 'Please select project name'
    , 'dropdown': 'Please select project name'
  }
  , 'project_desig': {
    'required': 'Please select project designation'
    , 'dropdown': 'Please select project designation'
  }
  , 'comments': {
   'maxlen': 'Task should not contain more than 1000 characters'
 }
 , 'select_project': {
  'required': 'Please select project name'
  , 'dropdown': 'Please select project name'
}
, 'select_designation': {
  'required': 'Please select designation'
  , 'dropdown': 'Please select designation'
}
, 'project_name': {
  'required': 'Please enter project name'
  , 'dropdown': 'Please select project name'
}
, 'hours': {
  'required': 'Please fill the hours you need field'
}
}
var $dropdownToValidate = $('#frm-create-user select, #project-day-time select, #assign-project select, #project-designation select');
var $formToValidate = $('#frm-create-user, #add-project, .login-form-page form, #assign-project, #project-designation');
var $fieldsToValidate = $('#frm-create-user input, #add-project input, .login-form-page input, #project-day-time input, #project-day-time textarea');
var $ignoreFields = $('.add-user-btn, #add-project #project_code, input[type="hidden"], select[multiple="multiple"], #volume, #priority');

$fieldsToValidate.not($ignoreFields).on('focus', function() {
  $(this).siblings('.error').text('').hide();
});
$fieldsToValidate.not($ignoreFields).on('blur change', function() {
  try{
    var $this = $(this);
    var isError = false;
    var val = $this.val().trim();
    var $err = $this.siblings('.error');
    var patterValidation = validation[$this.prop('id')].hasOwnProperty('regX');
    var emptyValidation = validation[$this.prop('id')].hasOwnProperty('required') && validation[$this.prop('id')].required;
    var matchPassValidation = validation[$this.prop('id')].hasOwnProperty('matchWith') && $(validation[$this.prop('id')].matchWith);
    var minlengthValidation = validation[$this.prop('id')].hasOwnProperty('minlen');
    var maxlengthValidation = validation[$this.prop('id')].hasOwnProperty('maxlen');
    /* Check whether field is empty or not */
    if(emptyValidation && !val) {
      $err.text(errorMessage[$this.prop('id')].required).show();
      isError = true;
    }
    /* Check whether field valide against required pattern */
    if(patterValidation && !val.match(validation[$this.prop('id')].regX) && !isError) {
      $err.text(errorMessage[$this.prop('id')].regX).show();
      isError = true;
    }
    /* Check for password match */
    if(matchPassValidation && val !== $(validation[$this.prop('id')].matchWith).val().trim() && isError) {
      $err.text(errorMessage[$this.prop('id')].matchWith).show();
      isError = true;
    }
    /* Check for minimum length */
    if(minlengthValidation && (val.length < validation[$this.prop('id')].minlen) && !isError) {
      $err.text(errorMessage[$this.prop('id')].minlen).show();
      isError = true;
    }
    /* Check for maximum length */
    if(maxlengthValidation && (val.length > validation[$this.prop('id')].maxlen) && !isError) {
      $err.text(errorMessage[$this.prop('id')].maxlen).show();
      isError = true;
    }

    if(!isError) {
      $err.text('').hide();
    }
  }
  catch(err) { }
});
$dropdownToValidate.not($ignoreFields).on('change', function() {
  try{
    var $this = $(this);
    var isError = false;
    var val = $this.val().trim();
    var $err = $this.siblings('.error');
    var dropdownValidation = validation[$this.prop('id')].hasOwnProperty('dropdown');
    var selectedIndex = (dropdownValidation) ? $this.find('option:selected').index() : 0;
    /* Check whether valid option from dropdown selected or not */
    if(dropdownValidation && selectedIndex === validation[$this.prop('id')].dropdown && !isError) {
      $err.text(errorMessage[$this.prop('id')].dropdown).show();
      isError = true;
    }
    if(!isError) {
      $err.text('').hide();
    }
  }
  catch(err) { }
});
$dropdownToValidate.not($ignoreFields).on('blur', function() {
  try{
    var $this = $(this);
    var isError = false;
    var val = $this.val().trim();
    var $err = $this.siblings('.error');
    var dropdownValidation = validation[$this.prop('id')].hasOwnProperty('dropdown');
    var selectedIndex = (dropdownValidation) ? $this.find('option:selected').index() : 0;
    /* Check whether valid option from dropdown selected or not */
    if(dropdownValidation && selectedIndex === validation[$this.prop('id')].dropdown && !isError) {
      $err.text(errorMessage[$this.prop('id')].dropdown).show();
      isError = true;
    }
    if(!isError) {
      $err.text('').hide();
    }
  }
  catch(err) { }
});

var dynamicElements = '#hrs_locked';
$(document).on('focus', dynamicElements, function() {
  $(this).siblings('.error').text('').hide();
});


$(document).on('blur change', dynamicElements, function() {
  var regX = /^[0-9]{0,2}([:.][0-9]{1,2})?$/;

  var $this = $(this);
  var $err = $this.siblings('.error');
  var val = $this.val().trim();
  var isError = false;
  if(!val || (val > 16) || (val == 0)) {
    $err.text('Please enter hours to complete a task and it should be less than 16').show();
    isError = true;
  }
  if(!val.match(regX) && !isError) {
    $err.text('Please enter numeric values with two decimal place only').show();
    isError = true;
  }

  if(!isError) {
    $err.text('').hide();
  }
});

$formToValidate.on('submit', function(event) {
  var $this = $(this);
  var isError = false;
  $this.find('input, select, textarea').not($ignoreFields).each(function(index, el) {
    var $el = $(el);
    var type = $el.prop('nodeName');
    if(type === 'INPUT') {
      $el.trigger('change');
      $el.trigger('blur');
    } else if(type === 'SELECT') {
      $el.trigger('change');
      $el.trigger('blur');
    } else if('textarea') {
      $el.trigger('blur');
    }
    if($el.siblings('.error').is(':visible')) {
      isError = true;
    }
  });
  if(isError) {
    event.preventDefault();
  }
  // Dropdown functionality ends here
});

/* Form validation end */

$('.modal-error-off').on('hidden.bs.modal', function () {
 $('.error').text(' ');
});

});

///////////////////////////////////////////////////////////////////////////
///// Validation Ends here
///////////////////////////////////////////////////////////////////////////

$(".timeline-cal input").prop('disabled', true);


$(document).on('keyup', '.hoursNeed', function () {

  var estimate_hrs = Number($('.appHours').val());
  if (estimate_hrs == 0 || estimate_hrs == 'undefined' ) {
    return;
  }else {
    var req_hrs = Number($('.hoursNeed').val()),
    result = Number((req_hrs / estimate_hrs)*100).toFixed(2) ;
    $('.percentHoursNeed').val(result);
  }
});

function showPopup( target ) {
  document.getElementById(target).style.display = 'block';
}

/********************************************************************************/
// This will calculate tot Hour per Day if hour is greter than 13 then,
// it will clear the input box
/********************************************************************************/


$(document).on('keyup', '.hrsLimit', function () {
  getHrs = $(this).val();
  if (getHrs > 13 ) {
    getHrs = $(this).val("");
    $(this).after("<p class='note disp-note'>Hours/Day should not exceed more than 13 hours.</p>")
  }else {
    $(".timelineDays").trigger("keyup");
    $(this).siblings('.note').remove();
  }
});

$(document).on('focusout', '.hrsLimit', function () {
  $(this).siblings('.note').remove();
});

/********************************************************************************/
// This will Calculate the requirement Gathering phase Functionality
/********************************************************************************/

var calculate = new Calculate();


$(document).on('keyup', '.require_gather', function () {
  var storeArray = calculate.getVal('.require_gather'),
  getTimelineDay = storeArray[0],
  getPerUserHour = $(this).val(),
  perHourCalculation = calculate.multiply(getTimelineDay,getPerUserHour),
  perUserPercent = calculate.percent(getPerUserHour),
  effeciveResource = calculate.add(storeArray),
  months = calculate.Months(),
  effeciveDays = calculate.days(storeArray, effeciveResource),
  effeciveHrs = calculate.Hour(effeciveDays);
  $(this).parents('tr').find('span:last').text(perHourCalculation);
  $(this).parents('tr').find('span:first').text(Math.round(perUserPercent)+"%");
  $(".require_gather_effective_resources").text(Number(effeciveResource).toFixed(2));
  $(".require_gather_effective_days_utilezed").text(Number(effeciveDays).toFixed(2));
  $(".require_gather_hrs_cal").text(effeciveHrs);
  $(".require_gather_month").text(months);
});

/********************************************************************************/
// This will Calculate the Design phase Functionality
/********************************************************************************/
var objDesign = new Calculate();
$(document).on('keyup', '.design', function () {
  var storeArray = objDesign.getVal('.design'),
  getTimelineDay = storeArray[0],
  getPerUserHour = $(this).val(),
  perHourCalculation = objDesign.multiply(getTimelineDay,getPerUserHour),
  perUserPercent = objDesign.percent(getPerUserHour),
  effeciveResource = objDesign.add(storeArray),
  months = objDesign.Months(),
  effeciveDays = objDesign.days(storeArray, effeciveResource),
  effeciveHrs = objDesign.Hour(effeciveDays);
  $(this).parents('tr').find('span:last').text(perHourCalculation);
  $(this).parents('tr').find('span:first').text(Math.round(perUserPercent)+"%");
  $(".design_effective_resources").text(Number(effeciveResource).toFixed(2));
  $(".design_effective_days_utilezed").text(Number(effeciveDays).toFixed(2));
  $(".design_hrs_cal").text(effeciveHrs);
  $(".design_month").text(months);
  // var storeTimelineMonths = objDesign.getValText('.timelineMonths');

});
/********************************************************************************/
// This will Calculate the Back End phase Functionality
/********************************************************************************/
var objBeDev = new Calculate();
$(document).on('keyup', '.backend_development', function () {
  var storeArray = objBeDev.getVal('.backend_development'),
  getTimelineDay = storeArray[0],
  getPerUserHour = $(this).val(),
  perHourCalculation = objBeDev.multiply(getTimelineDay,getPerUserHour),
  perUserPercent = objBeDev.percent(getPerUserHour),
  effeciveResource = objBeDev.add(storeArray),
  months = objBeDev.Months(),
  effeciveDays = objBeDev.days(storeArray, effeciveResource),
  effeciveHrs = objBeDev.Hour(effeciveDays);
  $(this).parents('tr').find('span:last').text(perHourCalculation);
  $(this).parents('tr').find('span:first').text(Math.round(perUserPercent)+"%");
  $(".backend_development_effective_resources").text(Number(effeciveResource).toFixed(2));
  $(".backend_development_effective_days_utilezed").text(Number(effeciveDays).toFixed(2));
  $(".backend_development_hrs_cal").text(effeciveHrs);
  $(".backend_development_month").text(months);
});
/********************************************************************************/
// This will Calculate the  Front End phase Functionality
/********************************************************************************/
var objFeDev = new Calculate();
$(document).on('keyup', '.frontend_development', function () {
  var storeArray = objFeDev.getVal('.frontend_development'),
  getTimelineDay = storeArray[0],
  getPerUserHour = $(this).val(),
  perHourCalculation = objFeDev.multiply(getTimelineDay,getPerUserHour),
  perUserPercent = objFeDev.percent(getPerUserHour),
  effeciveResource = objFeDev.add(storeArray),
  months = objFeDev.Months(),
  effeciveDays = objFeDev.days(storeArray, effeciveResource),
  effeciveHrs = objFeDev.Hour(effeciveDays);
 //console.log("FE perHourCalculation---->",getPerUserHour);
 $(this).parents('tr').find('span:last').text(perHourCalculation);
 $(this).parents('tr').find('span:first').text(Math.round(perUserPercent)+"%");
 $(".frontend_development_effective_resources").text(Number(effeciveResource).toFixed(2));
 $(".frontend_development_effective_days_utilezed").text(Number(effeciveDays).toFixed(2));
 $(".frontend_development_hrs_cal").text(effeciveHrs);
 $(".frontend_development_month").text(months);
});



/********************************************************************************/
// This will Calculate the  Testing phase Functionality
/********************************************************************************/
var objTesting = new Calculate();
$(document).on('keyup', '.testing', function () {
  var storeArray = objTesting.getVal('.testing'),
  getTimelineDay = storeArray[0],
  getPerUserHour = $(this).val(),
  perHourCalculation = objTesting.multiply(getTimelineDay,getPerUserHour),
  perUserPercent = objTesting.percent(getPerUserHour),
  effeciveResource = objTesting.add(storeArray),
  months = objTesting.Months(),
  effeciveDays = objTesting.days(storeArray, effeciveResource),
  effeciveHrs = objTesting.Hour(effeciveDays);
  $(this).parents('tr').find('span:first').text(Math.round(perUserPercent)+"%");
  $(this).parents('tr').find('span:last').text(perHourCalculation); 
  $(".testing_effective_resources").text(Number(effeciveResource).toFixed(2));
  $(".testing_effective_days_utilezed").text(Number(effeciveDays).toFixed(2));
  $(".testing_hrs_cal").text(effeciveHrs);
  $(".testing_month").text(months);
});
/********************************************************************************/
// This will Calculate the  Final Development phase Functionality
/********************************************************************************/
var objFinalDep = new Calculate();
$(document).on('keyup', '.final_development', function () {
  var storeArray = objFinalDep.getVal('.final_development'),
  getTimelineDay = storeArray[0],
  getPerUserHour = $(this).val(),
  perHourCalculation = objFinalDep.multiply(getTimelineDay,getPerUserHour),
  perUserPercent = objFinalDep.percent(getPerUserHour),
  effeciveResource = objFinalDep.add(storeArray),
  months = objFinalDep.Months(),
  effeciveDays = objFinalDep.days(storeArray, effeciveResource),
  effeciveHrs = objFinalDep.Hour(effeciveDays);
  $(this).parents('tr').find('span:last').text(perHourCalculation);
  $(this).parents('tr').find('span:first').text(Math.round(perUserPercent)+"%");
  $(".final_development_effective_resources").text(Number(effeciveResource).toFixed(2));
  $(".final_development_effective_days_utilezed").text(Number(effeciveDays).toFixed(2));
  $(".final_development_hrs_cal").text(effeciveHrs);
  $(".final_development_month").text(months);
});

/********************************************************************************/
// This will Calculate the Deployement phase Functionality
/********************************************************************************/
var objDeploy = new Calculate();
$(document).on('keyup', '.deployment', function () {
  var storeArray = objDeploy.getVal('.deployment'),
  getTimelineDay = storeArray[0],
  getPerUserHour = $(this).val(),
  perHourCalculation = objDeploy.multiply(getTimelineDay,getPerUserHour),
  perUserPercent = objDeploy.percent(getPerUserHour),
  effeciveResource = objDeploy.add(storeArray),
  months = objDeploy.Months(),
  effeciveDays = objDeploy.days(storeArray, effeciveResource),
  effeciveHrs = objDeploy.Hour(effeciveDays);
  $(this).parents('tr').find('span:last').text(perHourCalculation);
  $(this).parents('tr').find('span:first').text(Math.round(perUserPercent)+"%");
  $(".deployment_effective_resources").text(Number(effeciveResource).toFixed(2));
  $(".deployment_effective_days_utilezed").text(Number(effeciveDays).toFixed(2));
  $(".deployment_hrs_cal").text(effeciveHrs);
  $(".deployment_month").text(months);
  $(".triggerWarranty").trigger('keyup');
});

/********************************************************************************/
// This will Calculate the Warrenty phase Functionality
/********************************************************************************/

var many_resources = [];
var objWarranty = new Calculate(),
obj = new warrantyCalculation();
$(document).on('keyup', '.warranty_period', function () {
  var storeArray = objWarranty.getVal('.warranty_period'),
  getTimelineDay = storeArray[0],
  getPerUserHour = $(this).val(),
  perHourCalculation = objWarranty.multiply(getTimelineDay,getPerUserHour),
  perUserPercent = objWarranty.percent(getPerUserHour),

  effeciveResource = objWarranty.add(storeArray),
  months = objWarranty.Months(),
  effeciveDays = objWarranty.days(storeArray, effeciveResource),
  effeciveHrs = objWarranty.Hour(effeciveDays),
  tothorus = $(".t2live_hrs_cal").text(),
  toteDays = $(".t2live_effective_days_utilezed").text(),
  totDays = $(".t2live_timeline_days").text(),
  tottime2Live = $(".t2live_timeline_months").text(),
  getInput = $(".wtot").val(),
  calwarantyBackwards = objWarranty.addition(totDays, getInput),
  calwarantyToteDays = objWarranty.addition(tottime2Live, months),
  calwarantyBackwardDays = objWarranty.addition(toteDays, effeciveDays),
  calwarantyBackwardHrs = objWarranty.addition(tothorus, effeciveHrs),
  calwarantyBackwardMonths = objWarranty.addition(tottime2Live, months),
  totwarantymonths = objWarranty.addition(tottime2Live, months),
  eWResourceOverProject = objWarranty.effectiveResourceOverProject(calwarantyBackwards, calwarantyBackwardDays),
  calWBackwards = objWarranty.calbackword(calwarantyBackwards, eWResourceOverProject);
  $(this).parents('tr').find('span:last').text(perHourCalculation);
  $(this).parents('tr').find('span:first').text(Math.round(perUserPercent)+"%");
  $(".warranty_period_effective_resources").text(Number(effeciveResource).toFixed(2));

  $(".warranty_period_effective_days_utilezed").text(Number(effeciveDays).toFixed(2));
  $(".warranty_period_hrs_cal").text(effeciveHrs);
  $(".warranty_period_month").text(months);

  $(".t2live_warranty_timeline_days").text(Math.round(calwarantyBackwards),2);
  $(".t2live_warranty_effective_days_utilezed").text(calwarantyBackwardDays);
  $(".t2livewarranty_hrs_cal").text(calwarantyBackwardHrs);
  $(".t2live_warranty_timeline_months").text(totwarantymonths);
  if (isNaN(eWResourceOverProject)) {
    $(".warranty_backword_effective_days_utilezed").text(0);  
  }else {
    $(".warranty_backword_effective_days_utilezed").text(eWResourceOverProject);
  }
  if (isNaN(calWBackwards)) {
    $(".warranty_backword_timeline_days").text(0.00);  
  }else {
    $(".warranty_backword_timeline_days").text(calWBackwards);
  }
});

///////////////////////////////////////////////////////////////////////////
//// TimelineDays Calculation starts here
///////////////////////////////////////////////////////////////////////////

var totTime = [];
$(document).on('keyup', '.timelineDays', function () {
  var testerInput = $("input[name='phase[Testing/QA ONLY][spent_days]']").val(),
  calculateData = new Calculate(),
  storeArray = calculateData.getVal('.require_gather'),
  effeciveResource = calculateData.add(storeArray),
  months = calculateData.Months(),
  effeciveDays = calculateData.days(storeArray, effeciveResource),
  effeciveHrs = calculateData.Hour(effeciveDays),
  storeTimelineDay = calculateData.getVal('.timelineDays'),
  totalDays = calculateData.Total(storeTimelineDay),
  exceptTester = calculateData.removeTester(totalDays, testerInput),
  storeTimelineMonths = calculateData.getValText('.timelineMonths'),
  totalMonths = calculateData.Total(storeTimelineMonths),
  effectiveDays = calculateData.getValText('.eDays'),
  totEffectiveDays = calculateData.Total(effectiveDays),
  perPhaseTotal = calculateData.getValText('.phaseHourCal'),
  totPhaseHours = calculateData.Total(perPhaseTotal),
  eResourceOverProject = calculateData.effectiveResourceOverProject(totEffectiveDays, totalDays),
  calBackwards = calculateData.calbackword(exceptTester, eResourceOverProject);
  $(".effective_resources").text(Number(effeciveResource).toFixed(2));
  $(".effective_days_utilezed").text(Number(effeciveDays).toFixed(2)); 
  $(".hrs_cal").text(effeciveHrs);
  $(".require_gather_month").text(months);
  $(".t2live_effective_days_utilezed").text(totEffectiveDays);
  $(".t2live_timeline_days").text(exceptTester);
  $(".t2live_timeline_months").text(totalMonths);
  $(".t2live_hrs_cal").text(totPhaseHours);
  if (isNaN(eResourceOverProject)) {
    $(".backword_effective_days_utilezed").text(0);  
  }else{
    $(".backword_effective_days_utilezed").text(eResourceOverProject);
  }
  if (isNaN(calBackwards)) {
    $(".backword_timeline_days").text(0.00);  
  }else {
    $(".backword_timeline_days").text(calBackwards);
  }
});

///////////////////////////////////////////////////////////////////////////
//// TimelineDays Calculation Ends here
///////////////////////////////////////////////////////////////////////////
//$(document).on("","",function)
/***************************************************************************************/
// This will Add New Row for perticuler phase TESTING PURPOSE & OOR Example IMP
/***************************************************************************************/
$("#add").on("click", function () {
  var counter = 0;
  name = $("#name").val(),
  res = resources(name);
  many_resources.push(res);
  counter++;
});
var objDate = new Calculate();



/***************************************************************************************/
// This will Calculate the Dates fumctionality of estimation timeline
/***************************************************************************************/
$(document).on('change',"#project-start-date",function () {
  var start_date1 = $(this).val();
  $('#phase-I-end-date').datepicker('option', 'minDate', start_date1);
  $('#phase-II-end-date').datepicker('option', 'minDate', start_date1);
});

$(document).on('change',"#phase-I-end-date",function () {
  var phs1End_date = $(this).val();
  $('#phase-II-end-date').datepicker('option', 'minDate', phs1End_date);
  var getPhaseOneDate = $('#phase-I-end-date').val();
  $('#phase-II-end-date').val(getPhaseOneDate);
});

$(document).on('keyup', '.holiday', function () {
 holday = $(this).val();
 if (holday > 15 ) {
   holday = $(this).val("");
 }else {
   $(".holday").trigger("keyup");
 }
});

$(document).on('keyup', '.warranty-days', function () {
 warnt_day = $(this).val();
 if (warnt_day > 100 ) {
   warnt_day = $(this).val("");
 }else {
   $(".holday").trigger("keyup");
 }
});

$(document).on('keyup', '.resources', function () {
 resources_day = $(this).val();
 if (resources_day > 15 ) {
   resources_day = $(this).val("");
 }
});

$(document).on("bind keyup change", '.phaseCalculation', function () {
  var startDate = $('.startDate').val(),
  phaseOneDate = $('.p1Date').val(),
  phaseTwoDate = $('.p2Date').val(),
  warranty_days = $('.warranty-days').val(),
  totHolidays = $('.holiday').val();
  getwarrantyDate = $('#warrantyDate').val();

  if(warranty_days == '')
  {
    warranty_days=0;
  }
  if(totHolidays =='')
  {
    totHolidays=0;
  }

  var warrenty_end_date=$('#Warrenty-period-end').val();

  var resource = $('.resources').val(),
  p1goLive = objDate.datecalculate(startDate, phaseOneDate,warranty_days,totHolidays),
  warrantyDate = objDate.addWarranty(phaseTwoDate,warranty_days,totHolidays),
  overalldays = objDate.timelineOverallDay(startDate,warrantyDate,totHolidays),  
  monthEqi = objDate.eqiMonths(overalldays),
  hourEqi = objDate.Hour(overalldays),
  effectiveTotDays = objDate.calbackword(overalldays, resource),
  effectiveTotHrs = objDate.calbackword(hourEqi, resource);

  document.getElementById("phase-II-end-date").value = phaseTwoDate;
  document.getElementById("p1-go-live").value = p1goLive;
  document.getElementById("timelineDays").value = overalldays;
  document.getElementById("timelineMonths").value = monthEqi;
  document.getElementById("timelineHours").value = hourEqi;
  document.getElementById("timelineTotDays").value = effectiveTotDays;
  document.getElementById("timelineTotHours").value = effectiveTotHrs;

  if (warrantyDate == 'aN/aN/NaN') {
    $('#Warrenty-period-end').attr("placeholder", "dd/mm/yyyy");
    $('.pro-date-calulation-table input').val('0');
  } else {
    document.getElementById('Warrenty-period-end').value =warrantyDate ;
    $( "input[name*='Warrenty-period-end']" ).val(warrantyDate);
  }
});

var totForWarranty = new Calculate();

$(document).on("keyup", '.pm-hrs', function () {
  var getData = totForWarranty.getValText('.pm-calc-hrs'),
  tot = totForWarranty.totDesignation(getData),
  getLastValue = getData[(getData.length)-1],
  chkwarrantyvalue = $('#chkWarranty').is(':checked');

  if(chkwarrantyvalue){
    $('.tot-pm').text(Number(tot).toFixed(2));
  } else {
    $('.tot-pm').text(Number(tot-getLastValue).toFixed(2));
  }

});

$(document).on("keyup", '.designer-hrs', function () {
  var getData = totForWarranty.getValText('.designer-calc-hrs'),
  tot = totForWarranty.totDesignation(getData),
  getLastValue = getData[(getData.length)-1];

  $('.tot-designer').text(Number(tot).toFixed(2));

});

$(document).on("keyup", '.be_developer-hrs', function () {
  var getData = totForWarranty.getValText('.be_developer-calc-hrs'),
  tot = totForWarranty.totDesignation(getData),
  getLastValue = getData[(getData.length)-1],
  chkwarrantyvalue = $('#chkWarranty').is(':checked');

  if(chkwarrantyvalue){
    $('.tot-bed').text(Number(tot).toFixed(2));
  } else {
    $('.tot-bed').text(Number(tot-getLastValue).toFixed(2));
  }
});

$(document).on("keyup", '.fe_developer-hrs', function () {
  var getData = totForWarranty.getValText('.fe_developer-calc-hrs'),
  tot = totForWarranty.totDesignation(getData),
  getLastValue = getData[(getData.length)-1],
  chkwarrantyvalue = $('#chkWarranty').is(':checked');

  if(chkwarrantyvalue){
    $('.tot-fed').text(Number(tot).toFixed(2));
  } else {
    $('.tot-fed').text(Number(tot-getLastValue).toFixed(2));
  }
});

$(document).on("keyup", '.lead-hrs', function () {
  var getData = totForWarranty.getValText('.lead-calc-hrs'),
  tot = totForWarranty.totDesignation(getData),
  getLastValue = getData[(getData.length)-1];

  $('.tot-tech-lead').text(Number(tot).toFixed(2));

});

$(document).on("keyup", '.tester-hrs', function () {
  var getData = totForWarranty.getValText('.tester-calc-hrs'),
  tot = totForWarranty.totDesignation(getData),
  getLastValue = getData[(getData.length)-1],
  chkwarrantyvalue = $('#chkWarranty').is(':checked');

  if(chkwarrantyvalue){
    $('.tot-testing').text(Number(tot).toFixed(2));
  } else {
    $('.tot-testing').text(Number(tot-getLastValue).toFixed(2));
  }
});

var warrantyTest = new Calculate();
$(document).on("change","#chkWarranty",function(){
  $(".pm-hrs").trigger("keyup");
  $(".be_developer-hrs").trigger("keyup");
  $(".fe_developer-hrs").trigger("keyup");
  $(".tester-hrs").trigger("keyup");
  $(".lead-hrs").trigger("keyup");
});

$(function () {
  $("body").on('DOMSubtreeModified', ".totDesignationHrs", function () {
    var getData = totForWarranty.getValText('.totDesignationHrs'),
    tot = totForWarranty.totDesignation(getData);
    $('.tot-desig-hours').text(Number(tot).toFixed(2));
  });
});

var many_phases = [];
var obj = new phases();
$(document).on("click","#desig",function(){
  var selectedPhaseValue = $('#phase option:selected').val();                                                            
  var selectedDesigValue = $('#ddlDesignaionName option:selected').val();
  var selectedPhaseName = $('#phase option:selected').text();
  var selectedDesigName = $('#ddlDesignaionName option:selected').text();
  var a = obj.setname(selectedDesigName,selectedPhaseName);
  var row = obj.createResource(selectedPhaseValue,selectedDesigValue);
  

  $(".light-orange").each(function(){
    var getPhaseID = $('th:first', $(this)).attr("data-phase-id");
    if (getPhaseID == selectedPhaseValue ) {
      $('[data-phase-id="'+(parseInt(getPhaseID)+1)+'"]').parent().before().css("background-color","yellow");
      $('[data-phase-id="'+(parseInt(getPhaseID)+1)+'"]').next('.light-green').css("background-color","black");
    }else {
      // console.log("Not Hit");
    }
  }); 
});

$(document).on("click", '.sticky-info h3', function () {
  $(this).siblings('p').toggleClass('displayBlock');
});

$(document).mouseup(function (e)
{
  var container = $(".sticky-info");
    if (!container.is(e.target) // if the target of the click isn't the container...
        && container.has(e.target).length === 0) // ... nor a descendant of the container
    {
      $('.sticky-info p').removeClass("displayBlock");
    }
  });

// to display download pdf section
// $(document).click(function(event) {
//   var target = $(event.target);

//   if (target.parent().attr('class').match(/^dt-buttons/)) {
//     $('.dt-buttons a').css('display','block');
//   }
//   else {
//     $('.dt-buttons a').css('display','none');
//   }
// });

