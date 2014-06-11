gunboard5beta(G) bootstrap3(BS) 작업 참조사항. 

1.기존파일에서 먼저 수정해두어야 하는 부분.
config.php 115줄 G5_USE_MOBILE false 로 수정
define('G5_USE_MOBILE', false); // 모바일 홈페이지를 사용하지 않을 경우 false 로 설정

기존 헤더 및 라이브러리 파일에 모바일관련 부분을 수정하지 않고도 작업이 가능하고 또한 GBS 작업 취지에도 맞다.
즉, 별도의 모바일용 파일들(CSS,js,별도 스킨폴더등..)이 필요없다.

2.
