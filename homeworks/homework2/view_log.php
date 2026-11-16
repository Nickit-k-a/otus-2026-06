<?php
$logPath = $_SERVER["DOCUMENT_ROOT"] . '/local/logs/log_custom.log';
$content = file_get_contents($logPath);
?>
<pre><?= htmlspecialchars($content, ENT_QUOTES, 'UTF-8') ?></pre>