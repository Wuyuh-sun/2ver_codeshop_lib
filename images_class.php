<?
# 이미지 사이즈를 조정하는 함수
# Usage : ImgResize_lib("original image path","image type","new width",'new height");
# image type -> create new image as jpeg or gif or wbmp or png type
#
function ImgResize_lib($original,$type="jpg",$width=0,$height=0,$newpath=0,$dbchk) {						
  $no_java = $GLOBALS[ShellCmd] ? 1 : 0;													#$GLOBALS[ShellCmd]가 참이면 1 아니면 0반환
  $newpath = $newpath ? $newpath : "";														#$newpath가 참이면 $newpath 반환 아니면 ""반환

  if(!extension_loaded("gd"))																#확장 기능로드 여부 확인
    print_error_lib("ImgResize_lib() funtion required gd extension in PHP",$no_java);

  # DB 에 들어있는 image 를 얻어올 경우 처리
  if($dbchk) {
    if(is_dir("/dev/shm")) $file_path = "/dev/shm/ImgResize-".uniqid("").".$type";			#is_dir은 폴더 존재 여부 확인 참이면 $file_path변수에 해당 경로 문자열을 저장/ uniqid는 유니크 id를 생성하는 함수
    else $file_path = "/tmp/ImgResize-".uniqid("").".$type";								#참이 아닐경우 변수에 해당 경로 문자열 저장
    $p = fopen($file_path,"wb");															#$file_path를 파일을 쓰기모드로 열면서 binary mode로 연다.
    fwrite($p,$original);																	#$p에 $original을 쓴다.
    fclose($p);																				#fopen으로 열린 $p를 닫는다.
    $original = $file_path;
  }

  # 원본 이미지로 부터 JPEG 파일을 생성
  $otype = GetImageSize($original);															#이미지에 대한 정보 가져오기.
  switch($otype[2]) {
    case 1:
      $img = ImageCreateFromGIF($original);													#주어진 파일 이름에서 얻은 이미지를 나타내는 이미지 식별자를 반환(GIF)
      break;
    case 2:
      $img = ImageCreateFromJPEG($original);												#주어진 파일 이름에서 얻은 이미지를 나타내는 이미지 식별자를 반환(JPEG)
      break;
    case 3:
      $img = ImageCreateFromPNG($original);													#주어진 파일 이름에서 얻은 이미지를 나타내는 이미지 식별자를 반환(PNG)
      break;
    default:
      print_error_lib("Enable original file is type of GIF,JPG,PNG");
  }

  # 원본 이미지의 width, height 를 구함
  $owidth = ImagesX($img);
  $oheight = ImagesY($img);

  # width 와 height 를 모두 0 으로 주었을 경우 기본값 50
  if(!$width && !$height) $width = $height = 50;

  # width 가 없을 경우 height 의 축소/확대 비율로 width 를 구함
  if(!$width) {
    $ratio = ((real)$height/$oheight);
    $width = ((int)$owidth*$ratio);
  }

  # height 가 없을 경우 width 의 축소/확대 비율로 height 를 구함
  if(!$height) {
    $ratio = ((real)$width/$owidth);
    $height = ((int)$oheight*$ratio);
  }

  # 새로운 이미지를 생성
  $newimg = ImageCreate($width,$height);
  # 새로운 이미지에 원본 이미지를 사이즈 조정하여 복사.
  ImageCopyResized($newimg,$img,0,0,0,0,$width,$height,$owidth,$oheight);

  # 타입에 따라 헤더를 출력
  switch($type) {
    case "wbmp" :
      $type_header = "vnd.wap.wbmp";
      break;
    default :
      $type = ($type == "jpg") ? "jpeg" : $type;
      $type_header = $type;
  }
  if(!$newpath) Header("Content-type: image/$type_header");									#가공되지 않은 HTTP 헤더를 송신

  switch($type) {
    case "png" :
      if($newpath) ImagePNG($newimg,$newpath);												#PNG이미지를 출력
      else ImagePNG($newimg);
      break;
    case "wbmp" :
      if($newpath) ImageWBMP($newimg,$newpath);												#WBMP이미지 출력
      else ImageWBMP($newimg);
      break;
    case "gif" :
      if($newpath) ImageGIF($newimg,$newpath);												#GIF이미지 출력
      else ImageGIF($newimg);
    default :
      ImageJPEG($newimg,$newpath,80);														#JPEG이미지 출력
  }
  ImageDestroy($newimg);																	#이미지 삭제
  if($dbchk && file_exists($original)) unlink($original);									#file_exists-파일 경로 확인후 불로 반환, unlink-파일삭제
}
?>
