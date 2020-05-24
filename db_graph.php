<?php /*
*    Pi-hole: A black hole for Internet advertisements
*    (c) 2017 Pi-hole, LLC (https://pi-hole.net)
*    Network-wide ad blocking via your own hardware.
*
*    This file is copyright under the latest version of the EUPL.
*    Please see LICENSE file for your rights under this license. */
    require "scripts/pi-hole/php/header.php";

// Generate CSRF token
if(empty($_SESSION['token'])) {
    $_SESSION['token'] = base64_encode(openssl_random_pseudo_bytes(32));
}
$token = $_SESSION['token'];

?>
<!-- Send PHP info to JS -->
<div id="token" hidden><?php echo $token ?></div>

<div class="row pt-4 mb-3">
    <div class="col-sm-12">
        <h1>Compute graphical statistics from the Pi-hole query database</h1>
    </div>
</div>

<div class="row mb-3">
  <div class="col-md-12">
    <div class="card card-outline card-secondary">
      <div class="card-header">
        <h3 class="card-title">Select date and time range</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="form-group col-md-12">
            <div class="input-group">
              <div class="input-group-addon">
                <i class="far fa-clock"></i>
              </div>
              <input type="button" class="form-control pull-right" id="querytime" value="Click to select date and time range">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="row mb-3">
  <div class="col-md-12">
    <div id="timeoutWarning" class="alert alert-warning alert-dismissible fade show d-none" role="alert">
        Depending on how large of a range you specified, the request may time out while Pi-hole tries to retrieve all the data.
        <br/><span id="err"></span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
  </div>
</div>

<div class="row mb-3">
  <div class="col-md-12">
    <div class="card card-outline card-secondary" id="queries-over-time">
      <div class="card-header">
        <h3 class="card-title">Queries over the selected time period</h3>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-12">
            <div class="chart">
              <canvas id="queryOverTimeChart" width="800" height="250"></canvas>
            </div>
          </div>
        </div>
      </div>
      <div class="overlay" hidden>
        <i class="fas fa-2x fa-sync fa-spin"></i>
      </div>
    </div>
  </div>
</div>

<script src="scripts/vendor/daterangepicker.js"></script>
<script src="scripts/pi-hole/js/db_graph.js"></script>

<?php
    require "scripts/pi-hole/php/footer.php";
?>
