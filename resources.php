<?php
require_once("config.php");

if (!isset($_REQUEST['action'])) {
    displayBranchInformationForJQueryFileTree();
    exit;
}
$action = $_REQUEST['action'];
if ($action == 'upload') {
    uploadFiles();
} else if ($action == 'delete') {
    deleteResorce($_REQUEST['file']);
} else if ($action == 'addReport') {
    newReport($_REQUEST['name']);
} else {
    error_log("Called with unknown action $action.");
}

function newReport($name)
{
    // Sanitize name
    $sanitizedName = preg_replace('/[^a-zA-Z0-9 ]/', '', $name);
    if ($name !== $sanitizedName) {
        echo("Report may have had invalid characters.  Currently only alpha numeric characters and spaces are allowed.\n");
    }

    $newDirectory = RESOURCE_LOCATION . '/Reports/' . $sanitizedName;

    if (file_exists($newDirectory)) {
        echo("That name is already in use.  Please choose another.\n");
    }

    error_log($newDirectory);
    mkdir($newDirectory);

    if (!file_exists($newDirectory)) {
        echo("Error creating directory.  Ask your systems administrator to check the log files.\n");
    }
}

function deleteResorce($filename)
{
    $filePath = RESOURCE_LOCATION . $filename;
    assertFileIsInResources($filePath);
    if (is_dir($filePath)) {
        rmdir($filePath);
    } else {
        unlink($filePath);
    }
}

/**
 * Generally checks for trickery.
 * By just making sure they are the same we know there wern't any funny characters.
 *
 * @param $filename
 */
function assertFileIsInResources($filename)
{
    if (!$filename == realpath($filename)) {
        error_log("The real path of $filename didn't match, check for file trickery.");
        exit;
    }
}

function uploadFiles()
{
    error_log(print_r($_REQUEST, true ));
    require('js/vendor/jQuery-File-Upload-9.5.2/server/php/UploadHandler.php');
    $uploadToResourceDirectory = $_REQUEST['location'];
    $options = array();
    $options['upload_dir'] = RESOURCE_LOCATION . $uploadToResourceDirectory;
    $upload_handler = new UploadHandler($options);
}

function displayBranchInformationForJQueryFileTree() {
    //
    // jQuery File Tree PHP Connector
    //
    // Version 1.01
    //
    // Cory S.N. LaViska
    // A Beautiful Site (http://abeautifulsite.net/)
    // 24 March 2008
    //
    // History:
    //
    // 1.01 - updated to work with foreign characters in directory/file names (12 April 2008)
    // 1.00 - released (24 March 2008)
    //
    // Output a list of files for jQuery File Tree
    //
    // This code was origional addapted from jQuery File Tree.
    $dir = urldecode($_POST['dir']);

    if( file_exists(RESOURCE_LOCATION . $dir) ) {
        $files = scandir(RESOURCE_LOCATION . $dir);
        natcasesort($files);
        if( count($files) > 2 ) { /* The 2 accounts for . and .. */
            $fileTreeId = str_replace('.', '_', uniqid('',true));
            echo "<ul id=\"fileTree_$fileTreeId\" class=\"jqueryFileTree\" style=\"display: none;\">";

            // All dirs
            foreach( $files as $file ) {
                if( file_exists(RESOURCE_LOCATION . $dir . $file) && $file != '.' && $file != '..' && is_dir(RESOURCE_LOCATION . $dir . $file) ) {
                    $reportDirectoryTools = ($dir == '/Reports/') ? '<div class="report_directory_tools"></div>' : '';
                    echo "
                        <li class=\"directory collapsed\" style=\"clear: both;\">
                            <div class=\"directory_icon icon collapsed\">&nbsp;</div>
                            <a class=\"directory_name\" href=\"#\" rel=\"" . htmlentities($dir . $file) . "/\">" . htmlentities($file) . "</a>
                            $reportDirectoryTools
                            <div style=\"clear:both;\"></div>
                        </li>";
                }
            }

            // All files
            //
            foreach( $files as $file ) {
                if( file_exists(RESOURCE_LOCATION . $dir . $file) && $file != '.' && $file != '..' && !is_dir(RESOURCE_LOCATION . $dir . $file) ) {
                    $ext = preg_replace('/^.*\./', '', $file);
                    echo "
                        <li style=\"clear: both;\">
                            <div class=\"file ext_$ext icon\">&nbsp;</div>
                            <div class=\"file_name\">
                                <a href=\"#\" rel=\"" . htmlentities($dir . $file) . "\">" . htmlentities($file) . "</a>
                            </div>
                            <div class=\"file_tools\"></div>
                        </li>";
                }
            }

            // Add a fake file to represent uploading files
            $allowedUploadLocations = array();
            $allowedUploadLocations['Styles'] = 'Upload New Style Sheet';
            $allowedUploadLocations['Clipart'] = 'Upload a clipart image. Images of type SVG are recommended';

            $basename = basename($dir);

            if (array_key_exists($basename, $allowedUploadLocations)) {
                // echo "<li class=\"uploadFile\"><a href=\"#\" rel=\"" . htmlentities($dir) . "\">{$allowedUploadLocations[$basename]}</a></li>";
                echo "
                    <li class=\"uploadFile\" style=\"clear: both;\">
                        <input id=\"fileupload\" class=\"tree_upload\" type=\"file\" name=\"files[]\" data-url=\"resources.php\" multiple>
                    </li>";
            }

            echo "</ul>";
            echo("<script>onBranchExpand('$dir', 'fileTree_$fileTreeId');</script>");
            echo("<div style=\"clear:both;\"></div>");
        }
    }
}