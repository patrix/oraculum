<?php
/**
 * Classe de Testes
 *
 *
 *    @filesource     $HeadURL$
 *    @category       Framework
 *    @package        oraculum
 *    @subpackage     oraculum.core.test
 *    @license        http://www.opensource.org/licenses/lgpl-3.0.html (LGPLv3)
 *    @version        $Revision$
 *    @modifiedby     $LastChangedBy$
 *    @lastmodified   $Date$
 *
 *    http://www.coderholic.com/php-profile-class/
 */

class Oraculum_Test extends Oraculum
{
    /**
     * Stores details about the last profiled method
     */
    private $_details;

    public function __construct()
    {
    }

    public static function pqp()
    {
    	if (((int)DEBUG)&&(PROFILER)) {
	    	define("DIR_PQP","./library/components/pqp/");
	    	require_once(DIR_PQP.'classes/PhpQuickProfiler.php');
	    	return new PhpQuickProfiler(PhpQuickProfiler::getMicroTime());
    	} else {
    		return null;
    	}
    }
    /**
     * @param classname string
     * @param methodname string
     * @param methodargs array
     * @param invocations int The number of times to call the method
     * @return float average invocation duration in seconds
     */
    public function profile($classname, $methodname, $methodargs, $invocations = 1)
    {
        if (class_exists($classname)!=TRUE) {
            throw new Exception("{$classname} doesn't exist");
        }

        $method=new ReflectionMethod($classname, $methodname);

        $instance=NULL;
        if (!$method->isStatic()) {
            $class=new ReflectionClass($classname);
            $instance=$class->newInstance();
        }

        $durations = array();
        for ($i=0;$i<$invocations;$i++) {
            $start=microtime(true);
            $method->invokeArgs($instance, $methodargs);
            $durations[] = microtime(true)-$start;
        }

        $duration["total"]=round(array_sum($durations), 4);
        $duration["average"]=round($duration["total"]/count($durations), 4);
        $duration["worst"]=round(max($durations), 4);

        $this->_details=array(  "class" => $classname,
                                "method" => $methodname,
                                "arguments" => $methodargs,
                                "duration" => $duration,
                                "invocations" => $invocations);

        return $duration["average"];
    }

    /**
     * @return string
     */
    private function invokedMethod()
    {
        return "{$this->_details["class"]}::{$this->_details["method"]}(" .
             join(", ", $this->_details["arguments"]) . ")";
    }

    /**
     * Prints out details about the last profiled method
     */
    public function printDetails()
    {
        $methodString=$this->invokedMethod();
        $numInvoked=$this->_details["invocations"];

        if ($numInvoked==1) {
            echo "{$methodString} took {$this->details["duration"]["average"]}s\n";
        } else {
            echo "{$methodString} was invoked {$numInvoked} times\n";
            echo "Total duration:   {$this->details["duration"]["total"]}s\n";
            echo "Average duration: {$this->details["duration"]["average"]}s\n";
            echo "Worst duration:   {$this->details["duration"]["worst"]}s\n";
        }
    }
}