리스트
$wr_10 = $list[$i]['wr_10'];

뷰
$wr_10 = $view['wr_10'];


if($wr_10){
    $tmp = explode("|",$wr_10)
    //$tmp = list($a,$b,$c) = explode("|",$wr_10)
    
    switch ($tmp) {
        case 'a' : $str = 'str1' ; break; 
        case 'b' : $str = 'str2' ; break;  
        case 'c' : $str = 'str3' ; break;  
        default :  $str = '' ; break;
    }
}

echo $str;


function debug ($data) { 
    echo "<script>\r\n//<![CDATA[\r\nif(!console){var console={log:function(){}}}"; 
    $output    =    explode("\n", print_r($data, true)); 
    foreach ($output as $line) { 
        if (trim($line)) { 
            $line    =    addslashes($line); 
            echo "console.log(\"{$line}\");"; 
        } 
    } 
    echo "\r\n//]]>\r\n</script>"; 
} 
