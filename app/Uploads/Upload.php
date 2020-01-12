<?php

namespace App\Uploads;


class Upload
{
    public $error;
    public $destination;
    public $newImgName;
    public $success;

    public function upload($file, $name)
    {
        $this->isImage($file, $name);
    }

    protected function isImage($file, $name)
    {

        $allowed_extensions = ['jpg', 'jpeg', 'gif', 'png'];
        $my_file_extension = pathinfo($file['name'], PATHINFO_EXTENSION);

        if (in_array($my_file_extension, $allowed_extensions))
            $this->isNotHeavy($file, $name, $my_file_extension);
        else $this->error = 'le fichier doit être une image';


    }

    protected function isNotHeavy($file, $name, $fileExtension)
    {
        if ($file['size'] > 5000000) $this->error = 'le fichier doit faire moins de 5Mo !';
        else $this->setDestination($file, $name, $fileExtension);
    }

    protected function setDestination($file, $newName, $fileExtension)
    {
        $destination = '../storage/images/' . $newName . '.' . $fileExtension;
        $this->setNewImage($file, $newName, $fileExtension, $destination);


    }

    protected function setNewImage($file, $newName, $fileExtension, $destination)
    {
        $newImg = $newName . '.' . $fileExtension;
        $this->alreadyExist($file, $destination);
        $this->newImgName = $newImg;
    }

    public function alreadyExist($file, $destination)
    {
        $files = glob('../storage/images/*');
        if (in_array($destination, $files)) {
            $this->error = 'ce nom d\'image est déjà utilisé !';
            $this->destination = '';
        } else {
            $this->destination = $destination;
            $this->success = 'upload reussi !';
            $this->moveTo($file, $destination);
        }

    }

    protected function moveTo($file, $destination)
    {
        move_uploaded_file($file['tmp_name'], $destination);

    }

}
