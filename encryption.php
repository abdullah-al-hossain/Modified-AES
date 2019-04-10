<?php

///////////////////////////////////////////////////// Encryption /////////////////////////////////////////////////
	
	include 'operations.php';

	if (isset($_POST['encr'])) {
		$arrBin = array();    

	    $firstFour = array();
	    $mid1Four = array();
	    $mid2Four = array();
		$lastFour = array();
		foreach ($stringToAsciiPlain as $value) {
			$bin = decbin($value);	
			$len = strlen($bin);				
			$lackOfZeros = 8 - $len;
			
			for ($i=0; $i < $lackOfZeros; $i++) { 
				$bin = '0'.$bin;
			}

			array_push($arrBin, $bin);	
		}

		$plain_txt = '';
		foreach ($arrBin as $val) {
			$plain_txt .= $val;
		}

		for ($j=0; $j < 9; $j++) { 			
			$vals = '';
		
			for ($i=0; $i < 128; $i++) { 
				$vals .= (int)$allKeys[$j][$i] ^ (int)$plain_txt[$i];
			}

			$arr3 = str_split($vals, 8);

			foreach($arr3 as $value) {
				$current = bindec($value);
				$curVal =  (int)$SBOX[$current];
				$curBin = decbin($curVal);

				array_shift($arr3);
				array_push($arr3, $curBin);
			}

			foreach ($arr3 as $val) {		
				$len = strlen($val);				
				$lackOfZeros = 8 - $len;
				
				for ($i=0; $i < $lackOfZeros; $i++) { 
					$val = '0'.$val;
				}

				array_shift($arr3);
				array_push($arr3, $val);
					
			}
			
			///////////////// Shift rows
			$temp = $arr3[1];
			$arr3[1] = $arr3[5];
			$arr3[5] = $arr3[9];
			$arr3[9] = $arr3[13];
			$arr3[13] = $temp;

			$temp = $arr3[2];
			$arr3[2] = $arr3[10];
			$arr3[10] = $temp;


			$temp = $arr3[6];
			$arr3[6] = $arr3[14];
			$arr3[14] = $temp;

			$temp = $arr3[15];
			$arr3[15] = $arr3[11];
			$arr3[11] = $arr3[7];
			$arr3[7] = $arr3[3];
			$arr3[3] = $temp;

			////Transpose

			$temp = $arr3[1];
			$arr3[1] = $arr3[4];
			$arr3[4] = $temp;

			$temp = $arr3[2];
			$arr3[2] = $arr3[8];
			$arr3[8] = $temp;

			$temp = $arr3[3];
			$arr3[3] = $arr3[12];
			$arr3[12] = $temp;

			$temp = $arr3[6];
			$arr3[6] = $arr3[9];
			$arr3[9] = $temp;

			$temp = $arr3[7];
			$arr3[7] = $arr3[13];
			$arr3[13] = $temp;

			$temp = $arr3[11];
			$arr3[11] = $arr3[14];
			$arr3[14] = $temp;
			

			$plain_txt = '';

			foreach ($arr3 as $value) {
				$plain_txt .= $value;
			}

		}

		$vals = '';

			for ($i=0; $i < 128; $i++) { 
				$vals .= (int)$allKeys[9][$i] ^ (int)$plain_txt[$i];
			}


			$arr3 = str_split($vals, 8);

			foreach($arr3 as $value) {
				$current = bindec($value);
				$curVal =  (int)$SBOX[$current];
				$curBin = decbin($curVal);

				array_shift($arr3);
				array_push($arr3, $curBin);
			}

			foreach ($arr3 as $val) {		
				$len = strlen($val);				
				$lackOfZeros = 8 - $len;
				
				for ($i=0; $i < $lackOfZeros; $i++) { 
					$val = '0'.$val;
				}

				array_shift($arr3);
				array_push($arr3, $val);
					
			}
			
			///////////////// Shift rows
			$temp = $arr3[1];
			$arr3[1] = $arr3[5];
			$arr3[5] = $arr3[9];
			$arr3[9] = $arr3[13];
			$arr3[13] = $temp;

			$temp = $arr3[2];
			$arr3[2] = $arr3[10];
			$arr3[10] = $temp;


			$temp = $arr3[6];
			$arr3[6] = $arr3[14];
			$arr3[14] = $temp;

			$temp = $arr3[15];
			$arr3[15] = $arr3[11];
			$arr3[11] = $arr3[7];
			$arr3[7] = $arr3[3];
			$arr3[3] = $temp;
			
			$plain_txt = '';

			foreach ($arr3 as $value) {
				$plain_txt .= $value;
			}

			$vals = '';
			for ($i=0; $i < 128; $i++) { 
				$vals .= (int)$allKeys[10][$i] ^ (int)$plain_txt[$i];
			}
			$_SESSION['cipher'] = $vals;
			$_SESSION['plain'] = $_POST['plain_text'];
			$_SESSION['key'] = $_POST['c_key'];

			header('location: index.php?cipher='.$vals.'&plain='.$_POST['plain_text'].'&key='.$_POST['c_key']);

	}


