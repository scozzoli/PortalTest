<?php
  switch($pr->post("type")){
    case "info" :
      $pr->addInfoBox('Messagio di <b class="focus">informazione</b> generigo!');
    break;
    case "alert" :
      $pr->addAlertBox('Messagio di <b class="focus">allerta</b> generigo!');
    break;
    case "error" :
      $pr->addAlertBox('Messagio di <b class="focus">errore</b> generigo!');
    break;
    case "okCancel" :
      $pr->addOkCancelDialog(
        'Finestra di dialogo <b class="focus"> OK - Cancel</b>',
        'alert("hai premuto OK")',
        'alert("hai premuto CANCEL")'
      );
    break;
    case "yesNoCancel" :
      $pr->addYesNoCancelDialog(
        'Finestra di dialogo <b class="focus"> Yes - No - Cancel </b>',
        'alert("hai premuto YES")',
        'alert("hai premuto NO")',
        'alert("hai premuto CANCEL")'
      );
    break;
  }
  $pr->response();
?>
