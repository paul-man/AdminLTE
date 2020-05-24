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
        <h1>Generate debug log</h1>
        <h2 class="h3">On this page, you can add domain/IP associations</h2>
    </div>
</div>

<input type="checkbox" id="upload"><label for="upload">Upload debug log and provide token once finished</label>
<p>Once you click this button a debug log will be generated and can automatically be uploaded if we detect a working internet connection.</p>
<button type="button" id="debugBtn" class="btn btn-lg btn-primary btn-block">Generate debug log</button>
<pre id="output" class="w-100 h-100 bg-light d-none"></pre>

<script src="scripts/pi-hole/js/debug.js"></script>

<?php
    require "scripts/pi-hole/php/footer.php";
?>
