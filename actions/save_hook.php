<?php
/**
 * iF.SVNAdmin
 * Copyright (c) 2010 by Manuel Freiholz
 * http://www.insanefactory.com/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; version 2
 * of the License.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.
 */
if (!defined('ACTION_HANDLING')) {
	die("HaHa!");
}

$engine = \svnadmin\core\Engine::getInstance();

//
// Authentication
//

if (!$engine->isProviderActive(PROVIDER_REPOSITORY_EDIT)) {
	$engine->forwardError(ERROR_INVALID_MODULE);
}

$engine->checkUserAuthentication(true);
if (!$engine->isCurrentUserAdmin()) {
	$engine->forwardError(ERROR_NO_ACCESS);
}

//
// HTTP Request Vars
//

$varParentIdentifierEnc = get_request_var('pi');
$varRepoEnc = get_request_var('r');
$hookName = get_request_var('hook_name');
$hookContent = get_request_var('hook_content');

$varParentIdentifier = rawurldecode($varParentIdentifierEnc);
$varRepo = rawurldecode($varRepoEnc);

//
// Validation
//

if ($hookName == NULL) {
	$engine->addException(new ValidationException(tr("You have to fill out all fields.")));
}
else {
	$oR = new \svnadmin\core\entities\Repository($varRepo, $varParentIdentifier);

	try {
		$engine->getRepositoryEditProvider()->saveHook($oR, $hookName, $hookContent);
		$engine->addMessage(tr("The hook %0 has been saved successfully.", array($hookName)));
	}
	catch (Exception $ex) {
		$engine->addException($ex);
	}
}
?>
