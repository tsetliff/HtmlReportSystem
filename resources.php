<?php
require_once("config.php");

if (!isset($_REQUEST['action'])) {
    displayBranchInformationForJQueryFileTree();
} else if ($_REQUEST['action'] == 'upload') {
    uploadFiles();
} else {
    error_log("Called with unknown action.");
}

function uploadFiles()
{
    error_log(print_r($_REQUEST, true ));
    require('js/vendor/jQuery-File-Upload-9.5.2/server/php/UploadHandler.php');
    $uploadToResourceDirectory = $_REQUEST['location'];
    $options = array();
    $options['upload_dir'] = RESOURCE_LOCATION . $uploadToResourceDirectory;
    error_log($options['upload_dir']);
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
                    echo "<li class=\"directory collapsed\"><a href=\"#\" rel=\"" . htmlentities($dir . $file) . "/\">" . htmlentities($file) . "</a></li>";
                }
            }

            // All files
            //
            foreach( $files as $file ) {
                if( file_exists(RESOURCE_LOCATION . $dir . $file) && $file != '.' && $file != '..' && !is_dir(RESOURCE_LOCATION . $dir . $file) ) {
                    $ext = preg_replace('/^.*\./', '', $file);
                    echo "
                        <li style=\"clear: both\">
                            <div class=\"file ext_$ext icon\">&nbsp;</div>
                            <div class=\"file_name\"><a href=\"#\" rel=\"" . htmlentities($dir . $file) . "\">" . htmlentities($file) . "</a></div>
                            <div class=\"file_tools\">Tools go here</div>
                        </li>";
                }
            }

            // Add a fake file to represent uploading files
            $allowedUploadLocations = array();
            $allowedUploadLocations['Styles'] = 'Upload New Style Sheet';
            $allowedUploadLocations['Clipart'] = 'Upload a clipart image. Images of type SVG are recommended';
            $allowedUploadLocations['Reports'] = 'Upload a clipart image. Images of type SVG are recommended';

            $basename = basename($dir);

            if (array_key_exists($basename, $allowedUploadLocations)) {
                // echo "<li class=\"uploadFile\"><a href=\"#\" rel=\"" . htmlentities($dir) . "\">{$allowedUploadLocations[$basename]}</a></li>";
                echo "
                    <li class=\"uploadFile\" style=\"clear: both\">
                        <input id=\"fileupload\" class=\"tree_upload\" type=\"file\" name=\"files[]\" data-url=\"resources.php\" multiple>
                        <script>onBranchExpand('$dir', 'fileTree_$fileTreeId');</script>
                    </li>";
            }

            echo "</ul>";
        }
    }
}