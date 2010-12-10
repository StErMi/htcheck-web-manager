<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

// change the following paths if necessary
/*$yii=dirname(__FILE__).'/../yii-1.1.4/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/test.php';

// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
Yii::createWebApplication($config)->run();*/
$sql = getSql('database/datapost');
                	
                	$sqlDataArr =  splitQueries($sql);
                	

                    foreach ($sqlDataArr as $index => $script) {
                        if (preg_match('/insert\s+into/i', $script)) {
                            /*if (mysql_query($script,$db) === true) {
                                $remove[] = $index;
                            }*/
                        	//$result = $connection->createCommand($script)->execute();
                        	echo $script . ' <br/>';
                        	if ( $result )
                        		$remove[] = $index;
                        } else {
                            $remove[] = $index;
                        }
                    }

function getSql($path){
        if (strpos('/',$path) === false)
            $filePath = $path.'.sql';
        else
            $filePath = $path;
        if (file_exists($filePath) === false) {
            throw new Exception("File not found '{$filePath}.");
        }

        //mb_internal_encoding('UTF-8');
        $sql = @file_get_contents($filePath);
        //remove comment
        $sql = preg_replace('/\/\*.*?\*\/;/', '', $sql);
        $sql = preg_replace('/\/\*.*?\*\//', '', $sql);
        return $sql;
    }
                
function splitQueries($sql)
    {
        // Initialise variables.
        $buffer        = array();
        $queries    = array();
        $in_string    = false;

        // Trim any whitespace.
        $sql = trim($sql);

        // Remove comment lines.
        //$sql = preg_replace("/\n\#[^\n]*/", '', "\n".$sql);
		$sql = preg_replace("/\n\#[^\n]*/", '', "\n".$sql);
		$sql = preg_replace("/\n--[^\n]*/", '', "\n".$sql);
        // Parse the schema file to break up queries.
        for ($i = 0; $i < strlen($sql) - 1; $i ++)
        {
            if ($sql[$i] == ";" && !$in_string) {
                $queries[] = substr($sql, 0, $i);
                $sql = substr($sql, $i +1);
                $i = 0;
            }

            if ($in_string && ($sql[$i] == $in_string) && $buffer[1] != "\\") {
                $in_string = false;
            }
            elseif (!$in_string && ($sql[$i] == '"' || $sql[$i] == "'") && (!isset ($buffer[0]) || $buffer[0] != "\\")) {
                $in_string = $sql[$i];
            }
            if (isset ($buffer[1])) {
                $buffer[0] = $buffer[1];
            }
            $buffer[1] = $sql[$i];
        }

        // If there is anything left over, add it to the queries.
        if (!empty($sql)) {
            $queries[] = $sql;
        }

        return $queries;
    }
