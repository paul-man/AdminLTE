/* Pi-hole: A black hole for Internet advertisements
 *  (c) 2017 Pi-hole, LLC (https://pi-hole.net)
 *  Network-wide ad blocking via your own hardware.
 *
 *  This file is copyright under the latest version of the EUPL.
 *  Please see LICENSE file for your rights under this license. */

/* global utils:false */

// Define global variables
var auditList = [],
  auditTimeout;

function updateTopLists() {
  $.getJSON("api.php?topItems=audit", function(data) {
    if ("FTLnotrunning" in data) {
      return;
    }

    // Clear tables before filling them with data
    $("#domain-frequency td")
      .parent()
      .remove();
    $("#ad-frequency td")
      .parent()
      .remove();
    var domaintable = $("#domain-frequency").find("tbody:last");
    var adtable = $("#ad-frequency").find("tbody:last");
    var url, domain;
    for (domain in data.top_queries) {
      if (Object.prototype.hasOwnProperty.call(data.top_queries, domain)) {
        // Sanitize domain
        domain = utils.escapeHtml(domain);
        url = '<a href="queries.php?domain=' + domain + '">' + domain + "</a>";
        domaintable.append(
          "<tr> <td>" +
            url +
            "</td> <td>" +
            data.top_queries[domain] +
            '</td> <td> <button type="button" class="btn btn-default btn-sm text-red"><i class="fa fa-ban"></i> Blacklist</button> <button class="btn btn-default btn-sm text-orange"><i class="fa fa-balance-scale"></i> Audit</button> </td> </tr> '
        );
      }
    }

    for (domain in data.top_ads) {
      if (Object.prototype.hasOwnProperty.call(data.top_ads, domain)) {
        var input = domain.split(" ");
        // Sanitize domain
        var printdomain = utils.escapeHtml(input[0]);
        if (input.length > 1) {
          url =
            '<a href="queries.php?domain=' +
            printdomain +
            '">' +
            printdomain +
            "</a> (wildcard blocked)";
          adtable.append(
            "<tr> <td>" +
              url +
              "</td> <td>" +
              data.top_ads[domain] +
              '</td> <td> <button type="button" class="btn btn-default btn-sm text-orange"><i class="fa fa-balance-scale"></i> Audit</button> </td> </tr> '
          );
        } else {
          url = '<a href="queries.php?domain=' + printdomain + '">' + printdomain + "</a>";
          adtable.append(
            "<tr> <td>" +
              url +
              "</td> <td>" +
              data.top_ads[domain] +
              '</td> <td> <button type="button" class="btn btn-default btn-sm text-green"><i class="fas fa-check"></i> Whitelist</button> <button class="btn btn-default btn-sm text-orange"><i class="fa fa-balance-scale"></i> Audit</button> </td> </tr> '
          );
        }
      }
    }

    $("#domain-frequency .overlay").hide();
    $("#ad-frequency .overlay").hide();
    // Update top lists data every second
    setTimeout(updateTopLists, 1000);
  });
}

function add(domain, list) {
  var token = $("#token").text();
  $.ajax({
    url: "scripts/pi-hole/php/add.php",
    method: "post",
    data: { domain: domain, list: list, token: token }
  });
}

$(document).ready(function() {
  // Pull in data via AJAX
  updateTopLists();

  $("#domain-frequency tbody").on("click", "button", function() {
    var url = $(this)
      .parents("tr")[0]
      .textContent.split("	")[0];
    if ($(this).context.textContent === " Blacklist") {
      add(url, "audit");
      add(url, "black");
      $("#gravityBtn").prop("disabled", false);
    } else {
      auditUrl(url);
    }
  });

  $("#ad-frequency tbody").on("click", "button", function() {
    var url = $(this)
      .parents("tr")[0]
      .textContent.split("	")[0]
      .split(" ")[0];
    if ($(this).context.textContent === " Whitelist") {
      add(url, "audit");
      add(url, "white");
      $("#gravityBtn").prop("disabled", false);
    } else {
      auditUrl(url);
    }
  });
});

function auditUrl(url) {
  if (auditList.indexOf(url) > -1) {
    return;
  }

  if (auditTimeout) {
    clearTimeout(auditTimeout);
  }

  auditList.push(url);
  // wait 3 seconds to see if more domains need auditing
  // and batch them all into a single request
  auditTimeout = setTimeout(function() {
    add(auditList.join(" "), "audit");
    auditList = [];
  }, 3000);
}

$("#gravityBtn").on("click", function() {
  window.location.replace("gravity.php?go");
});
