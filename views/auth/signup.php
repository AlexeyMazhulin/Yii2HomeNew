<?php

?>

<div class="row">
    <div class="col-md-6">
        <?php $form=\yii\bootstrap\ActiveForm::begin([
            'method' => 'POST'
        ]);?>
            <?=$form->field($model,'email')?>
            <?=$form->field($model,'password')->passwordInput() ?>

        <div class="form-group">
            <button type="submit">Регистрация</button>
        </div>
        <?php \yii\bootstrap\ActiveForm::end(); ?>

    </div>
</div>

