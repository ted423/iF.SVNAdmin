<?php GlobalHeader(); ?>

<h1><?php Translate("Hook management"); ?></h1>
<p class="hdesc"><?php Translate("On this page you can view and edit the hooks of the repository."); ?></p>

<h2>
  <a href="repositoryview.php?pi=<?php print(GetValue("Repository")->getEncodedParentIdentifier()); ?>&amp;r=<?php print(GetValue("Repository")->getEncodedName()); ?>"><?php print(GetValue("Repository")->getName()); ?></a>
</h2>

<?php if (GetBoolValue("CanEdit")) : ?>
<form action="repositoryhooks.php?pi=<?php print(GetValue("Repository")->getEncodedParentIdentifier()); ?>&amp;r=<?php print(GetValue("Repository")->getEncodedName()); ?>" method="POST">
<table class="datatableinline">
<colgroup>
  <col width="150">
  <col>
</colgroup>
<tbody>
  <tr>
    <td><?php Translate("Hook name"); ?>:</td>
    <td>
      <?php if (GetBoolValue("IsNew")) : ?>
      <select name="hook_name">
        <option value=""><?php Translate("Custom"); ?></option>
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
      <input type="text" name="hook_name_custom" value="" size="30">
      <?php else : ?>
      <input type="text" name="hook_name" value="<?php print(GetValue("SelectedHook")); ?>" readonly="readonly" size="40">
      <?php endif; ?>
    </td>
  </tr>
  <tr>
    <td valign="top"><?php Translate("Hook content"); ?>:</td>
    <td>
      <textarea name="hook_content" rows="20" cols="80" style="font-family: monospace;"><?php PrintStringValue("HookContent"); ?></textarea>
    </td>
  </tr>
  <tr>
    <td></td>
    <td>
      <input type="submit" name="save" value="<?php Translate("Save hook"); ?>">
    </td>
  </tr>
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
    <?php if (GetBoolValue("CanEdit")) : ?>
    <th width="80"><?php Translate("Options"); ?></th>
    <?php endif; ?>
  </tr>
</thead>
<tbody>
  <?php foreach (GetArrayValue("HookList") as $hook) : ?>
  <tr>
    <td><?php print($hook->name); ?></td>
    <td align="right"><?php print($hook->size); ?></td>
    <?php if (GetBoolValue("CanEdit")) : ?>
    <td align="center">
      <a href="repositoryhooks.php?pi=<?php print(GetValue("Repository")->getEncodedParentIdentifier()); ?>&amp;r=<?php print(GetValue("Repository")->getEncodedName()); ?>&amp;hook=<?php print($hook->encodedName); ?>"><?php Translate("Edit"); ?></a>
    </td>
    <?php endif; ?>
  </tr>
  <?php endforeach; ?>
</tbody>
</table>

<?php GlobalFooter(); ?>
