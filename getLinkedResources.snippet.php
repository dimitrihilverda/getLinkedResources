<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$docId = $modx->getOption('docId', $scriptProperties, $modx->resource->get('id'));
$tpl = $modx->getOption('tpl', $scriptProperties, '');

if (!is_numeric($docId) && empty($docId)) {
	return false;
}

$currentResource = $modx->getObject('modResource', $docId);

if ($currentResource->get('class_key') == 'modSymLink') {
	//is symlink
	$docId = $currentResource->get('content');
	if (!is_numeric($docId) && empty($docId)) {
		return false;
	}
}

$modDocument = $modx->getObject('modResource', $docId);
$symlinkObjs = $modx->getCollection('modResource', array('content' => $docId));

if (count($symlinkObjs) != 0) {
	if ($tpl != '' ) {
		$output .= $modx->getChunk(
			$tpl,
			array(
				'id' => $modDocument->get('id'),
				'parent' => $modDocument->get('parent'),
				'pagetitle' => $modDocument->get('pagetitle'),
				'alias' => $modDocument->get('alias')
			)
		);
	}

	// loop tru each symlink
	foreach($symlinkObjs as $page) {
		if ($tpl != '') {
			$output .= $modx->getChunk(
				$tpl,
				array(
					'id' => $page->get('id'),
					'parent' => $page->get('parent'),
					'pagetitle' => $page->get('pagetitle'),
					'alias' => $page->get('alias')
				)
			);
		}
		else {
			$output[] = intval($page->get('id'));
		}
	}
}

if (is_array($output)) {
	if ($showSelf != 0) {
		$output[] = $docId;
	}
	$output = implode(',', $output);
}

return $output;
