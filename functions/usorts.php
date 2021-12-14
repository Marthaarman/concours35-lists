<?php

function usort_by_priority($a, $b) {
	return $a['priority'] - $b['priority'];
}