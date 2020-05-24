<?php /*
*    Pi-hole: A black hole for Internet advertisements
*    (c) 2017 Pi-hole, LLC (https://pi-hole.net)
*    Network-wide ad blocking via your own hardware.
*
*    This file is copyright under the latest version of the EUPL.
*    Please see LICENSE file for your rights under this license. */
    require "scripts/pi-hole/php/header.php";
?>

<div class="row pt-4 mb-3">
    <div class="col-sm-12">
        <h1>Update Gravity (list of blocked domains)</h1>
    </div>
</div>

<!-- Alerts -->
<div id="alInfo" class="alert alert-info alert-dismissible fade show d-none" role="alert">
    Updating...this may take a while. <strong>Please do not navigate away from or close this page.</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div id="alSuccess" class="alert alert-success alert-dismissible fade show d-none" role="alert">
    Success!
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<button type="button" id="gravityBtn" class="btn btn-lg btn-primary btn-block">Update</button>
<pre id="output" class="w-100 h-100 bg-light d-none"></pre>

<script src="scripts/pi-hole/js/gravity.js"></script>

<?php
    require "scripts/pi-hole/php/footer.php";
?>
