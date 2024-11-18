<?php

namespace Entities;

abstract class Storage
{
  // создать объект в хранилище
  abstract function create($object):string;

  // получить объект из хранилища
  abstract function read(string $slug);

  // обновить существующий объект в хранилище
  abstract function update(string $slug, $object): void;

  // удалить объект из хранилища
  abstract function delete(string $slug): void;

  // возвращает массив всех объектов в хранилище
  abstract function list(): array;
}
