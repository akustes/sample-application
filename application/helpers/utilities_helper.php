<?php 

/**
 * Utilities
 *
 * Misc. Functions, formats and conversions
 *
 * @access	public
 * @param	string
 * @return	string
 */	




/*
|--------------------------------------------------------------------------
| Files
|--------------------------------------------------------------------------
| File Functions for formating and conversions
*/


if ( ! function_exists('get_byte_size'))
{

	function get_byte_size($bytes) 
	{
	    $size = $bytes / 1024;
	    if($size < 1024)
	    {
	        $size = number_format($size, 2);
	        $size .= ' KB';
	    } 
	    else 
	    {
	        if($size / 1024 < 1024) 
	        {
	            $size = number_format($size / 1024, 2);
	            $size .= ' MB';
	        } 
	        elseif ($size / 1024 / 1024 < 1024)  
	        {
	            $size = number_format($size / 1024 / 1024, 2);
	            $size .= ' GB';
	        } 
	     }
	     
	    return $size;
	 } 
}


// ------------------------------------------------------------------------

/* End of file utilities_helper.php */
/* Location: ./system/application/helpers/utilities_helper.php */