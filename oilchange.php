<?php /*
*    Pi-hole: A black hole for Internet advertisements
*    (c) 2017 Pi-hole, LLC (https://pi-hole.net)
*    Network-wide ad blocking via your own hardware.
*
*    This file is copyright under the latest version of the EUPL.
*    Please see LICENSE file for your rights under this license. */
require "scripts/pi-hole/php/header.php";
require "scripts/pi-hole/php/oilchange/saveoilchange.php";
require_once "scripts/pi-hole/php/FTL.php";

$piholeFTLConf = piholeFTLConfig();

// Handling of PHP internal errors
$last_error = error_get_last();
if(isset($last_error) && ($last_error["type"] === E_WARNING || $last_error["type"] === E_ERROR))
{
	$error .= "There was a problem applying your settings.<br>Debugging information:<br>PHP error (".htmlspecialchars($last_error["type"])."): ".htmlspecialchars($last_error["message"])." in ".htmlspecialchars($last_error["file"]).":".htmlspecialchars($last_error["line"]);
}

?>
<style>
	.tooltip-inner {
		max-width: none;
		white-space: nowrap;
	}
</style>

<?php if (strlen($success) > 0) { ?>
    <div id="alInfo" class="alert alert-info alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-hide="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
        </button>
        <h4><i class="icon fa fa-info"></i> Info</h4>
        <?php echo $success; ?>
    </div>
<?php } ?>

<?php
if (isset($_GET['tab']) && in_array($_GET['tab'], array("sysadmin"))) {
    $tab = $_GET['tab'];
} else {
    $tab = "sysadmin";
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation"<?php if($tab === "sysadmin"){ ?> class="active"<?php } ?>>
                    <a href="#sysadmin" aria-controls="sysadmin" aria-expanded="<?php echo $tab === "sysadmin" ? "true" : "false"; ?>" role="tab" data-toggle="tab">System</a>
                </li>
            </ul>
            <div class="tab-content">
                <!-- ######################################################### System admin ######################################################### -->
                <div id="sysadmin" class="tab-pane fade<?php if($tab === "sysadmin"){ ?> in active<?php } ?>">
                    <form role="form" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">FTL Information</h3>
                                </div>
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <table class="table table-striped table-bordered nowrap">
                                                <tbody id="oil_change">
                                                    <tr>
                                                        <th>Make</th>
                                                        <th>Model</th>
                                                        <th>Year</th>
                                                        <th>Color</th>
                                                        <th>Mileage</th>
                                                        <th>Change Date yyyy-mm-dd</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box box-warning">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <button type="submit" class="btn btn-success btn-block">Save</button>
                                        </div>
                                        <p class="hidden-md hidden-lg"></p>
                                        <div class="col-md-4">
                                                <button type="button" class="btn btn-warning confirm-flusharp btn-block">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <input type="hidden" name="token" value="<?php echo $token ?>">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="scripts/vendor/jquery.confirm.min.js?v=<?=$cacheVer?>"></script>
<script src="scripts/pi-hole/js/utils.js?v=<?=$cacheVer?>"></script>
<script src="scripts/pi-hole/js/oilchange.js?v=<?=$cacheVer?>"></script>
<script>
$.getJSON("api.php?oilchangestats", function (data) {
  
  // idx zero is reserve for empty input for adding new rows
  $("#oil_change").append(`<tr>`+ 
  `<td><input type="text" class="form-control" name="field[0][make]" autocomplete="off" `+ 
  `spellcheck="false" autocapitalize="none" autocorrect="off" value=""></td>`+
  `<td><input type="text" class="form-control" name="field[0][model]" autocomplete="off" `+ 
  `spellcheck="false" autocapitalize="none" autocorrect="off" value=""></td>`+
  `<td><input type="text" class="form-control" name="field[0][myear]" autocomplete="off" `+ 
  `spellcheck="false" autocapitalize="none" autocorrect="off" value=""></td>`+
  `<td><input type="text" class="form-control" name="field[0][color]" autocomplete="off" `+ 
  `spellcheck="false" autocapitalize="none" autocorrect="off" value=""></td>`+
  `<td><input type="text" class="form-control" name="field[0][mileage]" autocomplete="off" `+ 
  `spellcheck="false" autocapitalize="none" autocorrect="off" value=""></td>`+
  `<td><input type="text" class="form-control" name="field[0][oil_change_dt]" autocomplete="off" `+ 
  `spellcheck="false" autocapitalize="none" autocorrect="off" value=""></td>`+
  `</tr>`);

  data.forEach(function (arrayItem, idx) {
    $("#oil_change").append(getOilChangeHtmlAsEdit(arrayItem, idx+1));
  });
  
});
</script>
<?php
require "scripts/pi-hole/php/footer.php";
?>
