<?php

namespace Core\Templates;
use Entities\TelegraphText;
use Entities\View;

class Swig extends View
{
  public function render(TelegraphText $telegraphText): string
  {
    // sprintf — Возвращает отформатированную строку
    $templatePath = sprintf('templates/%s.swig', $this -> templateName); // путь к файлу шаблона
    $template = file_get_contents($templatePath); // для чтения содержимого файла

    foreach($this -> variables as $variables){
      $templateContent = str_replace('{{' . $variables . '}}', $telegraphText -> {$variables}, $template);
    }

    return $templateContent;
  }
}
