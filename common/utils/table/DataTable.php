<?php
namespace common\utils\table;

use Yii;

/**
 * Class DataTable
 * @property integer $draw
 * @property integer $length
 * @property integer $start
 * @property mixed $searchValue
 * @property integer $column
 * @property string $direction
 * @property integer $totalRecords
 * @property array $data
 * @property array $filterDatas
 * @package common\utils\table
 */
abstract class DataTable
{
    public $draw = 1;
    public $length = 10;
    public $start = 0;
    public $searchValue = '';
    public $column = '';
    public $direction = SORT_DESC;
    public $totalRecords = 0;
    public $filterDatas = [];
    public $data = [];

    public function __construct()
    {
        $arguments         = Yii::$app->request->post();
        $this->draw        = $arguments['draw'];
        $this->length      = $arguments['length'] ?: 10;
        $this->start       = $arguments['start'];
        $this->searchValue = $arguments['search']['value'];
        if (array_key_exists('data', $arguments)) {
            $this->data = $arguments['data'];
        }
        if (array_key_exists('order', $arguments)) {
            $this->column = $arguments['order'][0]['column'];
            if ($arguments['order'][0]['dir'] === 'asc') {
                $this->direction = SORT_ASC;
            }
        }
        if (array_key_exists('filterDatas', $arguments)) {
            parse_str($arguments['filterDatas'], $datas);
            $this->filterDatas = $datas;
        }
    }

    public abstract function getData();

    public function getModels()
    {

    }

    public abstract function getColumn();
}

?>