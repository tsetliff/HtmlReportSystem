<?php
class Report {
    private $_resourcePath = '';
    private $_filePath = '';

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

    function renderForView()
    {
        // Render the header
            // Insert style sheets, the chosen style sheet as well as default stuff.
            // Insert

        // Actually fetch data for data sources & insert into report.

        readfile($this->_filePath . 'Demo.html');

        // Render the footer.
    }

    function renderForEdit()
    {
        // Return JSON
        // Put things in terms of tags that work in the WYSIWYG editor.
        // Add widget sidebar, menu with editing options.
        // Return options such as selected style sheet in json as well.
    }
} 