<?php
namespace App\Log;

/**
 * Created by PhpStorm.
 * Author: Wai Yan Aung
 * Date: 10/24/2016
 * Time: 6:28 PM
 */

use App\Core\Config\ConfigRepository;

class LogCustom
{
    /**
     * @param $rawDate
     * @param $message
     */

    //Sample ( How to use )
    //$date = '2016-10-24 14:53:20';
    //$message = '['. $date .'] '. 'info ' . ' TESTING MESSAGE' . PHP_EOL;
    //LogCustom::create($date,$message);

    public static function create($rawDate, $message){

        $date = date("Y-m-d",strtotime($rawDate));
        $fileName = "custom-laravel-" . $date . '.log';
        $dir        = storage_path('logs');
        $fileNameWithPath = $dir . '/' . $fileName;
        $rawFiles   = scandir($dir);
        $files = array();
        foreach($rawFiles as $rawFile){
            if (0 === strpos($rawFile, 'custom-laravel-')) {
                array_push($files,$rawFile);
            }
        }

        if(count($files)>0){

            if(in_array($fileName, $files)){
                // Open the file to get existing content
                $current = file_get_contents($fileNameWithPath);
                // Append a new person to the file
                $current .= $message;
                // Write the contents back to the file
                file_put_contents($fileNameWithPath, $current);

            }
            else{
                //$this::writeFile($fileName,$message);
                $myfile = fopen($fileNameWithPath, "w") or die("Unable to open file!");
                fwrite($myfile, $message);
                fclose($myfile);

            }
        }

        else{
            // $this::writeFile($fileName,$message);
            $myfile = fopen($fileNameWithPath, "w") or die("Unable to open file!");
            fwrite($myfile, $message);
            fclose($myfile);
        }
    }

    // This process is calling from the login function of AuthController while log in process happen
    public static function deleteLogFileAutomatically(){

        try {

            $configRepo = new ConfigRepository();
            $LogMaxFiles = $configRepo->getLogMaxFiles();

            $date = strtotime(date('Y-m-d'));
            $date2 = date('Y-m-d H:i:s');
            $dateCount = '-' . $LogMaxFiles . ' days';
            $logStartDate = date('Y-m-d', strtotime($dateCount, $date));

            $fileName = "custom-laravel-" . $date . '.log';
            $dir = storage_path('logs');
            $rawFiles = scandir($dir);

            foreach ($rawFiles as $rawFile) {
                if (0 === strpos($rawFile, 'custom-laravel-')) {
                    echo $rawFile . " == ";
                    $fileNameWithPath = $dir . "/" . $rawFile;
                    $rawTempLogFileDate = substr($rawFile, 15, 10);
                    $rawTempLogFileDate = date("Y-m-d", strtotime($rawTempLogFileDate));

                    if ($rawTempLogFileDate < $logStartDate) {
                        if(!unlink($fileNameWithPath)) {

                            $errorLogfileNameWithPath = $dir . "/" . "custom-error.log";
                            $messageError = "[" . $date2 . "] " . $fileNameWithPath . " can not delete automatically by system !" . PHP_EOL;

                            if (file_exists($errorLogfileNameWithPath)) {
                                // Open the file to get existing content
                                $current = file_get_contents($errorLogfileNameWithPath);
                                // Append a new person to the file
                                $current .= $messageError;
                                // Write the contents back to the file
                                file_put_contents($errorLogfileNameWithPath, $current);
                            } else {
                                //$this::writeFile($fileName,$message);
                                if ($myfile = fopen($errorLogfileNameWithPath, "w")) {
                                    fwrite($myfile, $messageError);
                                    fclose($myfile);
                                } else {

                                }

                            }
                        }
                    }
                }
            }

        }
        catch(\Exception $e){

        }
    }
}