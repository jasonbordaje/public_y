<?php
	header( "Content-Type: application/vnd.ms-excel" );
	header( "Content-disposition: attachment; filename=spreadsheet.xls" );
	
	// print your data here. note the following:
	// - cells/columns are separated by tabs ("\t")
	// - rows are separated by newlines ("\n")
	
	// for example:
	echo "<table>";
	echo "<tr>
	<td>dfsdf</td>
	<tdfdgdfg</td>
	</tr>";
	echo "</table>";
?>