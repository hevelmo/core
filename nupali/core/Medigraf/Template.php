<?php
//namespace Medigraf;

/**
 * This class 
 * 
 * @author Francisco Javier Corona Sánchez <javier@medigraf.com.mx>
 * @copyright 2017
 */
class Template
{
    private $loader;
    private $twig;   
    private $path;
    private $name;
    private $twigConfig;
    private $masterConfigArray;

    /**
     * Description
     * @param type $path 
     * @param type $name 
     * @param type $twigConfig 
     * @param type $masterConfigArray 
     * @return type
     */
    function __construct($path, $name, $twigConfig, $masterConfigArray)
    {
        $this->path              = $path;
        $this->name              = $name;
        $this->twigConfig        = $twigConfig;
        $this->masterConfigArray = $masterConfigArray;
        $this->startTwig();
    }

    /**
     * Description
     * @return type
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Description
     * @return type
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Description
     * @return type
     */
    public function getTwigConfig()
    {
        return $this->twigConfig;
    }

    /**
     * Description
     * @return type
     */
    public function getMasterConfigArray()
    {
        //Get an array arguments to the method
        $args       = func_get_args();
        //Get number of arguments
        $numArgs    = func_num_args();
        //Make a method name
        $methodName = __FUNCTION__ . $numArgs;
        //If the method exists called it 
        if (method_exists($this, $methodName)) {
            return call_user_func_array(array(
                $this,
                $methodName
            ), $args);
            //Otherwise
        } else {
        }
    }

    /**
     * Description
     * @param type $keys 
     * @return type
     */
    private function getMasterConfigArray1($keys)
    {
        return (gettype($keys) === "array") ? $this->getMasterConfigArrayArray($keys) : $this->getMasterConfigArrayValue($keys);
    }

    /**
     * Description
     * @return type
     */
    private function getMasterConfigArray0()
    {
        return $this->masterConfigArray;
    }

    /**
     * Description
     * @param type $key 
     * @return type
     */
    private function getMasterConfigArrayValue($key)
    {
        return (array_key_exists($key, $this->masterConfigArray)) ? $this->masterConfigArray[$key] : false;
    }

    /**
     * Description
     * @param type $keys 
     * @return type
     */
    private function getMasterConfigArrayArray($keys)
    {
        $foundMasterConfigArray = array();
        foreach ($keys as $key) {
            $foundMasterConfigArray[$key] = $this->getMasterConfigArrayValue($key);
        }
        return $foundMasterConfigArray;
    }

    /**
     * Description
     * @param type $siteName 
     * @param type $nameDefault 
     * @param type $description 
     * @param type $imageDefault 
     * @return type
     */
    public function makeFacebookTags($siteName, $nameDefault, $description, $imageDefault)
    {
        $mime = "";
        if (file_exists($imageDefault)) {    
            $imageInfo = getimagesize($imageDefault);
            $mime = $imageInfo["mime"];
        }
        $this->addToMasterConfigArray(array(
            "tag_site_name" => $siteName,
            "tag_name_default" => $nameDefault,
            "tag_description" => $description,
            "tag_image_default" => $imageDefault,
            "tag_content_type" => $mime
        ));
    }

    /**
     * Description
     * @param type $path 
     * @return type
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * Description
     * @param type $name 
     * @return type
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Description
     * @param type $masterConfigArray 
     * @return type
     */
    public function setMasterConfigArray($masterConfigArray)
    {
        $this->masterConfigArray = $masterConfigArray;
    }

    /**
     * Description
     * @param type $twigConfig 
     * @return type
     */
    public function setTwigConfig($twigConfig)
    {
        $this->twigConfig = $twigConfig;
    }

    /**
     * Description
     * @return type
     */
    public function addToMasterConfigArray()
    {
        //Get an array arguments to the method
        $args       = func_get_args();
        //Get number of arguments
        $numArgs    = func_num_args();
        //Make a method name
        $methodName = __FUNCTION__ . $numArgs;
        //If the method exists called it 
        if (method_exists($this, $methodName)) {
            call_user_func_array(array(
                $this,
                $methodName
            ), $args);
            ksort($this->masterConfigArray);
            //Otherwise
        } else {
        }
    }

    /**
     * Description
     * @param type $masterConfigArray 
     * @return type
     */
    private function addToMasterConfigArray1($masterConfigArray)
    {
        $masterConfigArray = (gettype($masterConfigArray) == "array") ? $masterConfigArray : array();
        $this->masterConfigArray = array_merge($this->masterConfigArray, $masterConfigArray);
    }

    /**
     * Description
     * @param type $key 
     * @param type $value 
     * @return type
     */
    private function addToMasterConfigArray2($key, $value)
    {
        $this->masterConfigArray[$key] = $value;
    }

    /**
     * Description
     * @return type
     */
    public function display()
    {
        $this->twig->display($this->name, $this->masterConfigArray);
    }

    /**
     * Description
     * @return type
     */
    public function render()
    {
        return $this->twig->render($this->name, $this->masterConfigArray);
    }

    /**
     * Description
     * @return type
     */
    private function startTwig()
    {
        Twig_Autoloader::register();
        $this->loader = new Twig_Loader_Filesystem($this->path);
        $this->twig   = new Twig_Environment($this->loader, $this->twigConfig);
    }
}