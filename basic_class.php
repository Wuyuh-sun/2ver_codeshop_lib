<?
	class dbConnect {																												#class dbConnect ����
		var $db_host, $db_name, $db_user, $db_pwd, $db_conn;																		#���� ����

		function dbConnect ( $db_host, $db_name, $db_user, $db_pwd) {																#���� ������ �Ķ���ͷ� ������ �޼ҵ�
			$this->db_host		= $db_host;																							#�޼ҵ� ���� ����
			$this->db_name		= $db_name;
			$this->db_user		= $db_user;
			$this->db_pwd		= $db_pwd;

			$this->db_conn = @mysql_connect( $this->db_host, $this->db_user, $this->db_pwd) or die("����Ÿ ���̽��� ������ �Ұ����մϴ�.");		#���� �� �����ͺ��̽� ���� or �����Ұ�� �޼��� ���
			@mysql_select_db( $this->db_name, $this->db_conn);																		#�����ͺ��̽� ����
		}

		function result ( $sql ) {																									#��� �޼ҵ�
			$sql				= trim( $sql );																						#$sql�� �յ� ���� ����
			$result			= @mysql_query( $sql, $this->db_conn ) or die($sql);													#����� �����ͺ��̽��� ���� sql��ɹ��� �����Ѵ�. �����Ұ�� $sql���� ��ȯ�Ѵ�.
			return $result;																											#���($result) ��ȯ
		}

		function select ( $table, $where, $field = "*" ) {																			#���� �޼ҵ�
			$sql				= "Select $field from $table $where";																#���� ���� ($sql������ �ش� ���ڿ��� ����)
			$result			= $this->result( $sql );																				#�� result�޼ҵ��� $sql�� ������ ������ ��������
			return $result;																											#���($result) ��ȯ
		}

		function object ( $table, $where, $field = "*" ) {																			#��ü �޼ҵ�
			$sql				= "Select $field from $table $where";																#���� ���� ($sql������ �ش� ���ڿ��� ����)
			$result			= $this->result( $sql );																				#�� result�޼ҵ��� $sql�� ������ ������ ��������
			$row			= @mysql_fetch_object($result);																			#$result������ ��ü�� ��ȯ��
			return $row;																											#$row ��ȯ
		}

		function row ( $table, $where, $field = "*" ) {																				#�� �޼ҵ�
			$sql				= "Select $field from $table $where";																#���� ���� ($sql������ �ش� ���ڿ��� ����)
			$result			= $this->result( $sql );																				#�� result�޼ҵ��� $sql�� ������ ������ ��������
			$row			= @mysql_fetch_row($result);																			#$result�� ���� �迭�� ��ȯ
			return $row;																											#$row ��ȯ
		}

		function sum ( $table, $where, $field = "*" ) {																				#�� �޼ҵ�
			$sql				= "Select sum($field) from $table $where";															#���� ���� ($sql������ �ش� ���ڿ��� ����)
			$result			= $this->result( $sql );																				#�� result�޼ҵ��� $sql�� ������ ������ ��������
			$row			=  @mysql_fetch_row($result);																			#$result�� ���� �迭�� ��ȯ
			if( $row[0] ) { return $row[0]; } else { return 0;}																		#$row�迭�� 0���� �ε����ϰ�� $row�迭�� 0���� �ε����� ��ȯ�Ѵ�. �� ���� ��� 0�� ��ȯ�Ѵ�.
		}

		function cnt ( $table, $where) {																							#ī��Ʈ �޼ҵ�
			$sql				= "Select count(idx) from $table $where";															#���� ���� ($sql������ �ش� ���ڿ��� ����)
			$result			= $this->result( $sql );																				#�� result�޼ҵ��� $sql�� ������ ������ ��������
			$row			=  @mysql_fetch_row($result);																			#$result�� ���� �迭�� ��ȯ
			if( $row[0] ) { return $row[0]; } else { return 0;}																		#$row�迭�� 0���� �ε����ϰ�� $row�迭�� 0���� �ε����� ��ȯ�Ѵ�. �� ���� ��� 0�� ��ȯ�Ѵ�.
		}

		function insert ( $table, $data ) {																							#������ ���� �޼ҵ�
			$sql				= "insert into $table set $data";																	#���� ���� ($sql������ �ش� ���ڿ��� ����)
			if($this->result( $sql )) { return true; } else { return false; }														#��� �޼ҵ��� �μ��� $sql�̸� true�� ��ȯ �� �ܿ��� false�� ��ȯ
		}

		function update ( $table, $data ) {																							#������Ʈ �޼ҵ�
			$sql				= "update $table set $data";																		#���� ���� ($sql������ �ش� ���ڿ��� ����)
			if($this->result( $sql )) { return true; } else { return false; }														#��� �޼ҵ��� �μ��� $sql�̸� true�� ��ȯ �� �ܿ��� false�� ��ȯ
		}
		
		function delete ( $table, $data ) {																							#������ ���� �޼ҵ�
			$sql				= "delete from $table $data";																		#���� ���� ($sql������ �ش� ���ڿ��� ����)
			if($this->result( $sql )) { return true; } else { return false; }														#��� �޼ҵ��� �μ��� $sql�̸� true�� ��ȯ �� �ܿ��� false�� ��ȯ
		}
		
		function dropTable ( $data ) {																								#���̺� ���� �޼ҵ�
			$sql				= "drop table $data";																				#���� ���� ($sql������ �ش� ���ڿ��� ����)
			if($this->result( $sql )) { return true; } else { return false; }														#��� �޼ҵ��� �μ��� $sql�̸� true�� ��ȯ �� �ܿ��� false�� ��ȯ
		}

		function createTable ( $data ) {																							#���̺� ���� �޼ҵ�
			$sql				= "create table $data";																				#���� ���� ($sql������ �ش� ���ڿ��� ����)
			if($this->result( $sql )) { return true; } else { return false; }														#��� �޼ҵ��� �μ��� $sql�̸� true�� ��ȯ �� �ܿ��� false�� ��ȯ
		}

		function stripSlash ( $str ) {																								#�齽���� ���� �޼ҵ�
			$str				= trim( $str );																						#$str�� �յ� ���� ����
			$str				= stripslashes( $str );																				#$str�� �齽���� ����
			return $str;																											#$str ��ȯ
		}

		function addSlash ( $str ) {																								#�齽���� �߰� �޼ҵ�		
			$str				= trim( $str );																						#$str�� �յ� ���� ����
			$str				= addslashes( $str );																				#$str�� �齽���� �߰�
			if(empty( $str )) {																										#$str�� ��������� $str�� "NULL"�� ����
				$str			= "NULL";
			}
			return $str;																											#$str ��ȯ
		}
	}

	class tools {																													#class ����
		
		// ���ڵ�
		function encode($data) {
			return base64_encode($data)."||";																						#$data�� ���ڵ��ϰ� "||"���ڿ��� ��ģ��.
		}
		
		// ���ڵ�
		function decode($data){
			$vars=explode("&",base64_decode(str_replace("||","",$data)));															#$data���ڿ����� "||"�� �κ��� ""���� �ٲٰ� ���ڵ� �� &�� �����ڷ� ������ �������� ���ڿ��� �� �κ��� ���ҷ� ���� �迭�� ��ȯ�Ѵ�.
			$vars_num=count($vars);																									#�ٷ� �� $vars�迭�� ���� ���� ������ ��ȯ�Ѵ�.
			for($i=0;$i<$vars_num;$i++) {																							#���ǹ� i=0���� ������ $vars_num�� �������� �۰� ������Ų��.
				$elements=explode("=",$vars[$i]);																					#$elements������ $vars�������� =�� �����ڷ� ������ �� �κ��� ���ҷ� ���� �迭�� ��ȯ�Ѵ�.
				$var[$elements[0]]=$elements[1];																					#$elements�� 0��° �ε������� �ε����� ������ $var������ $elements�� ù��° �ε��������� �����Ѵ�.
			}
			return $var;																											#$var ��ȯ
		}
		
		// ���ڿ� �ڸ��� �κ�
		function strCut($str, $len) {
			if ($len >= strlen($str)) return $str;																					#$len�� $str�� ���ڿ��� ���̺��� ũ�ų� ������� $str�� ��ȯ�Ѵ�.
			$klen = $len - 1;																										#$klen�� ���̴� $len - 1�� �����Ѵ�.
			while(ord($str[$klen]) & 0x80) $klen--;																					#$klen�� �ε����� ������ $str���ڿ��� ASCII�ڵ� ������ ��ȯ�ϰ� 0x80�� ���ϰ�� $klen�� ���ҽ�Ų��.
			return substr($str, 0, $len - (($len + $klen + 1) % 2)) ."..";															#$str���ڿ��� 0��° ���ں���  $len - (($len + $klen + 1) % 2)���� ���ڱ��� ��ȯ�ϰ� �ڿ� ".."���ڿ��� ��ģ��.
		}
		
		// HTML ���
		function strHtml($str) {
			$str = trim($str);																										#$str�� �յ� ���� ����
			$str = stripslashes($str);																								#$str�� �齽���� ����
			return $str;																											#$str ��ȯ
		}

		// ���ڿ� HTML BR ���� ���
		function strHtmlBr($str) {																									
			$str = trim($str);																										#$str�� �յ� ���� ����
			$str = stripslashes($str);																								#$str�� �齽���� ����																						
			$str = str_replace("\n","<br>", $str);																					#$str���ڿ����� "\n"�� �κ��� "<br>"�� �ٲ�
			return $str;																											#$str ��ȯ
		}

		// ���ڿ� TEXT ���� ���
		function strHtmlNo($str) {
			$str = trim($str);																										#$str�� �յ� ���� ����
			$str = htmlspecialchars($str);																							#$str�� Ư�����ڸ� HTML ��ƼƼ�� ��ȯ�Ѵ�.
			$str = stripslashes($str);																								#$str�� �齽���� ����
			$str = str_replace("\n","<br>", $str);																					#$str���ڿ����� "\n"�� �κ��� "<br>"�� �ٲ�
			return $str;																											#$str ��ȯ
		}
		
		// ���ڿ� TEXT ���� ���
		function strHtmlNoBr($str) {
			$str = trim($str);																										#$str�� �յ� ���� ����
			$str = htmlspecialchars($str);																							#$str�� Ư�����ڸ� HTML ��ƼƼ�� ��ȯ�Ѵ�.
			$str = stripslashes($str);																								#$str�� �齽���� ����
			return $str;																											#$str ��ȯ
		}

		// ������� ���� 
		function strDateCut($str, $chk = 1) {
			if( $chk==1 ) {																											#$chk�� 1�� �������
				$year	=	substr($str,0,4);																						#$year������ $str���ڿ��� 0��°���� 4���� ���ڱ��� ����
				$mon	=	substr($str,5,2);																						#$mon������ $str���ڿ��� 5��°���� 2���� ���ڱ��� ����
				$day	=	substr($str,8,2);																						#$day������ $str���ڿ��� 8��°���� 2���� ���ڱ��� ����
				$str	=	$year."/".$mon."/".$day;																				#$str������ $year���ڿ��� "/"���ڿ��� ��ġ�� $mon���ڿ� ��ġ�� "/"���ڿ� ��ġ�� $day���ڿ��� ��ģ�� ����
			} else if( $chk==2 ) {																									
				$year	=	substr($str,0,4);
				$mon	=	substr($str,5,2);
				$day	=	substr($str,8,2);
				$time	=	substr($str,11,2);
				$minu	=	substr($str,14,2);
				$str	=	$year."/".$mon."/".$day." ".$time.":".$minu;
			} else if( $chk==3 ) {
				$year	=	substr($str,0,4);
				$mon	=	substr($str,5,2);
				$day	=	substr($str,8,2);
				$str	=	$year."-".$mon."-".$day;
			} else if( $chk==4 ) {
				$year	=	substr($str,0,4);
				$mon	=	substr($str,5,2);
				$day	=	substr($str,8,2);
				$time	=	substr($str,11,2);
				$minu	=	substr($str,14,2);
				$str	=	$year."-".$mon."-".$day." ".$time.":".$minu;
			} else if( $chk==5 ) {
				$year	=	substr($str,0,4);
				$mon	=	substr($str,5,2);
				$day	=	substr($str,8,2);
				$str	=	$year."�� ".$mon."�� ".$day."��";
			} else if( $chk==6) {
				$year	=	substr($str,0,4);
				$mon	=	substr($str,5,2);
				$day	=	substr($str,8,2);
				$time	=	substr($str,11,2);
				$minu	=	substr($str,14,2);
				$str	=	$year."�� ".$mon."�� ".$day."�� ".$time."�� ".$minu."��";
			}
			return $str;
		}
		
		// ���ڷ� �� ���� ���Ϸ� ��ȯ�Ѵ�. (0:������, 1:ȭ����, 6:�Ͽ���)
		function strDateWeek($chk) {
			if( $chk==0 ) {
				$str="������";
			} else if( $chk==1 ) {
				$str="ȭ����";
			} else if( $chk==2 ) {
				$str="������";
			} else if( $chk==3 ) {
				$str="�����";
			} else if( $chk==4 ) {
				$str="�ݿ���";
			} else if( $chk==5 ) {
				$str="�����";
			} else if( $chk==6) {
				$str="�Ͽ���";
			}
			return $str;
		}
		
		# E-MAIL �ּҰ� ��Ȯ�� ������ �˻��ϴ� �Լ�
		#
		# eregi - ���� ǥ������ �̿��� �˻� (��ҹ��� ����)
		#         http://www.php.net/manual/function.eregi.php
		# gethostbynamel - ȣ��Ʈ �̸����� ip �� ����
		#          http://www.php.net/manual/function.gethostbynamel.php
		# checkdnsrr - ���ͳ� ȣ��Ʈ �����̳� IP ��巹���� �����Ǵ� DNS ���ڵ带 üũ��
		#          http://www.php.net/manual/function.checkdnsrr.php
		function chkMail($email,$hchk=0) {
			$url = trim($email);																									#$email�յ� ���� ����
			if($hchk) {
				$host = explode("@",$url);																							#$url�������� "@"�� �����ڷ� ������ �������� ���ڿ��� �� �κ��� ���ҷ� ���� �迭�� ��ȯ�Ѵ�.
				if(eregi("^[\xA1-\xFEa-z0-9_-]+@[\xA1-\xFEa-z0-9_-]+\.[a-z0-9._-]+$", $url)) {										#$url���ڿ��� ���Ͽ� ��ġ�ϴ��� ��ҹ��ڸ� �������� �ʰ� �˻��Ѵ�.
					if(checkdnsrr($host[1],"MX") || gethostbynamel($host[1])) return $url;  else return false;						#���� ���ǽ��� ���̶�� $host[1]�� ���ڵ尡 MX�̰ų� ���ͳ� ȣ��Ʈ�� $host[1]�̸� $url�� ��ȯ �� ���� ��� false��ȯ
				}
			} else {
				if(eregi("^[\xA1-\xFEa-z0-9_-]+@[\xA1-\xFEa-z0-9_-]+\.[a-z0-9._-]+$", $url)) return $url;  else return false;		#$url�������� "@"�� �����ڷ� ������ �������� ���ڿ��� �� �κ��� ���ҷ� ���� �迭�� ��ȯ�Ͽ� ���̶�� $url��ȯ �� ���� ��� false��ȯ
			}
		}
		// �ֹε�Ϲ�ȣ�������� Ȯ�� �Լ�
		function chkJumin($resno1,$resno2) { 
			$resno = $resno1.$resno2;																								#$resno1���ڿ��� $resno2���ڿ��� $resno������ ����
			$len = strlen($resno);																									#$resno������ ���ڿ����̸� $len������ ����
			if ($len <> 13) return false;																							#$len�� 13�� �ƴҰ�� false��ȯ
			if (!ereg('^[[:digit:]]{6}[1-4][[:digit:]]{6}$', $resno)) return false;													#$resno���ڿ��� ��ҹ��� �����Ͽ� �˻��Ͽ� ���� �ƴҰ�� false��ȯ
			$birthYear = ('2' >= $resno[6]) ? '19' : '20';																			#$resno[6]�� '2'���� �۰ų� ���� ��� '19'��ȯ �ƴҰ�� '20'��ȯ
			$birthYear += substr($resno, 0, 2);																						#$resno�� 0��° ���� 2���� ���ڱ��� ��ȯ �� $birthYear�� ���� �� $birthYear�� ����
			$birthMonth = substr($resno, 2, 2);																						#$resno�� 2��° ���� 2���� ���ڱ��� ����
			$birthDate = substr($resno, 4, 2);																						#$resno�� 4��° ���� 2���� ���ڱ��� ����
			if (!checkdate($birthMonth, $birthDate, $birthYear)) return false;														#���� �� ���� ���ڸ� �����͸� �޾� ������ �����ϴ� ��¥���� �˻��� �����ϰ�� false�� ��ȯ
			for ($i = 0; $i < 13; $i++) $buf[$i] = (int) $resno[$i];																#$i�� 0���� ���� 13���� �۰� ���� $buf[$i]�� $resno[$i]�� ������ ����ȯ �� ����
			$multipliers = array(2,3,4,5,6,7,8,9,2,3,4,5);																			#�迭 ����
			for ($i = $sum = 0; $i < 12; $i++) $sum += ($buf[$i] *= $multipliers[$i]);												#$i�� $sum�� 0���� ���� $i�� 12���� �۰� ���� $sum�� ���� �缱��
			if ((11 - ($sum % 11)) % 10 != $buf[12]) return false;																	#(11 - ($sum % 11)) % 10 != $buf[12]�� ���ϰ�� false��ȯ
			return true;																											#true ��ȯ
		} 
	
		// ����ڵ�Ϲ�ȣ üũ �Լ�
		function chkCompany($reginum) { 
			$weight = '137137135';																									#������ ���ڿ� ����
			$len = strlen($reginum);																								#$reginum�� ���ڿ� ���̸� $len������ ����
			$sum = 0;																												#������ 0����
			if ($len <> 10) return false;																							#$len�� 10�� �ƴҰ�� false��ȯ
			for ($i = 0; $i < 9; $i++) $sum = $sum + (substr($reginum,$i,1)*substr($weight,$i,1));									#$i�� 0���ͽ����ؼ� 9���� �۰� ���� $sum�� $sum + (substr($reginum,$i,1)*substr($weight,$i,1))����
			$sum = $sum + ((substr($reginum,8,1)*5)/10);																			
			$rst = $sum%10;																											#$sum�� 10���� ������ �������� $rst�� ����
			if ($rst == 0) $result = 0;																								#$rst�� 0�̶�� $result�� 0�� ����
			else $result = 10 - $rst;																								#�ƴҰ�� $result�� 10 - $rst�� ����
			$saub = substr($reginum,9,1);																							#$reginum���ڿ����� 9��°���� 1���� ���ڱ��� ��ȯ �� ����
			if ($result <> $saub) return false;																						#$result�� $saub�� ��ġ���� ���� ��� false��ȯ
			return true;																											#true ��ȯ
		} 
	
		# ���ڿ��� �ѱ��� ���ԵǾ� �ִ��� �˻��ϴ� �Լ�
		function chkHan($str) {
			# Ư�� ���ڰ� �ѱ��� ������(0xA1A1 - 0xFEFE)�� �ִ��� �˻�
			$strCnt=0;
			while( strlen($str) >= $strCnt) {																						#$str�� ���ڿ� ���̰� $strCnt���� ũ�ų� ������� �ݺ�
				$char = ord($str[$strCnt]);																							#$str[strCnt]�� ASCII�ڵ�� ��ȯ �� $char�� ����
				if($char >= 0xa1 && $char <= 0xfe) return true;																		#$char�� 0xa1���� ũ�ų� ���� $char�� 0xfe���� �۰ų� ������ true ��ȯ
				$strCnt++;																											#strCnt����
			}
		}

		// ���ڿ� üũ(����)
		function chkDigit($str) {
			if(ereg("^[1-9]+[0-9]*$",$str))  return true;
			else return false;
		}

		// ���ڿ� üũ(����)
		function chkAlpha($str) {
			if(ereg("^[a-zA-Z]+[a-zA-Z]*$",$str))  return true;
			else return false;
		}

		// ���ڿ� üũ(����+����)		
		function chkAlnum($str) {
			if(ereg("^[1-9a-zA-Z]+[0-9a-zA-Z]*$",$str))  return true;
			else return false;
		}

		// ���ڿ� üũ(����+����+Ư������)		
		function chkAlnumAll($str) {
			if(ereg("^[1-9a-zA-Z_-]+[0-9a-zA-Z_-]*$",$str))  return true;
			else return false;
		}

		// �޼��� ���
		function msg($msg) {
			echo "<script language='javascript'> alert('$msg'); </script>";
		}

		// �޼��� ����� BACK
		function errMsg($msg) {
			echo "<script language='javascript'> alert('$msg'); history.back(); </script>";
			exit();
		}

		// �޼��� ����� �̵��ϴ� �ڹٽ�ũ��Ʈ
		function alertJavaGo($msg,$url) {
			echo "<script language='javascript'> alert('$msg'); location.replace('$url'); </script>";
			exit();
		}

		// �޼��� ����� �̵��ϴ� ��Ÿ�ױ�
		function alertMetaGo($msg,$url) {
			echo "<script language='javascript'> alert('$msg'); </script>"; 
			echo "<meta http-equiv='refresh' content='0;url=$url'>";
			exit();
		}
		
		// ��Ÿ�±׷� �ٷ� ����
		function metaGo($url) {
			echo "<meta http-equiv='refresh' content='0;url=$url'>";
			exit();
		}

		// �ڹٽ�ũ��Ʈ�� �ٷ� ����
		function javaGo($url) {
			echo "<script language='javascript'> location.href='$url'; </script>";
			exit();
		}
		
		// â�� �ݱ�
		function winClose() { 
			echo "<script language='javascript'> window.close(); </script>";
			exit();
		}

		// �޼��� ����� â�� �ݱ�
		function msgClose($msg) { 
			echo "<script language='javascript'> alert('$msg'); window.close(); </script>";
			exit();
		}


		// â�� �ݰ� ���� �Լ�
		function javaGoClose($url) { 
			echo "<script language='javascript'> opener.location.replace('$url'); self.close(); </script>";
			exit();
		}
		
		// ���������� �� ��� ���� ���������� ���� �Լ�
		function javaGoTop($url) { 
			echo "<script language='javascript'> parent.frames.top.location.replace('$url'); </script>";
			exit();
		}
	}
?>