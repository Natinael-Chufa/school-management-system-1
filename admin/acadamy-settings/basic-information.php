<?php include('../../includes/config.php') ?>

<?php

if (isset($_POST['submit'])) {

    foreach ($_POST as $key => $value) {
        $check = mysqli_query($db_conn, "SELECT * FROM `settings` WHERE `setting_key` = '$key'");

        if (mysqli_num_rows($check)) {
            $sql = "UPDATE `settings` SET `setting_value`='$value' WHERE `setting_key` = '$key'";
        } else {
            $sql = "INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES ('$key','$value')";
        }
        mysqli_query($db_conn, $sql) or die('Something went wrong');
    }
}

?>
<?php

if (isset($_POST['save_session'])) {
    $title = isset($_POST['session']) ? $_POST['session'] : '';
    $query = mysqli_query($db_conn, "INSERT INTO `posts`(`author`, `title`, `description`, `type`, `status`,`parent`) VALUES ('1','$title','description','session','publish',0)") or die('DB error');

    header('Location:basic-information.php');exit;
}
?>
<?php include('../header.php') ?>
<?php include('../sidebar.php') ?>

<!-- Modal -->
<div class="modal fade" id="addNewSessionForm" tabindex="-1" role="dialog" aria-labelledby="addNewSessionFormLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNewSessionFormLabel">Add new session</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="session" class="form-control" placeholder="Add new session eg: 2024-2025">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" name="save_session" class="btn btn-primary" value="Save changes">
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Manage Acadamy Settings</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Admin</a></li>
                    <li class="breadcrumb-item active">Settings</li>
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
                <form action="" method="post" enctype="multipart/form-data">
                    <fieldset class="border border-secondary p-3 form-group">
                        <legend class="d-inline w-auto h6">Acadamy Information</legend>
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="form-group">
                                    <label for="acadany_name">Acadamy Name</label>
                                    <input type="text" class="form-control" name="acadany_name" id="acadany_name" placeholder="Acadamy Name">
                                </div>
                                <div class="form-group">
                                    <label for="acadany_description">Acadamy Description</label>
                                    <textarea name="acadany_description" id="" class="form-control" rows="5" placeholder="Acadamy Description"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="acadany_name">Acadamy Logo</label>
                                    <input type="text" class="form-control" name="acadany_name" id="acadany_name" placeholder="Acadamy Name">
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset class="border border-secondary p-3 form-group">
                        <legend class="d-inline w-auto h6">System Settings</legend>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="current_session">Current Session</label>
                                    <select name="current_session" id="current_session" class="form-control">
                                        <option value="">-Select Session-</option>
                                        <?php
                                        $args = array(
                                            'type' => 'session',
                                            'status' => 'publish',
                                        );
                                        $sessions = get_posts($args);
                                        foreach ($sessions as $session) {
                                            $selected = ($session_id == $session->id) ? 'selected' : '';
                                            echo '<option value="' . $session->id . '" ' . $selected . '>' . $session->title . '</option>';
                                        } ?>
                                    </select>
                                </div>

                                <button class="btn btn-info btn-xs" type="button" data-target="#addNewSessionForm" data-toggle="modal">Add New Session</button>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="session_starts_from">Session Starts From</label>
                                    <select name="session_starts_from" id="session_starts_from" class="form-control">
                                        <option value="">-Select Month-</option>
                                        <?php

                                        $months = array('january', 'fabruary', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');

                                        foreach ($months as $key => $value) {
                                            echo '<option value="' . $value . '">' . ucwords($value) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="examination_types">Examinsation Types</label>
                                    <select name="examination_types" id="examination_types" class="form-control">
                                        <option value="">-Select Examinsation-</option>
                                        <?php

                                        $exams = array('');

                                        foreach ($exams as $key => $value) {
                                            echo '<option value="' . $value . '">' . ucwords($value) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    <button type="submit" name="submit" class="btn btn-primary">Save Settings</button>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- /.content -->
<?php include('../footer.php') ?>