<?php

test('zip extension is enabled', function () {
    expect(extension_loaded('zip'))->toBeTrue();
});