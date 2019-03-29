<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Illuminate\Support\Facades\Cache;
use Exception;

class Configurations extends Model
{

    /**
     *
     * @var table name 
     */
    protected $table = "configurations";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'value'
    ];

    /*
     * Have Structure Like following
     * array(
            'configurations' => 
                array(
                    'search_radius' => array(
                        'label' => 'Search Radius (In KM)',
                        'value' => 5, // in KM
                    ),
                    'min_open_time_left' => array(
                        'label' => 'Shop Min Open Time (In mins)',
                        'value' => 30, // In Mins
                    )
                )
            );
     */
    protected $aConfiguration;

    /**
     * Contructor Method. Prepares Configuration structured Array.
     * 
     */
    public function __construct() {
        $aConfiguration = array(
            'configurations' => 
                array(
                    \Config::get('configurations.phone_payment_key') => array(
                        'label' => 'Phone Payment Number',
                        'value' => \Config::get('configurations.phone_payment_default_value'), // in KM
                    ),
                    \Config::get('configurations.contact_email_key') => array(
                        'label' => 'Contact Email',
                        'value' => \Config::get('configurations.contact_email_default_value'), // In Mins
                    )
                )
        );
        $this->aConfiguration = $aConfiguration;
    }

    /**
     * Method to save configuration in DB & cache as well.
     *
     *
     * @return array
     */
    public function saveConfigurations($confValues) {
        $response = array(
            'status'    => false,
            'message'   => ''
        );
        try {
            $aValidConfigurationKeys = array_keys($this->aConfiguration['configurations']);
            foreach ($confValues as $key => $value) {
                if (in_array($key, $aValidConfigurationKeys)) {
                    $this->set($key, $value);
                }
            }
            Cache::flush();
            $response['status'] = true;
        } catch (Exception $ex) {
            $response['message'] = $ex->getMessage();
        }
        return $response;
    }

    /**
     * Prepare Array of configuration whith label & default Values
     *
     *
     * @return array
     */
    public function getConfigurations() {
        $aConfiguration = $this->aConfiguration;
        foreach ($aConfiguration as $configuration) {
            foreach($configuration as $configurationKey => $configurationValues) {
                $configValue                        = $this->fetch($configurationKey);
                if (!empty($configValue)) {
                    $configurationValues['value']       = $configValue;
                    $configuration[$configurationKey]   = $configurationValues;
                }
            }
            $aConfiguration['configurations'] = $configuration;
        }
        return $aConfiguration;
    }

    /**
     * Store value into registry
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return mixed
     */
    private function set($key, $value)
    {
        //$value = serialize($value);
        $value = $value;
        $setting = DB::table($this->table)->where('key', $key)->first();
        if (is_null($setting)) {
            DB::table($this->table)
                           ->insert(['key' => $key, 'value' => $value]);
        } else {
            DB::table($this->table)
                           ->where('key', $key)
                           ->update(['value' => $value]);
        }
        //Cache::forever($key, unserialize($value));
        Cache::forever($key, $value);
        return $value;
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    private function fetch($key)
    {
        if (Cache::has($key)) {
            return Cache::get($key);
        }
        $row = DB::table($this->table)->where('key', $key)->first(['value']);
        $keyDefault = $key."_default_value";
        $keyDefaultValue = config('configurations.'.$keyDefault);
        //return (!is_null($row)) ? Cache::forever($key, unserialize($row->value)) : $keyDefaultValue;
        if ((!is_null($row))) {
            //$keyDefaultValue = unserialize($row->value);
            $keyDefaultValue = $row->value;
            Cache::forever($key, $keyDefaultValue);
        }
        return $keyDefaultValue;
    }

    /**
     * Public method to get Key Value
     *
     * @param string $key Key of configuration
     * @return mixed
     */
    public function get($key) {
        return self::fetch($key);
    }
        
}
