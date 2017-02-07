@extends('master')

@section('content')

<!-- Login Page wrap-content div Starts Here -->
<div class="wrap-content login-form-wrapper">
 <!-- Login Form Starts Here -->
 {!! Form::open(array('url' => 'login')) !!}

 <div class="form-group cf">
   {!! Html::decode(Form::label('email','Email ID<span class="required">*</span>:')) !!}
   {!! Form::text('email', Input::old('name'), array('class' => 'form-control', 'placeholder' => 'Email')) !!}
   {!! $errors->first('email', '<div class="message">*:message</div>') !!}
   <p class="error"></p>
 </div>

 <div class="form-group cf">
   {!! Html::decode(Form::label('password','Password<span class="required">*</span>:')) !!}
   {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control']) !!}
   <!-- {!! $errors->first('password', '<div class="message">*:message</div>') !!} -->
   <p class="error"></p>
 </div>

 <div class="form-group login cf">
   {!! Form::submit('SIGN IN', array('class' => 'submit-btn','title' =>'Sign In')) !!}
   <span class="message">{{ $error }}</span>
 </div>

 <div class="form-group cf">
  {!! Form::button('Sign in with Google', array('id'=>'customBtn','class' => 'google-login','title' =>'Sign In With Google')) !!}
  <p class="error"></p>
</div>

{!! Form::close() !!}
<!-- Keep me sign in starts here  -->
<!-- <div class=" form-group login-actions">
<span class="login-checkbox">
<input type="checkbox" name="remember" value="First Choice" id="remember" class="field login-checkbox">
<label for="remember" class="choice">Keep me signed in</label>
</span>
</div> -->
<!-- Keep me sign in starts here  -->

<!-- Login Form Ends Here -->
</div>
<!-- Login Page Wrap-content div Ends Here -->
<script type="text/javascript">
 $.ajaxSetup({
   headers : {
     'X-CSRF-Token': $('input[name="_token"]').val()
   }
 });

 $('.login .submit-btn').click(function(){
  var aboveError = $(this).parent().siblings('.form-group').children('.error').text();
  if(aboveError != ''){
    $(this).siblings('.message').hide();
  }
  $(this).parent().siblings('.google-login').children('.message').hide();
});

 var googleUser = {};
 var startApp = function() {
  gapi.load('auth2', function(){
    // Retrieve the singleton for the GoogleAuth library and set up the client.
    auth2 = gapi.auth2.init({
      client_id: '620380754257-266gntdhvq60ekb15k1ruve12iojlan9.apps.googleusercontent.com',
      cookiepolicy: 'single_host_origin',
      // Request scopes in addition to 'profile' and 'email'
      //scope: 'additional_scope'
    });
    attachSignin(document.getElementById('customBtn'));
  });
};

function attachSignin(element) {
  console.log(element.id);
  $('.google-login').click(function(){
    $(this).parent().siblings('.form-group').children('.error').hide();
    $(this).parent().siblings('.form-group').children('.message').hide();
  });
  auth2.attachClickHandler(element, {},
    function(googleUser) {
      var email=googleUser.getBasicProfile().getEmail();
      $.ajax({
       type:'POST',
       data:{'email':email},
       url:'gmaillogin',
       success:function(data)
       {

         if(data.success==1)
           location.href='http://ittt.prdxnstaging2.com';
         else
           // alert("You are not authorized user");
         $(".google-login").siblings('.error').text("You are not authorized user");
       }
     })
    }, function(error) {
      $(".google-login").siblings('.error').text("Something went wrong.Please try again...");
    });
}

startApp();
</script>

@stop

