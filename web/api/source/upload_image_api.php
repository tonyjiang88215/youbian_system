<?php
$callback = $_GET['callback'];
echo '<script type="text/javascript">';
echo 'window.top.'.$callback.'("data:'.$_FILES['image']['type'].';base64,'.base64_encode(file_get_contents($_FILES['image']['tmp_name'])).'");';
echo '</script>';
