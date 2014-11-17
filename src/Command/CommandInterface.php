<?php

namespace Juxta\Command;

use Juxta\Request;

interface CommandInterface
{
    public function run(Request $request);
}