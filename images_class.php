<?
# �̹��� ����� �����ϴ� �Լ�
# Usage : ImgResize_lib("original image path","image type","new width",'new height");
# image type -> create new image as jpeg or gif or wbmp or png type
#
function ImgResize_lib($original,$type="jpg",$width=0,$height=0,$newpath=0,$dbchk) {
  $no_java = $GLOBALS[ShellCmd] ? 1 : 0;
  $newpath = $newpath ? $newpath : "";

  if(!extension_loaded("gd"))
    print_error_lib("ImgResize_lib() funtion required gd extension in PHP",$no_java);

  # DB �� ����ִ� image �� ���� ��� ó��
  if($dbchk) {
    if(is_dir("/dev/shm")) $file_path = "/dev/shm/ImgResize-".uniqid("").".$type";
    else $file_path = "/tmp/ImgResize-".uniqid("").".$type";
    $p = fopen($file_path,"wb");
    fwrite($p,$original);
    fclose($p);
    $original = $file_path;
  }

  # ���� �̹����� ���� JPEG ������ ����
  $otype = GetImageSize($original);
  switch($otype[2]) {
    case 1:
      $img = ImageCreateFromGIF($original);
      break;
    case 2:
      $img = ImageCreateFromJPEG($original);
      break;
    case 3:
      $img = ImageCreateFromPNG($original);
      break;
    default:
      print_error_lib("Enable original file is type of GIF,JPG,PNG");
  }

  # ���� �̹����� width, height �� ����
  $owidth = ImagesX($img);
  $oheight = ImagesY($img);

  # width �� height �� ��� 0 ���� �־��� ��� �⺻�� 50
  if(!$width && !$height) $width = $height = 50;

  # width �� ���� ��� height �� ���/Ȯ�� ������ width �� ����
  if(!$width) {
    $ratio = ((real)$height/$oheight);
    $width = ((int)$owidth*$ratio);
  }

  # height �� ���� ��� width �� ���/Ȯ�� ������ height �� ����
  if(!$height) {
    $ratio = ((real)$width/$owidth);
    $height = ((int)$oheight*$ratio);
  }

  # ���ο� �̹����� ����
  $newimg = ImageCreate($width,$height);
  # ���ο� �̹����� ���� �̹����� ������ �����Ͽ� ����.
  ImageCopyResized($newimg,$img,0,0,0,0,$width,$height,$owidth,$oheight);

  # Ÿ�Կ� ���� ����� ���
  switch($type) {
    case "wbmp" :
      $type_header = "vnd.wap.wbmp";
      break;
    default :
      $type = ($type == "jpg") ? "jpeg" : $type;
      $type_header = $type;
  }
  if(!$newpath) Header("Content-type: image/$type_header");

  switch($type) {
    case "png" :
      if($newpath) ImagePNG($newimg,$newpath);
      else ImagePNG($newimg);
      break;
    case "wbmp" :
      if($newpath) ImageWBMP($newimg,$newpath);
      else ImageWBMP($newimg);
      break;
    case "gif" :
      if($newpath) ImageGIF($newimg,$newpath);
      else ImageGIF($newimg);
    default :
      ImageJPEG($newimg,$newpath,80);
  }
  ImageDestroy($newimg);
  if($dbchk && file_exists($original)) unlink($original);
}
?>
