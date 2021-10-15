<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Storage;
use Illuminate\Support\Str;

/**
 * App\Services\Saver
 *
 * @property \Illuminate\Database\Eloquent\Model $instance
 * @property boolean $saved
 */
abstract class Saver
{
    protected $instance;
    protected $saved = false;
    protected $pathUploadsFiles = 'tmp/';
    protected $pathSavedFiles = 'documents/';

    abstract function __construct($instance = null);

    /*
    Пример, того что вы должны сделать, наследуясь от Saver
    function __construct($instance = null)
    {
        $this->instance = $instance ?? new Form();
    }
    */

    function getInstance()
    {
        return $this->instance;
    }

    function fill($data)
    {
        $this->instance->fill($data);

        return $this;
    }

    function save()
    {
        $this->saved = $this->instance->saveOrFail();

        return $this;
    }

    final function syncRelations(array $data, $instance, $relationName, $class)
    {
        $data = new Collection($data);

        $this->deleteRelations($data, $instance->$relationName);

        foreach ($data as $datum) {
            $this->updateOrCreateRelation($datum, $instance, $relationName, $class);
        }
    }

    final function deleteRelations(Collection $data, $relation)
    {
        /**
         * @var Model $model
         * @var Collection $relation
         */
        foreach ($relation AS $i => $model) {
            if (!$data->contains('id', $model->id)) {
                $model->delete();

                $relation->forget($i);
            }
        }
    }

    final function updateOrCreateRelation(array $datum, $instance, $relationName, $class)
    {
        /**
         * @var Model $model
         * @var Collection $relation
         */
        if (data_get($datum, 'id', 0) > 0) {
            $model = $instance->$relationName
                ->where('id', $datum['id'])
                ->shift();

            $model->update($datum);
        } else {
            $model = new $class($datum);

            $instance->$relationName()
                ->save($model);

            $instance->$relationName->add($model);
        }

        return $model;
    }

    function getTitleFile()
    {
        return $this->instance->title_file;
    }

    final function getPathSavedFile()
    {
        return $this->pathSavedFiles . $this->generateSlugTitleFile();
    }

    final function generateSlugTitleFile($titleFile = null)
    {
        return $this->instance->id . '-' . Str::slug(
                pathinfo($titleFile ?? $this->getTitleFile(), PATHINFO_FILENAME), '-') .
            '.' . pathinfo($titleFile ?? $this->getTitleFile(), PATHINFO_EXTENSION);
    }

    final function deleteSavedFile($titleFile = null)
    {
        Storage::delete($this->pathSavedFiles . $this->generateSlugTitleFile($titleFile));

        return $this;
    }

    final function deleteUploadsFiles()
    {
        Storage::delete(Storage::allFiles($this->pathUploadsFiles));

        return $this;
    }

    final function moveUploadFile($titleUploadFile)
    {
        Storage::move($this->pathUploadsFiles . $titleUploadFile,
            $this->pathSavedFiles . $this->generateSlugTitleFile());

        return $this;
    }

    final function uploadFile($uploadFile)
    {
        $titleFile = uniqid() . '.' . $uploadFile->getClientOriginalExtension();
        Storage::putFileAs($this->pathUploadsFiles, $uploadFile, $titleFile);

        return $titleFile;
    }
}
