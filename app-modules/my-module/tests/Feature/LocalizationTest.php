<?php


it('localizes validation messages', function () {
    app()->setLocale('de');

    $messages = validator(
        ['name' => null],
        ['name' => 'required'],
    )->errors();

    expect($messages->all())
        ->toBe(['Das Feld Name muss ausgefüllt sein.']);
});
