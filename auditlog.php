<?php /*
*    Pi-hole: A black hole for Internet advertisements
*    (c) 2017 Pi-hole, LLC (https://pi-hole.net)
*    Network-wide ad blocking via your own hardware.
*
*    This file is copyright under the latest version of the EUPL.
*    Please see LICENSE file for your rights under this license. */
    require "scripts/pi-hole/php/header.php";
?>
<!-- Send PHP info to JS -->
<div id="token" hidden><?php echo $token ?></div>

<div class="row pt-4 mb-3">
    <div class="col-sm-12">
        <h1>Audit log (showing live data)</h1>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
      <div class="card card-outline card-secondary" id="domain-frequency">
        <div class="card-header">
          <h3 class="card-title">Allowed queries</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                    <th>Domain</th>
                    <th>Hits</th>
                    <th>Actions</th>
                    </tr>
                  </tbody>
                </table>
            </div>
        </div>
        <div class="overlay">
          <i class="fas fa-2x fa-sync fa-spin"></i>
        </div>
      </div>
    </div>
    <!-- /.col -->
    <div class="col-md-6">
      <div class="card card-outline card-secondary" id="ad-frequency">
        <div class="card-header">
          <h3 class="card-title">Blocked queries</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                  <tbody>
                    <tr>
                    <th>Domain</th>
                    <th>Hits</th>
                    <th>Actions</th>
                    </tr>
                  </tbody>
                </table>
            </div>
        </div>
        <div class="overlay">
          <i class="fas fa-2x fa-sync fa-spin"></i>
        </div>
      </div>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<script src="scripts/pi-hole/js/auditlog.js"></script>

<?php
    require "scripts/pi-hole/php/footer.php";
?>
