<?php GlobalHeader(); ?>

<h1><?php Translate("Hook management"); ?></h1>
<p class="hdesc"><?php Translate("On this page you can view and edit the hooks of the repository."); ?></p>

<h2>
  <a href="repositoryview.php?pi=<?php print(GetValue("Repository")->getEncodedParentIdentifier()); ?>&amp;r=<?php print(GetValue("Repository")->getEncodedName()); ?>"><?php print(GetValue("Repository")->getName()); ?></a>
</h2>

<?php if (GetBoolValue("CanEdit") || GetBoolValue("HasSelectedHook")) : ?>
<form action="repositoryhooks.php?pi=<?php print(GetValue("Repository")->getEncodedParentIdentifier()); ?>&amp;r=<?php print(GetValue("Repository")->getEncodedName()); ?>" method="POST">
<table class="datatableinline">
<colgroup>
  <col width="150">
  <col>
</colgroup>
<tbody>
  <tr>
    <td style="vertical-align: middle;"><?php Translate("Hook name"); ?>:</td>
    <td style="vertical-align: middle;">
      <?php if (GetBoolValue("IsNew")) : ?>
      <select name="hook_name" style="height: 22px;">
        <option value="start-commit">start-commit</option>
        <option value="pre-commit">pre-commit</option>
        <option value="post-commit">post-commit</option>
        <option value="pre-lock">pre-lock</option>
        <option value="post-lock">post-lock</option>
        <option value="pre-unlock">pre-unlock</option>
        <option value="post-unlock">post-unlock</option>
        <option value="pre-revprop-change">pre-revprop-change</option>
        <option value="post-revprop-change">post-revprop-change</option>
      </select>
      <?php else : ?>
      <input type="text" name="hook_name" value="<?php print(GetValue("SelectedHook")); ?>" readonly="readonly" size="40" style="height: 22px;">
      <?php endif; ?>
    </td>
  </tr>
  <tr>
    <td valign="top"><?php Translate("Hook content"); ?>:</td>
    <td>
      <textarea name="hook_content" rows="20" cols="80" style="font-family: monospace;" <?php if (GetBoolValue("SelectedHookReadOnly") || !GetBoolValue("CanEdit")) { print('readonly="readonly"'); } ?>><?php PrintStringValue("HookContent"); ?></textarea>
      <?php if (GetBoolValue("SelectedHookReadOnly")) : ?>
      <p><i><?php Translate("This is a Subversion hook template and cannot be edited."); ?></i></p>
      <?php endif; ?>
    </td>
  </tr>
  <?php if (GetBoolValue("CanEdit") && !GetBoolValue("SelectedHookReadOnly")) : ?>
  <tr>
    <td></td>
    <td>
      <input type="submit" name="save" value="<?php Translate("Save hook"); ?>">
    </td>
  </tr>
  <?php endif; ?>
</tbody>
</table>
</form>
<?php endif; ?>

<h3><?php Translate("Existing hooks"); ?></h3>

<table class="datatable">
<thead>
  <tr>
    <th><?php Translate("Hook name"); ?></th>
    <th width="100"><?php Translate("Size"); ?></th>
    <th width="80"><?php Translate("Options"); ?></th>
  </tr>
</thead>
<tbody>
  <?php foreach (GetArrayValue("ActiveHookList") as $hook) : ?>
  <tr>
    <td><?php print($hook->name); ?></td>
    <td align="right"><?php print($hook->size); ?></td>
    <td align="center">
      <a href="repositoryhooks.php?pi=<?php print(GetValue("Repository")->getEncodedParentIdentifier()); ?>&amp;r=<?php print(GetValue("Repository")->getEncodedName()); ?>&amp;hook=<?php print($hook->encodedName); ?>"><?php if (GetBoolValue("CanEdit")) { Translate("Edit"); } else { Translate("View"); } ?></a>
    </td>
  </tr>
  <?php endforeach; ?>
</tbody>
</table>

<?php if (count(GetArrayValue("TemplateHookList")) > 0) : ?>
<h3><?php Translate("Hook templates"); ?></h3>

<table class="datatable">
<thead>
  <tr>
    <th><?php Translate("Hook name"); ?></th>
    <th width="100"><?php Translate("Size"); ?></th>
    <th width="80"><?php Translate("Options"); ?></th>
  </tr>
</thead>
<tbody>
  <?php foreach (GetArrayValue("TemplateHookList") as $hook) : ?>
  <tr>
    <td><?php print($hook->name); ?></td>
    <td align="right"><?php print($hook->size); ?></td>
    <td align="center">
      <a href="repositoryhooks.php?pi=<?php print(GetValue("Repository")->getEncodedParentIdentifier()); ?>&amp;r=<?php print(GetValue("Repository")->getEncodedName()); ?>&amp;hook=<?php print($hook->encodedName); ?>"><?php Translate("View"); ?></a>
    </td>
  </tr>
  <?php endforeach; ?>
</tbody>
</table>
<?php endif; ?>

<?php GlobalFooter(); ?>
