<?php

namespace Core\Templates;
use Entities\TelegraphText;
use Entities\View;

class Spl extends View
{
  public function render(TelegraphText $telegraphText): string
  {
    $templatePath = sprintf('templates/%s.spl', $this -> templateName);
    $template = file_get_contents($templatePath);

    foreach($this -> variables as $variables){
      $templateContent = str_replace('$$' . $variables . '$$', $telegraphText -> {$variables}, $template);
    }

    return $templateContent;
  }
}
