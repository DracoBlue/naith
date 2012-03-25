<?php

function thisDoesNotThrowAnException()
{
    /*
     * DO not throw one!
     */
}

NaithCliRunner::assertException('thisDoesNotThrowAnException');