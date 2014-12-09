<?php

require_once("dompdf_config.inc.php");

$dompdf = new DOMPDF();

$html ='<html><head><style type="text/css">'.
'#content-panl {height: 800px;width: 755px;overflow: hidden;padding-top: 9px;width: 755px;border:1px solid red;}'.
'.field1 { border: 1px solid #DAD7D7;float: left;margin: 2px;height: 252px;width: 206px;}'.
'.field2 { border: 1px solid #DAD7D7;float: right;margin: 2px;height: 252px;width: 536px;}'.
'.field3 {border: 1px solid #DAD7D7;float: left;margin: 2px;height: 100px;width: 334px;}'.
'.field4 {border: 1px solid #DAD7D7;float: left;margin: 2px;height: 100px;width: 409px;}'.
'.field5 {border: 1px solid #DAD7D7;float: left;margin: 2px;height: 100px;width: 749px;}'.
'.field6, .field61, .field62 {border: 1px solid #DAD7D7;float: left;margin: 2px;height: 25px;width: 494px;}'.
'.field7, .field71, .field72 {border: 1px solid #DAD7D7;float: left;margin: 2px;height: 25px;width: 249px;}'.
'.field8 {border: 1px solid #DAD7D7;float: left;margin: 2px;height: 100px;width: 334px;}'.
'.field9 {border: 1px solid #DAD7D7;float: left;margin: 2px;height: 100px;width: 409px;}'.
'.field10 {border: 1px solid #DAD7D7;float: left;margin: 2px;height: 100px;width: 749px;}'.
'</style></head><body>'.
'<div id="content-panl" class="drop">'.
'<div class="drop field1"></div>'.
'<div class="drop field2"></div>'.
'<div class="drop field3"></div>'.
'<div class="drop field4"></div>'.
'<div class="drop field5"></div>'.
'<div class="drop field6"></div>'.
'<div class="drop field7"></div>'.
'<div class="drop field61"></div>'.
'<div class="drop field71"></div>'.
'<div class="drop field62"></div>'.
'<div class="drop field72"></div>'.
'<div class="drop field8"></div>'.
'<div class="drop field9"></div>'.
'<div class="drop field5"></div>'.
'</div>'.
'</body></html>';
 
$dompdf = new DOMPDF(); 
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("sample.pdf");



?>