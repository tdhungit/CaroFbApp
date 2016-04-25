<?php
/**
 * Created by Jacky.
 * User: Jacky
 * E-Mail: jacky@carocrm.com or jacky@youaddon.com
 * Date: 7/28/2015
 * Time: 1:49 PM
 * Project: carofw
 * File: ModelBase.php
 */

namespace Modules\Backend\Models;


use Phalcon\Mvc\Model;
use Phalcon\Paginator\Adapter\Model as PaginatorModel;

class ModelBase extends Model
{
    public $name_base = "Modules\\Backend\\Models\\";
    // config view
    public $list_view = array();
    public $detail_view = array();
    public $edit_view = array();
    public $menu = array();
    // config custom query
    static public $custom_conditions = null;
    static public $custom_bind = null;

    public function initialize()
    {
        $class_name = str_replace($this->name_base, '', get_class($this));
        $config_name = $class_name . '.conf.php';
        $file_config = APP_PATH . 'apps/backend/config/' . $config_name;
        if (is_file($file_config)) {
            $layout_config_list_view = array();
            $layout_config_detail_view = array();
            $layout_config_edit_view = array();
            include $file_config;
            $this->list_view = $layout_config_list_view;
            $this->detail_view = $layout_config_detail_view;
            $this->edit_view = $layout_config_edit_view;
        }
    }

    /**
     * @param $text
     * @return mixed|string
     */
    static public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        // trim
        $text = trim($text, '-');
        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // lowercase
        $text = strtolower($text);
        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }

    /**
     * render custom code in setting view model
     * user can user row value of current model
     * example:
     * {{ id }} or {{ name }}
     *
     * @param $custom_code
     * @return mixed
     */
    public function renderCustomCode($custom_code)
    {
        preg_match_all('/\{\{(.*)\}\}/U', $custom_code, $fields);
        $find = array();
        $replace = array();
        $i = 0;
        foreach ($fields[1] as $field) {
            $find[] = $fields[0][$i];
            $field = trim($field);
            $replace[] = !empty($this->$field) ? $this->$field : '';
            $i++;
        }
        return str_replace($find, $replace, $custom_code);
    }

    /**
     * Inserts or updates a model instance. Returning true on success or false otherwise.
     * <code>
     * //Creating a new robot
     * $robot = new Robots();
     * $robot->type = 'mechanical';
     * $robot->name = 'Astro Boy';
     * $robot->year = 1952;
     * $robot->save();
     * //Updating a robot name
     * $robot = Robots::findFirst("id=100");
     * $robot->name = "Biomass";
     * $robot->save();
     * </code>
     *
     * @param array $data
     * @param array $whiteList
     * @return boolean
     */
    public function save($data = null, $whiteList = null)
    {
        if (empty($this->created)) {
            $this->created = date('Y-m-d H:i:s');
        }

        if (empty($this->user_created_id)) {
            $this->user_created_id = 0;
        }

        if (empty($this->deleted)) {
            $this->deleted = 0;
        }

        if (empty($this->slug) && !empty($this->name)) {
            $this->slug = $this->slugify($this->name);
        }

        if (empty($this->id) && !empty($this->password)) {
            $this->password = md5($this->password);
        }

        return parent::save($data, $whiteList); // TODO: Change the autogenerated stub
    }

    /**
     * @param null $parameters
     * @return Model\ResultsetInterface
     */
    public static function find($parameters = null)
    {
        if (static::$custom_conditions) {
            if (strpos($parameters, '=') === false) {
                $parameters = "id = $parameters";
            }
            if (is_string($parameters)) {
                $parameters .= static::$custom_conditions;
            }
        }

        if (static::$custom_bind) {
            if (is_string($parameters)) {
                $parameters = array($parameters);
            }
            foreach (static::$custom_bind as $bind => $value) {
                $parameters['bind'][$bind] = $value;
            }
        }

        $data = parent::find($parameters);
        static::$custom_conditions = null;
        static::$custom_bind = null;
        return $data;
    }

    /**
     * @param null $parameters
     * @return Model
     */
    public static function findFirst($parameters = null)
    {
        if (static::$custom_conditions) {
            if (strpos($parameters, '=') === false) {
                $parameters = "id = $parameters";
            }
            if (is_string($parameters)) {
                $parameters .= static::$custom_conditions;
            }
        }

        if (static::$custom_bind) {
            if (is_string($parameters)) {
                $parameters = array($parameters);
            }
            foreach (static::$custom_bind as $bind => $value) {
                $parameters['bind'][$bind] = $value;
            }
        }

        $data = parent::findFirst($parameters);
        static::$custom_conditions = null;
        static::$custom_bind = null;
        return $data;
    }

    /**
     * @param $data
     * @param $limit
     * @param $current_page
     * @return \stdclass
     */
    public static function pagination($data, $limit, $current_page)
    {
        $paginator = new PaginatorModel(array(
            "data"  => $data,
            "limit" => $limit,
            "page"  => $current_page > 0 ? $current_page : 1
        ));

        return $paginator->getPaginate();
    }

    /**
     * All Fields on Model 
     * 
     * @return mixed
     */
    public function allFields()
    {
        $table = $this->getSource();
        $tables = $this->getAllDatabase();
        
        return $tables[$table];
    }

    /**
     * All Fields on Database
     * 
     * @return mixed
     */
    public function getAllDatabase()
    {
        if (is_file(__DIR__ . "/../../config/database_structures.ini.php")) {
            $tables = include  __DIR__ . "/../../config/database_structures.ini.php";
        } else {
            $tables = include __DIR__ . "/../../config/database_structures.php";
        }
        
        return $tables;
    }

    /**
     * All Models
     * @return array
     */
    public function getAllModels()
    {
        $model_path = APP_PATH . '/apps/backend/models/*.php';

        foreach (glob($model_path) as $model) {
            $name = basename($model, '.php');
            if ($name != 'ModelBase'
                && $name != 'ModelCustom'
                && $name != 'CaroLogs') {
                $models[$name] = $name;
            }
        }
        return $models;
    }

}