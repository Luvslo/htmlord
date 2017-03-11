<?php
	$html="<table>";
		$html .="<tr>";
			$html .="<th>Wood</th>";
			$html .="<th>Food</th>";
			$html .="<th>Coins</th>";
			$html .="<th>Stone</th>";
			$html .="<th>Iron</th>";
			$html .="<th>Workforce</th>";
		$html .="</tr>";

		foreach($res as $r) {
			$html .="<tr>";
				$html .="<td><div align='center'>".$r->wood."</div></td>";
				$html .="<td><div align='center'>".$r->food."</div></td>";
				$html .="<td><div align='center'>".$r->coins."</div></td>";
				$html .="<td><div align='center'>".$r->stone."</div></td>";
				$html .="<td><div align='center'>".$r->iron."</div></td>";
				$html .="<td><div align='center'>".$r->workforce."</div></td>";
			$html .="</tr>";
		}	
	$html .="</table>";
?>