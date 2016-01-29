<p>Hi! this is header.</p>

<?php
  $role_id = Session::get('user')[0]['role_id'];
  if($role_id) { ?>
  <div class="header-content">
<a href="/logout" title="Logout" class="logout">Logout</a>
<?php } ?>

<?php if($role_id == 1 || $role_id == 2) { ?>

  @include('templates/menu')
</div>
<?php } ?>
