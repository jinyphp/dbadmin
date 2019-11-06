<?php
namespace App\Controller;
class Tables
{

  private $db;

  public function __construct($db)
  {
    $this->db = $db;
  }

  public function main()
  {
    $html = new \Module\Html\HtmlTable;
    $query = "SHOW TABLES";
    $result = $this->db->queryExecute($query);
    $count = mysqli_num_rows($result);
    $content = "";

    for ($i=0; $i<$count ; $i++) {
      $row = mysqli_fetch_object($result);
      $rows [] = [
          'num'=>$i,
          'name'=>"<a href='/TableInfo/".$row->Tables_in_php."'>".$row->Tables_in_php."</a>"
      ];
    }
    $content = $html->table($rows);

    $body = file_get_contents("../Resource/table.html");
    $body = str_replace("{{content}}", $content, $body);
    echo $body;
  }
}
