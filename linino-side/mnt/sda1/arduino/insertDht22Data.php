<?php

    error_reporting(E_ERROR | E_PARSE);
	
	$log = fopen("insertDht22.log", 'a');
	fwrite($log, "\n" . time());
	fclose($log);
	

    require_once('www/cavair2/incs/db.php');

    $validArgKeys = array('temperature_inside', 'temperature_outside', 'humidity_inside', 'humidity_outside', 'dewpoint_inside', 'dewpoint_outside', 'dewpoints_difference', 'fan_state');

    function parseAndValidateArguments($args) {

        global $validArgKeys;

        $params = array();
        foreach ($args as $arg) {
            if (stristr($arg, '=')) {
                $argKeyValue = explode('=', $arg);
                if (count($argKeyValue) === 2) { // check if it's a valid key-value argument
                    if (in_array($argKeyValue[0], $validArgKeys)) { // check the key for validity
                        $params[$argKeyValue[0]] = $argKeyValue[1];
                    }
                }
            }
        }
        if (count($params) === count($validArgKeys)) {
            // @TODO: check the values per key for validity all needs to be numeric but comment a string...
            return $params;
        } else {
            // not enough valid arguments given:
            // we simple stop the ongoing process and return none zero.
            echo "ERROR 1\n";
			exit;
            //return array();
        }
    }


    $params = parseAndValidateArguments($argv);
	var_dump($params);
    if (count($params) > 0) {
        $insertStatement = 'INSERT INTO `dewpoints`.`dht22_datas` (`temperature_inside`, `temperature_outside`, `humidity_inside`, `humidity_outside`, `dewpoint_inside`, `dewpoint_outside`, `dewpoints_difference`, `fan_state`) VALUES ('. $params['temperature_inside'] / 100 .', '. $params['temperature_outside'] / 100 .', '. $params['humidity_inside'] / 100 .', '. $params['humidity_outside'] / 100 .', '. $params['dewpoint_inside'] / 100 .', '. $params['dewpoint_outside'] / 100 .', '. $params['dewpoints_difference'] / 100 .', "'. $params['fan_state'] .'");';

        $rs = $conn->query($insertStatement);
        if ($rs === false) {
            // we simply stop the ongoing process and return none zero.
            echo "ERROR 2";
        } else {
            // success: return 1;
            echo "SUCCESS";
        }
    } else {
		echo "ERROR 3";
	}
	echo "\n";
?>