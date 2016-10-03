<?php
/**
 * Created by PhpStorm.
 * User: Jenzri
 * Date: 01/10/2016
 * Time: 20:41
 */

namespace Zf3\Bootstrapdatepicker\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\FormInput;
use Zend\Form\Exception;
class Datepicker extends FormInput
{
    private $inlineScript;
    private $headLink;
    private $url;

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }


    /**
     * @return mixed
     */
    public function getInlineScript()
    {
        return $this->inlineScript;
    }

    /**
     * @param mixed $inlineScript
     */
    public function setInlineScript($inlineScript)
    {
        $this->inlineScript = $inlineScript;
    }

    /**
     * @return mixed
     */
    public function getHeadLink()
    {
        return $this->headLink;
    }

    /**
     * @param mixed $headLink
     */
    public function setHeadLink($headLink)
    {
        $this->headLink = $headLink;
    }


    public function render(ElementInterface $element) {

        $name = $element->getName();
        if ($name === null || $name === '') {
            throw new Exception\DomainException(sprintf(
                '%s requires that the element has an assigned name; none discovered',
                __METHOD__
            ));
        }

        $attributes          = $element->getAttributes();
        $attributes['name']  = $name;
        $type                = $this->getType($element);
        $attributes['type']  = $type;
        $attributes['value'] = $element->getValue();
        if ('password' == $type) {
            $attributes['value'] = '';
        }
        $settings= $element->getOption("settings");
        $id=array_key_exists("id",$settings)  ? $settings['id']:"datapicker_".uniqid();
        $datepickeroption=array_key_exists("datepicker",$settings)  ? $settings['datepicker']:array();

        $datepickericon=array_key_exists("icon",$settings)  ? $settings['icon']:false;
        $datepickericon_class=array_key_exists("icon-class",$settings)  ? $settings['icon-class']:"glyphicon glyphicon-th";

        if($datepickericon){
            $this->getInlineScript()->captureStart();
            echo "
            $('#$id .input-group.date').datepicker(".json_encode($datepickeroption).");
";
            $this->getInlineScript()->captureEnd();
            return sprintf(
                '<div id="'.$id.'"> <div class="input-group date">
                  <input  %s%s  <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                </div></div>
',
                $this->createAttributesString($attributes),
                $this->getInlineClosingBracket()
            );
        }
        else{
            $this->getInlineScript()->captureStart();
            echo "
            $('#$id').datepicker(".json_encode($datepickeroption).");
";
            $this->getInlineScript()->captureEnd();
            return sprintf(
                '<input id="'.$id.'" %s%s  ',
                $this->createAttributesString($attributes),
                $this->getInlineClosingBracket()
            );
        }

    }

    public function __invoke(ElementInterface $element = null) {
        $settings= $element->getOption("settings");
        $datepickeroption=array_key_exists("datepicker",$settings)  ? $settings['datepicker']:array();
        $datepickerlang=array_key_exists("language",$datepickeroption)  ? $datepickeroption['language']:"";
        $this->getInlineScript()->appendFile(($this->getUrl())('bootsrap-datapicker',array("action"=>"js","lang"=>$datepickerlang)));
        $this->getHeadLink()->prependStylesheet(($this->getUrl())('bootsrap-datapicker',array("action"=>"css")));

        return $this->render($element);
    }

    /**
     * Determine input type to use
     *
     * @param  ElementInterface $element
     * @return string
     */
    protected function getType(ElementInterface $element)
    {
        $type = $element->getAttribute('type');
        if (empty($type)) {
            return 'text';
        }

        $type = strtolower($type);
        return $type;
    }
}