<?php
// 이 파일은 extend에 업로드, 지정폴더외에는 G5 원본에 수정된 사항 없음
// 사용자 환경변수($ix) 및 bootstrap 관련 설정
define('TEMPLATE_DIR', 'template'); // 디렉토리 이름
define('TEMPLATE_PATH', G5_PATH.'/'.TEMPLATE_DIR); // path
define('TEMPLATE_URL', G5_URL.'/'.TEMPLATE_DIR); // url

// bootstrap
define('BS_DIR', 'bootstrap'); // 디렉토리 이름
define('BS_PATH', G5_PATH.'/'.BS_DIR); // path
define('BS_URL', G5_URL.'/'.BS_DIR); // url

// 구조화를 위한 그룹별 분기 - 호출방법 /g5/?ix=그룹아이디
if ($ix == "" && $gr_id == "" && $bo_table == "") $ix = 'bs'; // 값없을때 기본그룹
if ($ix == "") $ix = $gr_id;
if ($ix == "") $ix = $bo_table;

switch (TRUE)
{
    case preg_match("/\/template\/".basename(dirname($_SERVER['PHP_SELF']))."\/.*.php$/", $_SERVER[PHP_SELF]) :
    $ix = basename(dirname($_SERVER['PHP_SELF'])); // php 파일은 속해있는 디렉토리이름이 환경변수  $ix
    break;
    case preg_match("/^(search.php|current_connect.php|ca_search.php|new.php|login.php|register.php|register_form.php|register_result.php|member_confirm.php)$/", basename($_SERVER['PHP_SELF'])) :// 특정파일 접근시 $ix 임의지정 가능
    $ix = 'bs';
    break;
    default :
    $ix = $ix; // 기본
    break;
}
// 템플릿 폴더내 해당 $ix 폴더가 있는지 검사
$ix = preg_replace("`/`", "",  $ix);
if (!is_dir( TEMPLATE_PATH . '/' . $ix)) {// 없다면 처음으로
    goto_url(G5_URL); 
    //echo "<script>location.replace('g5_url');</script>";
    exit;
}
?>