<?
	class dbConnect {																												#class dbConnect 생성
		var $db_host, $db_name, $db_user, $db_pwd, $db_conn;																		#변수 선언

		function dbConnect ( $db_host, $db_name, $db_user, $db_pwd) {																#위의 변수를 파라미터로 가지는 메소드
			$this->db_host		= $db_host;																							#메소드 변수 정의
			$this->db_name		= $db_name;
			$this->db_user		= $db_user;
			$this->db_pwd		= $db_pwd;

			$this->db_conn = @mysql_connect( $this->db_host, $this->db_user, $this->db_pwd) or die("데이타 베이스에 접속이 불가능합니다.");		#서버 및 데이터베이스 연결 or 실패할경우 메세지 출력
			@mysql_select_db( $this->db_name, $this->db_conn);																		#데이터베이스 변경
		}

		function result ( $sql ) {																									#결과 메소드
			$sql				= trim( $sql );																						#$sql의 앞뒤 공백 제거
			$result			= @mysql_query( $sql, $this->db_conn ) or die($sql);													#연결된 데이터베이스에 대해 sql명령문을 실행한다. 실패할경우 $sql값을 반환한다.
			return $result;																											#결과($result) 반환
		}

		function select ( $table, $where, $field = "*" ) {																			#선택 메소드
			$sql				= "Select $field from $table $where";																#변수 선언 ($sql변수는 해당 문자열을 가짐)
			$result			= $this->result( $sql );																				#위 result메소드의 $sql을 값으로 가지는 변수선언
			return $result;																											#결과($result) 반환
		}

		function object ( $table, $where, $field = "*" ) {																			#객체 메소드
			$sql				= "Select $field from $table $where";																#변수 선언 ($sql변수는 해당 문자열을 가짐)
			$result			= $this->result( $sql );																				#위 result메소드의 $sql을 값으로 가지는 변수선언
			$row			= @mysql_fetch_object($result);																			#$result변수를 객체로 반환함
			return $row;																											#$row 반환
		}

		function row ( $table, $where, $field = "*" ) {																				#행 메소드
			$sql				= "Select $field from $table $where";																#변수 선언 ($sql변수는 해당 문자열을 가짐)
			$result			= $this->result( $sql );																				#위 result메소드의 $sql을 값으로 가지는 변수선언
			$row			= @mysql_fetch_row($result);																			#$result의 값을 배열로 반환
			return $row;																											#$row 반환
		}

		function sum ( $table, $where, $field = "*" ) {																				#합 메소드
			$sql				= "Select sum($field) from $table $where";															#변수 선언 ($sql변수는 해당 문자열을 가짐)
			$result			= $this->result( $sql );																				#위 result메소드의 $sql을 값으로 가지는 변수선언
			$row			=  @mysql_fetch_row($result);																			#$result의 값을 배열로 반환
			if( $row[0] ) { return $row[0]; } else { return 0;}																		#$row배열의 0번쨰 인덱스일경우 $row배열의 0번쨰 인덱스를 반환한다. 그 외의 경우 0을 반환한다.
		}

		function cnt ( $table, $where) {																							#카운트 메소드
			$sql				= "Select count(idx) from $table $where";															#변수 선언 ($sql변수는 해당 문자열을 가짐)
			$result			= $this->result( $sql );																				#위 result메소드의 $sql을 값으로 가지는 변수선언
			$row			=  @mysql_fetch_row($result);																			#$result의 값을 배열로 반환
			if( $row[0] ) { return $row[0]; } else { return 0;}																		#$row배열의 0번쨰 인덱스일경우 $row배열의 0번쨰 인덱스를 반환한다. 그 외의 경우 0을 반환한다.
		}

		function insert ( $table, $data ) {																							#데이터 삽입 메소드
			$sql				= "insert into $table set $data";																	#변수 선언 ($sql변수는 해당 문자열을 가짐)
			if($this->result( $sql )) { return true; } else { return false; }														#결과 메소드의 인수가 $sql이면 true를 반환 그 외에는 false를 반환
		}

		function update ( $table, $data ) {																							#업데이트 메소드
			$sql				= "update $table set $data";																		#변수 선언 ($sql변수는 해당 문자열을 가짐)
			if($this->result( $sql )) { return true; } else { return false; }														#결과 메소드의 인수가 $sql이면 true를 반환 그 외에는 false를 반환
		}
		
		function delete ( $table, $data ) {																							#데이터 삭제 메소드
			$sql				= "delete from $table $data";																		#변수 선언 ($sql변수는 해당 문자열을 가짐)
			if($this->result( $sql )) { return true; } else { return false; }														#결과 메소드의 인수가 $sql이면 true를 반환 그 외에는 false를 반환
		}
		
		function dropTable ( $data ) {																								#테이블 삭제 메소드
			$sql				= "drop table $data";																				#변수 선언 ($sql변수는 해당 문자열을 가짐)
			if($this->result( $sql )) { return true; } else { return false; }														#결과 메소드의 인수가 $sql이면 true를 반환 그 외에는 false를 반환
		}

		function createTable ( $data ) {																							#테이블 생성 메소드
			$sql				= "create table $data";																				#변수 선언 ($sql변수는 해당 문자열을 가짐)
			if($this->result( $sql )) { return true; } else { return false; }														#결과 메소드의 인수가 $sql이면 true를 반환 그 외에는 false를 반환
		}

		function stripSlash ( $str ) {																								#백슬레시 제거 메소드
			$str				= trim( $str );																						#$str의 앞뒤 공백 제거
			$str				= stripslashes( $str );																				#$str의 백슬래시 제거
			return $str;																											#$str 반환
		}

		function addSlash ( $str ) {																								#백슬래시 추가 메소드		
			$str				= trim( $str );																						#$str의 앞뒤 공백 제거
			$str				= addslashes( $str );																				#$str의 백슬래시 추가
			if(empty( $str )) {																										#$str이 비어있으면 $str을 "NULL"로 저장
				$str			= "NULL";
			}
			return $str;																											#$str 반환
		}
	}

	class tools {																													#class 생성
		
		// 엔코드
		function encode($data) {
			return base64_encode($data)."||";																						#$data를 인코딩하고 "||"문자열을 합친다.
		}
		
		// 디코드
		function decode($data){
			$vars=explode("&",base64_decode(str_replace("||","",$data)));															#$data문자열에서 "||"인 부분을 ""으로 바꾸고 디코딩 후 &을 구분자로 나누어 나누어진 문자열을 각 부분을 원소로 갖는 배열을 반환한다.
			$vars_num=count($vars);																									#바로 위 $vars배열이 가진 원소 개수를 반환한다.
			for($i=0;$i<$vars_num;$i++) {																							#조건문 i=0으로 시작해 $vars_num의 개수보다 작게 증가시킨다.
				$elements=explode("=",$vars[$i]);																					#$elements변수는 $vars변수에서 =을 구분자로 나누어 각 부분을 원소로 갖는 배열을 반환한다.
				$var[$elements[0]]=$elements[1];																					#$elements의 0번째 인덱스값을 인덱스로 가지는 $var변수는 $elements의 첫번째 인덱스값으로 저장한다.
			}
			return $var;																											#$var 반환
		}
		
		// 문자열 자르는 부분
		function strCut($str, $len) {
			if ($len >= strlen($str)) return $str;																					#$len이 $str의 문자열의 길이보다 크거나 같을경우 $str을 반환한다.
			$klen = $len - 1;																										#$klen의 길이는 $len - 1로 저장한다.
			while(ord($str[$klen]) & 0x80) $klen--;																					#$klen을 인덱스로 가지는 $str문자열을 ASCII코드 값으로 반환하고 0x80이 참일경우 $klen을 감소시킨다.
			return substr($str, 0, $len - (($len + $klen + 1) % 2)) ."..";															#$str문자열을 0번째 문자부터  $len - (($len + $klen + 1) % 2)개의 문자까지 반환하고 뒤에 ".."문자열을 합친다.
		}
		
		// HTML 출력
		function strHtml($str) {
			$str = trim($str);																										#$str의 앞뒤 공백 제거
			$str = stripslashes($str);																								#$str의 백슬래시 제거
			return $str;																											#$str 반환
		}

		// 문자열 HTML BR 형태 출력
		function strHtmlBr($str) {																									
			$str = trim($str);																										#$str의 앞뒤 공백 제거
			$str = stripslashes($str);																								#$str의 백슬래시 제거																						
			$str = str_replace("\n","<br>", $str);																					#$str문자열에서 "\n"인 부분을 "<br>"로 바꿈
			return $str;																											#$str 반환
		}

		// 문자열 TEXT 형태 출력
		function strHtmlNo($str) {
			$str = trim($str);																										#$str의 앞뒤 공백 제거
			$str = htmlspecialchars($str);																							#$str의 특수문자를 HTML 엔티티로 변환한다.
			$str = stripslashes($str);																								#$str의 백슬래시 제거
			$str = str_replace("\n","<br>", $str);																					#$str문자열에서 "\n"인 부분을 "<br>"로 바꿈
			return $str;																											#$str 반환
		}
		
		// 문자열 TEXT 형태 출력
		function strHtmlNoBr($str) {
			$str = trim($str);																										#$str의 앞뒤 공백 제거
			$str = htmlspecialchars($str);																							#$str의 특수문자를 HTML 엔티티로 변환한다.
			$str = stripslashes($str);																								#$str의 백슬래시 제거
			return $str;																											#$str 반환
		}

		// 날자출력 형태 
		function strDateCut($str, $chk = 1) {
			if( $chk==1 ) {																											#$chk가 1과 같을경우
				$year	=	substr($str,0,4);																						#$year변수에 $str문자열의 0번째부터 4개의 문자까지 저장
				$mon	=	substr($str,5,2);																						#$mon변수에 $str문자열의 5번째부터 2개의 문자까지 저장
				$day	=	substr($str,8,2);																						#$day변수에 $str문자열의 8번째부터 2개의 문자까지 저장
				$str	=	$year."/".$mon."/".$day;																				#$str변수에 $year문자열에 "/"문자열을 합치고 $mon문자열 합치고 "/"문자열 합치고 $day문자열을 합친후 저장
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
				$str	=	$year."년 ".$mon."월 ".$day."일";
			} else if( $chk==6) {
				$year	=	substr($str,0,4);
				$mon	=	substr($str,5,2);
				$day	=	substr($str,8,2);
				$time	=	substr($str,11,2);
				$minu	=	substr($str,14,2);
				$str	=	$year."년 ".$mon."월 ".$day."일 ".$time."시 ".$minu."분";
			}
			return $str;
		}
		
		// 숫자로 된 값을 요일로 변환한다. (0:월요일, 1:화요일, 6:일요일)
		function strDateWeek($chk) {
			if( $chk==0 ) {
				$str="월요일";
			} else if( $chk==1 ) {
				$str="화요일";
			} else if( $chk==2 ) {
				$str="수요일";
			} else if( $chk==3 ) {
				$str="목요일";
			} else if( $chk==4 ) {
				$str="금요일";
			} else if( $chk==5 ) {
				$str="토요일";
			} else if( $chk==6) {
				$str="일요일";
			}
			return $str;
		}
		
		# E-MAIL 주소가 정확한 것인지 검사하는 함수
		#
		# eregi - 정규 표현식을 이용한 검사 (대소문자 무시)
		#         http://www.php.net/manual/function.eregi.php
		# gethostbynamel - 호스트 이름으로 ip 를 얻어옴
		#          http://www.php.net/manual/function.gethostbynamel.php
		# checkdnsrr - 인터넷 호스트 네임이나 IP 어드레스에 대응되는 DNS 레코드를 체크함
		#          http://www.php.net/manual/function.checkdnsrr.php
		function chkMail($email,$hchk=0) {
			$url = trim($email);																									#$email앞뒤 공백 제거
			if($hchk) {
				$host = explode("@",$url);																							#$url변수에서 "@"를 구분자로 나누어 나누어진 문자열의 각 부분을 원소로 갖는 배열을 반환한다.
				if(eregi("^[\xA1-\xFEa-z0-9_-]+@[\xA1-\xFEa-z0-9_-]+\.[a-z0-9._-]+$", $url)) {										#$url문자열에 패턴에 일치하는지 대소문자를 구분하지 않고 검사한다.
					if(checkdnsrr($host[1],"MX") || gethostbynamel($host[1])) return $url;  else return false;						#위의 조건식이 참이라면 $host[1]의 레코드가 MX이거나 인터넷 호스트가 $host[1]이면 $url을 반환 그 외의 경우 false반환
				}
			} else {
				if(eregi("^[\xA1-\xFEa-z0-9_-]+@[\xA1-\xFEa-z0-9_-]+\.[a-z0-9._-]+$", $url)) return $url;  else return false;		#$url변수에서 "@"를 구분자로 나누어 나누어진 문자열의 각 부분을 원소로 갖는 배열을 반환하여 참이라면 $url반환 그 외의 경우 false반환
			}
		}
		// 주민등록번호진위여부 확인 함수
		function chkJumin($resno1,$resno2) { 
			$resno = $resno1.$resno2;																								#$resno1문자열과 $resno2문자열을 $resno변수에 저장
			$len = strlen($resno);																									#$resno변수의 문자열길이를 $len변수에 저장
			if ($len <> 13) return false;																							#$len이 13이 아닐경우 false반환
			if (!ereg('^[[:digit:]]{6}[1-4][[:digit:]]{6}$', $resno)) return false;													#$resno문자열을 대소문자 구분하여 검사하여 참이 아닐경우 false반환
			$birthYear = ('2' >= $resno[6]) ? '19' : '20';																			#$resno[6]이 '2'보다 작거나 같을 경우 '19'반환 아닐경우 '20'반환
			$birthYear += substr($resno, 0, 2);																						#$resno의 0번째 부터 2개의 문자까지 반환 후 $birthYear에 더한 후 $birthYear에 저장
			$birthMonth = substr($resno, 2, 2);																						#$resno의 2번째 부터 2개의 문자까지 저장
			$birthDate = substr($resno, 4, 2);																						#$resno의 4번째 부터 2개의 문자까지 저장
			if (!checkdate($birthMonth, $birthDate, $birthYear)) return false;														#연도 월 일의 인자를 데이터를 받아 실제로 존재하는 날짜인지 검사후 거짓일경우 false를 반환
			for ($i = 0; $i < 13; $i++) $buf[$i] = (int) $resno[$i];																#$i를 0부터 시작 13보다 작게 증가 $buf[$i]에 $resno[$i]를 정수로 형변환 후 저장
			$multipliers = array(2,3,4,5,6,7,8,9,2,3,4,5);																			#배열 저장
			for ($i = $sum = 0; $i < 12; $i++) $sum += ($buf[$i] *= $multipliers[$i]);												#$i과 $sum을 0부터 시작 $i를 12보다 작게 증가 $sum에 변수 재선언
			if ((11 - ($sum % 11)) % 10 != $buf[12]) return false;																	#(11 - ($sum % 11)) % 10 != $buf[12]이 참일경우 false반환
			return true;																											#true 반환
		} 
	
		// 사업자등록번호 체크 함수
		function chkCompany($reginum) { 
			$weight = '137137135';																									#변수에 문자열 저장
			$len = strlen($reginum);																								#$reginum의 문자열 길이를 $len변수에 저장
			$sum = 0;																												#변수에 0저장
			if ($len <> 10) return false;																							#$len이 10이 아닐경우 false반환
			for ($i = 0; $i < 9; $i++) $sum = $sum + (substr($reginum,$i,1)*substr($weight,$i,1));									#$i를 0부터시작해서 9보다 작게 증가 $sum에 $sum + (substr($reginum,$i,1)*substr($weight,$i,1))저장
			$sum = $sum + ((substr($reginum,8,1)*5)/10);																			
			$rst = $sum%10;																											#$sum을 10으로 나눈후 나머지를 $rst에 저장
			if ($rst == 0) $result = 0;																								#$rst가 0이라면 $result에 0을 저장
			else $result = 10 - $rst;																								#아닐경우 $result에 10 - $rst를 저장
			$saub = substr($reginum,9,1);																							#$reginum문자열에서 9번째부터 1개의 문자까지 반환 후 저장
			if ($result <> $saub) return false;																						#$result가 $saub와 일치하지 않을 경우 false반환
			return true;																											#true 반환
		} 
	
		# 문자열에 한글이 포함되어 있는지 검사하는 함수
		function chkHan($str) {
			# 특정 문자가 한글의 범위내(0xA1A1 - 0xFEFE)에 있는지 검사
			$strCnt=0;
			while( strlen($str) >= $strCnt) {																						#$str의 문자열 길이가 $strCnt보다 크거나 같을경우 반복
				$char = ord($str[$strCnt]);																							#$str[strCnt]를 ASCII코드로 변환 후 $char에 저장
				if($char >= 0xa1 && $char <= 0xfe) return true;																		#$char이 0xa1보다 크거나 같고 $char이 0xfe보다 작거나 같으면 true 반환
				$strCnt++;																											#strCnt증가
			}
		}

		// 문자열 체크(숫자)
		function chkDigit($str) {
			if(ereg("^[1-9]+[0-9]*$",$str))  return true;
			else return false;
		}

		// 문자열 체크(알파)
		function chkAlpha($str) {
			if(ereg("^[a-zA-Z]+[a-zA-Z]*$",$str))  return true;
			else return false;
		}

		// 문자열 체크(알파+숫자)		
		function chkAlnum($str) {
			if(ereg("^[1-9a-zA-Z]+[0-9a-zA-Z]*$",$str))  return true;
			else return false;
		}

		// 문자열 체크(알파+숫자+특수문자)		
		function chkAlnumAll($str) {
			if(ereg("^[1-9a-zA-Z_-]+[0-9a-zA-Z_-]*$",$str))  return true;
			else return false;
		}

		// 메세지 출력
		function msg($msg) {
			echo "<script language='javascript'> alert('$msg'); </script>";
		}

		// 메세지 출력후 BACK
		function errMsg($msg) {
			echo "<script language='javascript'> alert('$msg'); history.back(); </script>";
			exit();
		}

		// 메세지 출력후 이동하는 자바스크립트
		function alertJavaGo($msg,$url) {
			echo "<script language='javascript'> alert('$msg'); location.replace('$url'); </script>";
			exit();
		}

		// 메세지 출력후 이동하는 메타테그
		function alertMetaGo($msg,$url) {
			echo "<script language='javascript'> alert('$msg'); </script>"; 
			echo "<meta http-equiv='refresh' content='0;url=$url'>";
			exit();
		}
		
		// 메타태그로 바로 가기
		function metaGo($url) {
			echo "<meta http-equiv='refresh' content='0;url=$url'>";
			exit();
		}

		// 자바스크립트로 바로 가기
		function javaGo($url) {
			echo "<script language='javascript'> location.href='$url'; </script>";
			exit();
		}
		
		// 창을 닫기
		function winClose() { 
			echo "<script language='javascript'> window.close(); </script>";
			exit();
		}

		// 메세지 출력후 창을 닫기
		function msgClose($msg) { 
			echo "<script language='javascript'> alert('$msg'); window.close(); </script>";
			exit();
		}


		// 창을 닫고 가는 함수
		function javaGoClose($url) { 
			echo "<script language='javascript'> opener.location.replace('$url'); self.close(); </script>";
			exit();
		}
		
		// 프레임으로 된 경우 상위 프레임으로 가는 함수
		function javaGoTop($url) { 
			echo "<script language='javascript'> parent.frames.top.location.replace('$url'); </script>";
			exit();
		}
	}
?>