#
# Table structure for table 'tx_mrjobs_offers'
#
CREATE TABLE tx_mrjobs_offers (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	zip tinytext NOT NULL,
	city tinytext NOT NULL,
	employer tinytext NOT NULL,
	workaddress tinytext NOT NULL,
	commune tinytext NOT NULL,
	canton tinytext NOT NULL,
	jobtype int(11) DEFAULT '0' NOT NULL,
	position tinytext NOT NULL,
	jobstart tinytext NOT NULL,
	number int(11) DEFAULT '0' NOT NULL,
	timetype int(11) DEFAULT '0' NOT NULL,
	pensum_percentage tinytext NOT NULL,
	pensum_hours tinytext NOT NULL,
	term_application tinytext NOT NULL,
	contact_name tinytext NOT NULL,
	contact_firstname tinytext NOT NULL,
	contact_function tinytext NOT NULL,
	contact_phone tinytext NOT NULL,
	contact_email tinytext NOT NULL,
	contact_street tinytext NOT NULL,
	contact_zip tinytext NOT NULL,
	contact_city tinytext NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_mrjobs_searches'
#
CREATE TABLE tx_mrjobs_searches (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	starttime int(11) DEFAULT '0' NOT NULL,
	endtime int(11) DEFAULT '0' NOT NULL,
	fe_group int(11) DEFAULT '0' NOT NULL,
	firstname tinytext NOT NULL,
	name tinytext NOT NULL,
	phone tinytext NOT NULL,
	email tinytext NOT NULL,
	street tinytext NOT NULL,
	zip tinytext NOT NULL,
	city tinytext NOT NULL,
	region tinytext NOT NULL,
	workfield tinytext NOT NULL,
	jobtype tinytext NOT NULL,
	jobstart tinytext NOT NULL,
	number int(11) DEFAULT '0' NOT NULL,
	timetype int(11) DEFAULT '0' NOT NULL,
	pensum_percentage tinytext NOT NULL,
	pensum_hours tinytext NOT NULL,

	PRIMARY KEY (uid),
	KEY parent (pid)
);