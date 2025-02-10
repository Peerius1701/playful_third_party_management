<?php
if(!isset($sWidth))
    // Default
    $sWidth = '654px';

if(!isset($aInvalidEntries) || !array_key_exists('sErrorMessage', $aInvalidEntries)) {
    $sErrorMessage = '';
} else {
    $sErrorMessage = '\n' . $aInvalidEntries['sErrorMessage'];
    $sErrorMessage = str_replace('\n', "<br>", $sErrorMessage);
}
if(!empty($aInvalidEntries)) {
    echo '<div class="ptpm-alert alert high" style="max-width: ' . $sWidth . ';" role="alert">
          <span id="fadeout" class="closebtn-red" onclick="this.parentElement.style.display=\'none\';">&times;</span>
                Ungültige Eingaben! ' . $sErrorMessage . '
          </div>';
}
?>

<script>
    var closeButton = document.getElementById("fadeout");
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

