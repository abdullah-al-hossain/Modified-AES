<?php

////////////////////////////////// Decryption //////////////////////////////////
		
		include 'operations.php';
		
		if (isset($_POST['decrypt'])) {


			$arr = array();
			$arr = str_split($_SESSION['cipher'], 8);

			

			echo '<div class="alert alert-success">
								    <strong>Cipher Text: </strong>';
			$cipher = '';
			foreach ($arr as $value) {
				$cipher .= bin2hex(chr(bindec($value)));					
				echo " ";												
			}
			echo "$cipher<br>";

			$stringToAscii = unpack("C*", hex2bin($cipher));
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

			echo "<pre>";
			print_r($arrBin);
			echo "</pre>";


			echo $_SESSION['cipher']."</br>";

			$convert = '';
			foreach ($arrBin as $value) {
				$convert .= $value;
			}

			$vals = $convert;

			echo "<h1 style='text-align:center; font-size: 35px;'>Decryption Stages</h1>";

			$inter = '';
			for ($i=0; $i < 128; $i++) { 
				$inter .= (int)$allKeys[10][$i] ^ (int)$vals[$i];
			}


			$arr3 = array();

			$arr3 = str_split($inter, 8);

			echo "XOR:";
			echo "<pre>";
		    print_r($arr3);
		    echo "</pre>";


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

			header('location: index.php?var='.$decrypt.'&key='.$_POST['c_key']);
				
		}		

?>