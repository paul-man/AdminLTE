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
        <h1>Group management</h1>
    </div>
</div>

<!-- Group Input -->
<div class="row mb-3">
    <div class="col-md-12">
        <div class="card card-outline card-secondary" id="add-group">
            <div class="card-header">
                <h3 class="card-title">Add a new group</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="new_name">Name:</label>
                        <input id="new_name" type="text" class="form-control" placeholder="Group name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="new_desc">Description:</label>
                        <input id="new_desc" type="text" class="form-control" placeholder="Group description (optional)">
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-md-end">
                <button type="button" id="btnAdd" class="btn btn-primary">Add</button>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-outline card-secondary" id="groups-list">
            <div class="card-header">
                <h3 class="card-title">List of configured groups</h3>
            </div>
            <div class="card-body">
                <table id="groupsTable" class="display table table-striped table-bordered w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Description</th>
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
<script src="scripts/pi-hole/js/groups.js"></script>

<?php
    require "scripts/pi-hole/php/footer.php";
?>
