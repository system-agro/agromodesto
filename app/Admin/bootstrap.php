<?php
use OpenAdmin\Admin\Admin;

/**
 * Open-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * OpenAdmin\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * OpenAdmin\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */


Admin::js('https://code.jquery.com/jquery-3.6.0.min.js');
Admin::js('https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js');
Admin::js('utils/eventButtonTable.js');



use OpenAdmin\Admin\Grid;


Grid::init(function (Grid $grid) {

    // $grid->enableDblClick();

    // $grid->disableActions();

    // $grid->disablePagination();

    // $grid->disableCreateButton();

    // $grid->disableFilter();

    // $grid->disableRowSelector();

    // $grid->disableColumnSelector();

    // $grid->disableTools();

    // $grid->disableExport();

});

OpenAdmin\Admin\Form::forget(['editor']);
