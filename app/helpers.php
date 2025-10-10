<?php

if (!function_exists('formatBytes')) {
    /**
     * Format bytes into human readable file size
     *
     * @param int $bytes
     * @param int $precision
     * @return string
     */
    function formatBytes($bytes, $precision = 2) {
        if ($bytes == 0) {
            return '0 Bytes';
        }

        $units = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB'];

        // More robust approach that works across PHP versions
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}

if (!function_exists('getFileIcon')) {
    /**
     * Get appropriate icon class for file extension
     *
     * @param string $filename
     * @return string
     */
    function getFileIcon($filename) {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

        $icons = [
            'pdf' => 'fas fa-file-pdf text-danger',
            'doc' => 'fas fa-file-word text-primary',
            'docx' => 'fas fa-file-word text-primary',
            'xls' => 'fas fa-file-excel text-success',
            'xlsx' => 'fas fa-file-excel text-success',
            'ppt' => 'fas fa-file-powerpoint text-warning',
            'pptx' => 'fas fa-file-powerpoint text-warning',
            'jpg' => 'fas fa-file-image text-info',
            'jpeg' => 'fas fa-file-image text-info',
            'png' => 'fas fa-file-image text-info',
            'gif' => 'fas fa-file-image text-info',
            'zip' => 'fas fa-file-archive text-dark',
            'rar' => 'fas fa-file-archive text-dark',
            'txt' => 'fas fa-file-alt text-muted',
        ];

        return $icons[$extension] ?? 'fas fa-file text-secondary';
    }
}
