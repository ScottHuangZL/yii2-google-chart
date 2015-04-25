<?php

namespace scotthzl\googlechart;

use yii\base\Widget;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\web\View;


/**
 * This is just an example.
 */
class GoogleChart extends Widget
{
    public $message;
    /**
     * @var string $containerId the container Id to render the visualization to
     */
    public $containerId;

    /**
     * @var string $visualization the type of visualization -ie PieChart
     * @see https://google-developers.appspot.com/chart/interactive/docs/gallery
     */
    public $visualization;

    /**
     * @var string $packages the type of packages, default is corechart
     * @see https://google-developers.appspot.com/chart/interactive/docs/gallery
     */
    public $packages = 'corechart';  // such as 'orgchart' and so on.

    public $loadVersion = "1"; //such as 1 or 1.1  Calendar chart use 1.1.  Add at Sep 16

    /**
     * @var array $data the data to configure visualization
     * @see https://google-developers.appspot.com/chart/interactive/docs/datatables_dataviews#arraytodatatable
     */
    public $data = array();

    /**
     * @var array $options additional configuration options
     * @see https://google-developers.appspot.com/chart/interactive/docs/customizing_charts
     */
    public $options = array();

    /**
     * @var array $htmlOption the HTML tag attributes configuration
     */
    public $htmlOptions = array();

    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = 'Hello World';
        }
    }

    public function run()
    {

        $id = $this->getId();
        // if no container is set, it will create one
        if ($this->containerId == null) {
            $this->htmlOptions['id'] = 'div-chart' . $id;
            $this->containerId = $this->htmlOptions['id'];
            echo '<div ' . Html::renderTagAttributes($this->htmlOptions) . '></div>';
        }
        $this->registerClientScript($id);
        //return Html::encode($this->message);
    }

    /**
     * Registers required scripts
     */
    public function registerClientScript($id)
    {

        $jsData = Json::encode($this->data);
        $jsOptions = Json::encode($this->options);

        $script = '
			google.setOnLoadCallback(drawChart' . $id . ');
			var ' . $id . '=null;
			function drawChart' . $id . '() {
				var data = google.visualization.arrayToDataTable(' . $jsData . ');

				var options = ' . $jsOptions . ';

				' . $id . ' = new google.visualization.' . $this->visualization . '(document.getElementById("' . $this->containerId . '"));
				' . $id . '.draw(data, options);
			}';

        $view = $this->getView();
        $view->registerJsFile('https://www.google.com/jsapi');
        $view->registerJs('google.load("visualization", "' . $this->loadVersion . '", {packages:["' . $this->packages . '"]});', View::POS_HEAD, __CLASS__ . '#' . $id);
        $view->registerJs($script, View::POS_HEAD, $id);
    }

}
