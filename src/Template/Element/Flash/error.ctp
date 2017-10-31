<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message error msg-pop" onclick="this.classList.add('hidden');"><?= $message ?></div>
