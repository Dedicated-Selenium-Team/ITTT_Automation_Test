@extends('master')
<title>ITTT | My Projects</title>

@section('content')

<!-- My Projects container data starts here -->
<div class="project-list">

  <!-- My projects header starts here -->
  <div class="container-heading cf">
    <a href="/myself" title="Add Myself To A Project" class="assign-project">Add myself to a project</a>
  </div>
  <!-- My projects header ends here -->

  <!-- My projects content starts here -->
  <div class="project-snipet content-min-height">

    <!-- List of assigned projects starts here -->
    <div class="project_name">
      <?php $count = 1;?>
      <?php $i = 0;?>
      @foreach($projects as $key)
      <li class="current-projects">
        <div>
          <span class="project-client" title="Project Name: {{$key}}">
            {{$key}}
          </span>
          <span class="current-client" title="Client Name: {{$client_name[$i]}}">
            {{$client_name[$i]}}
          </span>
          <span title="Designation: {{$designation[$i]}}">
            {{$designation[$i]}}
          </span>
        </div>
      </li>
      <?php $count += 1;?>
      <?php $i += 1;?>
      @endforeach
    </div>
    <!-- List of assigned projects ends here -->

  </div>
  <!-- My projects content ends here -->

</div>
<!-- My Projects container data ends here -->
@stop
