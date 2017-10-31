<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="message success msg-pop" onclick="this.classList.add('hidden')"><?= $message ?></div>
