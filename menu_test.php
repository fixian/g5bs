<?php
//if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
//Superfish v1.7.4 jQuery menu - g5 통합메뉴 현재위치 표시등 1402 플록 
//include_once("../common.php");
//include_once(G5_PATH.'/head.sub.php');
?>
<!-- link to the CSS files for this menu type -->
<link rel="stylesheet" media="screen" href="<?php echo TEMPLATE_URL;?>/superfish.css">
<!-- link to the JavaScript files (hoverIntent is optional) -->
<!-- if you use hoverIntent, use the updated r7 version (see FAQ) -->
<script src="<?php echo TEMPLATE_URL;?>/hoverIntent.js"></script>
<script src="<?php echo TEMPLATE_URL;?>/superfish.js"></script>

<!-- initialise Superfish -->
<script>

	jQuery(document).ready(function(){
		jQuery('ul.sf-menu').superfish({
			pathClass:	'current'
		});
	});

</script>

<div id="tb_nav" class="tb_nav">
  <ul class="sf-menu">

<?php

$list = array();

$sql="select * from {$g5['group_table']} g inner join {$g5['board_table']} b using (gr_id) where g.gr_5 = '1' and gr_device <> 'mobile' and b.bo_5 = '1' and bo_device <> 'mobile' order by gr_order, bo_order";
$result = sql_query($sql);
for ($i=0; $row = sql_fetch_array($result); $i++) {
  //$list[$row['gr_id']]['group'] = array( 'gr_id'=>$row['gr_id'], 'gr_subject'=>$row['gr_subject'], 'gr_9'=>$row['gr_9'], 'gr_10'=>$row['gr_10']);
  $list[$row['gr_id']]['gr_id'] = $row['gr_id'];
  $list[$row['gr_id']]['gr_subject'] = $row['gr_subject'];
  $list[$row['gr_id']]['gr_1'] = $row['gr_1'];//gr_1 그룹정렬
  $list[$row['gr_id']]['gr_9'] = $row['gr_9'];//gr_9 서브메뉴 사용여부 설정
  $list[$row['gr_id']]['gr_10'] = $row['gr_10'];//gr_10 그룹 링크

  $list[$row['gr_id']]['bbs'][] = array( 'bo_table'=> $row['bo_table'], 'bo_subject'=>$row['bo_subject'], 'bo_list_level'=>$row['bo_list_level'], 'bo_use_category'=>$row['bo_use_category'], 'bo_new'=>$row['bo_new'], 'bo_7'=> $row['bo_7'], 'sca'=>explode("|", $row['bo_category_list']));//bo_7 게시판 링크
}

//print_r2($list);

    //그룹 지정
    $groupSet = $ix;
    //$groupSet = $gr_id;
    $groupOption = "";//특정그룹 링크설정

    $menu_size= count( $list);

    foreach( $list as $value)
    {
      $groupSubject = "<span>".cut_str(get_text($value['gr_subject']),20,"")."</span>";
      //$groupLink = ($value['gr_id'] == $groupOption)?"특정링크":G5_BBS_URL."/group.php?gr_id=".$value['gr_id'];
      $groupLink = ($value['gr_id'] == $groupOption)?"특정링크":G5_URL.'/?ix='.$value['gr_id'];

      // 대메뉴 스타일
      if ($board['gr_id'])//게시판 영역
      {
        $current = ($value['gr_id'] == $board['gr_id'])?" id=\"current\" class=\"current\"":"";
      }
      else//그룹 메인
      {
        $current = ($_GET['ix'] == $value['gr_id'])?" id=\"current\" class=\"current\"":"";

        if ($_GET['ix'] == "")
        {
          $current = ($value['gr_id'] == $groupSet)?" id=\"current\" class=\"current\"":"";
        }
      }

      echo "    <li".$current."><a href=\"".$groupLink."\">".$groupSubject."</a>\n";
      echo "     <ul>\n";

      foreach( $value['bbs'] as $bbs)
      {
        $subLink = ($value['gr_id'] == $groupOption)?"특정링크":G5_BBS_URL.'/board.php?bo_table=' .$bbs['bo_table'];
        $subSubject = cut_str(get_text($bbs['bo_subject']),30,"");
        // 서브 스타일
        $fdecoration = ($bbs['bo_table'] == $bo_table)?"class=\"active_text_s\"":"class=\"normal_text_s\"";//데코

        echo "      <li><a href=\"".$subLink."\" ".$fdecoration."><span>".$subSubject."</span></a></li>\n";

      }

      // 전체그룹 부가메뉴 - 파일을 읽어서 메뉴생성
      // 정렬문제가 있다면 각 그룹별로 분리해서 코딩
      $lm_cat =  Array();//분류 및 정렬
      $lm_link =  Array();//경로
      $lm_title =  Array();//제목

      $s_dir = TEMPLATE_PATH."/".$value['gr_id']."/";// 그룹 템플릿 디렉토리
      $d = dir($s_dir);
      while (false !== ($entry = $d->read()))
      {
        if (substr($entry, 0, 1) != '.' && substr($entry, -4) != 'phps' && is_file($s_dir . $entry))
        {
          $fd = fopen ($s_dir . $entry, "r");
          $info = fgets($fd, 1024);
          fclose ($fd);

          preg_match("`#(.+)##(.+)###(.+)\?`", $info, $matches);
          if (!empty($matches[1]) && !empty($matches[2]) && !empty($matches[3]))
          {
            $lm_cat[$entry] = $matches[1];
            $lm_link[$entry] = $matches[2];
            $lm_title[$entry] = $matches[3];
          }
        }
      }

      $d->close();

      $check1  = '';
      asort($lm_cat);
      foreach($lm_cat as $key => $val1)
      {
        $val = trim($val1);
        if ($check1 != $val1)
        {
          $check1 = $val1;
          $check2  = '';
          asort($lm_link);
          foreach($lm_link as $key2 => $val2)
          {
            if (trim($lm_link[$key2]) != $val2) continue;

            $val2 = trim($val2);
            if ($check2 != $val2)
            {
              $check2 = $val2;
              $check3  = '';
              asort($lm_title);
              foreach($lm_title as $key3 => $val3)
              {
                if (trim($lm_cat[$key3]) != $val1 || trim($lm_link[$key3]) != $val2) continue;

                $val3 = trim($val3);
                if ($check3 != $val3)
                {
                  $check3 = $val3;

                  // 현재위치
                  $fdecoration = ($key3 == basename($_SERVER['PHP_SELF']))?"class=\"active_text_s\"":"class=\"normal_text_s\"";//데코

                  if ($member['mb_id'])// 로긴파일 적용시
                  {
                    if (($val3 != '회원로그인') && ($val3 != '회원가입'))
                    {
                      echo "      <li><a href=\"{$val2}\" ".$fdecoration.">".$val3."</a></li>\n";
                    }
                  }
                  else
                  {
                    if (($val3 != '회원정보수정') && ($val3 != '마이페이지'))
                    {
                      echo "      <li><a href=\"{$val2}\" ".$fdecoration.">".$val3."</a></li>\n";
                    }
                  }
                }
              }
            }
          }
        }
      }
      // 부가메뉴 끝

          echo "     </ul>\n";
    echo "    </li>\n";
  }

?>

  </ul>
</div>

