<?php

namespace App\Debug;

use Bitrix\Main\Diag\ExceptionHandlerFormatter;
use Bitrix\Main\Diag\ExceptionHandlerLog;
use Bitrix\Main\Diag\FileExceptionHandlerLog;

class Log extends FileExceptionHandlerLog
{   /**
 * Writes a message to a custom log file in /local/logs/.
 *
 * @param mixed $message The value to log (string, array, or object).
 * @param bool $clear Overwrite the file instead of appending to it.
 * @param string $fileName Log file name, without extension.
 * @param bool $timeVersion Append the current date to the file name.
 *
 * @return void
 */
    public static function addLog($message, bool $clear = false, string $fileName = 'custom', $timeVersion = true): void 
        {
            $logFile = $_SERVER["DOCUMENT_ROOT"] . '/local/logs/' . $fileName;

            if ($timeVersion) {
                $logFile .= '_' . date("d.m.Y");
            }
            $logFile .= '.log';

            $_message = date("d.m.Y H:i:s");
            $_message .= "\n";
            $_message .= print_r($message, true);
            $_message .= "\n";
            $_message .= "---";
            $_message .= "\n";

            if ($clear)
            {
                file_put_contents($logFile, $_message);
            }
            else
            {
                file_put_contents($logFile, $_message, FILE_APPEND);
            }
        }

    /**
     * Clears the content of a custom log file.
     *
     * @param string $fileName Log file name, without extension.
     *
     * @return void
     */
    public static function cleanLog(string $fileName = 'custom')
    {
        $logFile = $_SERVER["DOCUMENT_ROOT"] . '/local/logs/' . $fileName;
        $logFile .= '.log';
        file_put_contents($logFile, '');
    }
    /**
     * Formats the given exception and writes it to the exception log file,
     * prefixing every line with the word "OTUS".
     *
     * @param \Throwable $exception The exception being logged.
     * @param int $logType One of the ExceptionHandlerLog::* type constants.
     *
     * @return void
     */
    public function write($exception, $logType)
    {
        $text = ExceptionHandlerFormatter::format($exception, false, $this->level);

        $context = [
            'type' => static::logTypeToString($logType),
        ];

        $logLevel = static::logTypeToLevel($logType);

        $message = "OTUS - {date} - Host: {host} - {type} - {$text}\n";

        $this->logger->log($logLevel, $message, $context);
    }

}