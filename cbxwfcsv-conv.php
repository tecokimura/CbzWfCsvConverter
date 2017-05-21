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

        $csv = readCsvFile($config);

        foreach($csv as $line) {
            $record = new CsvRecord();
            $record->setFromLine($line);
        }

    } catch( Exception $e) {
        var_dump($e);
    }

    $log->notice(__FILE__." END");
}


function readCsvFile(Config $config) {

    $csvAry = array();

    try {

        $fp = fopen($config->getInputCsvFile(), 'r');

        $line = "";
        $tmpAry = array();
        while( $tmpLine = fgets($fp) ) {

            $line .= trim($tmpLine);

            if( preg_match('/[^,]"$/', trim($line), $m) ) {
                $tmpAry []= $line;
                $line = "";
            }
        }

        // separatorじゃないカンマを消す
        foreach($tmpAry as $line) {
            $csvAry []= preg_replace('/([^"]),/', '$1', $line);
        }

        fclose($fp);

    } catch(Exception $e){
        throw $e;
    }

    return $csvAry;
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
    const IDX_NO            = 0;
    const IDX_REQ_NAME      = 1;
    const IDX_REQ_DATETIME  = 2;
    const IDX_FORM_NAME     = 3;
    const IDX_TITLE         = 4;
    const IDX_ACCRUAL_DATE  = 153;
    const IDX_PURPOSE       = 165;
    const IDX_PRICE         = 169;

    // print $1","$2","$3","$4","$5","$154","$156","$170}
    private $csvAry = array();


    function setFromLine($str) {
        $this->csvAry = explode(',', $str);
        echo " ".$this->getWorkFlowNo()
            .','.$this->getRequestName()
            .','.$this->getRequestDatetime()
            .','.$this->getPrice()
            .','.$this->getAccrualDate()
            .','.$this->getTitle()
            .','.$this->getFormName()
            .','.$this->getPurpose()
            .PHP_EOL;
    }

    // getter
    function getWorkFlowNo() { return $this->getByIndex(self::IDX_NO); }
    function getRequestName() { return $this->getByIndex(self::IDX_REQ_NAME); }
    function getRequestDatetime() { return $this->getByIndex(self::IDX_REQ_DATETIME); }
    function getFormName() { return $this->getByIndex(self::IDX_FORM_NAME); }
    function getTitle() { return $this->getByIndex(self::IDX_TITLE); }
    function getAccrualDate() { return $this->getByIndex(self::IDX_ACCRUAL_DATE); }
    function getPurpose() { return $this->getByIndex(self::IDX_PURPOSE); }
    function getPrice() { return $this->getByIndex(self::IDX_PRICE); }
    function getByIndex($i) { return isset($this->csvAry[$i]) ? $this->csvAry[$i] : "";}
}

