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
    <p>Each report has it's own directory. Click the view icon to view the report or open the directory and click it.</p>
    <div class="resource_tree" id="report_tree"></div>
    <script>
        $(document).ready( function() {
            displayResourceTree('report_tree', '/Reports/');
        });
    </script>
    <div class="add_report">
        Add a blank report named <input type="text" id="newReportName" /><img src="images/22x22-list-add-5.png" alt="Add a list" onclick="addReport();">
    </div>
</div>


<div class="resource_manager">
    <h1>Resource Manager</h1>

    <div class="resource_tree" id="resource_tree"></div>
    <script>
        $(document).ready( function() {
            displayResourceTree('resource_tree', '/')
        });
    </script>

    <div id="progress">
        <div class="bar" style="width: 0%;height: 10px; background:green;"></div>
    </div>
</div>

<script>
    function addReport() {
        $.post( "resources.php", { action: 'addReport', name: $('#newReportName').val()}, function( data ) {
            $('#newReportName').val('');
            displayResourceTree('report_tree', '/Reports/');
            // The response will have any related error messages.
            if(data.length) {
                alert(data);
            }
        })
    }

    function displayResourceTree(id, root)
    {
        $('#' + id).fileTree({ root: root, script: 'resources.php', expandSpeed: 150, collapseSpeed: 150 }, function(file) {
            alert(file);
        });
    }

    // Custom script to add upload options to file tree
    function onBranchExpand(dir, t) {
        $('.tree_upload').fileupload({
            dataType: 'json',
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    // Refresh the folder
                    refreshFolder(t);

                    // Reset the progress bar
                    $('#progress .bar').css(
                        'width',
                        0
                    );
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
                ],
            fail: function (e, data)
            {
                alert('File upload failed.' + data.errorThrown + ' ' + data.textStatus);
            }
        });

        // Add tools to each line of files
        $('#'+ t).find('.file_tools').append('<img class=\"delete_resource\" src="images/16x16-edit-delete-2.png" alt=\"Delete File\"/>');
        // The following line is not working
        $('#'+ t).find('.report_directory_tools').append(
            '<img class=\"delete_resource\" src="images/16x16-edit-delete-2.png" alt=\"Delete File\"/>' +
            '&nbsp;<img class=\"view_report\" src="images/16x16-go-next.png" alt=\"View Report\"/>');
        $('#'+ t).find('.delete_resource').click(function() {
            var resourceName = $(this).parent().parent().find("a").attr('rel');
            var msg = "Are you sure you want to delete " + resourceName + '?';
            if (confirm(msg)) {
                $.post( "resources.php", { action: 'delete', file: resourceName}, function( data ) {
                    // Adding a confirmation here would be nice when we have a global messasge div.
                    refreshFolder(t);
                })
                    .fail(function() {
                        alert("error");
                        refreshFolder(t);
                    });
            }
        });
        $('#'+ t).find('.view_report').click(function() {
            var resourceName = $(this).parent().parent().find("a").attr('rel');
            alert('Go view ' + resourceName);
        });

    }

    function refreshFolder(tgt)
    {
        // If the parent folder exists, refresh it.
        var folder = $('#'+ tgt).parent().children().first();
        if (folder.prop('tagName') == 'A') {
            folder.trigger('click');
            folder.trigger('click');
        } else {
            $treeRoot = $('#'+ tgt).closest('.resource_tree');
            // Having to maintain a list isn't great
            // There should be soem other way the div id is regestered to the directory settings.
            // or, it would be cool if the tree code itself had a refresh option.
            if ($treeRoot.attr('id') == 'report_tree') {
                displayResourceTree('report_tree', '/Reports/');
            }
        }
    }
</script>

</body>
</html>
