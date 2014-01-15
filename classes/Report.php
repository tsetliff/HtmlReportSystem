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

    public static function create($name)
    {
        // Sanitize name
        $sanitizedName = preg_replace('/[^a-zA-Z0-9 ]/', '', $name);
        if ($name !== $sanitizedName) {
            echo("Report may have had invalid characters.  Currently only alpha numeric characters and spaces are allowed." . PHP_EOL);
        }

        $newDirectory = RESOURCE_LOCATION . '/Reports/' . $sanitizedName;

        if (file_exists($newDirectory)) {
            echo("That name is already in use.  Please choose another." . PHP_EOL);
        }

        mkdir($newDirectory);

        if (!file_exists($newDirectory)) {
            echo("Error creating directory.  Ask your systems administrator to check the log files." . PHP_EOL);
        }

        // In the future copying a template might go here, but for now... blank file.
        $newFile = $newDirectory . '/' . $sanitizedName . '.html';
        $result = file_put_contents($newFile, '');
        if ($result === false) {
            echo("Error creating file $newFile" . PHP_EOL);
        }
    }


    public function isReport($filePath) {
        $filePath = realpath($filePath);
        if (!is_dir($filePath)) return false;
        $reportDirectory = RESOURCE_LOCATION . '/Reports/';
        if (substr($filePath, 0, strlen($reportDirectory)) == $reportDirectory) {
            return true;
        }
        return false;
    }

    protected function renderHeader()
    {
        $title = $this->getTitle();
        return <<< EOT
<html>
    <head>
        <title>$title</title>
        <link href="js/vendor/jqueryFileTree/jqueryFileTree.css" rel="stylesheet" type="text/css" />
        <link href="css/main.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
        <script type="text/javascript" src="js/vendor/jqueryFileTree/jqueryFileTree.js"></script>
        <script src="js/vendor/jQuery-File-Upload-9.5.2/js/vendor/jquery.ui.widget.js"></script>
        <script src="js/vendor/jQuery-File-Upload-9.5.2/js/jquery.iframe-transport.js"></script>
        <script src="js/vendor/jQuery-File-Upload-9.5.2/js/jquery.fileupload.js"></script>
        <script src="js/vendor/nicEdit/nicEdit.js"></script>
    </head>
    <body>
EOT;
    }

    public function render()
    {
        $document = $this->renderHeader();
        $document .= file_get_contents($this->_filePath . $this->getFileName());
        $document .= $this->renderFooter();
        return $document;
    }

    public function getFileName()
    {
        $parts = explode('/', $this->_filePath);
        array_pop($parts);
        return array_pop($parts) . '.html';
    }

    protected function renderFooter()
    {
        return <<< EOT
</body>
</html>
EOT;
    }

    public function getTitle()
    {
        $parts = explode('/', $this->_resourcePath);
        array_pop($parts);
        $name = array_pop($parts);
        return $name;
    }
} 