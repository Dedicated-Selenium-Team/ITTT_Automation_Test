<!-- Add New User Modal Starts Here-->
<div class="modal fade modal-error-off" id="user" role="dialog">
  <div class="modal-dialog" id="ping">

    <!-- Modal content Starts Here-->
    <div class="modal-content">

      <!-- Modal Header Starts Here-->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h1 class="modal-title">User Info</h1>
      </div>
      <!-- Modal Header Ends Here-->

      <!-- Modal Body Starts Here-->
      <div class="modal-body">
        <div class="panel panel-default">
          <div class="panel-body">
            @if (count($errors) > 0)
            <ul>
              @foreach ($errors->all() as $error)
              <li>{!! $error !!}</li>
              @endforeach
            </ul>
            @endif

            <!-- Form Starts here -->
            {!! Form::open(array('url' => 'store-admin-user', 'id' => 'frm-create-user','data-toggle'=>"validator")) !!}
            <div class="row display">
              <div class="col-lg-12 col-sm-12">
                <div class="form-group cf">
                  {!! Form::label('u_id', 'ID') !!}
                  {!! Form::text('u_id', '',array('class' => 'form-control','placeholder' => 'User Id')) !!}
                  {!! $errors->first('fname', '<div>:message</div>') !!}
                  <p class="error"></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-sm-12">
                <div class="form-group cf">
                  {!! Html::decode(Form::label('fname','First Name<span class="required">*</span>:')) !!}
                  {!! Form::text('fname', Input::old('fname'), array('class' => 'form-control','placeholder' => 'First name','required')) !!}
                  {!! $errors->first('fname', '<div>:message</div>') !!}
                  <p class="error"></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-sm-12">
                <div class="form-group cf">
                  {!! Html::decode(Form::label('lname','Last Name<span class="required">*</span>:')) !!}
                  {!! Form::text('lname', Input::old('lname'), array('class' => 'form-control','placeholder' => 'Last name','required')) !!}
                  {!! $errors->first('lname', '<div>:message</div>') !!}
                  <p class="error"></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-sm-12">
                <div class="form-group cf">
                  {!! Html::decode(Form::label('designation','Designation<span class="required">*</span>:')) !!}
                  {!! Form::select('designation', $designation,'null',array('class' => 'form-control','required')); !!}
                  {!! Form::hidden('designation-id', '', array('id' => 'designation-id')) !!}
                  <p class="error"></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-sm-12">
                <div class="form-group cf">
                  {!! Form::label('qualification', 'Qualification:') !!}
                  {!! Form::text('qualification', Input::old('qualification'), array('class' => 'form-control','placeholder' => 'Your qualification')) !!}
                  {!! $errors->first('qualification', '<div>:message</div>') !!}
                  <p class="error"></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-sm-12">
                <div class="form-group cf">
                  {!! Form::label('address', 'Address:') !!}
                  {!! Form::text('address', Input::old('address'), array('class' => 'form-control','placeholder' => 'Your address' )) !!}
                  {!! $errors->first('address', '<div>:message</div>') !!}
                  <p class="error"></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-sm-12">
                <div class="form-group cf">
                  {!! Form::label('mobile_no', 'Contact No:') !!}
                  {!! Form::text('mobile_no', Input::old('mobile_no'), array('class' => 'form-control','placeholder' =>'0000000000' )) !!}
                  {!! $errors->first('mobile_no', '<div>:message</div>') !!}
                  <p class="error"></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-sm-12">
                <div class="form-group cf">
                  {!! Form::label('alt_no', 'Alternate No:') !!}
                  {!! Form::text('alt_no', Input::old('alt_no'), array('class' => 'form-control','placeholder' => '0000000000')) !!}
                  {!! $errors->first('alt_no', '<div>:message</div>') !!}
                  <p class="error"></p>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-lg-12 col-sm-12">
                <div class="form-group cf">
                 {!! Html::decode(Form::label('joining_date','Date of Joining<span class="required">*</span>:')) !!}
                 {!! Form::text('joining_date','',['class' => 'datepicker','placeholder'=>'DD/MM/YYYY','readonly']) !!}
                 {!! $errors->first('joining_date', '<div>:message</div>') !!}
                 <p class="error"></p>
               </div>
             </div>
           </div>
           <div class="row">
            <div class="col-lg-12 col-sm-12">
              <div class="form-group cf">
                {!! Html::decode(Form::label('email','Email Id<span class="required">*</span>:')) !!}
                {!! Form::text('email', Input::old('email'), array('class' => 'form-control','placeholder' => 'abcd@gmail.com','required')) !!}
                {!! $errors->first('email', '<div>:message</div>') !!}
                <p class="error"></p>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="form-group cf">
              <div class="col-lg-6 col-sm-6">
                {!! Html::decode(Form::label('password','Password<span class="required">*</span>:')) !!}
              </div>
              <div class="col-lg-6 col-sm-6">
                {!! Form::password('password',['placeholder' => 'Your password', 'class' => 'form-control','required']) !!}
                <p class="error"></p>
              </div>
              {!! $errors->first('password', '<div>:message</div>') !!}
            </div>
          </div>
          <div class="row">
            <div class="form-group cf">
              <div class="col-lg-6 col-sm-6">
                {!! Html::decode(Form::label('re-password','Confirm Password<span class="required">*</span>:')) !!}
              </div>
              <div class="col-lg-6 col-sm-6">
                {!! Form::password('re-password', ['placeholder' => 'Confirm password', 'class' => 'form-control', 'required']) !!}
                <p class="error"></p>
              </div>
              {!! $errors->first('re-password', '<div>:message</div>') !!}
            </div>
          </div>
          <div class="row">
            <div class="form-group cf">
              <div class="col-lg-6 col-sm-6">
               {!! Html::decode(Form::label('role','Role type<span class="required">*</span>:')) !!}
             </div>
             <div class="col-lg-6 col-sm-6">
              {!! Form::select('role', $roles,'null',array('class' => 'form-control','required'));!!}
              {!! Form::hidden('role-id', '', array('id' => 'role-id')) !!}
              <p class="error"></p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal Body Ends Here-->

  {!! Form::hidden('id', '', array('id' => 'id'))!!}

  <!-- Modal Footer Starts Here -->
  <div class="modal-footer">
    {!! Form::submit('Add', array('class' => 'add-user-btn', 'id' => 'save')) !!}
    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> --}}
  </div>
  <!-- Modal Footer Ends Here -->

</div>
{!! Form::close() !!}
<!-- Form Ends here -->

</div>
</div>
<!-- Add New User Modal Ends Here -->

</body>
<script>
 // $(".user_datepicker").datepicker('setDate', new Date());
</script>
</html>
