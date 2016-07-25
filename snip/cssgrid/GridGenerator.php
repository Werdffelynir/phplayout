<?php
/**
 * Created by Oleg Werdffelynir.
 * Date: 03.07.14
 * Time: 22:40
 */

/**
 * Class GridGenerator
 */
class GridGenerator
{

    /** @var number $width
     *  */
    private $width;
    /** @var number $padding
     *  */
    private $padding;
    /** @var number $grid
     *  */
    private $grid;

    /** Дополнительный код
     * @var string $addCode
     * @var string $addCodeBefore
     * @var string $addCodeAfter
     */
    public $addCode;
    public $addCodeBefore;
    public $addCodeAfter;

    /** Процентное соотнощение отступа к ширине
     * @var number $_percentPadding
     */
    private $percentPadding;

    /** Private
     * @var number $sumPadding Сума всех отступов
     * @var array $math
     * @var array $cssData
     * @var array $defConfig
     */
    private $sumPadding;
    private $math = array();
    private $cssData = array();
    private $defConfig = [
        'width' => '960',       // символическая ширина всей сетки/страницы
        'padding' => '5',       // символическая ширина отступов между долями
        'grid' => '12',         // количество долей (блоков/колонок)
        'prefix' => '.grid',    // префикс, имя класса с CSS файле
        'compress' => false,    // true что бы сжать результат
        'path' => '',           // путь сохранения
        'codeBefore' => null,   // добавляет строку CSS правил перед решеткой, для ресет стиля
        'codeAfter' => null,    // добавляет строку CSS правил после решеткойб для дополнительные правил
        'br' => false,
    ];

    /**
     * GridGenerator constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        foreach($this->defConfig as $param => $value ){
            if(isset($config[$param]))
                $this->defConfig[$param] = $config[$param];
        }
    }

    private function math()
    {
        $this->defConfig['padding'] = $this->defConfig['padding']/$this->defConfig['width']*100;
        $this->sumPadding = $this->defConfig['padding']*($this->defConfig['grid']-1);

        $mathData[0] = ($this->defConfig['width'] - $this->sumPadding) / $this->defConfig['grid'];

        $iterator = $this->defConfig['grid']-1;

        for($i=1; $i<$iterator; $i++)
            $mathData[] = $mathData[0] * ($i+1) + $this->defConfig['padding'] * $i;

        for($j=0; $j<$iterator; $j++)
            $this->math[] = $mathData[$j] / $this->defConfig['width'] * 100;
    }

    public function compile()
    {
        $this->math();

        $css = array();
        $grid = $this->defConfig['grid'];
        $prefix = $this->defConfig['prefix'];
        $padding = $this->defConfig['padding'];
        $iterator = $grid - 1;

        for($j=0; $j < $iterator; $j++){
            $numColumn = $j + 1;
            if ($j < $iterator-1){
                $css[] = $prefix.$numColumn.":first-child,";
            }else{
                $css[] = $prefix.$numColumn.":first-child{margin-left:0;}";
            }
        }

        for($r = 0; $r < $iterator; $r ++) {
            $numColumn = $r + 1;
            $css[] = $prefix.$numColumn."{width:".$this->math[$r]."%;}";
        }


        for($i=0; $i<$iterator; $i++) {
            $numColumn = $i + 1;

            if ($i < $iterator-1){
                $css[] = $prefix.$numColumn.",";
            }else{
                $css[] = $prefix.$numColumn.
                    "{display:inline; float:left; margin: 0 0 0 ".$padding."%; list-style:none;}\n".
                    ".first{margin-left:0; clear:left;}\n".
                    ".full,".$prefix.",".$prefix.$grid."{display:block; width:100%; clear:both;}\n".
                    ".full>div:nth-child(1),".$prefix.">div:nth-child(1),".$prefix.$grid.">div:nth-child(1){margin-left:0; clear:left;}\n".
                    ".clear:before, .clear:after{content: \" \"; display: table;}\n.clear:after {clear: both;}\n.clear {*zoom: 1;}";
            }
        }

        $this->cssData = $css;
        return $this;
    }

    public function saveCss($savePath=null, $onlyReturn = false)
    {

        $this->compile();

        $cssString = !empty($this->defConfig['codeBefore'])
            ? $this->defConfig['codeBefore']
            : "*{margin: 0; padding: 0; -webkit-box-sizing: border-box; -moz-box-sizing: border-box; -ms-box-sizing: border-box; box-sizing: border-box;}\n";

        foreach($this->cssData as $item)
            $cssString .= $item."\n";

        $resultCss = !empty($this->defConfig['codeAfter'])
            ? $cssString . $this->defConfig['codeAfter']
            : $cssString . ".hidden{visibility: hidden;}\n.none,.hide{display: none;}\n.block{display: block;}\n";

        if($this->defConfig['compress'])
            $resultCss = str_replace(";}","}",str_replace(["\n"," "],"",$resultCss));
        else if($this->defConfig['br']){
            $resultCss = nl2br($resultCss);
        }

        if(!$onlyReturn){
            $savePath = $savePath ? $savePath : $this->defConfig['path'];

            if(is_file($savePath)) chmod($savePath, 0777);

            $resultSave = file_put_contents($savePath, $resultCss);
            if($resultSave) chmod($savePath, 0777);
        }

        return $resultCss;
    }


    public function set($property,$value)
    {
        if(isset($this->$property))
            $this->$property = $value;
        else
            throw new Exception('Property <b>'.$property.'</b> is not exists!');
    }

    public function get($property)
    {
        if(isset($this->$property))
            return $this->$property;
        else
            throw new Exception('Property "'.$property.'" is not exists!');
    }


}