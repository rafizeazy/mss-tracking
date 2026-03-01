<?php

test('registration screen returns 404 when feature is disabled', function () {
    $response = $this->get('/register');

    $response->assertNotFound();
});
