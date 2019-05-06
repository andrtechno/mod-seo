<?php
use yii\helpers\Html;
use panix\engine\bootstrap\ActiveForm;
use panix\ext\tinymce\TinyMce;

\panix\mod\seo\SeoAsset::register($this);



$this->registerJs("
        jQuery.fn.exists = function () {
            return this.length > 0;
        };

        $('.addparams').change(function () {
            var val = $('option:selected', this).val();
            var id = $(this).attr('data-id');
            var text = $('option:selected', this).text();
            rowID = text + id;
            rowID = rowID.replace(\".\", \"\");
            if (!$('#' + rowID).exists()) {
                $('#container-param-' + id).append('<tr id=\"' + rowID + '\"><td><input type=\"hidden\" name=\"param[' + id + '][' + val + ']\" value=\"{' + text + '}\" /><code>{' + text + '}</code></td><td class=\"text-center\"><a href=\"javascript:void(0);\" onclick=\"removeParam(this);\" class=\"btn btn-xs btn-danger\"><i class=\"icon-delete\"></i></a></td></tr>');
            } else {
                common.notify('Уже добавлен!', 'error');
            }

        });

    function removeParam(that) {
        $(that).parent().parent().remove();
    }
    
");
?>


<?php
$form = ActiveForm::begin();
?>
<div class="card">
    <div class="card-header">
        <h5><?= Html::encode($this->context->pageName); ?></h5>
    </div>
    <div class="card-body">



        <?= $form->field($model, 'url')->textInput() ?>
        <?= $form->field($model, 'meta_robots')->checkboxList([
            'index'=>'index',
            'follow'=>'follow',
            'noindex'=>'noindex',
            'nofollow'=>'nofollow'
        ]) ?>

        <?= $form->field($model, 'title')->textInput() ?>
        <?= $form->field($model, 'description')->textInput() ?>
        <?= $form->field($model, 'h1')->textInput() ?>
        <?= $form->field($model, 'text')->widget(TinyMce::class, [
            'options' => ['rows' => 6],

        ]); ?>


        <div class="form-group row">
            <div class="col-sm-4"></div>
            <div class="col-sm-8">


                <?php //echo Html::dropDownList('title_param', "param", ArrayHelper::map($this->context->getParams(), "value", "name", 'group'), array("empty" => "Свойства", 'class' => 'selectpicker addparams', 'data-id' => $model->id)); ?>
                <?php echo $this->render('_formMetaParams', array('model' => $model)); ?></div>
        </div>
        <div class="form-group row" style="display:none;">
            <div class="col-sm-4"><?php echo Html::dropDownList("name", "", ["robots" => "robots", "author" => "author", "copyright" => "copyright"], ["empty" => "change"]) ?>
            </div>
            <div class="col-sm-8">
                <?php echo Html::button("add meta name", array('class' => "meta-name")); ?>
                <span id="load-meta-name"></span>
            </div>
        </div>




    </div>
    <div class="card-footer text-center">
        <?= $model->submitButton(\yii\helpers\Url::previous()); ?>
    </div>
</div>
<?php ActiveForm::end(); ?>