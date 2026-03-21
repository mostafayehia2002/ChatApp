<?php

if (!function_exists('notifyMessage')) {
    /**
     *
     * @param string $type 'success', 'error', 'info', 'warning'
     * @param string $position
     * @param bool $rtl
     */
    function notifyMessage(string $message, string $type = 'success', string $position = 'top-center', bool $rtl = true): void
    {
        flash($message, $type, ['position' => $position, 'rtl' => $rtl]);

    }
}
