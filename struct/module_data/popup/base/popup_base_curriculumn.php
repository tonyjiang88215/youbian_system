<?php
$Views = array();

$Views['source_type'] = factory::getModel('edu_source_type')->get_source_types();

$Views['subject'] = factory::getModel('edu_subject')->get_subjects();


