<?php 

function backup_tables($host, $user, $pass, $name, $tables = '*'){

    $link = mysql_connect($host, $user, $pass);
    mysql_select_db($name, $link);
    
    if($tables == '*'){
        $tables = array();
        $result = mysql_query('SHOW TABLES');
        while($row = mysql_fetch_row($result)){
            $tables[] = $row[0];
        }
    }else{
        $tables = is_array($tables) ? $tables : explode(',',$tables);
    }
    
    $return = "";
    foreach($tables as $table){
        $result = mysql_query('SELECT * FROM '.$table);
        $num_fields = mysql_num_fields($result);
        
        $return.= 'DROP TABLE '.$table.';';
        $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
        $return.= "\n\n".$row2[1].";\n\n";
        
        for ($i = 0; $i < $num_fields; $i++){
            while($row = mysql_fetch_row($result)){
                $return.= 'INSERT INTO '.$table.' VALUES(';
                    for($j=0; $j<$num_fields; $j++){
                        $row[$j] = addslashes($row[$j]);
                        $row[$j] = ereg_replace("\n","\\n",$row[$j]);
                        $return.= (isset($row[$j]))? '"'.$row[$j].'"' : '""';

                        if ($j<($num_fields-1)){
                            $return.= ',';
                        }
                    }
                    $return.= ");\n";
            }
        }
        $return.="\n\n\n";
    }

    $filename = 'bak-'.date("Y.m.d-H.i.s", time()).'.sql';
    $handle = fopen(APP_DIR_PATH . $filename,'w+');
    fwrite($handle, $return);
    fclose($handle);

    return $filename;
}
