<?php

namespace Entities;

class FileStorage extends Storage
{
  // приватное поле которое хранит путь
  private string $directoryPath;

  public function __construct(string $directoryPath){
    $this -> directoryPath = $directoryPath;
  }

  // для генерации полного пути к файлу
  private function getFilePath(string $slug): string
  {
    return $this -> directoryPath . DIRECTORY_SEPARATOR . $slug . ".txt";
  }

  // для сохранения объекта
  public function create($object): string
  {
      $slug = $object->slug . "_" . date('Y-m-d-H');
      $counterFile = 0; // счётчик для добавления цифры к файлу
      $fileName = $this -> getFilePath($slug);

      // проверяем, существует ли файл с таким именем
      while (file_exists($fileName)) {
          $counterFile++;
          $fileName = $this -> getFilePath($slug . "_$counterFile");
      }

      // сохраняем объект в файл сериализуя его
      file_put_contents($fileName, serialize($object));

      return $slug . ($counterFile > 0 ? "_$counterFile" : "");
  }

  public function read(string $slug)
  {
    $file = $this -> getFilePath($slug);
    if(file_exists($file)) {
      return unserialize(file_get_contents($file));
    }

    return null;
  }

  public function update(string $slug, $object): void
  {
    $file = $this -> getFilePath($slug);
    if(file_exists($file)) {
      file_put_contents($file, serialize($object));
    }
  }

  public function delete(string $slug): void
  {
    $file = $this -> getFilePath($slug);
    if(file_exists($file)) {
      unlink($file); // unlink — Удаляет файл
    }
  }

  public function list(): array
  {
    $fileDir = scandir($this -> directoryPath);
    $objectFile = [];

    foreach ($fileDir as $file) {
        // исключаем служебные файлы
        if ($file === '.' || $file === '..') {
            continue;
        }

        // полный путь к файлу
        $filePath = $this -> directoryPath . DIRECTORY_SEPARATOR . $file;

        // является ли файл файлом, а не директорией
        if (is_file($filePath)) {
            $objectFile[] = unserialize(file_get_contents($filePath));
        }
    }

    return $objectFile;
  }
}
