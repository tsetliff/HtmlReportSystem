<?php
class Report_Edit extends Report
{
    public function render()
    {
        $document = $this->renderHeader();
        $document .= $this->addEditorStart();
        $document .= htmlspecialchars(file_get_contents($this->_filePath . $this->getFileName()));
        $document .= $this->addEditorEnd();
        $document .= $this->renderFooter();
        return $document;
    }

    private function addEditorStart()
    {
        return <<< EOT
            <textarea id="report_editor" style="width: 100%; height:80%">
EOT;
    }

    private function addEditorEnd()
    {
        $fullPathToFile = $this->_resourcePath . $this->getFileName();
        return <<< EOT
</textarea>
            <script type="text/javascript">
                bkLib.onDomLoaded(function() {
                    new nicEditor({
                        onSave: function(content, id, instance) {
                            $.post( "resources.php", { action: 'saveFile', file: '$fullPathToFile', content: content}, function( data ) {
                                // The response will have any related error messages.
                                if(data.length) {
                                    alert(data);
                                }
                            })
                        },
                        fullPanel: true,
                        iconsPath: 'js/vendor/nicEdit/nicEditorIcons.gif'
                    }).panelInstance('report_editor');
                });
            </script>
EOT;

    }
} 