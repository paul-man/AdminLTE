/* Pi-hole: A black hole for Internet advertisements
 *  (c) 2017 Pi-hole, LLC (https://pi-hole.net)
 *  Network-wide ad blocking via your own hardware.
 *
 *  This file is copyright under the latest version of the EUPL.
 *  Please see LICENSE file for your rights under this license. */

// The following functions allow us to display time until pi-hole is enabled after disabling.
// Works between all pages

function secondsTimeSpanToHMS(s) {
  var h = Math.floor(s / 3600); //Get whole hours
  s -= h * 3600;
  var m = Math.floor(s / 60); //Get remaining minutes
  s -= m * 60;
  return h + ":" + (m < 10 ? "0" + m : m) + ":" + (s < 10 ? "0" + s : s); //zero padding on minutes and seconds
}

function piholeChanged(action) {
  var status = document.getElementById("status");
  var piholeEnable = document.getElementById("pihole-enable");
  var piholeDisable = document.getElementById("pihole-disable");

  switch (action) {
    case "enabled":
      status.innerHTML = '<i class="fa fa-circle text-green-light"></i> Active';
      piholeEnable.style.display = "none";
      piholeDisable.style.display = "";
      piholeDisable.classList.remove("active");
      break;

    case "disabled":
      status.innerHTML = '<i class="fa fa-circle text-red"></i> Offline';
      piholeEnable.style.display = "";
      piholeDisable.style.display = "none";
      break;

    default:
    // nothing
  }
}

function countDown() {
  var piholeEnableLabel = document.getElementById("enableLabel");
  var piholeEnableTimer = document.getElementById("enableTimer");
  var target = new Date(parseInt(piholeEnableTimer.innerHTML, 10));
  var seconds = Math.round((target.getTime() - new Date().getTime()) / 1000);

  if (seconds > 0) {
    setTimeout(countDown, 1000);
    piholeEnableLabel.textContent = "Enable (" + secondsTimeSpanToHMS(seconds) + ")";
  } else {
    piholeEnableLabel.textContent = "Enable";
    piholeChanged("enabled");
    localStorage.removeItem("countDownTarget");
  }
}

function piholeChange(action, duration) {
  var token = encodeURIComponent(document.getElementById("token").textContent);
  var piholeEnableTimer = document.getElementById("enableTimer");
  var btnStatus;

  switch (action) {
    case "enable":
      btnStatus = document.getElementById("flip-status-enable");
      btnStatus.innerHTML = '<i class="fa fa-spinner"></i>';
      $.getJSON("api.php?enable&token=" + token, function (data) {
        if (data.status === "enabled") {
          btnStatus.innerHTML = "";
          piholeChanged("enabled");
        }
      });
      break;

    case "disable":
      btnStatus = document.getElementById("flip-status-disable");
      btnStatus.innerHTML = '<i class="fa fa-spinner"></i>';
      $.getJSON("api.php?disable=" + duration + "&token=" + token, function (data) {
        if (data.status === "disabled") {
          btnStatus.innerHTML = "";
          piholeChanged("disabled");
          if (duration > 0) {
            piholeEnableTimer.textContent = new Date().getTime() + duration * 1000;
            setTimeout(countDown, 100);
          }
        }
      });
      break;

    default:
    // nothing
  }
}

function checkMessages() {
  $.getJSON("api_db.php?status", function (data) {
    if ("message_count" in data && data.message_count > 0) {
      var title;
      if (data.message_count > 1) {
        title = "There are " + data.message_count + " warnings. Click for further details.";
      } else {
        title = "There is one warning. Click for further details.";
      }

      var diagnosisEl = document.getElementById("pihole-diagnosis");

      diagnosisEl.title = title;
      document.getElementById("pihole-diagnosis-count").textContent = data.message_count;
      diagnosisEl.classList.remove("d-none");
    }
  });
}

// Handle Enable/Disable
document.getElementById("pihole-enable").addEventListener("click", function (e) {
  e.preventDefault();
  localStorage.removeItem("countDownTarget");
  piholeChange("enable", "");
});

document.getElementById("pihole-disable-permanently").addEventListener("click", function (e) {
  e.preventDefault();
  piholeChange("disable", "0");
});
document.getElementById("pihole-disable-10s").addEventListener("click", function (e) {
  e.preventDefault();
  piholeChange("disable", "10");
});
document.getElementById("pihole-disable-30s").addEventListener("click", function (e) {
  e.preventDefault();
  piholeChange("disable", "30");
});
document.getElementById("pihole-disable-5m").addEventListener("click", function (e) {
  e.preventDefault();
  piholeChange("disable", "300");
});
document.getElementById("pihole-disable-custom").addEventListener("click", function (e) {
  e.preventDefault();
  var custVal = document.getElementById("customTimeout").value;
  custVal = document.getElementById("btnMins").classList.contains("active")
    ? custVal * 60
    : custVal;
  piholeChange("disable", custVal);
});

// Session timer
var sessionTimerCounter = document.getElementById("sessiontimercounter");
var sessionvalidity = parseInt(sessionTimerCounter.textContent, 10);
var start = new Date();

function updateSessionTimer() {
  start = new Date();
  start.setSeconds(start.getSeconds() + sessionvalidity);
}

if (sessionvalidity > 0) {
  // setSeconds will correctly handle wrap-around cases
  updateSessionTimer();

  setInterval(function () {
    var current = new Date();
    var totalseconds = (start - current) / 1000;
    var minutes = Math.floor(totalseconds / 60);
    if (minutes < 10) {
      minutes = "0" + minutes;
    }

    var seconds = Math.floor(totalseconds % 60);
    if (seconds < 10) {
      seconds = "0" + seconds;
    }

    if (totalseconds > 0) {
      sessionTimerCounter.textContent = minutes + ":" + seconds;
    } else {
      sessionTimerCounter.textContent = "-- : --";
    }
  }, 1000);
} else {
  document.getElementById("sessiontimer").style.display = "none";
}

// Handle Strg + Enter button on Login page
document.addEventListener("keydown", function (e) {
  var loginForm = document.getElementById("loginform");

  if (!loginForm) {
    return;
  }

  loginForm.addEventListener(
    "focus",
    function () {
      if (
        (e.code === "Enter" || e.code === "NumpadEnter") &&
        (e.code === "ControlLeft" || e.code === "ControlRight")
      ) {
        loginForm.setAttribute("action", "settings.php");
        loginForm.submit();
      }
    },
    true
  );
});

function testCookies() {
  if (navigator.cookieEnabled) {
    return true;
  }

  // set and read cookie
  document.cookie = "cookietest=1";
  var ret = document.cookie.indexOf("cookietest=") !== -1;

  // delete cookie
  document.cookie = "cookietest=1; expires=Thu, 01-Jan-1970 00:00:01 GMT";

  return ret;
}

// The only function that runs on `$(document).ready()`
$(function () {
  var piholeEnableTimer = document.getElementById("enableTimer");
  var target = new Date(parseInt(piholeEnableTimer.innerHTML, 10));
  var seconds = Math.round((target.getTime() - new Date().getTime()) / 1000);

  if (seconds > 0) {
    setTimeout(countDown, 100);
  }

  var cookieInfo = document.getElementById("cookieInfo");

  if (!testCookies() && cookieInfo.length > 0) {
    cookieInfo.style.display = "";
  }

  var checkboxTheme = document.getElementById("checkbox_theme").textContent;

  $("input").icheck({
    checkboxClass: "icheckbox_" + checkboxTheme,
    radioClass: "iradio_" + checkboxTheme,
    increaseArea: "20%"
  });

  // Run check immediately after page loading ...
  checkMessages();
  // ... and once again with five seconds delay
  setTimeout(checkMessages, 5000);
});
