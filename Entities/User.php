<?php

namespace Entities;

abstract class User
{
  // protected для скрытия от прямого доступа извне
  protected  int $id;
  protected  string $name;
  protected  string $role;

  // присваивание переданных параметров
  function __construct(int $id, string $name, string $role)
  {
    $this -> id = $id;
    $this -> name = $name;
    $this -> role = $role;
  }

  // бстрактный метод getTextsToEdit, который выводит список доступных пользователю для редактирования текстов.
  abstract function getTextsToEdit():array;
}
