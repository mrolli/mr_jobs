<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');
$TCA["tx_mrjobs_offers"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers',
		'label'     => 'zip',
		'label_alt' => 'city',
		'label_alt_force' => 1,
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'languageField'            => 'sys_language_uid',
		'transOrigPointerField'    => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'default_sortby' => "ORDER BY crdate DESC",
		'delete' => 'deleted',
		'enablecolumns' => array (
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_mrjobs_offers.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, starttime, endtime, fe_group, zip, city, employer, workaddress, commune, canton, jobtype, position, jobstart, number, timetype, pensum_percentage, pensum_hours, term_application, contact_name, contact_firstname, contact_phone, contact_email",
	)
);

$TCA["tx_mrjobs_searches"] = array (
	"ctrl" => array (
		'title'     => 'LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches',
		'label'     => 'name',
		'label_alt' => 'firstname',
		'label_alt_force' => 1,
		'tstamp'    => 'tstamp',
		'crdate'    => 'crdate',
		'cruser_id' => 'cruser_id',
		'languageField'            => 'sys_language_uid',
		'transOrigPointerField'    => 'l18n_parent',
		'transOrigDiffSourceField' => 'l18n_diffsource',
		'default_sortby' => "ORDER BY crdate DESC",
		'delete' => 'deleted',
		'enablecolumns' => array (
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
			'fe_group' => 'fe_group',
		),
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY).'tca.php',
		'iconfile'          => t3lib_extMgm::extRelPath($_EXTKEY).'icon_tx_mrjobs_searches.gif',
	),
	"feInterface" => array (
		"fe_admin_fieldList" => "sys_language_uid, l18n_parent, l18n_diffsource, hidden, starttime, endtime, fe_group",
	)
);



// add FlexForm field to tt_content
$TCA['tt_content']['types']['list']['subtypes_addlist'][$_EXTKEY.'_pi1']='pi_flexform';
// add flexform definition
t3lib_extMgm::addPiFlexFormValue($_EXTKEY.'_pi1', 'FILE:EXT:mr_jobs/flexform_ds.xml');
t3lib_extMgm::addStaticFile($_EXTKEY,'static/ts_mrjobs/', 'Job Offers');


t3lib_div::loadTCA('tt_content');
$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi1']='layout,select_key';
t3lib_extMgm::addPlugin(array('LLL:EXT:mr_jobs/locallang_db.xml:tt_content.list_type_pi1', $_EXTKEY.'_pi1'),'list_type');
//t3lib_extMgm::addStaticFile($_EXTKEY,"pi1/static/","Job Offers");

//t3lib_div::loadTCA('tt_content');
//$TCA['tt_content']['types']['list']['subtypes_excludelist'][$_EXTKEY.'_pi2']='layout,select_key';
//t3lib_extMgm::addPlugin(array('LLL:EXT:mr_jobs/locallang_db.xml:tt_content.list_type_pi2', $_EXTKEY.'_pi2'),'list_type');
//t3lib_extMgm::addStaticFile($_EXTKEY,"pi2/static/","Job Searches");

if (TYPO3_MODE=="BE")	$TBE_MODULES_EXT["xMOD_db_new_content_el"]["addElClasses"]["tx_mrjobs_pi1_wizicon"] = t3lib_extMgm::extPath($_EXTKEY).'pi1/class.tx_mrjobs_pi1_wizicon.php';

?>