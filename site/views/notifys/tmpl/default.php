<?php
	echo "Notified."; 
	for($i = 0; i < sizeof($this->items); $i++)
		echo $this->items[$i]->email; 
	echo $this->weekNum; ?>
