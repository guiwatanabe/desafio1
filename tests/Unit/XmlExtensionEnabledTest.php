<?php

test('xml extension is enabled', function () {
    expect(extension_loaded('xml'))->toBeTrue();
});