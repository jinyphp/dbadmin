<?php


    /*
    PHP 터미널 입력 STDIN 상수 정의를 확인합니다.
    */
    if  (!defined("STDIN")) {
        define("STDIN", fopen('php://stdin','rb'));
    }


    echo "데이터베이스 환경값을 설정합니다.\n\n";
    $std = new StandardInput;

    $dbname = $std->input("DB 이름 = ");
    $dbuser = $std->input("DB 접속 아이디 = ");
    $dbpass = $std->input("DB 접속 암호 = ");

    makeConf($dbname, $dbuser, $dbpass);
    print_r(readConf());
    
    function makeConf($dbname, $dbuser, $dbpass) {
        if (!$dbname) {
            echo "DB 이름이 입력되지 않았습니다.\n";
            exit;
        }

        if (!$dbuser) {
            echo "DB 접속 ID가 입력되지 않았습니다.\n";
            exit;
        }

        if (!$dbpass) {
            echo "DB 접속 패스워드가 입력되지 않았습니다.\n";
            exit;
        }

        $contents = "<?php return ['dbname'=>'$dbname','dbuser'=>'$dbuser','dbpass'=>'$dbpass']; ?>";
        file_put_contents("dbconf.php",$contents);
    }

    function readConf() {
        if(file_exists("dbconf.php")) {
            $conf = include "dbconf.php";
            return $conf;
        }
    }

class StandardInput
{
    private $_in;

    public function __construct()
    {
        $this->_in = fopen('php://stdin','rb');
    }

    /**
     * Read up to 80 characters or a newline
     */
    public function input($msg)
    {
        if(is_string($msg)) echo $msg;            
        $text = fread($this->_in, 80);
        return str_replace(["\n","\r"],"",$text);
    }

    /**
     * 숫자 포맷 입력
     */
    function numInput()
    {
        fscanf($this->_in, "%d\n", $number); // reads number from STDIN
        return $number;
    }

    /**
     * y/n 확인요청
     * confirm('변경 후에는 복구할 수 없습니다. 변경하시겠습니까?');
     */  
    function confirm($question, $msg=['yes'=>'yes','no'=>'no']){
        echo $question.' (y/n) ';

        /*
        \readline_callback_handler_install('', function () {
        }); 
        */

        while (true) {
        $r = [STDIN];
        $w = null;
        $e = null;
        $n = stream_select($r, $w, $e, 0);
        if ($n && in_array(STDIN, $r)) {
            $c = stream_get_contents(STDIN, 1);
            if (strcasecmp($c, 'y') != 0) {
            echo $msg['no']."\n";
            return;
            }
            break;
        }
        }
    
        echo $msg['yes']."\n";
    }    

    /**
     * 
     */
}





