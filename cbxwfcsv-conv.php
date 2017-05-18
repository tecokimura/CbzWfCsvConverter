<?php
/**
 * Created by PhpStorm.
 * User: ace
 * Date: 17/05/18
 * Time: 15:16
 */

// at workflow.csv | perl -pe 's/[\r\n]//mg' | perl -pe 's/\"(\"[0-9]+\")/\n$1/mg' | perl -pe 's/([^"]),/$1/g' | grep -e "sec" -e "Name" | awk -F, '{ print $1","$2","$3","$4","$5","$154","$156","$170}' > temp2.csv

require_once './vendor/autoload.php';

// argv index
define( 'ARG_INDEX_PHP', 0 );
define( 'ARG_INDEX_CONFIG', 1 );
define( 'ARG_INDEX_INPUT', 2 );
define( 'ARG_INDEX_OUTPUT', 3 );

if ( isset($argc) && isset($argv) ) {
    main($argv);
}
exit;

/**
 * Program main
 * @param $argv
 */
function main($argv) {

    $log = new Monolog\Logger(Monolog\Logger::DEBUG);
    $log->notice(__FILE__." START");

    try {

        $config = new Config();
        $config->setFromArgv($argv);

        $log->notice($config->getConfigFile());

        readCsvFile();

    } catch( Exception $e) {
        var_dump($e);
    }

    $log->notice(__FILE__." END");
}


function readCsvFile(Config $config) {

    try {

        while(TRUE) {

            /*
             * 一行づつ読み込む
             * 正規表現で行等が"[0-9]+", である
             *  yes : 配列に追加
             *  no : 一つうえの配列に追加
             *
             * "," なっていない,は;に置換する
             */

            break;
        }

        /*
         * 必要な grep をかける
         * key1 | key2
         */


        /*
         *  foreach()
         *  , で分割して該当indexを取得
         */



    } catch(Exception $e){
        throw $e;
    }


}

function encShiftJISToUtf8($str) {
    return mb_convert_encoding($str, 'UTF-8', 'sjis');
}

function encUtf8ToShiftJIS($str) {
    return mb_convert_encoding($str, 'sjis', 'UTF-8');
}


class Config
{
    private $phpFile;   // 実行されたPHPファイル名
    private $configFile; // 設定ファイル名
    private $inputCsvFile; // 入力CSVファイル名
    private $outputFile;    // 出力ファイル名

    /**
     * @param $argv
     * @return bool
     */
    function setFromArgv($argv) {
        $ret = FALSE;

        $this->phpFile      = isset($argv[0]) ? $argv[0] : "";
        $this->configFile   = isset($argv[1]) ? $argv[1] : "";
        $this->inputCsvFile = isset($argv[2]) ? $argv[2] : "";
        $this->outputFile   = isset($argv[3]) ? $argv[3] : "";

        return $this->checkVar();
    }

    /**
     * @param $argv
     * @return bool
     */
    function checkVar() {

        return TRUE;
    }


    /**
     * @return mixed
     */
    public function getPhpFile()
    {
        return $this->phpFile;
    }

    /**
     * @return mixed
     */
    public function getConfigFile()
    {
        return $this->configFile;
    }

    /**
     * @return mixed
     */
    public function getInputCsvFile()
    {
        return $this->inputCsvFile;
    }

    /**
     * @return mixed
     */
    public function getOutputFile()
    {
        return $this->outputFile;
    }
}


class CsvRecord
{
    private $wfNo;
    private $reqName;
    private $reqDatetime;
    private $title;
    private $price;
    private $accrualDate;   // 発生日
    private $formName;  // フォーム名
    private $purpose;   // 目的

}