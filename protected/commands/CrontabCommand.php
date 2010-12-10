<?php

class CrontabCommand extends CConsoleCommand
{
public function run($args)
	{
    	$config = Configuration::model()->find();
        $path = Yii::getPathOfAlias('application');
        $path = str_replace('/protected', '', $path);
    	$cronTabsDone = array();
        $pids = array();
        $crawler_list = array();
        $cronTabs = CrawlerCrontab::model()->findAll(); //Controllo prima se ci sono fra i cronjob
        foreach ( $cronTabs as $c ) {
        	//Controllo se il cron e' attivabile. Se e' attivabile controllo se il crwler al momento si sta aggiornando o meno
        	$passed = $this->checkCron($c);
        	if ( $passed )
        		$cronTabsDone[$c->crawler_id] = $c->crawler_id;
        	//$c->delete();
        }
        
        // Controllo se sono presenti fra i le richieste effettuate manualmente
        $queue = CrawlerQueue::model()->findAll();
        foreach ( $queue as $q ) {
        	if (!array_key_exists($q->crawler_id, $cronTabsDone))
        		$cronTabsDone[$q->crawler_id] = $q->crawler_id;
        	$q->delete();
        }
        
        
        
        foreach ( $cronTabsDone as $cID ) {
        	$crawler = Crawler::model()->findByPk($cID);
        	// Check if config file exist.
        	if ( $crawler !== null && $crawler->status == Crawler::STATUS_READY ) {
        		$crawler->saveConfig($path.'/crawlers_config/' . $crawler->db_name_prepend . $crawler->db_name . '.temp');
        		$crawler_list[] = $crawler;
        		$crawler->status = Crawler::STATUS_BUSY;
        		$crawler->save(false);
        		
        		
        		
        		$pids[$cID] = popen($config->webmanager_path . '/htcheck -vsi -c '.$path.'/crawlers_config/'.$crawler->db_name_prepend.$crawler->db_name.'.conf > '. $path.'/crawlers_config/' . $crawler->db_name_prepend . $crawler->db_name . '.out 2>&1' , 'r');
        		//$pids[$cID] = popen($config->webmanager_path . '/htcheck -vsi -c '.$path.'/crawlers_config/'.$crawler->db_name_prepend.$crawler->db_name.'.conf' , 'r');
        	} else {
        		$confPath = $path.'/crawlers_config/' . $crawler->db_name_prepend . $crawler->db_name . '.out';
				$fh = fopen($confPath, 'w') or die("can't open file");
				$confContent = 'db: '.$crawler->db_name_prepend . $crawler->db_name. ' - cstatus: ' . $crawler->status ;
				
				fwrite($fh, $confContent);
				fclose($fh);
        	}
        }
        
    	/*for($i = 0; $i < count($pids); $i++) {
		  pclose($pids[$i]);
		}*/
        
        foreach ( $crawler_list as $crawler ) {
        	pclose($pids[$crawler->id]);
        }
        
		foreach ( $crawler_list as $crawler ) {
			//pclose($pids[$crawler->id]);
			//usleep(500000);
			$db = $crawler->db_name_prepend . $crawler->db_name;
			
			try {
				$dsn = 'mysql:host='.$config->htcheck_host.';port='.$config->htcheck_port.';dbname='.$db;
				//echo "$dsn\n";
				$connection = new CDbConnection($dsn, $config->htcheck_user, $config->htcheck_password);
				$connection->setActive(true);
				$command = $connection->createCommand('SELECT * FROM htCheck');
				$dataReader = $command->query();
				$cLog = new CrawlerLog();
				$dataReader = $dataReader->readAll();
				if ( count($dataReader) > 0 ) {
					$reader = $dataReader[0];
					$cLog->crawler_id = $crawler->id;
					$cLog->version = $reader['Version'];
					$cLog->start_time = $reader['StartTime'];
					$cLog->end_time = $reader['EndTime'];
					$cLog->scheduled_urls = $reader['ScheduledUrls'];
					$cLog->tot_urls = $reader['TotUrls'];
					$cLog->retrieved_urls = $reader['RetrievedUrls'];
					$cLog->tcp_connections = $reader['TCPConnections'];
					$cLog->server_changes = $reader['ServerChanges'];
					$cLog->http_requests = $reader['HTTPRequests'];
					$cLog->http_seconds = $reader['HTTPSeconds'];
					$cLog->http_bytes = $reader['HTTPBytes'];
					$cLog->accessibility_checks = $reader['AccessibilityChecks'];
					$cLog->htdig_notification = $reader['HtDigNotification'];
					$cLog->user = $reader['User'];
					
					$cLog->save(false);
				} else {
					$confPath = $path.'/crawlers_config/' . $crawler->db_name_prepend . $crawler->db_name . '.out2';
					$fh = fopen($confPath, 'w') or die("can't open file");
					$confContent = 'Problem taking LOG db: '.$crawler->db_name_prepend . $crawler->db_name. ' - cdr: ' . count($dataReader) . ' - dr: '.print_r($dataReader);
					
					fwrite($fh, $confContent);
					fclose($fh);
				}
			} catch ( Exception $e ) {
        		$confPath = $path.'/crawlers_config/' . $crawler->db_name_prepend . $crawler->db_name . '.out2';
					$fh = fopen($confPath, 'w') or die("can't open file");
					$confContent = 'SQL EX ' . print_r($e) . ' Problem taking LOG db: '.$crawler->db_name_prepend . $crawler->db_name;
					fwrite($fh, $confContent);
					fclose($fh);
        	}
			
			$crawler->status = Crawler::STATUS_READY;
        	$crawler->save(false);
        	//$crawler->unlinkConfig($path.'/crawlers_config/' . $crawler->db_name_prepend . $crawler->db_name . '.temp');
		}
    }
    
	public function checkCron( $c ) {
    	$now = getdate();
    	$passed = true;
        if ( $c->minute != $now['minutes'] )
        	$passed = false;
        if ( $passed && $c->hour != $now['hours'] )
        	$passed = false;
        if ( $passed && $c->day != '*' && $c->day !=  $now['mday'] )
        	$passed = false;
        if ( $passed && $c->weekday != '*' && $c->weekday !=  $now['wday'] )
        	$passed = false;
        if ( $passed && $c->month != '*' && $c->month !=  $now['mon'] )
        	$passed = false;
        return $passed;
    }
    
    
}


