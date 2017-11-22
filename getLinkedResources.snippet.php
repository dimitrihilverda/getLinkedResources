<?php
$docId = $modx->getOption('docId', $scriptProperties, $modx->resource->get('id'));
$tpl = $modx->getOption('tpl', $scriptProperties, '');

if (is_numeric($docId) && !empty($docId)) {
	$page = $modx->getObject('modResource', $docId);

//see if the id given is used in content if so the this is a original id and I get all symlinks then I have an array with symlinks and I have the original id
	$symlinkObjs = $modx->getCollection('modResource', array('content' => $docId));
	if (count($symlinkObjs) != 0) {
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
		foreach($symlinkObjs as $page) {
			//print_r($symlinkObj, true);
			if (is_numeric($page->get('content')) && !empty($page->get('content'))) {
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
	} else {
	//its a symlink lets see if there are more symlinks
	//if the id is not found as content then this could be 2 reasons, 1 this id is not used at all or this is a symlink, if this is a symlink then try to find this id as resource and check if the content is an ID then us that Id to do the same as above

	$output .= $modx->getChunk(
		$tpl,
		array(
			'id' => $page->get('id'),
			'parent' => $page->get('parent'),
			'pagetitle' => $page->get('pagetitle'),
			'alias' => $page->get('alias')
		)
	);

	$symlinkObjs = $modx->getIterator('modResource', array('content' => $page->get('content')));

	foreach($symlinkObjs as $page) {

		if (is_numeric($page->get('content')) && !empty($page->get('content'))) {
			if ($tpl != '') {
				$output .= $modx->getChunk(
					$tpl,
					array(
						'id' => $page->get('id'),
						'pagetitle' => $page->get('pagetitle'),
						'alias' => $page->get('alias'),
						'parent' => $page->get('parent')
					)
				);
			}
			else {
				$output[] = $page->get('id');
			}
		}
	}
}

}

if (is_array($output)) {
	$output[] = $docId;
	$output = implode(',', $output);
}

return $output;
