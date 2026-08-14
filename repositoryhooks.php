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
include("include/config.inc.php");

//
// Authentication
//

$engine = \svnadmin\core\Engine::getInstance();

if (!$engine->isProviderActive(PROVIDER_REPOSITORY_EDIT)) {
	$engine->forwardError(ERROR_INVALID_MODULE);
}

$engine->checkUserAuthentication(true, ACL_MOD_REPO, ACL_ACTION_ADD);
$appTR->loadModule("repositoryhooks");

//
// HTTP Request Vars
//

$varParentIdentifierEnc = get_request_var('pi');
$varRepoEnc = get_request_var('r');
$varSelectedHookEnc = get_request_var('hook');

$varParentIdentifier = rawurldecode($varParentIdentifierEnc);
$varRepo = rawurldecode($varRepoEnc);

//
// Actions
//

if (check_request_var('save')) {
	$engine->handleAction('save_hook');
}

//
// View Data
//

$oR = new \svnadmin\core\entities\Repository($varRepo, $varParentIdentifier);

$hookList = array();
$selectedHook = null;
$hookContent = '';
$isNew = true;
$canEdit = IsProviderActive(PROVIDER_REPOSITORY_EDIT) && HasAccess(ACL_MOD_REPO, ACL_ACTION_ADD);

try {
	if ($varSelectedHookEnc != null) {
		$selectedHook = rawurldecode($varSelectedHookEnc);
		$hookContent = $engine->getRepositoryEditProvider()->getHookContent($oR, $selectedHook);
		$isNew = false;
	}

	$hookList = $engine->getRepositoryEditProvider()->listHooks($oR);
}
catch (Exception $ex) {
	$engine->addException($ex);
}

SetValue('Repository', $oR);
SetValue('HookList', $hookList);
SetValue('SelectedHook', $selectedHook);
SetValue('HookContent', $hookContent);
SetValue('IsNew', $isNew);
SetValue('CanEdit', $canEdit);
ProcessTemplate("repository/repositoryhooks.html.php");
?>
