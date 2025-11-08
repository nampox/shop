<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

/**
 * Controller for viewing application logs.
 */
class LogController extends Controller
{
    /**
     * Display the logs page.
     */
    public function index(Request $request)
    {
        $logFiles = $this->getLogFiles();
        $selectedFile = $request->get('file', 'laravel.log');
        $level = $request->get('level', 'all');
        $search = $request->get('search', '');
        $selectedDate = $request->get('date', '');

        $logs = $this->getLogs($selectedFile, $level, $search, $selectedDate);
        $logsByDate = $this->groupLogsByDate($logs);
        $availableDates = $this->getAvailableDates($selectedFile);

        return view('logs.index', [
            'logFiles' => $logFiles,
            'selectedFile' => $selectedFile,
            'level' => $level,
            'search' => $search,
            'selectedDate' => $selectedDate,
            'logsByDate' => $logsByDate,
            'availableDates' => $availableDates,
        ]);
    }

    /**
     * Get list of available log files.
     *
     * @return array
     */
    protected function getLogFiles(): array
    {
        $logPath = storage_path('logs');
        $files = File::files($logPath);
        
        $logFiles = [];
        foreach ($files as $file) {
            if ($file->getExtension() === 'log') {
                $logFiles[] = $file->getFilename();
            }
        }

        // Sort by modification time (newest first)
        usort($logFiles, function ($a, $b) use ($logPath) {
            return filemtime($logPath . '/' . $b) - filemtime($logPath . '/' . $a);
        });

        return $logFiles;
    }

    /**
     * Get logs from file with filtering.
     *
     * @param  string  $fileName
     * @param  string  $level
     * @param  string  $search
     * @param  string  $selectedDate
     * @return array
     */
    protected function getLogs(string $fileName, string $level, string $search, string $selectedDate = ''): array
    {
        $logPath = storage_path('logs/' . $fileName);
        
        if (!File::exists($logPath)) {
            return [];
        }

        $content = File::get($logPath);
        $lines = explode("\n", $content);
        
        $logs = [];
        $currentLog = null;

        foreach ($lines as $line) {
            // Check if line starts a new log entry (Laravel log format)
            if (preg_match('/^\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\] (.+?)\.(.+?): (.+)$/', $line, $matches)) {
                // Save previous log if exists
                if ($currentLog !== null) {
                    if ($this->shouldIncludeLog($currentLog, $level, $search, $selectedDate)) {
                        $logs[] = $currentLog;
                    }
                }

                // Extract date from timestamp
                $timestamp = $matches[1];
                $date = substr($timestamp, 0, 10); // YYYY-MM-DD

                // Start new log entry
                $currentLog = [
                    'timestamp' => $timestamp,
                    'date' => $date,
                    'time' => substr($timestamp, 11), // HH:MM:SS
                    'environment' => $matches[2],
                    'level' => strtoupper($matches[3]),
                    'message' => $matches[4],
                    'context' => '',
                ];
            } elseif ($currentLog !== null) {
                // Append to context
                $currentLog['context'] .= $line . "\n";
            }
        }

        // Add last log
        if ($currentLog !== null && $this->shouldIncludeLog($currentLog, $level, $search, $selectedDate)) {
            $logs[] = $currentLog;
        }

        // Reverse to show newest first
        return array_reverse($logs);
    }

    /**
     * Group logs by date.
     *
     * @param  array  $logs
     * @return array
     */
    protected function groupLogsByDate(array $logs): array
    {
        $grouped = [];

        foreach ($logs as $log) {
            $date = $log['date'];
            if (!isset($grouped[$date])) {
                $grouped[$date] = [];
            }
            $grouped[$date][] = $log;
        }

        // Sort dates descending (newest first)
        krsort($grouped);

        return $grouped;
    }

    /**
     * Get available dates from log file.
     *
     * @param  string  $fileName
     * @return array
     */
    protected function getAvailableDates(string $fileName): array
    {
        $logPath = storage_path('logs/' . $fileName);
        
        if (!File::exists($logPath)) {
            return [];
        }

        $content = File::get($logPath);
        $lines = explode("\n", $content);
        
        $dates = [];

        foreach ($lines as $line) {
            if (preg_match('/^\[(\d{4}-\d{2}-\d{2})/', $line, $matches)) {
                $date = $matches[1];
                if (!in_array($date, $dates)) {
                    $dates[] = $date;
                }
            }
        }

        // Sort dates descending (newest first)
        rsort($dates);

        return $dates;
    }

    /**
     * Check if log should be included based on filters.
     *
     * @param  array  $log
     * @param  string  $level
     * @param  string  $search
     * @param  string  $selectedDate
     * @return bool
     */
    protected function shouldIncludeLog(array $log, string $level, string $search, string $selectedDate = ''): bool
    {
        // Filter by date
        if (!empty($selectedDate) && isset($log['date']) && $log['date'] !== $selectedDate) {
            return false;
        }

        // Filter by level
        if ($level !== 'all' && strtolower($log['level']) !== strtolower($level)) {
            return false;
        }

        // Filter by search
        if (!empty($search)) {
            $searchLower = strtolower($search);
            $messageLower = strtolower($log['message']);
            $contextLower = strtolower($log['context']);
            
            if (strpos($messageLower, $searchLower) === false && 
                strpos($contextLower, $searchLower) === false) {
                return false;
            }
        }

        return true;
    }

    /**
     * Download log file.
     */
    public function download(string $fileName)
    {
        $logPath = storage_path('logs/' . $fileName);
        
        if (!File::exists($logPath)) {
            abort(404, 'Log file not found');
        }

        return response()->download($logPath);
    }

    /**
     * Clear log file.
     */
    public function clear(string $fileName)
    {
        $logPath = storage_path('logs/' . $fileName);
        
        if (!File::exists($logPath)) {
            abort(404, 'Log file not found');
        }

        File::put($logPath, '');

        $this->logInfo('Log file cleared', [
            'file' => $fileName,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('logs.index')
            ->with('success', "Đã xóa log file: {$fileName}");
    }
}
