<?php
/**
 * AjaxResponse class file.
 * @author Christoffer Niska <christoffer.niska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2013-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package crisu83.yii-ajaxtools.components
 */

/**
 * Component that represents a simple AJAX response.
 */
class AjaxResponse extends CComponent
{
    /**
     * @var array response data.
     */
    protected $_data = array();

    /**
     * Adds data to the response.
     * @param string $key data key.
     * @param mixed $value data value.
     * @param bool $override whether to override the value if the key already exists.
     */
    public function add($key, $value, $override = false)
    {
        if ($override || !isset($this->_data[$key])) {
            $this->_data[$key] = $value;
        }
    }

    /**
     * Outputs the JSON for AJAX success.
     * @param array $data optional response data.
     */
    public function success($data = array())
    {
        if (!empty($data)) {
            foreach ($data as $key => $value) {
                $this->add($key, $value);
            }
        }
        echo $this->jsonEncode(
            array(
                'success' => true,
                'data' => $this->_data,
            )
        );
    }

    /**
     * Outputs the JSON for AJAX error.
     * @param string $message error message.
     * @param array $data optional response data.
     */
    public function error($message, $data = array())
    {
        $data['message'] = $message;
        echo $this->jsonEncode(
            array(
                'success' => false,
                'error' => $data,
                'data' => $this->_data,
            )
        );
    }

    /**
     * JSON encodes the given array.
     * @param array $array array to encode.
     * @return string the JSON.
     */
    protected function jsonEncode($array)
    {
        return CJSON::encode($array);
    }
}