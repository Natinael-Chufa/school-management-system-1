<?php include('../includes/config.php'); ?>
<?php include('header.php') ?>
<?php include('sidebar.php') ?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Manage Attendance</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Admin</a></li>
          <li class="breadcrumb-item active">Attendance</li>
        </ol>
      </div><!-- /.col -->


    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <form action="" method="get" id="get_user_attendance">
          <div class="row">

            <div class="col-lg-2">
              <div class="form-group">
                <label for="">User Tpye</label>
                <select name="user_type" id="user_type" class="form-control">
                  <option value="">-Select Type-</option>
                  <option value="student">Student</option>
                  <option value="teacher">Teacher</option>
                  <option value="counseller">Counseller</option>
                  <option value="ohter">Other</option>
                </select>
              </div>
            </div>

            <div class="col-lg-2">
              <div class="form-group mb-0">
                <label for="">User</label>
                <select name="user_id" id="user_id" class="form-control select2-users">

                </select>
              </div>
            </div>


            <div class="col-lg-2">
              <div class="form-group">
                <label for="">Session</label>
                <select name="session" id="session" class="form-control">
                  <option value="">Current Session</option>
                </select>
              </div>
            </div>
            <div class="col-lg-2">
              <div class="form-group mb-0">
                <label for="">Month</label>
                <select name="month" id="months" class="form-control">
                  <option value="">All</option>
                  <?php

                  $months = array('january', 'fabruary', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');

                  foreach ($months as $key => $value) {
                    echo '<option value="' . ++$key . '">' . ucwords($value) . '</option>';
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>
          <input type="hidden" name="year" value="<?php echo date('Y') ?>">
          <input type="submit" value="View" name="filter" class="btn btn-primary">
        </form>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-5">
        <div class="calendar fade" id="calendar"></div>
      </div>
    </div>

  </div><!--/. container-fluid -->
</section>
<!-- /.content -->


<script>

  var attData = {
    ajaxUrl : '',
    currentSession : '<?php echo get_setting('current_session', true)?>',
    sessionStatMonth : '<?php echo get_setting('session_starts_from', true)?>',
  }

  function get_session_year_by_month(session, monthNum){

    if(!session){
      session = attData.currentSession;
    }

    return session;
  }
  var session = '2024-2025';
  console.log(get_session_year_by_month(session, 6));
  att_url = '<?php echo 'ajax.php?action=get_user_attendance&user_id=' . (isset($_GET['user_id']) ? $_GET['user_id'] : '0'); ?>';

  var calendarWrapper;
  jQuery(document)
    .on('submit', '#get_user_attendance', function(e) {
      e.preventDefault();
      if (calendarWrapper) {
        calendarWrapper.zabuto_calendar('destroy');
      }

      var args = {
        classname: 'table table-bordered lightgrey-weekends',
        ajax: {
          url: 'ajax.php',
          data: {
            action: 'get_user_attendance',

            se: parseInt(jQuery('[name="user_id"]').val())
          }
        }
      };

      if (jQuery('[name="session"]').val() !== '') {

        var session = '2024-2025';
        console.log(get_session_year(session));

        args['year'] = parseInt(jQuery('[name="year"]').val());
      } else {
        args['year'] = new Date().getFullYear();
      }

      if (jQuery('[name="month"]').val() !== '') {
        args['month'] = parseInt(jQuery('[name="month"]').val());
        args['navigation_prev'] = false;
        args['navigation_next'] = false;
      }

      calendarWrapper
        .zabuto_calendar(args)
        .addClass('show');

      console.log(calendarWrapper);
      
    })
    .ready(function() {
      calendarWrapper = jQuery("#calendar").zabuto_calendar({
        classname: 'table table-bordered lightgrey-weekends',
      });
      $("#calendar").on('zabuto:calendar:data-fail', function(e){
        console.log('asdfasdf,',e);
        
      })
      $("#calendar").on('zabuto:calendar:data', function(e){
        console.log('ss,',e);
        
      })
      $('#calendar').on('zabuto:calendar:preRender', function (event) {
    console.log('Calendar init',event);
});
      jQuery('.select2-users').select2({
        placeholder: 'Search User',
        ajax: {
          delay: 250,
          url: 'ajax.php',
          dataType: 'json',
          data: function(params) {
            return {
              action: 'get_user_by_type',
              type: jQuery('[name="user_type"]').val(),
              q: params.term, // search term
              page: params.page
            };
          },
          processResults: function(data) {
            return {
              results: data
            };
          }
        }
      });
    });
</script>
<?php include('footer.php') ?>