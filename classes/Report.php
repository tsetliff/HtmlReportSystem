<?php
class Report {
    private $_reportPath = '';

    public function __construct($reportPath) {
        $this->_reportPath = $reportPath;
        if (!$this->isReport($this->_reportPath)) {
            throw new Exception("Tried to create a report object on a directory that wasn't a report.");
        }
    }

    function isReport($filePath) {
        $filePath = realpath($filePath);
        if (!is_dir($filePath)) return false;
        $reportDirectory = RESOURCE_LOCATION . '/Reports/';
        if (substr($filePath, 0, strlen($reportDirectory)) == $reportDirectory) {
            return true;
        }
        return false;
    }
} 