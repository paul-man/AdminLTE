<?php /* 
*    Pi-hole: A black hole for Internet advertisements
*    (c) 2017 Pi-hole, LLC (https://pi-hole.net)
*    Network-wide ad blocking via your own hardware.
*
*    This file is copyright under the latest version of the EUPL.
*    Please see LICENSE file for your rights under this license. */
    require "scripts/pi-hole/php/header.php";
?>

<div class="row pt-4 mb-2">
    <div class="col-sm-12">
        <h1 class="m-0">Find Blocked Domain In Lists</h1>
    </div>
</div>

<div class="row mt-3">
  <div class="col-md-12">
    <div class="card card-outline card-secondary">
      <div class="card-body">
        <div class="row">
          <div class="form-group col-md-12">
            <div class="form-group input-group">
              <input id="domain" type="text" class="form-control" placeholder="Domain to look for (example.com or sub.example.com)">
              <input id="quiet" type="hidden" value="no">
              <span class="input-group-btn">
                <button type="button" id="btnSearch" class="btn btn-light">Search partial match</button>
                <button type="button" id="btnSearchExact" class="btn btn-light">Search exact match</button>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<pre id="output" class="w-100 h-100 bg-light d-none"></pre>

<script src="scripts/pi-hole/js/queryads.js"></script>

<?php
    require "scripts/pi-hole/php/footer.php";
?>
