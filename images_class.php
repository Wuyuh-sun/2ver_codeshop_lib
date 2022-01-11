<?
# �̹��� ����� �����ϴ� �Լ�
# Usage : ImgResize_lib("original image path","image type","new width",'new height");
# image type -> create new image as jpeg or gif or wbmp or png type
#
function ImgResize_lib($original,$type="jpg",$width=0,$height=0,$newpath=0,$dbchk) {						
  $no_java = $GLOBALS[ShellCmd] ? 1 : 0;													#$GLOBALS[ShellCmd]�� ���̸� 1 �ƴϸ� 0��ȯ
  $newpath = $newpath ? $newpath : "";														#$newpath�� ���̸� $newpath ��ȯ �ƴϸ� ""��ȯ

  if(!extension_loaded("gd"))																#Ȯ�� ��ɷε� ���� Ȯ��
    print_error_lib("ImgResize_lib() funtion required gd extension in PHP",$no_java);

  # DB �� ����ִ� image �� ���� ��� ó��
  if($dbchk) {
    if(is_dir("/dev/shm")) $file_path = "/dev/shm/ImgResize-".uniqid("").".$type";			#is_dir�� ���� ���� ���� Ȯ�� ���̸� $file_path������ �ش� ��� ���ڿ��� ����/ uniqid�� ����ũ id�� �����ϴ� �Լ�
    else $file_path = "/tmp/ImgResize-".uniqid("").".$type";								#���� �ƴҰ�� ������ �ش� ��� ���ڿ� ����
    $p = fopen($file_path,"wb");															#$file_path�� ������ ������� ���鼭 binary mode�� ����.
    fwrite($p,$original);																	#$p�� $original�� ����.
    fclose($p);																				#fopen���� ���� $p�� �ݴ´�.
    $original = $file_path;
  }

  # ���� �̹����� ���� JPEG ������ ����
  $otype = GetImageSize($original);															#�̹����� ���� ���� ��������.
  switch($otype[2]) {
    case 1:
      $img = ImageCreateFromGIF($original);													#�־��� ���� �̸����� ���� �̹����� ��Ÿ���� �̹��� �ĺ��ڸ� ��ȯ(GIF)
      break;
    case 2:
      $img = ImageCreateFromJPEG($original);												#�־��� ���� �̸����� ���� �̹����� ��Ÿ���� �̹��� �ĺ��ڸ� ��ȯ(JPEG)
      break;
    case 3:
      $img = ImageCreateFromPNG($original);													#�־��� ���� �̸����� ���� �̹����� ��Ÿ���� �̹��� �ĺ��ڸ� ��ȯ(PNG)
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
  if(!$newpath) Header("Content-type: image/$type_header");									#�������� ���� HTTP ����� �۽�

  switch($type) {
    case "png" :
      if($newpath) ImagePNG($newimg,$newpath);												#PNG�̹����� ���
      else ImagePNG($newimg);
      break;
    case "wbmp" :
      if($newpath) ImageWBMP($newimg,$newpath);												#WBMP�̹��� ���
      else ImageWBMP($newimg);
      break;
    case "gif" :
      if($newpath) ImageGIF($newimg,$newpath);												#GIF�̹��� ���
      else ImageGIF($newimg);
    default :
      ImageJPEG($newimg,$newpath,80);														#JPEG�̹��� ���
  }
  ImageDestroy($newimg);																	#�̹��� ����
  if($dbchk && file_exists($original)) unlink($original);									#file_exists-���� ��� Ȯ���� �ҷ� ��ȯ, unlink-���ϻ���
}
?>
