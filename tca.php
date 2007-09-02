<?php
if (!defined ('TYPO3_MODE')) 	die ('Access denied.');

$TCA["tx_mrjobs_offers"] = array (
	"ctrl" => $TCA["tx_mrjobs_offers"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,fe_group,zip,city,employer,workaddress,commune,canton,jobtype,position,jobstart,number,timetype,pensum_percentage,pensum_hours,term_application,contact_name,contact_firstname,contact_phone,contact_email"
	),
	"feInterface" => $TCA["tx_mrjobs_offers"]["feInterface"],
	"columns" => array (
		'sys_language_uid' => array (
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l18n_parent' => array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_mrjobs_offers',
				'foreign_table_where' => 'AND tx_mrjobs_offers.pid=###CURRENT_PID### AND tx_mrjobs_offers.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array (
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'hidden' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'starttime' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'default'  => '0',
				'checkbox' => '0'
			)
		),
		'endtime' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'checkbox' => '0',
				'default'  => '0',
				'range'    => array (
					'upper' => mktime(0, 0, 0, 12, 31, 2020),
					'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
				)
			)
		),
		'fe_group' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config'  => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		"zip" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.zip",
			"config" => Array (
				"type" => "input",
				"size" => "6",
				"eval" => "required",
			)
		),
		"city" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.city",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
		"employer" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.employer",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
		"workaddress" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.workaddress",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
		"commune" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.commune",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
		"canton" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.canton",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
		"jobtype" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.jobtype",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.jobtype.I.0", "0"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.jobtype.I.1", "1"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.jobtype.I.2", "2"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.jobtype.I.3", "3"),
				),
				"size" => 1,
				"maxitems" => 1,
			)
		),
		"position" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.positiontype",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.positiontype.I.0", "0"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.positiontype.I.1", "1"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.positiontype.I.2", "2"),
				),
				"size" => 1,
				"maxitems" => 1,
			)
		),
		"jobstart" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.jobstart",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
		"number" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.0", "0"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.1", "1"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.2", "2"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.3", "3"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.4", "4"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.5", "5"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.6", "6"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.7", "7"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.8", "8"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.9", "9"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.10", "10"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.11", "11"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.12", "12"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.13", "13"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.14", "14"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.15", "15"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.16", "16"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.17", "17"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.18", "18"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.19", "19"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.20", "20"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.21", "21"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.22", "22"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.23", "23"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.24", "24"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.25", "25"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.26", "26"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.27", "27"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.28", "28"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.29", "29"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.30", "30"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.number.I.31", "31"),
				),
				"size" => 1,
				"maxitems" => 1,
			)
		),
		"timetype" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.timetype",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.timetype.I.0", "0"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.timetype.I.1", "1"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.timetype.I.2", "2"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.timetype.I.3", "3"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.timetype.I.4", "4"),
				),
				"size" => 1,
				"maxitems" => 1,
			)
		),
		"pensum_percentage" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.pensum_percentage",
			"config" => Array (
				"type" => "input",
				"size" => "5",
			)
		),
		"pensum_hours" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.pensum_hours",
			"config" => Array (
				"type" => "input",
				"size" => "5",
			)
		),
		"term_application" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.term_application",
			"config" => Array (
				"type" => "input",
				"size" => "12",
				"eval" => "required",
			)
		),
		"contact_name" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.contact_name",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
		"contact_firstname" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.contact_firstname",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
		"contact_function" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.contact_function",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
		"contact_phone" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.contact_phone",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
		"contact_email" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.contact_email",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
		'contact_street' => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.contact_street",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
		'contact_zip' => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.contact_zip",
			"config" => Array (
				"type" => "input",
				"size" => "6",
				"eval" => "required",
			)
		),
		'contact_city' => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_offers.contact_city",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
    ),
	"types" => array (
		"0" => array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, zip, city, employer, workaddress, commune, canton, jobtype, position, jobstart, number, timetype, pensum_percentage, pensum_hours, term_application, contact_name, contact_firstname, contact_phone, contact_email, contact_street, contact_zip, contact_city")
	),
	"palettes" => array (
		"1" => array("showitem" => "starttime, endtime, fe_group")
	)
);



$TCA["tx_mrjobs_searches"] = array (
	"ctrl" => $TCA["tx_mrjobs_searches"]["ctrl"],
	"interface" => array (
		"showRecordFieldList" => "sys_language_uid,l18n_parent,l18n_diffsource,hidden,starttime,endtime,fe_group"
	),
	"feInterface" => $TCA["tx_mrjobs_searches"]["feInterface"],
	"columns" => array (
		'sys_language_uid' => array (
			'exclude' => 1,
			'label'  => 'LLL:EXT:lang/locallang_general.xml:LGL.language',
			'config' => array (
				'type'                => 'select',
				'foreign_table'       => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xml:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.default_value', 0)
				)
			)
		),
		'l18n_parent' => array (
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude'     => 1,
			'label'       => 'LLL:EXT:lang/locallang_general.xml:LGL.l18n_parent',
			'config'      => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
				),
				'foreign_table'       => 'tx_mrjobs_searches',
				'foreign_table_where' => 'AND tx_mrjobs_searches.pid=###CURRENT_PID### AND tx_mrjobs_searches.sys_language_uid IN (-1,0)',
			)
		),
		'l18n_diffsource' => array (
			'config' => array (
				'type' => 'passthrough'
			)
		),
		'hidden' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.hidden',
			'config'  => array (
				'type'    => 'check',
				'default' => '0'
			)
		),
		'starttime' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.starttime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'default'  => '0',
				'checkbox' => '0'
			)
		),
		'endtime' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.endtime',
			'config'  => array (
				'type'     => 'input',
				'size'     => '8',
				'max'      => '20',
				'eval'     => 'date',
				'checkbox' => '0',
				'default'  => '0',
				'range'    => array (
					'upper' => mktime(0, 0, 0, 12, 31, 2020),
					'lower' => mktime(0, 0, 0, date('m')-1, date('d'), date('Y'))
				)
			)
		),
		'fe_group' => array (
			'exclude' => 1,
			'label'   => 'LLL:EXT:lang/locallang_general.xml:LGL.fe_group',
			'config'  => array (
				'type'  => 'select',
				'items' => array (
					array('', 0),
					array('LLL:EXT:lang/locallang_general.xml:LGL.hide_at_login', -1),
					array('LLL:EXT:lang/locallang_general.xml:LGL.any_login', -2),
					array('LLL:EXT:lang/locallang_general.xml:LGL.usergroups', '--div--')
				),
				'foreign_table' => 'fe_groups'
			)
		),
		'firstname' => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.firstname",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
		'name' => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.name",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
		'phone' => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.phone",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
		'email' => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.email",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
		'street' => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.street",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
		'zip' => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.zip",
			"config" => Array (
				"type" => "input",
				"size" => "6",
				"eval" => "required",
			)
		),
		'city' => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.city",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
		'region' => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.region",
			"config" => Array (
				"type" => "input",
				"size" => "30",
			)
		),
		'workfield' => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.workfield",
			"config" => Array (
				"type" => "input",
				"size" => "30",
			)
		),
		"jobtype" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.jobtype",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.jobtype.I.1", "1"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.jobtype.I.2", "2"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.jobtype.I.3", "3"),
				),
				"renderMode" => 'checkbox',
				"size" => 3,
				"maxitems" => 3,
			)
		),
		"jobstart" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.jobstart",
			"config" => Array (
				"type" => "input",
				"size" => "30",
				"eval" => "required",
			)
		),
		"number" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.0", "0"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.1", "1"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.2", "2"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.3", "3"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.4", "4"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.5", "5"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.6", "6"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.7", "7"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.8", "8"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.9", "9"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.10", "10"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.11", "11"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.12", "12"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.13", "13"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.14", "14"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.15", "15"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.16", "16"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.17", "17"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.18", "18"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.19", "19"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.20", "20"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.21", "21"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.22", "22"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.23", "23"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.24", "24"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.25", "25"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.26", "26"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.27", "27"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.28", "28"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.29", "29"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.30", "30"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.number.I.31", "31"),
				),
				"size" => 1,
				"maxitems" => 1,
			)
		),
		"timetype" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.timetype",
			"config" => Array (
				"type" => "select",
				"items" => Array (
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.timetype.I.0", "0"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.timetype.I.1", "1"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.timetype.I.2", "2"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.timetype.I.3", "3"),
					Array("LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.timetype.I.4", "4"),
				),
				"size" => 1,
				"maxitems" => 1,
			)
		),
		"pensum_percentage" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.pensum_percentage",
			"config" => Array (
				"type" => "input",
				"size" => "5",
			)
		),
		"pensum_hours" => Array (
			"exclude" => 1,
			"label" => "LLL:EXT:mr_jobs/locallang_db.xml:tx_mrjobs_searches.pensum_hours",
			"config" => Array (
				"type" => "input",
				"size" => "5",
			)
		),
	),
	"types" => array (
		"0" => array("showitem" => "sys_language_uid;;;;1-1-1, l18n_parent, l18n_diffsource, hidden;;1, firstname, name, phone, email, street, zip, city, region, workfield, jobtype, jobstart, number, timetype, pensum_percentage, pensum_hours")
	),
	"palettes" => array (
		"1" => array("showitem" => "starttime, endtime, fe_group")
	)
);
?>
