<?php
if ($show_alert) {
    $alert_class = $alert_status == 0 ? 'medium' : ($alert_status == -1 ? 'high' : 'success');
    $button_type = $alert_status == 0 ? 'closebtn-orange' : ($alert_status == -1 ? 'closebtn-red' : 'closebtn-green');
    $alert_info = str_replace('\n', "<br>", $alert_info);
    echo '<div  class="alert ptpm-alert  ' . $alert_class . '">
                <span id="fadeout-button" class="'. $button_type .'" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                <strong>' . ($alert_status <= 0 ? 'Achtung!' : '') . '</strong> '. ($alert_status <= 0 ? '<br/>' : '') . $alert_info . '
            </div>';
}
?>

<script>
    var closeButton = document.getElementById("fadeout-button");
    if(closeButton !== null) {
        closeButton.onclick = function () {
            var div = this.parentElement;
            div.style.opacity = "0";
            setTimeout(function () {
                div.style.display = "none";
            }, 600);
        }
    }
</script>