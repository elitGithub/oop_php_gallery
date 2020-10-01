<?php


namespace Gallery;


class Utils
{
    /**
     * @param $location
     */
    public static function redirect($location): void
    {
        header("Location: $location");
    }

    /**
     * @param bool $success
     * @param string $message
     * @param array $data
     */
    public static function sendFinalResponseAsJson($success = true, $message = '', $data = []): void
    {
        if (!is_array($data)) {
            $data = [$data];
        }
        die(@json_encode(['success' => $success, 'message' => $message, 'data' => $data]));
    }
}