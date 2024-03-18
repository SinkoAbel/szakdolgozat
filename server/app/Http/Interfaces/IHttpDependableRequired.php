<?php

namespace App\Http\Interfaces;

interface IHttpDependableRequired
 {
    public function isRequired(array $methods): string;
 }
