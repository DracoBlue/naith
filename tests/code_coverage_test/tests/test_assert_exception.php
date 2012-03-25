<?php

function thisThrowsAnException()
{
    throw new Exception('There was an exception');
}

NaithCliRunner::assertException('thisThrowsAnException');