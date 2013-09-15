<?php

	// Written on March 3, 2004 (12 Esfand 1382)
	function get_search_navlist($results_total, $current_page, $results_per_page = 10, $page_list_range = 10) {
	
		if ($results_total <= 0)
			return FALSE;

		$pages_total = ceil($results_total / $results_per_page);	

		if ($current_page > $pages_total)
			return FALSE;

		// lower bound of navigationl links
		$low_page_num = $current_page - (int)($page_list_range / 2);

		// higher bound of navigationl links
		$high_page_num = $current_page + (int)($page_list_range / 2);

		if ($low_page_num <= 0) {
			$high_page_num = $high_page_num + abs($low_page_num);
			$low_page_num = 1;
		}

		if ($high_page_num > $pages_total) {
			$low_page_num = $low_page_num - ($high_page_num - $pages_total);
			$high_page_num = $pages_total;

			if ($low_page_num <= 0) {
				$low_page_num = 1;
			}

		}

		return range($low_page_num, $high_page_num);

	}
	
	function get_text_summary($text, $max_len=200) {
		if (strlen($text) <= $max_len) {
			return $text;
		}
		$text = substr($text, 0, $max_len);	
		$last_space_pos = strrpos($text, ' ');
		return substr($text, 0, $last_space_pos) . '...';
	}

	function get_highlighted_string($word, $full_str) {

		if (strlen(trim($word)) == 0) return $full_str;

		$word = explode(" ", $word);
		$word = implode("|", $word);

		return preg_replace_callback(
			sprintf("/(%s)/i", quotemeta($word)),
			create_function( 
				'$matches',
				'return "<span style=\"color: #f30\">${matches[0]}</span>";'
			),		
			$full_str
		);

	}