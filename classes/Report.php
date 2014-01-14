<?php
class Report {
    protected $_resourcePath = '';
    protected $_filePath = '';

    public function __construct($resourcePath) {
        $this->_resourcePath = $resourcePath;
        $this->_filePath = RESOURCE_LOCATION . $this->_resourcePath;
        if (!$this->isReport($this->_filePath)) {
            throw new Exception("Tried to create a report object on a directory ($reportPath) that wasn't a report.");
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

    public function render()
    {
        // Render the header
            // Insert style sheets, the chosen style sheet as well as default stuff.
            // Insert

        // Actually fetch data for data sources & insert into report.
        return file_get_contents($this->_filePath . 'Demo.html');
        // Render the footer.
    }
} 