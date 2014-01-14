<?php
class Report_Edit extends Report
{
    public function render()
    {
        // Put things in terms of tags that work in the WYSIWYG editor.
        // Add widget sidebar, menu with editing options.
        // Return options such as selected style sheet in json as well.
        parent::render();
        echo("<html><head><script src=\"js/vendor/nicEdit/nicEdit.js\"></script></head><body>
        <script type=\"text/javascript\">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
        <textarea>");
        echo(htmlspecialchars(file_get_contents($this->_filePath . 'Demo.html')));
        echo("</textarea></body></html>");
    }
} 