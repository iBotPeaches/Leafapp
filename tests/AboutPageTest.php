<?php


class AboutPageTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $this->visit('/')
            ->click('About')
            ->seePageIs('/about');
    }
}
