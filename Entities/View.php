<?php

namespace Entities;
use Interfaces\IRender;

abstract class View implements IRender
{
  public string $templateName;
  public array $variables = [];

  public function __construct(string $templateName)
  {
    $this -> templateName = $templateName;
  }

  public function addVariablesToTemplate(array $variables): void
  {
    $this -> variables = $variables;
  }
}
