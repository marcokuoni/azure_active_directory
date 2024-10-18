<?php defined('C5_EXECUTE') or die('Access denied.'); ?>
<div class="alert alert-info">
    <p><?php echo t('Set the "Redirect URI" to: %s', ' <code>'.$redirectUri.'</code>'); ?></p>
</div>

<div class='form-group'>
    <?=$form->label('displayName', t('Authentication Type Display Name'))?>
    <?=$form->text('displayName', $this->getAuthenticationTypeDisplayName())?>
</div>
<div class='form-group'>
    <?=$form->label('url', t('URL'))?>
    <?=$form->text('url', isset($data['url']) ? $data['url'] : '')?>
</div>
<div class='form-group'>
    <?=$form->label('directoryid', t('Tenant'))?>
    <?=$form->text('directoryid', isset($data['directoryid']) ? $data['directoryid'] : '')?>
</div>
<div class='form-group'>
    <?=$form->label('apikey', t('App ID'))?>
    <?=$form->text('apikey', isset($data['appid']) ? $data['appid'] : '')?>
</div>
<div class='form-group'>
    <?=$form->label('apisecret', t('App Secret'))?>
    <div class="input-group">
        <?=$form->password('apisecret', isset($data['secret']) ? $data['secret'] : '', array('autocomplete' => 'off'))?>
        <span class="input-group-btn">
        <button id="showsecret" class="btn btn-warning" type="button"><?php echo t('Show secret key')?></button>
      </span>
    </div>
</div>
<div class='form-group'>
    <div class="input-group">
        <label type="checkbox">
            <input type="checkbox" name="registration_enabled" value="1" <?= isset($data['registration.enabled']) && $data['registration.enabled'] ? 'checked' : '' ?>>
            <span style="font-weight:normal"><?= t('Allow automatic registration') ?></span>
        </label>
    </div>
</div>
<div class='form-group registration-group'>
    <label for="registration_group" class="control-label"><?= t('Group to enter on registration') ?></label>
    <select name="registration_group" class="form-control">
        <option value="0"><?= t("None") ?></option>
        <?php
        /** @var \Group $group */
        foreach ($groups as $group) {
            ?>
            <option value="<?= $group->getGroupID() ?>" <?= intval($group->getGroupID(), 10) === intval(
                isset($data['registration.group']) ? $data['registration.group'] : 0,
                10) ? 'selected' : '' ?>>
                <?= $group->getGroupDisplayName(false) ?>
            </option>
        <?php
        }
        ?>
    </select>
</div>

<script type="text/javascript">

    (function RegistrationGroup() {

        var input = $('input[name="registration_enabled"]'),
            group_div = $('div.registration-group');

        input.change(function () {
            input.get(0).checked && group_div.show() || group_div.hide();
        }).change();

    }());

    var button = $('#showsecret');
    button.click(function() {
        var apisecret = $('#apisecret');
        if(apisecret.attr('type') == 'password') {
            apisecret.attr('type', 'text');
            button.html('<?php echo addslashes(t('Hide secret key'))?>');
        } else {
            apisecret.attr('type', 'password');
            button.html('<?php echo addslashes(t('Show secret key'))?>');
        }
    });
</script>
