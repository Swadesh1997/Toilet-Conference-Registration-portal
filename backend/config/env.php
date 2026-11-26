<?php
/**
 * Minimal .env loader.
 * Reads KEY=VALUE pairs from the project-level .env file (one level above /backend)
 * so that no credentials are kept in the source code.
 */
if (!function_exists('env')) {
    $envFile = dirname(__DIR__, 2) . '/.env';
    if (is_readable($envFile)) {
        foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || $line[0] === '#' || strpos($line, '=') === false) {
                continue;
            }
            [$key, $value] = array_map('trim', explode('=', $line, 2));
            $value = trim($value, "\"'");
            if (getenv($key) === false) {
                putenv("$key=$value");
            }
        }
    }

    function env(string $key, $default = null)
    {
        $value = getenv($key);
        return $value === false ? $default : $value;
    }
}
