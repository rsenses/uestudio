<?php

namespace Expomark\Upload;

use Exception;
use Upload\Storage\FileSystem;
use Upload\File;
use Upload\Validation\Mimetype;
use Upload\Validation\Size;
use Imagine\Gd\Imagine;
use Cocur\Slugify\Slugify;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\ListContainersOptions;
use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

class AuthorImage
{
    private $imagine;
    private $slugify;

    public function __construct()
    {
        $this->imagine = new Imagine();
        $this->slugify = new Slugify();
    }

    public function isExternalCdnEnaled()
    {
        if (isset($GLOBALS['env']['azure']['enable'])) {
            return $GLOBALS['env']['azure']['enable'];
        }
        return false;
    }

    public function upload($input)
    {
        if ($this->isExternalCdnEnaled()) {
            $connectionString = 'DefaultEndpointsProtocol=https;AccountName=' . $GLOBALS['env']['azure']['blob']['AccountName'] . ';AccountKey=' . $GLOBALS['env']['azure']['blob']['AccountKey'];
            $blobClient = BlobRestProxy::createBlobService($connectionString);
            $container = 'images';

            $this->createContainerIfNotExists($container, $blobClient);
        }

        $folder = $GLOBALS['config']['uploads_dir'] . 'images/';

        $storage = new FileSystem($folder . '/');

        $file = new File($input, $storage);

        $image = time() . '_' . $this->slugify->slugify($file->getName());

        $file->setName($image);
        $file->addValidations([
            new Mimetype(['image/jpeg', 'image/png', 'image/gif']),
            new Size('1100K'),
        ]);

        try {
            // Success!
            $file->upload();
            $imageName = $file->getNameWithExtension();

            if ($this->isExternalCdnEnaled()) {
                $content = fopen($folder . '/' . $imageName, 'r');
                $this->uploadBlob($container, 'author/' . $imageName, $content, $blobClient);
            }

            if ($this->isExternalCdnEnaled()) {
                unlink($folder . '/' . $imageName);
            }

            return $imageName;
        } catch (\Exception $e) {
            if ($file->getErrors()) {
                throw new Exception($file->getErrors()[0]);
            } else {
                throw new Exception($e->getMessage());
            }
        }
    }

    public function uploadBlob($container, $blob_name, $content, $blobClient)
    {
        try {
            //Upload blob
            $blobClient->createBlockBlob($container, $blob_name, $content);
        } catch (ServiceException $e) {
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code . ': ' . $error_message . PHP_EOL;
        }
    }

    public function createContainerIfNotExists($containerName, $blobClient)
    {
        // See if the container already exists.
        $listContainersOptions = new ListContainersOptions();
        $listContainersOptions->setPrefix($containerName);
        $listContainersResult = $blobClient->listContainers($listContainersOptions);
        $containerExists = false;
        $containers = $listContainersResult->getContainers();
        foreach ($containers as $container) {
            if ($container->getName() == $containerName) {
                // The container exists.
                $containerExists = true;
                // No need to keep checking.
                break;
            }
        }

        if (!$containerExists) {
            $this->createContainer($containerName, $blobClient);
        }
    }

    public function createContainer($containerName, $blobClient)
    {
        // OPTIONAL: Set public access policy and metadata.
        // Create container options object.
        $createContainerOptions = new CreateContainerOptions();
        // Set public access policy. Possible values are
        // PublicAccessType::CONTAINER_AND_BLOBS and PublicAccessType::BLOBS_ONLY.
        // CONTAINER_AND_BLOBS: full public read access for container and blob data.
        // BLOBS_ONLY: public read access for blobs. Container data not available.
        // If this value is not specified, container data is private to the account owner.
        $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);
        try {
            // Create container.
            $blobClient->createContainer($containerName, $createContainerOptions);
        } catch (ServiceException $e) {
            $code = $e->getCode();
            $error_message = $e->getMessage();
            echo $code . ': ' . $error_message . PHP_EOL;
        }
    }
}
