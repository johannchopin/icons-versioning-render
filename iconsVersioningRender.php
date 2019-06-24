<?php

class IconsVersioningRender
{
    protected $localPath;
    protected $projectParams;

    public function __construct(string $absolutPathToProject, string $pathToIconsFolder = "/icons")
    {
        $this->localPath = dirname(__FILE__);

        $this->projectParams["absolutPathToProject"] = $absolutPathToProject;
        $this->projectParams["projectName"] = "";
        $this->projectParams["customCssFiles"] = [];
        $this->projectParams["pathToIconsFolder"] = $pathToIconsFolder;
    }

    public function render()
    {
        $this->renderPage();
    }

    public function addProjectName(string $projectName)
    {
        $this->projectParams["projectName"] = $projectName;
    }

    public function addCustomCss(array $customCssFiles)
    {
        $this->projectParams["customCssFiles"] = $customCssFiles;
    }

    protected function getProjectParams()
    { }

    protected function getallIconPath()
    {
        $allIconPath = [];
        foreach (glob($this->projectParams["absolutPathToProject"] . $this->projectParams["pathToIconsFolder"] . '/*') as $iconPath) {
            array_push($allIconPath, $iconPath);
        }

        return array_reverse($allIconPath);
    }

    protected function pageRender()
    {
        $pageStructure = $this->getPageStructure();

        $pageStructure = str_replace("@icons", $this->iconsRender(), $pageStructure);
        $pageStructure = str_replace("@defaultCss", $this->getHTMLDefaultCss(), $pageStructure);
        $pageStructure = str_replace("@customCss", $this->getHTMLCustomCssFiles(), $pageStructure);
        $pageStructure = str_replace("@projectName", $this->projectParams["projectName"], $pageStructure);

        return $pageStructure;
    }

    protected function iconsRender()
    {
        $iconsHtml = "";
        $allIconPath = $this->getallIconPath();

        foreach ($allIconPath as $iconPath) {
            $iconVersion = str_replace($this->projectParams["absolutPathToProject"] . $this->projectParams["pathToIconsFolder"] . "/", "", $iconPath);
            $relativIconPath = str_replace($this->projectParams["absolutPathToProject"], ".", $iconPath);

            $iconVersion = "<h3> > " . $iconVersion . "</h3>";
            $iconImg = "<img src=\"" . $relativIconPath . "\" alt=\"icon\"><br>";

            $iconsHtml .= "<div class=\"img-ctn\">" . $iconVersion . $iconImg . "</div>";
        }

        return $iconsHtml;
    }

    protected function getPageStructure()
    {
        return file_get_contents($this->localPath . "/src/pageStructure.html");
    }

    protected function getHTMLCustomCssFiles()
    {
        $HTMLCustomCssFiles = "";

        foreach ($this->projectParams["customCssFiles"] as $cssFileName) {
            $HTMLCustomCssFiles .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"" . $cssFileName . "\">";
        }

        return $HTMLCustomCssFiles;
    }

    protected function getHTMLDefaultCss()
    {
        $defaultCss = file_get_contents($this->localPath . "/src/default.css");

        return "<style type=\"text/css\">" . $defaultCss . "</style>";
    }


    protected function renderPage()
    {
        echo $this->pageRender();
    }
}
