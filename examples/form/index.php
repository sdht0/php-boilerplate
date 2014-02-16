<?php
require '../../config.php';

$title = "Login";
include SITE_DIR . 'header.php';
?>
<!-- Bootstrap core CSS -->
<link href="<?php echo SITE_URL; ?>examples/form/bootstrap.min.css" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="<?php echo SITE_URL; ?>examples/form/signin.css" rel="stylesheet">

<div class="container">
    <form class="form-horizontal col-lg-5" role="form" method="POST" action="<?php echo SITE_URL; ?>examples/form/process.php">
        <h2 class="form-signin-heading col-sm-offset-4">Register</h2>
        <?php if (isset($_SESSION['formmsg'])) {
            ?>
            <div class="alert alert-danger col-sm-offset-4 col-sm-7" style="text-align: center">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?php echo PHPB::getSessionData("formmsg"); ?>
            </div>
        <?php }
        ?>
        <div class="form-group">
            <label for="inputname" class="col-sm-4 control-label">Name</label>
            <div class="col-sm-7">
                <input type="text" name="data[name]" value="<?php echo PHPB::getSessionData("formdata", "name"); ?>" class="form-control" id="inputname">
            </div>
        </div>
        <div class="form-group">
            <label for="inputemail" class="col-sm-4 control-label">Email</label>
            <div class="col-sm-7">
                <input type="email" name="data[email]" value="<?php echo PHPB::getSessionData("formdata", "email"); ?>" class="form-control" id="inputemail">
            </div>
        </div>
        <div class="form-group">
            <label for="inputcity" class="col-sm-4 control-label">City</label>
            <div class="col-sm-7">
                <select name="data[city]" id="inputcity" class="form-control">
                    <?php
                    $res = array(array("id" => "1", "cityname" => "X"), array("id" => "2", "cityname" => "Y"),
                        array("id" => "3", "cityname" => "Z"), array("id" => "4", "cityname" => "W"));
                    /* Alternatively, obtain results from the database:
                     * $res = DB::findAllFromQuery("select id,cityname from cities"); */
                    $v = PHPB::getSessionData("formdata", "city");
                    foreach ($res as $value) {
                        echo "<option value='" . $value['id'] . "' " . ($value['id'] == $v ? "selected=''" : "") . ">" . $value['cityname'] . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-4 col-sm-4">
                <button class="btn btn-lg btn-primary btn-block" name="formregister" type="submit">Submit</button>
            </div>
        </div>
    </form>
</div> <!--/container -->

<?php
include SITE_DIR . 'footer.php';
?>
<!--Bootstrap core JavaScript -->
<script src="<?php echo SITE_URL; ?>examples/form/bootstrap.min.js"></script>