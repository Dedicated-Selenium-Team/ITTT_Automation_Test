<?php
function getminutes($date_array)
{
  $time = new DateTime('00:00');
  foreach($date_array as $new_date)
  {


    $new_date = number_format((float)$new_date,2);
    $time->add(new DateInterval("PT".str_replace(".","H",$new_date."M")));  
  }
  $interval = $time->diff(new DateTime('00:00'));
  $dates=$interval->d;
  return ($dates*24)+$interval->h.':'.sprintf("%'.02d\n",$interval->i);
}
function getdiff_minutes($date)
{
  $time = new DateTime('08:30');
  $date=str_replace(":", ".", $date);
  $date = number_format((float)$date,2);
  $new_date=new DateTime(str_replace(".", ":", $date));
  $interval = $time->diff($new_date);
  $dates=$interval->d;
//if($interval->h<0)
  return ($dates*24)+$interval->h.'.'.sprintf("%'.02d\n",$interval->i);
}
?>
@extends('master')
<title>ITTT | Timesheet</title>

@section('content')

<?php 
$today = date('Y-m-d');
?>

<div class="bread-crumb">
  <div> 
    <a href="/time-management/{{$today}}">Timesheet</a>
    <a class="current-page">week</a>
  </div>
</div>

<!-- Timesheet Data container Starts Here -->
<div class="day-timesheet">

  <!-- Timesheet Header starts here -->
  <div class="container-heading cf">

    <!-- Current week, Next and Previous week functionality starts here -->
    <?php
    $week_date = date('j F Y', strtotime('monday this week'));
    $today     = date('Y-m-d');
    $prev_date = date('Y, F j', strtotime('previous sunday', strtotime($date))+86400);
    $prev_date_timestamp=strtotime('previous sunday', strtotime($date));
    $prev_arrow_date=date('j F Y', strtotime('previous sunday', strtotime($date)));
    $week_start_date=date('Y, F j',strtotime('next monday', strtotime($prev_date_timestamp)));
    $end_date = strtotime("+7 days", strtotime('previous sunday', strtotime($date)));
    $next_date = date('j F Y', $end_date+86400);
    $check_end_date_year=date("Y",$end_date);
    $start_date_year=date("Y",($prev_date_timestamp));
    if($check_end_date_year==$start_date_year)
     $end_date=date('F j',$end_date);
   else
     $end_date=date('Y, F j',$end_date);
   
   $today_date = date('d-m-Y');
   $week_start = date('d-m-Y',strtotime($date));
   $week_end = date('d-m-Y',strtotime("+6 days",strtotime($date)));
   
   
   /*<!-- Current week, Next and Previous week functionality ends here -->*/
   ?>
   <?php

   $daily_total=array();
   if(count($projects)>0)
   {
     foreach($projects as $project_key=>$project_value)
     {

      foreach($project_value->project_details as $key=>$value)
      {
        if(count($value)>0)
        {
          foreach($value as $project_data_key=>$project_data_value)
          {
            if(array_key_exists ( $key , $daily_total ))
            {
              array_push($daily_total[$key], $project_data_value->hrs_locked);
            }
            else
            {
              $daily_total[$key]=array();
              array_push($daily_total[$key], $project_data_value->hrs_locked);
            }
          }
        }
        else
        {
          if(!array_key_exists ( $key , $daily_total ))
          {
           $daily_total[$key]=array();
         }
         
         array_push($daily_total[$key], 0);
       }
     }
   }
 }
 else
 {
  $daily_total=array_fill(0, 7, array(0));
}

?>
<input type="hidden" name="current_date" value="{{$prev_date}} - {{$end_date}}" class="border-style input-read-only" disabled>
<span class="border-style input-read-only">{{$prev_date}} - {{$end_date}}</span>

<!-- Timesheet header right starts here -->
<div class="timesheet-header-right">
  <?php if(strtotime($today_date)>=strtotime($week_start) && strtotime($today_date)<=strtotime($week_end)) { ?>
    <a href="/time-management/week/{{$week_date}}" class="today today-hover" title="Today">Today</a>
    <?php } else { ?>
      <a href="/time-management/week/{{$week_date}}" class="today" title="Today">Today</a>
      <?php } ?>
      <div class="arrow">
        <a href="/time-management/week/{{$prev_arrow_date}}" class="previous" title="Previous">Previous</a>
        <a href="/time-management/week/{{$next_date}}" class="next" title="Next">Next</a>
      </div>

      <input class="date-pick" placeholder="DD/MM/YYYY" readonly="readonly" name="joining_date" type="text" value="" id="joining_date" title="Datepicker">

      <div class="views">
        <a href="/time-management/{{$today}}" title="Day View" class="day">Day</a>
        <a href="/time-management/week/{{$week_date}}" title="Week View" class="week active-view">Week</a>
      </div>

    </div>
    <!-- Timesheet header right ends here -->

  </div>
  <!-- Timesheet Header Ends here -->

  <!-- Timesheet content starts here -->
  <div class="timesheet-content">

    <!-- Week View Table Starts here -->
    <div class="table-timesheet-week">
     <?php $free_time=array();?>
     <table class="week-table">
      <tbody>
        <tr class="head-row">
          <th>
            Projects
          </th>
          <?php $week_total=array();?>
          @foreach($period as $periods)
          <th>
            <a href=../{{$periods->format("Y-m-d")}}>
              <p>
                {{$periods->format("l")}}
              </p>
              <p>
                {{$periods->format("d M")}}
              </p>
            </a>
          </th>
          @endforeach
          <th>Total Hours</th>
        </tr>
        @foreach($projects as $project)
        <?php $week_total_hrs = 0; ?>
        <tr>
         <th class="break-words">
           {{$project->project_name}} 
         </th>
         <?php $total_hrs = array();?>
         @foreach($project->project_details as $newdata)
         <td>
          @if(count($newdata)>0)
          <?php
          $total_project_hrs=array();
          ?>
          @foreach($newdata as $data)

          @if(strlen($data->hrs_locked)>0)
          <?php 
          
          array_push($total_project_hrs,$data->hrs_locked);
          array_push($total_hrs, $data->hrs_locked);
          
          
          ?>
          @endif
          @endforeach
          {{getminutes($total_project_hrs)}}
          @else
          -
          @endif

        </td>
        @endforeach

        <?php $week_total_hrs = getminutes($total_hrs);
        ?>
        <td> {{$week_total_hrs}} </td>
        <?php

        $week_total_hrs=str_replace(':', '.', $week_total_hrs); 
        array_push($week_total,$week_total_hrs);
        
        ?>
      </tr>
      @endforeach

      <tr class="total">
        <th>Total Hours</th>
        <?php
        foreach($daily_total as $daily_total_key=>$daily_total_value)
        {
          $total_minutes=getminutes($daily_total_value);
          if(str_replace(':', '.', $total_minutes)<08.30)
            array_push($free_time,getdiff_minutes(str_replace(':', '.', $total_minutes)));
          else
            array_push($free_time,0);
          echo "<td>$total_minutes</td>";
        }
        echo "<td>".getminutes($week_total)."</td></tr>";
           // <tr class='free-hours'><th>Free Hours</th>";
        ?>
        
        <?php
        $free_time_size=count($free_time);

        $free_time=array_slice($free_time, 0, $free_time_size-2); 
//foreach($free_time as $key=>$value)
//echo "<td>$value</td>";
//$total_free_time=getminutes($free_time);
//echo "<td>0:00</td><td>0:00</td><td>$total_free_time</td>";
        ?>
        <!--</tr>-->
      </tbody>
    </table>
    <div class="time-details">
      <p><span class="free-time-title">Free Hours - </span> <span class="free-time">{{getminutes($free_time)}}</span></p>
    </div>
    <!-- Day View Table Ends here -->

  </div>
  <!-- Timesheet content ends here -->

</div>
<!-- Timesheet Data container Starts Here -->
<script>
 $('.date-pick').datepicker( {
  changeMonth: true,
  changeYear: true,
  onSelect: function(date) {
    var mydate=new Date(date);
    var monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
    ];

    var curr_date = mydate.getDate();

    var curr_month = mydate.getMonth();

    var curr_year = mydate.getFullYear();

//alert(curr_date+"/"+monthNames[curr_month]+"/"+curr_year);

location.href=curr_date+" "+monthNames[curr_month]+" "+curr_year;
}
});
</script>
@stop

