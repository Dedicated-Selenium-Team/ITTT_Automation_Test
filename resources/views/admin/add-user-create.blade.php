@extends('master')
<title>ITTT | Users</title>

@section('content')

<!-- Admin Page Starts Here -->
<div class="admin">

  <!-- Admin Page Heading starts here -->
  <nav class="container-heading cf">
    <ul class="admin-ul">
      <li class="admin-list">
        <span class="admin-menu">users</span>
      </li>
    </ul>
  </nav>
  <!-- Admin Page Heading starts here -->

  <!-- Admin page main content starts here -->
  <div class="admin-info timesheet-content">

    <!-- Add new button starts here -->
    <div class="add-search cf">
      <button type="button" class="btn admin-add-new" id="admin-user" value="add" title="Add New User">ADD NEW</button>
      <input type="text" name="search" id="search" class="form-control search-function" placeholder="Search">
    </div>
    <!-- Add new button Ends here -->

    <!-- Add new user modal included here -->
    @include('admin.new-user')
    <!-- Add new user modal inclusion completed -->

<!-- {!! Form::open( [ 'url' => 'test', 'method' => 'post', 'files' => true ] ) !!}{{ csrf_field() }}
<div class="row">
<div class="col-lg-6">
  <input class="form-control" type="file" name="upload_excel" accept=".xls,.xlsx" required>
  
  <br>
  <input type="submit" class="form-control btn btn-primary" value="Export Contacts">
  </div>
  </div>
{!! Form::close() !!} -->
    <!-- User details table starts here -->
    <table class="user-table">
      <thead>
        <tr class="head-row">
          <th>User Id</th>
          <th>Employee Name</th>
          <th>Email</th>
          <th>Designation</th>
          <th>Date of Joining</th>
          <th>Role</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody class="table-body">
        <?php $count = 1;
        $i           = 0;
        $today = date('Y-m-d');
        ?>
        @foreach ($users_info as $user)
        <tr id="user{{$user->user_id}}">
          <td class="count">{{$count}}</td>
          <td><a href="/time-management/{{$today}}/{{$user->user_id}}" class="emp-name"><span class="name-capital">{{$user->first_name}}</span> <span class="name-capital">{{$user->last_name}}</span></a></td>
          <td>{{$user->username}}</td>
          <td>
            @foreach ($designation as $key => $value)
            @if ($user->UserDetails['designation_id'] == $key)
            {{$value}}
            @endif
            @endforeach
          </td>
          <td id="{{$i}}">{{$details[$i]->joining_date}}</td>
          <td>
            @foreach ($roles as $key => $value)
            @if ($user->role_id == $key)
            {{$value}}
            @endif
            @endforeach
          </td>
          <td>
            <button type="button" class="btn btn-edit edit" id="edit-user" data-id="{{$user->user_id}}">Edit User</button>
          </td>
          <td>
            <button type="button" class="btn btn-delete confirm" id="delete-user" data-id="{{$user->user_id}}" data-toggle="modal" data-target="#confirm-delete">Delete User</button>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
          </td>
        </tr>
        <?php $count += 1;
        $i += 1;?>
        @endforeach
      </tbody>
    </table>
    <!-- User details table starts here -->

    <!-- Admin page main content starts here -->

  </div>
  <!-- Admin Page Ends Here -->

  <!-- Modal for Delete start here -->
  <div class="modal fade delete-modal" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
        </div>
        <div class="modal-body">
          <h5>Confirm Delete</h5>
          <p>Remove entry from this timesheet?</p>
          <p class="debug-url"></p>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> -->
          <a class="btn btn-danger btn-ok" id="btnYes">Delete</a>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Modal for delete ends here -->

<script type="text/javascript">
  $.ajaxSetup({
    headers : {
      'X-CSRF-Token': $('input[name="_token"]').val()
    }
  });
  var datatable=$('.user-table').DataTable({
    "bSort":false,
    "orderable": false,
    "paging": false,
    "searchHighlight": true,
    
    // "scrollY": true
  });
  $('#search').on('keyup', function() {
    var searchstring=$('#search').val();
    var body = $( datatable.table().body() );
    
    body.unhighlight();
    
        //datatable.search(searchstring) ).draw();  
        datatable.search(searchstring).draw();
        body.highlight(searchstring);
      });
  // Create user functionality starts here
  $("#admin-user").on('click',function(e){
    clearForm("#user");
    $('#save').val('Save Entry');
    $("#user").modal('show');
    $('#frm-create-user select').removeClass('noValue');
  });

  // Clear form funcionality starts here
  function clearForm(form)
  {
    $(":input",form).each(function()
    {
      var type = this.type;
      var tag = this.tagName.toLowerCase();
      if (type == 'text' || type == 'password' || tag == 'select')
      {
        this.value = "";
      }
    });
  };
  // Clear form funcionality Ends here
  function AutoNumber(){
   $('table tr').each(function (i) {
    $(this).find('.Count').text(i);
  });
 }
  // Update and Add User Functinality Satrts Here
  $('#frm-create-user').on('submit', function(e){
    e.preventDefault();
    var e_id = $('#u_id').val();
    var form = $('#frm-create-user');
    var frmData = form.serialize();
    var url = form.attr('action');
    var state = $('#save').val();
    var type = 'post';
    var iserror = 0;
    if (state == 'Update Entry') {
      type = 'put';
      url = url + '/' + e_id;
    }

    var pass = $('#frm-create-user #password').val();
    var confirmPass = $('#frm-create-user #re-password').val();
    if(pass != confirmPass){
      $('#frm-create-user #re-password').siblings('.error').text('The passwords entered do not match');
    }

    $(".error").each(function(){
      if ($(this).text().trim().length) {
       iserror++;
     }
   });

    if(iserror > 0){
      e.preventDefault();
    }
    else{

     $.ajax({
      type : type,
      url : url,
      data : frmData,
      success : function(data){
        console.log(data);
        if(data.success==1)
        {
          var role = "";
          if (data.user.role_id == 1) {
            data.user.role_id = "Admin";
          }
          else 
          {
            data.user.role_id = "User";
          }
          var designation = data.user_detail.designation_id;
          switch (designation) {
            case "1":
            data.user_detail.designation_id = "Developer";
            break;
            case "2":
            data.user_detail.designation_id = "Quality Analyst";
            break;
            case "3":
            data.user_detail.designation_id = "Project Manager";
            break;
            case "4":
            data.user_detail.designation_id = "Design team";
            break;
            default:
          }
          var row = '<tr id="user' + data.user.user_id + '">'+
          '<td class="count">'+data.user.user_id +'</td>'+
          '<td>' + '<span class="name-capital">' + data.user.first_name + '</span>' + ' ' +
          '<span class="name-capital">' + data.user.last_name + '</span>' + '</td>'+
          '<td>'+data.user.username +'</td>'+
          '<td>'+data.user_detail.designation_id +'</td>'+
          '<td>' + data.user_detail.joining_date + '</td>' +
          '<td>' + data.user.role_id + '</td>' +
          '<td>' + '<button type="button" class="btn btn-edit edit" id="edit-user" data-id="' + data.user.user_id + '">Edit User</button>' + '</td>' +
          '<td>' + '<button type="button" class="btn btn-delete confirm" id="delete-user" data-id="' + data.user.user_id + '" data-toggle="modal" data-target="#confirm-delete">Delete User</button>' + '</td>'
          '</tr>';
          if (state == 'Save Entry') {
            var addrow = datatable
            .row.add( [data.user.user_id,'<span class="name-capital">' + data.user.first_name + '</span>' + ' ' +
              '<span class="name-capital">' + data.user.last_name + '</span>',data.user.username,data.user_detail.designation_id,data.user_detail.joining_date, data.user.role_id,'<button type="button" class="btn btn-edit edit" id="edit-user" data-id="' + data.user.user_id + '">Edit User</button>','<button type="button" class="btn btn-delete confirm" id="delete-user" data-id="' + data.user.user_id + '" data-toggle="modal" data-target="#confirm-delete">Delete User</button>'] )
            .draw(false);
            $('.user-table tr:last').attr('id','user'+data.user.user_id);
            location.reload();
         // datatable.order([1, 'asc']).draw();
         var index = 0, //0 sets the index as the first row
         rowCount = datatable.data().length-1,
         insertedRow = datatable.row(rowCount).data(),
         tempRow;

         for (var i=rowCount;i>index;i--) {
          tempRow = datatable.row(i-1).data();
          datatable.row(i).data(tempRow);
          datatable.row(i-1).data(insertedRow);
        }
        
    //refresh the page
    //datatable.page(currentPage).draw(false);

         // $('.head-row').eq(0).after(row);
       }
       else {
        $('#user' + data.user.user_id).replaceWith(row);
        location.reload();
      }
      $("#user").modal('hide');
      AutoNumber();
    }
    else
    {
      $("#email").siblings("p").css('display','block');
      $("#email").siblings("p").text("Email already exist");
    }

  }
});
   }
 });

  // Edit User functionality Starts Here
  $('tbody').delegate('.btn-edit', 'click', function(){
    var value = $(this).data('id');
    var url = '{{ URL::to('admin-edit-user') }}';
    $.ajax({
      type : 'get',
      url : url,
      data : {
        'id':value
      },
      headers: {
        'id': value
      },
      success : function(data){
        console.log(data);
        $('#u_id').val(data.user_id);
        $('#fname').val(data.first_name);
        $('#lname').val(data.last_name);
        $('#email').val(data.username);
        if (data.user_details.designation_id == 0 ) {
          $('#designation').val('');
        }
        else {
          $('#designation').val(data.user_details.designation_id);
        }
        $('#qualification').val(data.user_details.qualification);
        $('#address').val(data.user_details.address);
        $('#mobile_no').val(data.user_details.mobile_no);
        $('#alt_no').val(data.user_details.alternate_no);
        $("#password").val('');
        var joining_date_string=data.user_details.joining_date,
        split_array=joining_date_string.split("-");
        var joining_date=split_array[2]+"/"+split_array[1]+"/"+split_array[0];
        $('#joining_date').val(joining_date);
        if (data.role_id == 0 ) {
          $('#role').val();
        }
        else{
          $('#role').val(data.role_id);
        }
        $('#save').val('Update Entry');
        $("#user").modal('show');
      }
    });
  });

  // Delete User functionality Starts Here
  $('tbody').delegate('.btn-delete', 'click', function(e){
    var value = $(this).data('id');
    var url = '{{ URL::to('admin-delete-user') }}';
    var row=$(this).closest('tr');
    $('#btnYes').click(function() {
      $("#confirm-delete").modal('hide');
      $.ajax({
        type : 'post',
        url : url + '/' + value,
        data : {
          'id':value 
        },
        success : function(data){
         datatable
         .row(row)
         .remove()
         .draw();          
         AutoNumber();
       }
     });
    });
  });
</script>
@stop
