<?php
	$html="";
		$html .="<tr>";
			$html .="<th width='400px'></th>";
			$html .="<th class='header_res_th'>Wood</th>";
			$html .="<th class='header_res_th'>Food</th>";
			$html .="<th class='header_res_th'>Coins</th>";
			$html .="<th class='header_res_th'>Stone</th>";
			$html .="<th class='header_res_th'>Iron</th>";
			$html .="<th class='header_res_th'>Workforce</th>";
			$html .="<th width='0px'></th>";
		$html .="</tr>";

		foreach($res as $r) {
			$html .="<tr>";
				$html .="<td width='400px'></td>";
				$html .="<td class='header_res'>".$r->wood."</td>";
				$html .="<td class='header_res'>".$r->food."</td>";
				$html .="<td class='header_res'>".$r->coins."</td>";
				$html .="<td class='header_res'>".$r->stone."</td>";
				$html .="<td class='header_res'>".$r->iron."</td>";
				$html .="<td class='header_res'>".$r->workforce."</td>";
				$html .="<th width='0px'></th>";
			$html .="</tr>";
		}	
	$html .="";
?>