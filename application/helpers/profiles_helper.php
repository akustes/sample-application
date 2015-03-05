<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Profile Attributes
 *
 * Displays Profiles Lists and Misc. Data
 */	
 
/**
 * Accounts
 *
 * Displays Accounts Lists and Misc. Data
 */
 	
/**
 * URI Segment Parser
 *
 * handles actions, id's and messages
 */
 	
if ( ! function_exists('uri_parser'))
{
	function uri_parser()
	{
		
		$CI =& get_instance();
		
		$segs = $CI->uri->segment_array();
		
		if(isset($segs))
		{
			foreach ($segs as $segment)
			{
			    if(is_numeric($segment))
			    {
			    	$id = $segment;
			    }
			    elseif($segment == 'view' 
			    	|| $segment == 'add' 
			    	|| $segment == 'edit' 
			    	|| $segment == 'delete' 
			    	|| $segment == 'deleted' 
			    	|| $segment == 'active' 
			    	|| $segment == 'not_active' 
			    	|| $segment == 'search_profile_name' 
			    	|| $segment == 'search_gender'
			    )
			    {
			    	$action = $segment;
			    }
			    elseif($segment == 'saved')
			    {
			    	$message = $segment;
			    }
			    else
			    {
			    	$id = '';
			    	$action = '';
			    	$message = '';
			    }
			}
						
			return array(
				'id' => $id,
				'action' => $action,
				'message' => $message
			);

		}
		else
		{
			return FALSE;
		}

	}
}
 

if ( ! function_exists('ages'))
{
	function ages()
	{
	
		return array( 
			
			'' => 'Choose Age',
			'18' => '18',
			'19' => '19',
			'20' => '20',
			'21' => '21',
			'22' => '22',
			'23' => '23',
			'24' => '24',
			'25' => '25',
			'26' => '26',
			'27' => '27',
			'28' => '28',
			'29' => '29',
			'30' => '30',
			'31' => '31',
			'32' => '32',
			'33' => '33',
			'34' => '34',
			'35' => '35',
			'36' => '36',
			'37' => '37',
			'38' => '38',
			'39' => '39',
			'40' => '40',
			'41' => '41',
			'42' => '42',
			'43' => '43',
			'44' => '44',
			'45' => '45',
			'46' => '46',
			'47' => '47',
			'48' => '48',
			'49' => '49',
			'50' => '50',
			'51' => '51',
			'52' => '52',
			'53' => '53',
			'54' => '54',
			'55' => '55',
			'56' => '56',
			'57' => '57',
			'58' => '58',
			'59' => '59',
			'60' => '60',
			'61' => '61',
			'62' => '62',
			'63' => '63',
			'64' => '64',
			'65' => '65',
			'66' => '66',
			'67' => '67',
			'68' => '68',
			'69' => '69',
			'70' => '70',
			'71' => '71',
			'72' => '72',
			'73' => '73',
			'74' => '74',
			'75' => '75',
			'76' => '76',
			'77' => '77',
			'78' => '78',
			'79' => '79',
			'80' => '80',
			'81' => '81',
			'82' => '82',
			'83' => '83',
			'84' => '84',
			'85' => '85',
			'86' => '86',
			'87' => '87',
			'88' => '88',
			'89' => '89',
			'90' => '90',
			'91' => '91',
			'92' => '92',
			'93' => '93',
			'94' => '94',
			'95' => '95',
			'96' => '96',
			'97' => '97',
			'98' => '98',
			'99' => '99',
			'100' => '100'
		);	

	}
}



if ( ! function_exists('heights'))
{
	function heights()
	{
	
		return array(
			
			'' => 'Choose Height',
			'31' => '3 ft. 1 in.',
			'32' => '3 ft. 2 in.',
			'33' => '3 ft. 3 in.',
			'34' => '3 ft. 4 in.',
			'35' => '3 ft. 5 in.',
			'36' => '3 ft. 6 in.',
			'37' => '3 ft. 7 in.',
			'38' => '3 ft. 8 in.',
			'39' => '3 ft. 9 in.',
			'310' => '3 ft. 10 in.',
			'311' => '3 ft. 11 in.',
			'40' => '4 ft. 0 in.',
			'41' => '4 ft. 1 in.',
			'42' => '4 ft. 2 in.',
			'43' => '4 ft. 3 in.',
			'44' => '4 ft. 4 in.',
			'45' => '4 ft. 5 in.',
			'46' => '4 ft. 6 in.',
			'47' => '4 ft. 7 in.',
			'48' => '4 ft. 8 in.',
			'49' => '4 ft. 9 in.',
			'410' => '4 ft. 10 in.',
			'411' => '4 ft. 11 in.',
			'50' => '5 ft. 0 in.',
			'51' => '5 ft. 1 in.',
			'52' => '5 ft. 2 in.',
			'53' => '5 ft. 3 in.',
			'54' => '5 ft. 4 in.',
			'55' => '5 ft. 5 in.',
			'56' => '5 ft. 6 in.',
			'57' => '5 ft. 7 in.',
			'58' => '5 ft. 8 in.',
			'59' => '5 ft. 9 in.',
			'510' => '5 ft. 10 in.',
			'511' => '5 ft. 11 in.',
			'60' => '6 ft. 0 in.',
			'61' => '6 ft. 1 in.',
			'62' => '6 ft. 2 in.',
			'63' => '6 ft. 3 in.',
			'64' => '6 ft. 4 in.',
			'65' => '6 ft. 5 in.',
			'66' => '6 ft. 6 in.',
			'67' => '6 ft. 7 in.',
			'68' => '6 ft. 8 in.',
			'69' => '6 ft. 9 in.',
			'610' => '6 ft. 10 in.',
			'611' => '6 ft. 11 in.',
			'70' => '7 ft. 0 in.',
			'71' => '7 ft. 1 in.',
			'72' => '7 ft. 2 in.',
			'73' => '7 ft. 3 in.',
			'74' => '7 ft. 4 in.',
			'75' => '7 ft. 5 in.',
			'76' => '7 ft. 6 in.',
			'77' => '7 ft. 7 in.',
			'78' => '7 ft. 8 in.',
			'79' => '7 ft. 9 in.',
			'710' => '7 ft. 10 in.',
			'711' => '7 ft. 11 in.'		
		);

	}
}


if ( ! function_exists('body_types'))
{
	function body_types()
	{
	
		return array( 
			
			'' => 'Choose Body Type',
			'Slim' => 'Slim',
			'Average' => 'Average',
			'Athletic' => 'Athletic',
			'Extra pounds' => 'Extra Pounds',
			'Large' => 'Large'
		);	

	}
}


if ( ! function_exists('eye_colors'))
{
	function eye_colors()
	{
	
		return array( 
			
			'' => 'Choose Eye Color',
			'Brown' => 'Brown',
			'Light Brown' => 'Light Brown',
			'Dark Brown' => 'Dark Brown',
			'Green' => 'Green',
			'Hazel' => 'Hazel',
			'Blue' => 'Blue'
		);	
				
	}
}


if ( ! function_exists('hair_colors'))
{
	function hair_colors()
	{
	
		return array( 
			
			'' => 'Choose Hair Color',
			'Brown' => 'Brown',
			'Light Brown' => 'Light Brown',
			'Dark Brown' => 'Dark Brown',
			'Blonde' => 'Blonde',
			'Dirty Blonde' => 'Dirty Blonde',
			'Black' => 'Black',
			'Multi Color' => 'Multi-Color'
		);	

	}
}


if ( ! function_exists('ethnicities'))
{
	function ethnicities()
	{
	
		return array( 
			
			'' => 'Choose Ethnicity',
			'White' => 'White',
			'Black' => 'Black',
			'Hispanic' => 'Hispanic',
			'Asian' => 'Asian',
			'Native American' => 'Native American',
			'Pacific Islander' => 'Pacific Islander',
			'Bi-Racial' => 'Bi-Racial',
			'Multi-Racial' => 'Multi-Racial'
		);	

	}
}

if ( ! function_exists('languages'))
{
	function languages() 
	{
	
		return array( 
			
			'' => 'Choose Language',
			'AA' => 'Afar',
			'AB' => 'Abkhazian',
			'AF' => 'Afrikaans',
			'AM' => 'Amharic',
			'AR' => 'Arabic',
			'AS' => 'Assamese',
			'AY' => 'Aymara',
			'AZ' => 'Azerbaijani',
			'BA' => 'Bashkir',
			'BE' => 'Byelorussian',
			'BG' => 'Bulgarian',
			'BH' => 'Bihari',
			'BI' => 'Bislama',
			'BN' => 'Bengali Bangla',
			'BO' => 'Tibetan',
			'BR' => 'Breton',
			'CA' => 'Catalan',
			'CO' => 'Corsican',
			'CS' => 'Czech',
			'CY' => 'Welsh',
			'DA' => 'Danish',
			'DE' => 'German',
			'DZ' => 'Bhutani',
			'EL' => 'Greek',
			'EN' => 'English American',
			'EO' => 'Esperanto',
			'ES' => 'Spanish',
			'ET' => 'Estonian',
			'EU' => 'Basque',
			'FA' => 'Persian',
			'FI' => 'Finnish',
			'FJ' => 'Fiji',
			'FO' => 'Faeroese',
			'FR' => 'French',
			'FY' => 'Frisian',
			'GA' => 'Irish',
			'GD' => 'Gaelic (Scots Gaelic)',
			'GL' => 'Galician',
			'GN' => 'Guarani',
			'GU' => 'Gujarati',
			'HA' => 'Hausa',
			'HI' => 'Hindi',
			'HR' => 'Croatian',
			'HU' => 'Hungarian',
			'HY' => 'Armenian',
			'IA' => 'Interlingua',
			'IE' => 'Interlingue',
			'IK' => 'Inupiak',
			'IN' => 'Indonesian',
			'IS' => 'Icelandic',
			'IT' => 'Italian',
			'IW' => 'Hebrew',
			'JA' => 'Japanese',
			'JI' => 'Yiddish',
			'JW' => 'Javanese',
			'KA' => 'Georgian',
			'KK' => 'Kazakh',
			'KL' => 'Greenlandic',
			'KM' => 'Cambodian',
			'KN' => 'Kannada',
			'KO' => 'Korean',
			'KS' => 'Kashmiri',
			'KU' => 'Kurdish',
			'KY' => 'Kirghiz',
			'LA' => 'Latin',
			'LN' => 'Lingala',
			'LO' => 'Laothian',
			'LT' => 'Lithuanian',
			'LV' => 'Latvian Lettish',
			'MG' => 'Malagasy',
			'MI' => 'Maori',
			'MK' => 'Macedonian',
			'ML' => 'Malayalam',
			'MN' => 'Mongolian',
			'MO' => 'Moldavian',
			'MR' => 'Marathi',
			'MS' => 'Malay',
			'MT' => 'Maltese',
			'MY' => 'Burmese',
			'NA' => 'Nauru',
			'NE' => 'Nepali',
			'NL' => 'Dutch',
			'NO' => 'Norwegian',
			'OC' => 'Occitan',
			'OM' => 'Oromo Afan',
			'OR' => 'Oriya',
			'PA' => 'Punjabi',
			'PL' => 'Polish',
			'PS' => 'Pashto Pushto',
			'PT' => 'Portuguese',
			'QU' => 'Quechua',
			'RM' => 'Rhaeto-Romance',
			'RN' => 'Kirundi',
			'RO' => 'Romanian',
			'RU' => 'Russian',
			'RW' => 'Kinyarwanda',
			'SA' => 'Sanskrit',
			'SD' => 'Sindhi',
			'SG' => 'Sangro',
			'SH' => 'Serbo-Croatian',
			'SI' => 'Singhalese',
			'SK' => 'Slovak',
			'SL' => 'Slovenian',
			'SM' => 'Samoan',
			'SN' => 'Shona',
			'SO' => 'Somali',
			'SQ' => 'Albanian',
			'SR' => 'Serbian',
			'SS' => 'Siswati',
			'ST' => 'Sesotho',
			'SU' => 'Sudanese',
			'SV' => 'Swedish',
			'SW' => 'Swahili',
			'TA' => 'Tamil',
			'TE' => 'Tegulu',
			'TG' => 'Tajik',
			'TH' => 'Thai',
			'TI' => 'Tigrinya',
			'TK' => 'Turkmen',
			'TL' => 'Tagalog',
			'TN' => 'Setswana',
			'TO' => 'Tonga',
			'TR' => 'Turkish',
			'TS' => 'Tsonga',
			'TT' => 'Tatar',
			'TW' => 'Twi',
			'UK' => 'Ukrainian',
			'UR' => 'Urdu',
			'UZ' => 'Uzbek',
			'VI' => 'Vietnamese',
			'VO' => 'Volapuk',
			'WO' => 'Wolof',
			'XH' => 'Xhosa',
			'YO' => 'Yoruba',
			'ZH' => 'Chinese',
			'ZU' => 'Zulu'		
		);	

	}
}


if ( ! function_exists('education'))
{
	function education()
	{
	
		return array( 
			
			'' => 'Choose Education',
			'None' => 'None',
			'GED' => 'GED',
			'High School' => 'High School',
			'Some College' => 'Some College',
			'College' => 'College',
			'2 year degree' => '2 Year Degree',
			'4 year degree' => '4 Year Degree',
			'Masters' => 'Masters',
			'PHD Non-Medical' => 'P.H.D Non-Medical',
			'PHD Medical' => 'P.H.D. Medical'
		);	

	}
}


if ( ! function_exists('marital_status'))
{
	function marital_status()
	{
	
		return array( 
			
			'' => 'Choose Marital Status',
			'Single' => 'Single',
			'Married' => 'Married',
			'Separated' => 'Separated',
			'Divorced' => 'Divorced'
		);	
				
	}
}


if ( ! function_exists('habits'))
{
	function habits()
	{
	
		return array( 
			
			'' => 'Choose Habits',
			'Not a Drinker' => 'Not a Drinker',
			'Not a Smoker' => 'No a Smoker',
			'Drinks Socially' => 'Drinks Socially',
			'Drinks Heavily' => 'Drinks Heavily',
			'Smokes Socially' => 'Smokes Socially',
			'Smokes Heavily' => 'Smokes Heavily'
		);	

	}
}


if ( ! function_exists('seeking'))
{
	function seeking()
	{
	
		return array( 
			
			'' => 'I am a',
			'Daddy' => 'Daddy',
			'Baby' => 'Baby'
		);	
		
	}
}




// ------------------------------------------------------------------------

/* End of file profiles_helper.php */
/* Location: ./system/application/helpers/profiles_helper.php */