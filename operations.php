<?php  
	session_start();

	// if (strlen($_POST['c_key']) != 16 ) {
	// 	header('location: index.php?msg=notCorrect');
	// }
	$pText = $_POST['plain_text'];

	if (isset($_POST['decrypt'])) {
		$vals =$pText;	
	}

	// if (isset($_POST['enc_text'])) {
	// 	$pText = $_POST['enc_text'];
	// 	echo "$pText";
	// }
	$cipherKey = $_POST['c_key'];

	$stringToAscii = unpack("C*", $cipherKey);
	$stringToAsciiPlain = unpack("C*", $pText);
	
	$eightBitConv = array();

	$SBOX = array(
	    0x63, 0x7c, 0x77, 0x7b, 0xf2, 0x6b, 0x6f, 0xc5, 0x30, 0x01, 0x67, 0x2b, 0xfe, 0xd7, 0xab, 0x76,
	    0xca, 0x82, 0xc9, 0x7d, 0xfa, 0x59, 0x47, 0xf0, 0xad, 0xd4, 0xa2, 0xaf, 0x9c, 0xa4, 0x72, 0xc0,
	    0xb7, 0xfd, 0x93, 0x26, 0x36, 0x3f, 0xf7, 0xcc, 0x34, 0xa5, 0xe5, 0xf1, 0x71, 0xd8, 0x31, 0x15,
	    0x04, 0xc7, 0x23, 0xc3, 0x18, 0x96, 0x05, 0x9a, 0x07, 0x12, 0x80, 0xe2, 0xeb, 0x27, 0xb2, 0x75,
	    0x09, 0x83, 0x2c, 0x1a, 0x1b, 0x6e, 0x5a, 0xa0, 0x52, 0x3b, 0xd6, 0xb3, 0x29, 0xe3, 0x2f, 0x84,	
	    0x53, 0xd1, 0x00, 0xed, 0x20, 0xfc, 0xb1, 0x5b, 0x6a, 0xcb, 0xbe, 0x39, 0x4a, 0x4c, 0x58, 0xcf,
	    0xd0, 0xef, 0xaa, 0xfb, 0x43, 0x4d, 0x33, 0x85, 0x45, 0xf9, 0x02, 0x7f, 0x50, 0x3c, 0x9f, 0xa8,
	    0x51, 0xa3, 0x40, 0x8f, 0x92, 0x9d, 0x38, 0xf5, 0xbc, 0xb6, 0xda, 0x21, 0x10, 0xff, 0xf3, 0xd2,
	    0xcd, 0x0c, 0x13, 0xec, 0x5f, 0x97, 0x44, 0x17, 0xc4, 0xa7, 0x7e, 0x3d, 0x64, 0x5d, 0x19, 0x73,
	    0x60, 0x81, 0x4f, 0xdc, 0x22, 0x2a, 0x90, 0x88, 0x46, 0xee, 0xb8, 0x14, 0xde, 0x5e, 0x0b, 0xdb,
	    0xe0, 0x32, 0x3a, 0x0a, 0x49, 0x06, 0x24, 0x5c, 0xc2, 0xd3, 0xac, 0x62, 0x91, 0x95, 0xe4, 0x79,
	    0xe7, 0xc8, 0x37, 0x6d, 0x8d, 0xd5, 0x4e, 0xa9, 0x6c, 0x56, 0xf4, 0xea, 0x65, 0x7a, 0xae, 0x08,
	    0xba, 0x78, 0x25, 0x2e, 0x1c, 0xa6, 0xb4, 0xc6, 0xe8, 0xdd, 0x74, 0x1f, 0x4b, 0xbd, 0x8b, 0x8a,
	    0x70, 0x3e, 0xb5, 0x66, 0x48, 0x03, 0xf6, 0x0e, 0x61, 0x35, 0x57, 0xb9, 0x86, 0xc1, 0x1d, 0x9e,
	    0xe1, 0xf8, 0x98, 0x11, 0x69, 0xd9, 0x8e, 0x94, 0x9b, 0x1e, 0x87, 0xe9, 0xce, 0x55, 0x28, 0xdf,
	    0x8c, 0xa1, 0x89, 0x0d, 0xbf, 0xe6, 0x42, 0x68, 0x41, 0x99, 0x2d, 0x0f, 0xb0, 0x54, 0xbb, 0x16
	);

	//// index124
	$INV_SBOX = array(
	    0x52, 0x09, 0x6a, 0xd5, 0x30, 0x36, 0xa5, 0x38, 0xbf, 0x40, 0xa3, 0x9e, 0x81, 0xf3, 0xd7, 0xfb,
	    0x7c, 0xe3, 0x39, 0x82, 0x9b, 0x2f, 0xff, 0x87, 0x34, 0x8e, 0x43, 0x44, 0xc4, 0xde, 0xe9, 0xcb,
	    0x54, 0x7b, 0x94, 0x32, 0xa6, 0xc2, 0x23, 0x3d, 0xee, 0x4c, 0x95, 0x0b, 0x42, 0xfa, 0xc3, 0x4e,
	    0x08, 0x2e, 0xa1, 0x66, 0x28, 0xd9, 0x24, 0xb2, 0x76, 0x5b, 0xa2, 0x49, 0x6d, 0x8b, 0xd1, 0x25,
	    0x72, 0xf8, 0xf6, 0x64, 0x86, 0x68, 0x98, 0x16, 0xd4, 0xa4, 0x5c, 0xcc, 0x5d, 0x65, 0xb6, 0x92,
	    0x6c, 0x70, 0x48, 0x50, 0xfd, 0xed, 0xb9, 0xda, 0x5e, 0x15, 0x46, 0x57, 0xa7, 0x8d, 0x9d, 0x84,
	    0x90, 0xd8, 0xab, 0x00, 0x8c, 0xbc, 0xd3, 0x0a, 0xf7, 0xe4, 0x58, 0x05, 0xb8, 0xb3, 0x45, 0x06,
	    0xd0, 0x2c, 0x1e, 0x8f, 0xca, 0x3f, 0x0f, 0x02, 0xc1, 0xaf, 0xbd, 0x03, 0x01, 0x13, 0x8a, 0x6b,
	    0x3a, 0x91, 0x11, 0x41, 0x4f, 0x67, 0xdc, 0xea, 0x97, 0xf2, 0xcf, 0xce, 0xf0, 0xb4, 0xe6, 0x73,
	    0x96, 0xac, 0x74, 0x22, 0xe7, 0xad, 0x35, 0x85, 0xe2, 0xf9, 0x37, 0xe8, 0x1c, 0x75, 0xdf, 0x6e,
	    0x47, 0xf1, 0x1a, 0x71, 0x1d, 0x29, 0xc5, 0x89, 0x6f, 0xb7, 0x62, 0x0e, 0xaa, 0x18, 0xbe, 0x1b,
	    0xfc, 0x56, 0x3e, 0x4b, 0xc6, 0xd2, 0x79, 0x20, 0x9a, 0xdb, 0xc0, 0xfe, 0x78, 0xcd, 0x5a, 0xf4,
	    0x1f, 0xdd, 0xa8, 0x33, 0x88, 0x07, 0xc7, 0x31, 0xb1, 0x12, 0x10, 0x59, 0x27, 0x80, 0xec, 0x5f,
	    0x60, 0x51, 0x7f, 0xa9, 0x19, 0xb5, 0x4a, 0x0d, 0x2d, 0xe5, 0x7a, 0x9f, 0x93, 0xc9, 0x9c, 0xef,
	    0xa0, 0xe0, 0x3b, 0x4d, 0xae, 0x2a, 0xf5, 0xb0, 0xc8, 0xeb, 0xbb, 0x3c, 0x83, 0x53, 0x99, 0x61,
	    0x17, 0x2b, 0x04, 0x7e, 0xba, 0x77, 0xd6, 0x26, 0xe1, 0x69, 0x14, 0x63, 0x55, 0x21, 0x0c, 0x7d
	);
    
    $arrBin = array();

    $allKeys = array();

    $firstFour = array();
    $mid1Four = array();
    $mid2Four = array();
	$lastFour = array();

	foreach ($stringToAscii as $value) {
		$bin = decbin($value);	
		$len = strlen($bin);				
		$lackOfZeros = 8 - $len;
		
		for ($i=0; $i < $lackOfZeros; $i++) { 
			$bin = '0'.$bin;
		}

		array_push($arrBin, $bin);	
	}

		$initialKey = '';
		foreach ($arrBin as $value) {
			$initialKey .= $value;
		}

		// echo "<p>Initial Key: $initialKey</p>";
		array_push($allKeys, $initialKey);

		$i = 1;
	foreach ($arrBin as $val) {						
		if ($i <= 4) {
			array_push($firstFour, $val);	
		}		
		if ($i > 4 and $i <= 8) {
			array_push($mid1Four, $val);	
		}		
		if ($i > 8 and $i <= 12) {
			array_push($mid2Four, $val);	
		}		
		if ($i > 12) {
			array_push($lastFour, $val);	
		}		
		// echo "<b>".$i++."</b>.$val<br>";	
		$i++;
	}

	$W1 = '';
	foreach ($mid1Four as $val) {		
		$W1 .= $val;
	}

	$W2 = '';
	foreach ($mid2Four as $val) {
		$W2 .= $val;
	}

	$W3new = '';
	foreach ($lastFour as $val) {
		$W3new .= $val;
	}

	$W3 = array_shift($lastFour);
	array_push($lastFour, $W3);

	// Pushing the first 8 bit of W3 at the end and shifting 24 bits to the most right of the word
	// foreach ($lastFour as $val) {
	// 	echo "<u>$val</u>&nbsp;&nbsp;&nbsp;";
	// }

	// Substitution of the aquired values with the values aquired from the SBOX
	foreach($lastFour as $value) {
		$current = bindec($value);
		$curVal =  (int)$SBOX[$current];
		$curBin = decbin($curVal);

		array_shift($lastFour);
		array_push($lastFour, $curBin);
	}

	foreach ($lastFour as $val) {		
		$len = strlen($val);				
		$lackOfZeros = 8 - $len;
		
		for ($i=0; $i < $lackOfZeros; $i++) { 
			$val = '0'.$val;
		}

		array_shift($lastFour);
		array_push($lastFour, $val);
			
	}

	//$RC = array(0x01, 0x02, 0x04, 0x08, 0x10, 0x20, 0x40, 0x80, 0x1b, 0x36);

	$RC = array('00000001', '00000010', '00000100', '00001000','00001010', '00010100', '01000000', '10000000', '00011011', '00110110');
	
	$G1 = (int)$RC[0] ^ (int)$lastFour[0];
	
	$lackOfZeros = 8 - strlen($G1);

	for ($i=0; $i < $lackOfZeros; $i++) { 
		$G1 = '0'.$G1;
	}

	array_shift($lastFour);
	array_unshift($lastFour, $G1);
	
	$G1 = '';
	foreach ($lastFour as $val) {
		$G1 .= $val;
	}	

	$W0 = '';
	foreach ($firstFour as $val) {
		$W0 .= $val;		
	}

	

	$W4 = '';
	
	for ($i=0; $i < 32; $i++) { 
		$W4 .= (int)$G1[$i] ^ (int)$W0[$i];		
	}
	
	$W5 = '';
	
	for ($i=0; $i < 32; $i++) { 
		$W5 .= (int)$W1[$i] ^ (int)$W4[$i];		
	}
	
	$W6 = '';
	
	for ($i=0; $i < 32; $i++) { 
		$W6 .= (int)$W2[$i] ^ (int)$W5[$i];		
	}
	
	$W7 = '';
	
	for ($i=0; $i < 32; $i++) { 
		$W7 .= (int)$W3new[$i] ^ (int)$W6[$i];		
	}
	

	$key1 = '';
	$key1 .= $W4.$W5.$W6.$W7;
		
	array_push($allKeys, $key1);

	$arr2 = str_split($key1, 8);

	//////////////////////////////////////////89gfhfdkgjkfbcvnbmnjgadfkg//////////////////////



	for ($j=0; $j < 9; $j++) { 

		$firstFour = array(); 
		$mid1Four = array(); 
		$mid2Four = array(); 
		$lastFour = array(); 
		
		$i = 1;
		foreach ($arr2 as $val) {						
			if ($i <= 4) {
				array_push($firstFour, $val);	
			}		
			if ($i > 4 and $i <= 8) {
				array_push($mid1Four, $val);	
			}		
			if ($i > 8 and $i <= 12) {
				array_push($mid2Four, $val);	
			}		
			if ($i > 12) {
				array_push($lastFour, $val);	
			}		
			// echo "<b>".$i++."</b>.$val<br>";	
			$i++;
		}	

	
	$W1 = '';
	foreach ($mid1Four as $val) {		
		$W1 .= $val;
	}
	

	$W2 = '';
	foreach ($mid2Four as $val) {
		$W2 .= $val;
	}

	$W3new = '';
	foreach ($lastFour as $val) {
		$W3new .= $val;
	}

	$W3 = array_shift($lastFour);
	array_push($lastFour, $W3);


	// Pushing the first 8 bit of W3 at the end and shifting 24 bits to the most right of the word
	// foreach ($lastFour as $val) {
	// 	echo "<u>$val</u>&nbsp;&nbsp;&nbsp;";
	// }

	// Substitution of the aquired values with the values aquired from the SBOX
	foreach($lastFour as $value) {
		$current = bindec($value);
		$curVal =  (int)$SBOX[$current];
		$curBin = decbin($curVal);

		array_shift($lastFour);
		array_push($lastFour, $curBin);
	}


	foreach ($lastFour as $val) {		
		$len = strlen($val);				
		$lackOfZeros = 8 - $len;
		
		for ($i=0; $i < $lackOfZeros; $i++) { 
			$val = '0'.$val;
		}

		array_shift($lastFour);
		array_push($lastFour, $val);
			
	}

	//$RC = array(0x01, 0x02, 0x04, 0x08, 0x10, 0x20, 0x40, 0x80, 0x1b, 0x36);

	$RC = array('00000001', '00000010', '00000100', '00001000','00001010', '00010100', '01000000', '10000000', '00011011', '00110110');

	// $G1 = (int)$RC[$j+1] ^ (int)$lastFour[0];        ///////////////////////ghadfgyryhiuwehfkhjhhyasiuewfdkjg
	$G1 = '';

	for ($i=0; $i < 8; $i++) { 
		$G1 .= (int)$RC[$j+1][$i] ^ (int)$lastFour[0][$i];		
	}

	$lackOfZeros = 8 - strlen($G1);

	for ($i=0; $i < $lackOfZeros; $i++) { 
		$G1 = '0'.$G1;
	}

	array_shift($lastFour);
	array_unshift($lastFour, $G1);
	
	$G1 = '';
	foreach ($lastFour as $val) {
		$G1 .= $val;
	}

	$W0 = '';
	foreach ($firstFour as $val) {
		$W0 .= $val;		
	}

	$W4 = '';

	for ($i=0; $i < 32; $i++) { 
		$W4 .= (int)$G1[$i] ^ (int)$W0[$i];		
	}
	
	$W5 = '';
	
	for ($i=0; $i < 32; $i++) { 
		$W5 .= (int)$W1[$i] ^ (int)$W4[$i];		
	}
	
	$W6 = '';
	
	for ($i=0; $i < 32; $i++) { 
		$W6 .= (int)$W2[$i] ^ (int)$W5[$i];		
	}
	
	$W7 = '';
	
	for ($i=0; $i < 32; $i++) { 
		$W7 .= (int)$W3new[$i] ^ (int)$W6[$i];		
	}
	

	$key1 = '';
	$key1 .= $W4.$W5.$W6.$W7;
			
	array_push($allKeys, $key1);

	$arr2 = str_split($key1, 8);
	
	}
///////////////////////////////////////////////////// Encryption /////////////////////////////////////////////////
	if (isset($_POST['encr'])) {
		$arrBin = array();  
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

			header('location: index.php');

	}



		////////////////////////////////// Decryption //////////////////////////////////
		if (isset($_POST['decrypt'])) {


			$arr = array();			

			$cipher = $_POST['plain_text'];
			

			$stringToAscii = unpack("C*", hex2bin($cipher));

			echo "<pre>";
			print_r($stringToAscii);
			echo "<pre>";


			$arrBin = array();

			foreach ($stringToAscii as $value) {
				$bin = decbin($value);	
				$len = strlen($bin);				
				$lackOfZeros = 8 - $len;
				
				for ($i=0; $i < $lackOfZeros; $i++) { 
					$bin = '0'.$bin;
				}

				array_push($arrBin, $bin);	
			}

			echo $_SESSION['cipher'];

			echo "<pre>";
			print_r($arrBin);
			echo "</pre>";


			echo $_SESSION['cipher']."</br>";

			$convert = '';
			foreach ($arrBin as $value) {
				$convert .= $value;
			}

			$vals = $convert;
			

			$inter = '';
			for ($i=0; $i < 128; $i++) { 
				$inter .= (int)$allKeys[10][$i] ^ (int)$vals[$i];
			}


			$arr3 = array();

			$arr3 = str_split($inter, 8);


			$temp = $arr3[13];
		    $arr3[13] = $arr3[9];
		    $arr3[9]  = $arr3[5];
		    $arr3[5]  = $arr3[1];
		    $arr3[1] = $temp;
		    // row2
		    $temp = $arr3[14];
		    $arr3[14]  = $arr3[6];
		    $arr3[6] = $temp;

		    $temp = $arr3[10];
		    $arr3[10]  = $arr3[2];
		    $arr3[2] = $temp;
		    // row3
		    $temp = $arr3[3];
		    $arr3[3] = $arr3[7];
		    $arr3[7] = $arr3[11];
		    $arr3[11]  = $arr3[15];
		    $arr3[15]  = $temp;

		    echo "Inverse Shift:";
		    echo "<pre>";
		    print_r($arr3);
		    echo "</pre>";

		    foreach($arr3 as $value) {
				$current = bindec($value);
				$curVal =  (int)$INV_SBOX[$current];
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


			echo "Inverse Sub:";
			echo "<pre>";
			print_r($arr3);
			echo "</pre>";

			$vals = '';		

			foreach ($arr3 as $value) {
				$vals .= $value;
			}


			echo "<p>Key 9: ";
			echo $allKeys[9];
			echo "</p>";

			echo "<p>Subbyte: $vals</p>";

			$values = '';
			for ($i=0; $i < 128; $i++) { 
				$values .= (int)$allKeys[9][$i] ^ (int)$vals[$i];
			}

			echo "<p>XOR: ";
			echo $values;		
			echo "</p>";

			echo "<pre>sdfjkd";
			print_r(str_split($values, 8));
			echo "</pre>";

			$arr3 = array();
			$arr3 = str_split($values, 8);

			for ($j=8; $j >= 0; $j--) { 

				//// Transpose
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

				
				// //// inverse shift
				$temp = $arr3[13];
			    $arr3[13] = $arr3[9];
			    $arr3[9]  = $arr3[5];
			    $arr3[5]  = $arr3[1];
			    $arr3[1] = $temp;

			    
			    $temp = $arr3[14];
			    $arr3[14]  = $arr3[6];
			    $arr3[6] = $temp;


			    $temp = $arr3[10];
			    $arr3[10]  = $arr3[2];
			    $arr3[2] = $temp;

			    
			    $temp = $arr3[3];
			    $arr3[3] = $arr3[7];
			    $arr3[7] = $arr3[11];
			    $arr3[11]  = $arr3[15];
			    $arr3[15]  = $temp;


			 //    //// Inverse SubBytes

			    foreach($arr3 as $value) {
					$current = bindec($value);
					$curVal =  (int)$INV_SBOX[$current];
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

				$values = '';		

				foreach ($arr3 as $value) {
					$values .= $value;
				}					

				// echo "<pre>Inverse Sub";
				// print_r($arr3);						
				// /// Key XOR
				

				$vals = '';
				for ($i=0; $i < 128; $i++) { 
					$vals .= (int)$allKeys[$j][$i] ^ (int)$values[$i];
				}

				echo "<p>";
				echo $vals;
				echo "</p>";

				$arr3 = array();

				$arr3 = str_split($vals, 8);			
			}

			echo "<pre>";
			print_r($arr3);
			echo "</pre>";

			foreach ($arr3 as $value) {
				$binToDec = bindec($value);

				array_shift($arr3);
				array_push($arr3, $binToDec);
			}

			$decrypt = '';

			foreach ($arr3 as $value) {
				$decrypt .= chr($value);
			}					

			$_SESSION['decrr'] = $decrypt;
			$_SESSION['keyy'] = $_POST['c_key'];
			header('location: index.php');
				
		}		
?>
