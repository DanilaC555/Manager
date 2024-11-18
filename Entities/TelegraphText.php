<?php

namespace Entities;
use Exception;

class CharactersLong extends Exception {}

class TelegraphText
{
  public string $title;
  public string $text;
  public string $slug;

  public function __construct(string $title, string $slug)
  {
    $this -> title = $title;
    $this -> text = '';
    $this -> slug = $slug;
  }

  public function editText(string $title, string $text): void
  {
    if(strlen($text) < 1 || strlen($text) > 500){
      throw new CharactersLong('The text must be between 1 and 500 characters long.');
    }

    $this -> title = $title;
    $this -> text = $text;
  }
}
