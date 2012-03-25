<?php

class ClassWhichIsNotFullyTested {
    static function methodWhichWillBeCalled()
    {
        if (true)
        {
            return ;
        }
    }
    
    static function methodWhichIsNotCalled()
    {
        if (false)
        {
            return ;
        }
    }
}
