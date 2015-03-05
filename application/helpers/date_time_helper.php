<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Unix to "Human"
 *
 * Formats Unix timestamp to the following prototype: 2006-08-21 11:35 PM
 *
 * @access	public
 * @param	integer Unix timestamp
 * @param	bool	whether to show seconds
 * @param	string	format: us or euro
 * @return	string
 */
if ( ! function_exists('convert_to_human'))
{
	function convert_to_human($time = '', $show_time = FALSE, $seconds = FALSE, $fmt = 'us')
	{
		$r  = date('m', $time).'-'.date('d', $time).'-'.date('Y', $time).' ';
		
		if($show_time)
		{
			if ($fmt == 'us')
			{
				$r .= date('h', $time).':'.date('i', $time);
			}
			else
			{
				$r .= date('H', $time).':'.date('i', $time);
			}
	
			if ($seconds)
			{
				$r .= ':'.date('s', $time);
			}
	
			if ($fmt == 'us')
			{
				$r .= ' '.date('A', $time);
			}
		}

		return $r;
	}
}


// ------------------------------------------------------------------------

/* End of file date_time_helper.php */
/* Location: ./system/application/helpers/date_time_helper.php */