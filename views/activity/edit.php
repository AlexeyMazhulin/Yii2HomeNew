<?php
/**
 * @var $this \yii\web\\View
 * @var $model  \app\models\Activity

 */

use yii\bootstrap\ActiveForm; ?>
<div class = "row">
    <div class="col-md-12">
        <h3>Редактирование события</h3>


        <?php $form=\yii\bootstrap\ActiveForm::begin([
            'options' => ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data'],
            'fieldConfig' => [
                'options' => ['class' => 'input-group'],
                'inputOptions' => ['class' => 'form-control']
            ],
        ]);?>
        <?=$form->field($model,'title')?>
        <?=$form->field($model,'description')->textarea(['data-attr'=>2])?>
        <?=$form->field($model,'dateStart');?>
        <?=$form->field($model,'useNotification')->checkbox();?>
        <?=$form->field($model,'email',
            ['enableClientValidation'=> false,
                'enableAjaxValidation' => true,
            ]);?>
        <?=$form->field($model,'isBlocked')->checkbox();?>
        <?=$form->field($model,'repeatCountList')->dropDownList($model->getRepeatCountList());?>
        <?=$form->field($model,'repeatCount')->input('number');?>
        <?=$form->field($model,'file[]')->fileInput(['multiple' => true]);?>
        <div class="form-group">
            <button class="btn btn-default" type="submit">Создать</button>
        </div>


        <?php yii\bootstrap\ActiveForm::end();?>
    </div>
</div>
