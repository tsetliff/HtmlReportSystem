<?php
require_once("config.php");

/**
 * So basically the job of this system is to load the javascript UI
 */
?>
<html>
<head>
    <title>HTML Reports</title>
    <link href="js/vendor/jqueryFileTree/jqueryFileTree.css" rel="stylesheet" type="text/css" />
    <link href="css/main.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script type="text/javascript" src="js/vendor/jqueryFileTree/jqueryFileTree.js"></script>
    <script src="js/vendor/jQuery-File-Upload-9.5.2/js/vendor/jquery.ui.widget.js"></script>
    <script src="js/vendor/jQuery-File-Upload-9.5.2/js/jquery.iframe-transport.js"></script>
    <script src="js/vendor/jQuery-File-Upload-9.5.2/js/jquery.fileupload.js"></script>
</head>
<body>

<div class="resource_manager">
    <h1>Report List</h1>
    <div class="resource_tree" id="report_tree"></div>
    <script>
        $(document).ready( function() {
            $('#report_tree').fileTree({ root: '/Reports/', script: 'resources.php', expandSpeed: 150, collapseSpeed: 150 }, function(file) {
                alert(file);
            });
        });
    </script>
</div>


<div class="resource_manager">
    <h1>Resource Manager</h1>

    <div class="resource_tree" id="resource_tree"></div>
    <script>
        $(document).ready( function() {
            $('#resource_tree').fileTree({ root: '/', script: 'resources.php', expandSpeed: 150, collapseSpeed: 150 }, function(file) {
                alert(file);
            });
        });
    </script>

    <div id="progress">
        <div class="bar" style="width: 0%;height: 18px; background:green;"></div>
    </div>
</div>

<script>
    function onBranchExpand(dir, t) {
        $('.tree_upload').fileupload({
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    // Refresh the folder
                    var folder = $('#'+ t).parent().children().first();
                    folder.trigger('click');
                    folder.trigger('click');
                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .bar').css(
                    'width',
                    progress + '%'
                );
            },
            formData:
                [
                    {
                        name: 'location',
                        value: dir
                    },
                    {
                        name: 'action',
                        value: 'upload'
                    }
                ]
        });
    }
</script>

</body>
</html>
