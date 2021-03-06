<?php 
/**
 * FreeBSD System Class
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PSI_OS
 * @author    Michael Cramer <BigMichi1@users.sourceforge.net>
 * @copyright 2009 phpSysInfo
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @version   SVN: $Id$
 * @link      http://phpsysinfo.sourceforge.net
 */
 /**
 * FreeBSD sysinfo class
 * get all the required information from FreeBSD system
 *
 * @category  PHP
 * @package   PSI_OS
 * @author    Michael Cramer <BigMichi1@users.sourceforge.net>
 * @copyright 2009 phpSysInfo
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License
 * @version   Release: 3.0
 * @link      http://phpsysinfo.sourceforge.net
 */
class FreeBSD extends BSDCommon
{
    /**
     * define the regexp for log parser
     */
    public function __construct()
    {
        parent::__construct();
        $this->setCPURegExp1("CPU: (.*) \((.*)-MHz (.*)\)");
        $this->setCPURegExp2("/(.*) ([0-9]+) ([0-9]+) ([0-9]+) ([0-9]+)/");
        $this->setSCSIRegExp1("^(.*): <(.*)> .*SCSI.*device");
        $this->setSCSIRegExp2("^(da[0-9]): (.*)MB ");
        $this->setPCIRegExp1("/(.*): <(.*)>(.*) pci[0-9]$/");
        $this->setPCIRegExp2("/(.*): <(.*)>.* at [.0-9]+ irq/");
    }
    
    /**
     * UpTime
     * time the system is running
     *
     * @return void
     */
    private function _uptime()
    {
        $s = preg_split('/ /', $this->grabkey('kern.boottime'));
        $a = preg_replace('/,/', '', $s[3]);
        $this->sys->setUptime(time() - $a);
    }
    
    /**
     * get network information
     *
     * @return void
     */
    private function _network()
    {
        $dev = NULL;
        if (CommonFunctions::executeProgram('netstat', '-nibd', $netstat, PSI_DEBUG)) {
            $lines = preg_split("/\n/", $netstat, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($lines as $line) {
                $ar_buf = preg_split("/\s+/", $line);
                if (! empty($ar_buf[0])) {
                    if (preg_match('/^<Link/i',$ar_buf[2])) {
                        if (!is_null($dev))
                           $this->sys->setNetDevices($dev);
                        $dev = new NetDevice();
                        $dev->setName($ar_buf[0]);
                        if (strlen($ar_buf[3]) < 17) { /* no Address */
                            if (isset($ar_buf[11])) { /* Idrop column exist*/
                              $dev->setTxBytes($ar_buf[9]);
                              $dev->setRxBytes($ar_buf[6]);
                              $dev->setErrors($ar_buf[4] + $ar_buf[8]); 
                              $dev->setDrops($ar_buf[11] + $ar_buf[5]);
                            } else {
                              $dev->setTxBytes($ar_buf[8]);
                              $dev->setRxBytes($ar_buf[5]);
                              $dev->setErrors($ar_buf[4] + $ar_buf[7]);
                              $dev->setDrops($ar_buf[10]);
                            }
                        } else {
                            if (isset($ar_buf[12])) { /* Idrop column exist*/
                              $dev->setTxBytes($ar_buf[10]);
                              $dev->setRxBytes($ar_buf[7]);
                              $dev->setErrors($ar_buf[5] + $ar_buf[9]);
                              $dev->setDrops($ar_buf[12] + $ar_buf[6]);
                            } else {
                              $dev->setTxBytes($ar_buf[9]);
                              $dev->setRxBytes($ar_buf[6]);
                              $dev->setErrors($ar_buf[5] + $ar_buf[8]);
                              $dev->setDrops($ar_buf[11]);
                            }
                            $dev->setInfo(preg_replace('/:/', '-', $ar_buf[3]));                        }
                    }
                    else if (!is_null($dev)) {
                        if ($dev->getName() == $ar_buf[0]) { /* other infos */
                           if (!preg_match('/^fe80::/i',$ar_buf[3]))
                                $dev->setInfo(($dev->getInfo()?$dev->getInfo().';':'').$ar_buf[3]);
                        }
                        else { /* something wrong */
                             $this->sys->setNetDevices($dev);
                             $dev = NULL;
                        }
                    }
                }
            }
            if (!is_null($dev))
                           $this->sys->setNetDevices($dev);

        }
    }
    
    /**
     * get icon name
     *
     * @return void
     */
    private function _distroicon()
    {
        $this->sys->setDistributionIcon('FreeBSD.png');
    }
    
    /**
     * extend the memory information with additional values
     *
     * @return void
     */
    private function _memoryadditional()
    {
        $pagesize = $this->grabkey("hw.pagesize");
        $this->sys->setMemCache($this->grabkey("vm.stats.vm.v_cache_count") * $pagesize);
        $this->sys->setMemApplication(($this->grabkey("vm.stats.vm.v_active_count") + $this->grabkey("vm.stats.vm.v_wire_count")) * $pagesize);
        $this->sys->setMemBuffer($this->sys->getMemUsed() - $this->sys->getMemApplication() - $this->sys->getMemCache());
    }

    
    /**
     * get the information
     *
     * @see BSDCommon::build()
     *
     * @return Void
     */
    function build()
    {
        parent::build();
        $this->_memoryadditional();
        $this->_distroicon();
        $this->_network();
        $this->_uptime();
    }
}
?>
