<?php 
/**
 * CpuDevice TO class
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PSI_TO
 * @author    Michael Cramer <BigMichi1@users.sourceforge.net>
 * @copyright 2009 phpSysInfo
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @version   SVN: $Id$
 * @link      http://phpsysinfo.sourceforge.net
 */
 /**
 * CpuDevice TO class
 *
 * @category  PHP
 * @package   PSI_TO
 * @author    Michael Cramer <BigMichi1@users.sourceforge.net>
 * @copyright 2009 phpSysInfo
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @version   Release: 3.0
 * @link      http://phpsysinfo.sourceforge.net
 */
class CpuDevice
{
    /**
     * model of the cpu
     *
     * @var String
     */
    private $_model = "";
    
    /**
     * speed of the cpu in hertz
     *
     * @var Integer
     */
    private $_cpuSpeed = 0;
    
    /**
     * cache size in bytes, if available
     *
     * @var Integer
     */
    private $_cache = null;

    /**
     * virtualization, if available
     *
     * @var String
     */
    private $_virt = null;    
    
    /**
     * busspeed in hertz, if available
     *
     * @var Integer
     */
    private $_busSpeed = null;
    
    /**
     * temperature of the cpu, if available
     *
     * @var Integer
     */
    private $_temp = null;
    
    /**
     * bogomips of the cpu, if available
     *
     * @var Integer
     */
    private $_bogomips = null;
    
    /**
     * current load in percent of the cpu, if available
     *
     * @var Integer
     */
    private $_load = null;
    
    /**
     * Returns $_bogomips.
     *
     * @see Cpu::$_bogomips
     *
     * @return Integer
     */
    public function getBogomips()
    {
        return $this->_bogomips;
    }
    
    /**
     * Sets $_bogomips.
     *
     * @param Integer $bogomips bogompis
     *
     * @see Cpu::$_bogomips
     *
     * @return Void
     */
    public function setBogomips($bogomips)
    {
        $this->_bogomips = $bogomips;
    }
    
    /**
     * Returns $_busSpeed.
     *
     * @see Cpu::$_busSpeed
     *
     * @return Integer
     */
    public function getBusSpeed()
    {
        return $this->_busSpeed;
    }
    
    /**
     * Sets $_busSpeed.
     *
     * @param Integer $busSpeed busspeed
     *
     * @see Cpu::$_busSpeed
     *
     * @return Void
     */
    public function setBusSpeed($busSpeed)
    {
        $this->_busSpeed = $busSpeed;
    }
    
    /**
     * Returns $_cache.
     *
     * @see Cpu::$_cache
     *
     * @return Integer
     */
    public function getCache()
    {
        return $this->_cache;
    }
    
    /**
     * Sets $_cache.
     *
     * @param Integer $cache cache size
     *
     * @see Cpu::$_cache
     *
     * @return Void
     */
    public function setCache($cache)
    {
        $this->_cache = $cache;
    }
    
    /**
     * Returns $_virt.
     *
     * @see Cpu::$_virt
     *
     * @return String
     */
    public function getVirt()
    {
        return $this->_virt;
    }
    
    /**
     * Sets $_virt.
     *
     * @param String $_virt
     *
     * @see Cpu::$_virt
     *
     * @return Void
     */
    public function setVirt($virt)
    {
        $this->_virt = $virt;
    }    
    
    /**
     * Returns $_cpuSpeed.
     *
     * @see Cpu::$_cpuSpeed
     *
     * @return Integer
     */
    public function getCpuSpeed()
    {
        return $this->_cpuSpeed;
    }
    
    /**
     * Sets $_cpuSpeed.
     *
     * @param Integer $cpuSpeed cpuspeed
     *
     * @see Cpu::$_cpuSpeed
     *
     * @return Void
     */
    public function setCpuSpeed($cpuSpeed)
    {
        $this->_cpuSpeed = $cpuSpeed;
    }
    
    /**
     * Returns $_model.
     *
     * @see Cpu::$_model
     *
     * @return String
     */
    public function getModel()
    {
        return $this->_model;
    }
    
    /**
     * Sets $_model.
     *
     * @param String $model cpumodel
     *
     * @see Cpu::$_model
     *
     * @return Void
     */
    public function setModel($model)
    {
        $this->_model = $model;
    }
    
    /**
     * Returns $_temp.
     *
     * @see Cpu::$_temp
     *
     * @return Integer
     */
    public function getTemp()
    {
        return $this->_temp;
    }
    
    /**
     * Sets $_temp.
     *
     * @param Integer $temp temperature
     *
     * @see Cpu::$_temp
     *
     * @return Void
     */
    public function setTemp($temp)
    {
        $this->_temp = $temp;
    }
    
    /**
     * Returns $_load.
     *
     * @see CpuDevice::$_load
     *
     * @return Integer
     */
    public function getLoad()
    {
        return $this->_load;
    }
    
    /**
     * Sets $_load.
     *
     * @param Integer $load load percent
     *
     * @see CpuDevice::$_load
     *
     * @return Void
     */
    public function setLoad($load)
    {
        $this->_load = $load;
    }
}
?>
