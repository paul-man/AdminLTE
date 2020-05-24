<?php /*
*    Pi-hole: A black hole for Internet advertisements
*    (c) 2019 Pi-hole, LLC (https://pi-hole.net)
*    Network-wide ad blocking via your own hardware.
*
*    This file is copyright under the latest version of the EUPL.
*    Please see LICENSE file for your rights under this license. */
    require "scripts/pi-hole/php/header.php";
?>

<div class="row pt-4 mb-3">
    <div class="col-sm-12">
        <h1>Adlist group management</h1>
    </div>
</div>

<!-- Domain Input -->
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card card-outline card-secondary" id="add-group">
            <div class="card-header">
                <h3 class="card-title">Add a new adlist</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="new_address">Address:</label>
                        <input id="new_address" type="text" class="form-control" placeholder="http://..., https://..., file://..." autocomplete="off" spellcheck="false" autocapitalize="none" autocorrect="off">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="new_comment">Comment:</label>
                        <input id="new_comment" type="text" class="form-control" placeholder="Adlist description (optional)">
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Hint:</strong> Please run <code>pihole -g</code> or update your gravity list <a href="gravity.php">online</a> after modifying your adlists.
                    </div>
                    <div class="col-md-6 d-flex justify-content-md-end mt-3 mt-md-0">
                        <button type="button" id="btnAdd" class="btn btn-primary">Add</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-secondary" id="adlists-list">
            <div class="card-header">
                <h3 class="card-title">
                    List of configured adlists
                </h3>
            </div>
            <div class="card-body">
                <table id="adlistsTable" class="display table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Address</th>
                            <th>Status</th>
                            <th>Comment</th>
                            <th>Group assignment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
                <button type="button" id="resetButton" class="btn btn-light btn-sm text-red d-none">Reset sorting</button>
            </div>
        </div>
    </div>
</div>

<script src="scripts/pi-hole/js/utils.js"></script>
<script src="scripts/pi-hole/js/groups-adlists.js"></script>

<?php
    require "scripts/pi-hole/php/footer.php";
?>
