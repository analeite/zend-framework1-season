<?php 
class Sam_Validate_RangeDate extends Zend_Validate_Abstract
{
  const DATE_GT_MAX = 'dateGtMax';
  const DATE_LT_MIN = 'dateLtMin';


  protected $_messageTemplates = array(
      self::DATE_GT_MAX => "'%value%' é maior que a data limite permitida (%max%)",
      self::DATE_LT_MIN => "'%value%' é menor que a data limite permitida (%min%)"
  );
  /**
   * Additional variables available for validation failure messages
   *
   * @var array
   */
  protected $_messageVariables = array(
      'min' => '_min',
      'max' => '_max'
  );


  /**
   * Number of days before today
   *
   * @var int
   */
  protected $_min = null;
  /**
   * Number of days after today
   *
   * @var int
   */
  protected $_max = null;


  /**
   * Sets validator options. If option not set or set as 0, then assume value is today
   * Accepts the following option keys:
   *   'min' => int, number of days before today
   *   'max' => int, number of days after today
   *
   * @param  array|Zend_Config $options
   * @return void
   */
  public function __construct($options)
  {
    if ($options instanceof Zend_Config)
    {
      $options = $options->toArray();
    }
    else if (!is_array($options))
    {
      $options = func_get_args();
      $temp['min'] = array_shift($options);
      if (!empty($options))
      {
        $temp['max'] = array_shift($options);
      }


      $options = $temp;
    }


    if (!array_key_exists('min', $options) && !array_key_exists('max', $options))
    {
      require_once 'Zend/Validate/Exception.php';
      throw new Zend_Validate_Exception("Missing option. 'min' or 'max' has to be given");
    }


    $this->_min = $options['min'];
    $this->_max = $options['max'];
  }


  /**
   * Returns true if and only if $value meets the validation requirements
   *
   * If date is greater than (today - _min days) and less than (today + _max days) then return true.
   *
   * @param mixed $value
   * @return boolean
   */
  public function isValid($value)
  {  
    $valid = TRUE;
    $this->_setValue($value);
    //check $value is greater than _min days before today
    if ($this->_min != null)
    {
      $obj     = DateTime::createFromFormat('d/m/Y', $value);
      $obj_min = DateTime::createFromFormat('d/m/Y', $this->_min);	
       
      if ($obj_min->getTimestamp() > $obj->getTimestamp())
      {
        $valid = FALSE;
        $this->_error(self::DATE_LT_MIN);
      }
    }


    if ($this->_max != null)
    {
      $obj     = DateTime::createFromFormat('d/m/Y', $value);
      $obj_max = DateTime::createFromFormat('d/m/Y', $this->_max);	
       
      if ($obj_max->getTimestamp() < $obj->getTimestamp())
      {
        $valid = FALSE;
        $this->_error(self::DATE_GT_MAX);
      }
    }


    //return boolean
    return $valid;
  }
}