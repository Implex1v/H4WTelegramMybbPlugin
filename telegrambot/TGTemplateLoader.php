<?php

/**
 * Class TemplateLoader for loading a template file into a string which will be inserted into the mybb_templates table
 */
class TGTemplateLoader {
    private $extension = ".tpl";
    private $templateDir;

    function __construct() {
        $this->templateDir = __DIR__ . "/templates/";
    }

    /**
     * Loads the specified template file into a string from the template directory
     * @param $templateName
     * @throws Exception Thrown if $templateName is null or specified file is not found
     * @return The template loaded from file
     */
    function load($templateName) {
        if(! $templateName) {
            throw new Exception("Template name mustn't be null.");
        }

        $file = $this->templateDir . $templateName . $this->extension;
        if(file_exists($file)) {
            $template = file_get_contents($file);

            return $template;
        } else {
            throw new Exception("File ".$file. " not found");
        }
    }
}