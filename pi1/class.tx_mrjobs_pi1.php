<?php
/***************************************************************
*  Copyright notice
*
*  (c) 2007 Michael Rolli <michael@rollis.ch>
*  All rights reserved
*
*  This script is part of the TYPO3 project. The TYPO3 project is
*  free software; you can redistribute it and/or modify
*  it under the terms of the GNU General Public License as published by
*  the Free Software Foundation; either version 2 of the License, or
*  (at your option) any later version.
*
*  The GNU General Public License can be found at
*  http://www.gnu.org/copyleft/gpl.html.
*
*  This script is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of'hidden
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*  GNU General Public License for more details.
*
*  This copyright notice MUST APPEAR in all copies of the script!
***************************************************************/

require_once(PATH_tslib.'class.tslib_pibase.php');


/**
 * Plugin 'Job offers' for the 'mr_jobs' extension.
 *
 * @author	Michael Rolli <michael@rollis.ch>
 * @package	TYPO3
 * @subpackage	tx_mrjobs
 */
class tx_mrjobs_pi1 extends tslib_pibase {
	var $prefixId      = 'tx_mrjobs_pi1';		// Same as class name
	var $scriptRelPath = 'pi1/class.tx_mrjobs_pi1.php';	// Path to this script relative to the extension dir.
	var $extKey        = 'mr_jobs';	// The extension key.
	var $pi_checkCHash = true;

	var $config = array();
	var $pageArray = array(); // Is initialized with an array of the pages in the pid-list

	/**
	 * The main method of the PlugIn
	 *
	 * @param	string		$content: The PlugIn content
	 * @param	array		$conf: The PlugIn configuration
	 * @return	The content that is displayed on the website
	 */
	function main($content,$conf)	{

	    $this->local_cObj = t3lib_div::makeInstance('tslib_cObj'); // Local cObj.
	    $this->pi_USER_INT_obj=1;	// Configuring so caching is not expected. This value means that no cHash params are ever set. We do this, because it's a USER_INT object!
        $this->init($conf);

        // get codes and decide which function is used to process the content
		$codes = t3lib_div::trimExplode(',', $this->config['code'] ? $this->config['code'] : 'NONE', 1);
		if (!count($codes)) { // no code at all
			$codes = array('NONE');
			$noCode = true;
		}

		foreach($codes as $code) {
		    $code = $this->theCode = (string)strtoupper(trim($code));
		    switch($code) {
		        case 'JOBOFFER_FORM':
		            if(isset($_POST['submitButton'])) {
		                $content .= $this->addJobOffer();
		            } else {
		                $content .= $this->displayJobOfferForm();
		            }
		            break;
		        case 'JOBOFFER_LIST':
		            $content .= $this->displayJobOfferList();
		            break;
		        case 'JOBSEARCH_FORM':
		            if(isset($_POST['submitButton'])) {
		                $content .= $this->addJobSearch();
		            } else {
		                $content .= $this->displayJobSearchForm();
		            }
		            break;
		        case 'JOBSEARCH_LIST':
		            $content .= $this->displayJobSearchList();
		            break;
		        default:
		            $content .= $this->pi_getLL('no_view_selected');
		    }
		}

		/*$content='
			<strong>This is a few paragraphs:</strong><br />
			<p>This is line 1</p>
			<p>This is line 2</p>

			<h3>This is a form:</h3>
			<form action="'.$this->pi_getPageLink($GLOBALS['TSFE']->id).'" method="POST">
				<input type="hidden" name="no_cache" value="1">
				<input type="text" name="'.$this->prefixId.'[input_field]" value="'.htmlspecialchars($this->piVars['input_field']).'">
				<input type="submit" name="'.$this->prefixId.'[submit_button]" value="'.htmlspecialchars($this->pi_getLL('submit_button_label')).'">
			</form>
			<br />
			<p>You can click here to '.$this->pi_linkToPage('get to this page again',$GLOBALS['TSFE']->id).'</p>
		';*/

		return $this->pi_wrapInBaseClass($content);
	}

	private function init($conf) {
	    $this->conf = $conf;
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
		$this->pi_initPIflexForm(); // Init FlexForm configuration for plugin

		// "CODE" decides what is rendered: codes can be set by TS or FF with priority on FF
		$code = $this->pi_getFFvalue($this->cObj->data['pi_flexform'], 'what_to_display', 'sDEF');
		$this->config['code'] = $code ? $code : $this->cObj->stdWrap($this->conf['code'], $this->conf['code.']);
	}

	private function displayJobOfferForm($data = array()) {
	    $code = '<p>' . $this->pi_getLL('joboffer_formguide') . '</p>';
	    if(count($data) > 0) {
	        $code .= '<p class="required">' . $this->pi_getLL('form_error');
	    }
	    $code.= '<p>
	                <form  action="'.$this->pi_getPageLink($GLOBALS['TSFE']->id).'" method="post" enctype="multipart/form-data">
	                <fieldset id="tx_mrjobs-fieldset">
	                <legend>' . $this->pi_getLL('facts_about_job') . '</legend>
	                <span class="formfield">
	                    <label><span class="required">* </span>' . $this->pi_getLL('zip') . '</label><input type="text" name="zip" size="7" value="';
	                    if(isset($data['zip'])) {
	                        $code .= $data['zip'];
	                    }
	                    $code .= '" /><label><span class="required">* </span>' . $this->pi_getLL('city') . '</label><input type="text" name="city" size="22" value="';
	                    if(isset($data['city'])) {
	                        $code .= $data['city'];
	                    }
	                    $code .= '" /></span>
	                <span class="formfield">
	                    <label><span class="required">* </span>' . $this->pi_getLL('workaddress') . '</label><input type="text" name="workaddress" size="31" value="';
	                    if(isset($data['workaddress'])) {
	                        $code .= $data['workaddress'];
	                    }
	                    $code .= '" />
	                </span>
	                <label><span class="required">* </span>' . $this->pi_getLL('commune') . '</label><input type="text" name="commune" size="31" value="';
	                if(isset($data['commune'])) {
	                    $code .= $data['commune'];
	                }
	                $code .= '" /><label><span class="required">* </span>' . $this->pi_getLL('canton') . '</label><input type="text" name="canton" size="31" value="';
	                if(isset($data['canton'])) {
	                    $code .= $data['canton'];
	                }
	                $code .= '" /><label><span class="required">* </span>' . $this->pi_getLL('employer') . '</label><input type="text" name="employer" size="31" value="';
	                if(isset($data['employer'])) {
	                        $code .= $data['employer'];
	                }
	                $code .= '" /><label><span class="required">* </span>' . $this->pi_getLL('jobtype') . '</label>
     				<select name="jobtype" size="1">
 					    <option selected="selected" value="0">' . $this->pi_getLL('select_option') . '</option>';
	                for($i=1;$i<4;$i++) {
	                    $code .= '<option value="' . $i . '"';
	                    if(isset($data['jobtype']) && $data['jobtype'] == $i) {
						    $code .= ' selected="selected"';
						}
						$code .= '>' . $this->pi_getLL('jobtype.' . $i) . '</option>';
	                }
	                $code .= '</select><select name="position" size="1">
					   <option selected="selected" value="0">' . $this->pi_getLL('select_option') . '</option>';
	                for($i=1;$i<3;$i++) {
	                    $code .= '<option value="' . $i . '"';
	                    if(isset($data['position']) && $data['position'] == $i) {
						    $code .= ' selected="selected"';
						}
						$code .= '>' . $this->pi_getLL('positiontype.' . $i) . '</option>';
	                }
				    $code .= '</select><label>' . $this->pi_getLL('description') . '</label><textarea name="description" rows="10" cols="30"></textarea><label><span class="required">* </span>' . $this->pi_getLL('jobstart') . '</label><input type="text" name="jobstart" size="31" value="';
	                if(isset($data['jobstart'])) {
	                    $code .= $data['jobstart'];
	                }
	                $code .= '" /><label>' . $this->pi_getLL('duration') . '</label><select name="number" size="1">
						<option selected value="0">' . $this->pi_getLL('select_option') . '</option>';
	                for($i=1;$i<32;$i++) {
	                    $code .= '<option value="' . $i . '"';
	                    if(isset($data['number']) && $data['number'] == $i) {
	                        $code .= ' selected="selected"';
	                    }
	                    $code .= '>' . $i . '</option>';
	                }
	                $code .= '</select><select name="timetype" size="1">
						<option selected value="0">' . $this->pi_getLL('select_option') . '</option>';
	                for($i=1;$i<5;$i++) {
	                    $code .= '<option value="' . $i . '"';
	                    if(isset($data['timetype']) && $data['timetype'] == $i) {
	                        $code .= ' selected="selected"';
	                    }
	                    $code .= '>' . $this->pi_getLL('timetype.'.$i) . '</option>';
	                }
	                $code .= '</select><label><span class="required">* </span>' . $this->pi_getLL('pensum') . '</label><input type="text" name="pensum_percentage" size="6" value="';
	                if(isset($data['pensum_percentage'])) {
	                    $code .= $data['pensum_percentage'];
	                }
	                $code .= '" />%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="pensum_hours" size="5" value="';
	                if(isset($data['pensum_hours'])) {
	                    $code .= $data['pensum_hours'];
	                }
	                $code .= '" />h / ' . $this->pi_getLL('timetype.2') . '<label><span class="required">* </span>' . $this->pi_getLL('term_application') . '</label><input type="text" name="term_application" size="31" value="';
	                if(isset($data['term_application'])) {
	                   $code .= $data['term_application'];
	                }
	                $code .= '" /></fieldset><fieldset><legend>' . $this->pi_getLL('contact_person') . '</legend>
                        <label><span class="required">* </span>' . $this->pi_getLL('name') . '</label><input type="text" name="contact_name" size="31" value="';
                        if(isset($data['contact_name'])) {
	                        $code .= $data['contact_name'];
	                    }
	                    $code .= '" /><label><span class="required">* </span>' . $this->pi_getLL('firstname') . '</label><input type="text" name="contact_firstname" size="31" value="';
	                    if(isset($data['contact_firstname'])) {
	                        $code .= $data['contact_firstname'];
	                    }
	                    $code .= '" /><label><span class="required">* </span>' . $this->pi_getLL('function') . '</label><input type="text" name="contact_function" size="31" value="';
	                    if(isset($data['contact_function'])) {
	                        $code .= $data['contact_function'];
	                    }
	                    $code .= '" /><label><span class="required">* </span>' . $this->pi_getLL('street') . '</label><input type="text" name="contact_street" size="31" value="';
	                    if(isset($data['contact_street'])) {
	                        $code .= $data['contact_street'];
	                    }
	                    $code .= '" /><label><span class="required">* </span>' . $this->pi_getLL('zip') . '</label><input type="text" name="contact_zip" size="31" value="';
	                    if(isset($data['contact_zip'])) {
	                        $code .= $data['contact_zip'];
	                    }
	                    $code .= '" /><label><span class="required">* </span>' . $this->pi_getLL('city') . '</label><input type="text" name="contact_city" size="31" value="';
	                    if(isset($data['contact_city'])) {
	                        $code .= $data['contact_city'];
	                    }
	                    $code .= '" /><label><span class="required">* </span>' . $this->pi_getLL('phone') . '</label><input type="text" name="contact_phone" size="31" value="';
	                    if(isset($data['contact_phone'])) {
	                        $code .= $data['contact_phone'];
	                    }
	                    $code .= '" /><label><span class="required">* </span>' . $this->pi_getLL('email') . '</label><input type="text" name="contact_email" size="31" value="';
	                    if(isset($data['contact_email'])) {
	                        $code .= $data['contact_email'];
	                    }
	                    $code .= '" /></fieldset>
                    <p><input type="submit" name="submitButton" value="' . $this->pi_getLL('submit_button') . '" /></p>
    			</form></p>';
	    return $code;
	}

	private function displayJobOfferList() {
	    global $TYPO3_DB;
	    $content = '';
	    $result = $TYPO3_DB->exec_SELECTquery('*', 'tx_mrjobs_offers','1=1 ' . $this->cObj->enableFields('tx_mrjobs_offers'), 'crdate DESC');

	    while($row = $TYPO3_DB->sql_fetch_assoc($result)) {
	        $content .= '<div class="job">';
	        $content .= '<p><b>' . $this->pi_getLL('city') . ':</b> ' . $row['zip'] . ' ' . $row['city'] . '</p>';
	        $content .= '<p><b>' . $this->pi_getLL('employer') . ':</b><br />' . $row['employer'] . '<br />' . $this->pi_getLL('workaddress') . ': ' . $row['workaddress'] . '<br />' . $this->pi_getLL('commune') . ': ' . $row['commune'] . '<br />' . $this->pi_getLL('canton') . ': ' . $row['canton'] . '</p>';
	        $content .= '<p><b>' . $this->pi_getLL('pensum') . ':</b><br />';
	        $content .= $row['pensum_percentage'] . ' ' . $this->pi_getLL('percent') . '<br />' . $row['pensum_hours'] . ' h/' . $this->pi_getLL('week') . '</p>';
	        $content .= '<p><b>' . $this->pi_getLL('jobstart') . ':</b><br />' . $row['jobstart'] . '</p>';
	        $content .= '<p><b>' . $this->pi_getLL('jobtype') . ':</b><br />' . $this->pi_getLL('jobtype.' . $row['jobtype']);
	        $content .= ($row['number'] > 0) ? '<br />' . $row['number'] . ' ' . $this->pi_getLL('timetype.' . $row['timetype']) : '';
		$content .= ($row['position'] > 0) ? '<br />' . $this->pi_getLL('positiontype.' . $row['position']) : '';
	        $content .= '</p>';
		$content .= (!empty($row['description'])) ? '<p><b>' . $this->pi_getLL('description') . ':</b><br />' . nl2br($row['description']) . '</p>' : '';
	        $content .= '<p><b>' . $this->pi_getLL('contact_person') . ':</b><br />' . $row['contact_firstname'] . ' ' . $row['contact_name'] . '<br />' . $row['contact_function'] . '<br />';
	        $content .= $row['contact_street'] . '<br />' . $row['contact_zip'] . ' ' . $row['contact_city'];
	        $content .= (!empty($row['contact_email'])) ? '<br />' . $this->cObj->mailto_makelinks('mailto:' . $row['contact_email'],'') : '';
	        $content .= (!empty($row['contact_phone'])) ? '<br />' . $row['contact_phone'] : '';
	        $content .= '</p>';
	        $content .= '<p><b>' . $this->pi_getLL('term_application') . ':</b> ' . $row['term_application'] . '</p>';
	        $content .= '<p>' . $this->pi_getLL('crdate') . ' ' . date('d.m.Y', $row['crdate']) . '</p>';
	        $content .= '</div>';
	    }
	    return $content;
	}

	private function displayJobSearchForm($data = array()) {
	    $code .= '<p>' . $this->pi_getLL('jobsearch_formguide') . '</p>';
	    if(count($data) > 0) {
	        $code .= '<p class="required">' . $this->pi_getLL('form_error') . '</p>';
	    }
	    $code .= '<p>
	                <form  action="'.$this->pi_getPageLink($GLOBALS['TSFE']->id).'" method="post" enctype="multipart/form-data">
	                <fieldset>
                        <legend>' . $this->pi_getLL('personal_details') . '</legend>
                        <label><span class="required">* </span>' . $this->pi_getLL('name') . '</label><input type="text" name="name" size="31" value="';
	                    if(isset($data['name'])) {
	                        $code .= $data['name'];
	                    }
	                    $code .= '" /><label><span class="required">* </span>' . $this->pi_getLL('firstname') . '</label><input type="text" name="firstname" size="31" value="';
	                    if(isset($data['firstname'])) {
	                        $code .= $data['firstname'];
	                    }
	                    $code .= '" /><label><span class="required">* </span>' . $this->pi_getLL('street') . '</label><input type="text" name="street" size="31" value="';
	                    if(isset($data['street'])) {
	                        $code .= $data['street'];
	                    }
	                    $code .= '" /><label><span class="required">* </span>' . $this->pi_getLL('zip') . '</label><input type="text" name="zip" size="7" value="';
	                    if(isset($data['zip'])) {
	                        $code .= $data['zip'];
	                    }
	                    $code .= '" /><label><span class="required">* </span>' . $this->pi_getLL('city') . '</label><input type="text" name="city" size="31" value="';
	                    if(isset($data['city'])) {
	                        $code .= $data['city'];
	                    }
	                    $code .= '" /><label><span class="required">* </span>' . $this->pi_getLL('phone') . '</label><input type="text" name="phone" size="31" value="';
	                    if(isset($data['phone'])) {
	                        $code .= $data['phone'];
	                    }
	                    $code .= '" /><label><span class="required">* </span>' . $this->pi_getLL('email') . '</label><input type="text" name="email" size="31" value="';
	                    if(isset($data['email'])) {
	                        $code .= $data['email'];
	                    }
	                    $code .= '" /></fieldset><fieldset>
	                <legend>' . $this->pi_getLL('facts_about_searched_job') . '</legend>
	                <span class="formfield">
	                    <label>' . $this->pi_getLL('region') . '</label><input type="text" name="region" size="31" value="';
	                    if(isset($data['region'])) {
	                        $code .= $data['region'];
	                    }
	                    $code .= '" /><label>' . $this->pi_getLL('workfield') . '</label><input type="text" name="workfield" size="31" value="';
	                    if(isset($data['workfield'])) {
	                        $code .= $data['workfield'];
	                    }
	                    $code .= '" /></span><label><span class="required">* </span>' . $this->pi_getLL('jobtype') . '</label>
     				<select name="jobtype" size="1">
 					    <option selected="selected" value="0">' . $this->pi_getLL('select_option') . '</option>
						<option value="1"';
						if(isset($data['jobtype']) && $data['jobtype'] == 1) {
						  $code .= ' selected="selected"';
						}
						$code .= '>' . $this->pi_getLL('jobtype.1') . '</option>';
						$code .= '<option value="2"';
						if(isset($data['jobtype']) && $data['jobtype'] == 2) {
						  $code .= ' selected="selected"';
						}
						$code .= '>' . $this->pi_getLL('jobtype.2') . '</option>';
						$code .= '<option value="3"';
						if(isset($data['jobtype']) && $data['jobtype'] == 3) {
						  $code .= ' selected="selected"';
						}
						$code .= '>' . $this->pi_getLL('jobtype.3') . '</option>';
					$code .= '</select>
					<label><span class="required">* </span>' . $this->pi_getLL('jobstart') . '</label><input type="text" name="jobstart" size="31" value="';
					if(isset($data['jobstart'])) {
	                        $code .= $data['jobstart'];
	                }
	                $code .= '" /><label>' . $this->pi_getLL('duration') . '</label>
     				<select name="number" size="1"><option value="0"';
	                $code .= '>' . $this->pi_getLL('select_option') . '</option>';
        	        for($i=1;$i<32;$i++) {
        	            $code .= '<option value="' . $i . '"';
        	            if(isset($data['jobtype']) && $data['jobtype'] == $i) {
        	                $code .= ' selected="selected"';
        	            }
        	            $code .=  '>' . $i . '</option>';
        	        }
	                $code .= '</select><select name="timetype" size="1"><option value="0">' . $this->pi_getLL('select_option') . '</option>';
	                for($i=1;$i<4;$i++) {
	                    $code .= '<option value="' . $i . '"';
	                    if(isset($data['timetype']) && $data['timetype'] == $i) {
        	                $code .= ' selected="selected"';
        	            }
        	            $code .=  '>' . $this->pi_getLL('timetype.' . $i) . '</option>';
	                }
	                $code .= '</select><label><span class="required">* </span>' . $this->pi_getLL('pensum') . '</label><input type="text" name="pensum_percentage" size="6" value="';
	                if(isset($data['pensum_percentage'])) {
	                    $code .= $data['pensum_percentage'];
	                }
	                $code .= '" />%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="pensum_hours" size="5" value="';
	                if(isset($data['pensum_hours'])) {
	                    $code .= $data['pensum_hours'];
	                }
	                $code .= '" />h / ' . $this->pi_getLL('timetype.2') . '
                    </fieldset>
                    <p><input type="submit" name="submitButton" value="' . $this->pi_getLL('submit_button') . '" /></p>
    			</form></p>';
	    return $code;
	}

	private function displayJobSearchList() {
	    global $TYPO3_DB;
	    $content = '';
	    $result = $TYPO3_DB->exec_SELECTquery('*', 'tx_mrjobs_searches','1=1 ' . $this->cObj->enableFields('tx_mrjobs_searches'), 'crdate DESC');

	    while($row = $TYPO3_DB->sql_fetch_assoc($result)) {
	        $content .= '<div class="job">';
	        $content .= '<p><b>' . $this->pi_getLL('name') . ':</b> ' . $row['firstname'] . ' ' . $row['name'] . '<br />';
	        $content .= '<b>' . $this->pi_getLL('street') . ':</b> ' . $row['street'] . '<br />';
	        $content .= '<b>' . $this->pi_getLL('city') . ':</b> ' . $row['zip'] . ' ' . $row['city'] . '<br />';
	        if(!empty($row['phone'])) {
	           $content .= '<b>' . $this->pi_getLL('phone') . ':</b> ' . $row['phone'] . '<br />';
	        }
	        if(!empty($row['email'])) {
	           $content .= '<b>' . $this->pi_getLL('email') . ':</b> ' . $row['email'] . '</p>';
	        }
	        if(!empty($row['region']) || !empty($row['workfield'])) {
	            $content .= '<p>';
    	        if(!empty($row['region'])) {
    	           $content .= '<b>' . $this->pi_getLL('region') . ':</b> ' . $row['region'] . '<br />';
    	        }
    	        if(!empty($row['workfield'])) {
    	           $content .= '<b>' . $this->pi_getLL('workfield') . ':</b> ' . $row['workfield'];
    	        }
    	        $content .= '</p>';
	        }
	        $content .= '<p><b>' . $this->pi_getLL('pensum') . ':</b><br />';
	        if(!empty($row['pensum_percentage'])) {
	            $content .= $row['pensum_percentage'] . ' ' . $this->pi_getLL('percent');
	        }
	        if(!empty($row['pensum_percentage']) && !empty($row['pensum_hours'])) { $content .= ' / '; }
	        if(!empty($row['pensum_hours'])) {
	            $content .= $row['pensum_hours'] . ' h/' . $this->pi_getLL('week');
	        }
	        echo '</p>';
	        $content .= '<p><b>' . $this->pi_getLL('jobstart') . ':</b> ' . $row['jobstart'];
	        $content .= ($row['number'] != 0) ? '<br />' . $row['number'] . ' ' . $this->pi_getLL('timetype.' . $row['timetype']) : '';
	        $content .= '</p>';
	        $content .= '<p>' . $this->pi_getLL('crdate') . ' ' . date('d.m.Y', $row['crdate']) . '</p>';
	        $content .= '</div>';
	    }
	    return $content;
	}

	private function addJobOffer() {
	    global $TYPO3_DB;

	    $row = array();
	    $row['pid'] = $this->conf['pid_storage'];
	    $row['deleted'] = 0;
	    $row['hidden'] = 1;
	    $row['starttime'] = 0;
	    $row['endtime'] = $this->_mkTimeStamp(t3lib_div::_POST('term_application'));
	    $row['zip'] = t3lib_div::_POST('zip');
	    $row['city'] = t3lib_div::_POST('city');
	    $row['employer'] = t3lib_div::_POST('employer');
	    $row['workaddress'] = t3lib_div::_POST('workaddress');
	    $row['commune'] = t3lib_div::_POST('commune');
	    $row['canton'] = t3lib_div::_POST('canton');
	    $row['jobtype'] = t3lib_div::_POST('jobtype');
	    $row['position'] = t3lib_div::_POST('position');
	    $row['description'] = t3lib_div::_POST('description');
	    $row['jobstart'] = t3lib_div::_POST('jobstart');
	    $row['number'] = t3lib_div::_POST('number');
	    $row['timetype'] = t3lib_div::_POST('timetype');
	    $row['pensum_percentage'] = t3lib_div::_POST('pensum_percentage');
	    $row['pensum_hours'] = t3lib_div::_POST('pensum_hours');
	    $row['term_application'] = t3lib_div::_POST('term_application');
	    $row['contact_name'] = t3lib_div::_POST('contact_name');
	    $row['contact_firstname'] = t3lib_div::_POST('contact_firstname');
	    $row['contact_street'] = t3lib_div::_POST('contact_street');
	    $row['contact_function'] = t3lib_div::_POST('contact_function');
	    $row['contact_zip'] = t3lib_div::_POST('contact_zip');
	    $row['contact_city'] = t3lib_div::_POST('contact_city');
	    $row['contact_email'] = t3lib_div::_POST('contact_email');
	    $row['contact_phone'] = t3lib_div::_POST('contact_phone');


	    if(empty($row['zip']) || empty($row['city']) || empty($row['employer']) || empty($row['commune']) || empty($row['canton']) ||
	       empty($row['workaddress']) || $row['jobtype'] == 0 || $row['position'] == 0 || empty($row['jobstart']) ||
	       (empty($row['pensum_percentage']) && empty($row['pensum_hours'])) || empty($row['term_application']) ||
	       empty($row['contact_name']) || empty($row['contact_firstname']) || empty($row['contact_function']) ||  empty($row['contact_street']) || empty($row['zip']) ||
	       empty($row['contact_city']) || empty($row['contact_email']) || empty($row['contact_phone']) ) {
	        return $this->displayJobOfferForm($row);
	    }

	    $newFieldList = 'deleted,hidden,starttime,endtime,zip,city,employer,workaddress,commune,canton,jobtype,position,description,jobstart,number,timetype,pensum_percentage,pensum_hours,term_application,contact_name,contact_firstname,contact_phone,contact_email,contact_street,contact_zip,contact_city,contact_function';
	    $this->cObj->DBgetInsert('tx_mrjobs_offers', $this->conf['pid_storage'], $row, $newFieldList, TRUE);
        $newId = $TYPO3_DB->sql_insert_id();
        $data = array(
                    'Neue Datensatz-ID:' => $newId,
                    'Arbeitgeber' => $row['employer'],
                    'Adresse' => $row['workaddress'],
                    'PLZ/Ort' => $row['zip'] . ' ' . $row['city'],
                    'Kontaktperson' => $row['contact_firstname'] . ' ' . $row['contact_name'],
                     );
        $this->_createNotifyEmail($data, "Neues Stellenangebot eingegangen");
	    return '<p>'. $this->pi_getLL('joboffers_thanks') . '<br />' . $this->pi_linkToPage($this->pi_getLL('redirect_to_offer_list'),$this->conf['pid_offer_list']) . '</p>';
	}

	private function addJobSearch() {
	    global $TYPO3_DB;

	    $row = array();
	    $row['pid'] = $this->conf['pid_storage'];
	    $row['deleted'] = 0;
	    $row['hidden'] = 1;
	    $row['starttime'] = 0;
	    $row['endtime'] = time();
	    $row['name'] = trim(t3lib_div::_POST('name'));
	    $row['firstname'] = trim(t3lib_div::_POST('firstname'));
	    $row['street'] = t3lib_div::_POST('street');
	    $row['zip'] = t3lib_div::_POST('zip');
	    $row['city'] = t3lib_div::_POST('city');
	    $row['email'] = t3lib_div::_POST('email');
	    $row['phone'] = t3lib_div::_POST('phone');
	    $row['region'] = t3lib_div::_POST('region');
	    $row['workfield'] = t3lib_div::_POST('workfield');
	    $row['jobtype'] = t3lib_div::_POST('jobtype');
	    $row['jobstart'] = t3lib_div::_POST('jobstart');
	    $row['number'] = t3lib_div::_POST('number');
	    $row['timetype'] = t3lib_div::_POST('timetype');
	    $row['pensum_percentage'] = t3lib_div::_POST('pensum_percentage');
	    $row['pensum_hours'] = t3lib_div::_POST('pensum_hours');

	    if(empty($row['name']) || empty($row['firstname']) || empty($row['street']) || empty($row['zip']) || empty($row['city']) ||
	       empty($row['phone']) || empty($row['email']) || $row['jobtype'] == 0 || empty($row['jobstart']) || (empty($row['pensum_percentage']) && empty($row['pensum_hours'])) ) {
	        return $this->displayJobSearchForm($row);
	    }
	    $newFieldList = 'deleted,hidden,starttime,endtime,name,firstname,street,zip,city,phone,email,region,workfield,jobtype,jobstart,number,timetype,pensum_percentage,pensum_hours,term_application';
	    $this->cObj->DBgetInsert('tx_mrjobs_searches', $this->conf['pid_storage'], $row, $newFieldList, TRUE);
        $newId = $TYPO3_DB->sql_insert_id();
        $data = array(
                    'Neue Datensatz-ID:' => $newId,
                    'Name' => $row['firstname'] . ' ' . $row['name'],
                    'PLZ/Ort' => $row['zip'] . ' ' . $row['city'],
                     );
        $this->_createNotifyEmail($data, "Neue Stellensuche eingegangen");
	    return '<p>'. $this->pi_getLL('jobsearch_thanks') . '<br />' . $this->pi_linkToPage($this->pi_getLL('redirect_to_searches_list'),$this->conf['pid_search_list']) . '</p>';
	}

	private function _createNotifyEmail($data, $subject) {
	    $mail_from = $this->conf['email.']['from'];
	    $mail_fromName = $this->conf['email.']['fromName'];
	    $mail_to = $this->conf['email.']['to'];
	    $body = $subject . "\n";
	    foreach ($data as $key => $value) {
	        $body .= $value . "\n";
	    }
	    $this->cObj->sendNotifyEmail($body, $mail_to, '', $mail_from, $mail_fromName);
	}

	private function _mkTimeStamp($date) {
	    $timestamp = 0;
	    $splitArr = explode('.',$date);
	    if(count($splitArr) == 3) {
	        $timestamp = mktime(23, 59, 0, $splitArr[1], $splitArr[0], $splitArr[2]);
	    }
	    return $timestamp;
	}

}

if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mr_jobs/pi1/class.tx_mrjobs_pi1.php'])	{
	include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/mr_jobs/pi1/class.tx_mrjobs_pi1.php']);
}

?>
