<?php
/**
 * Created by JetBrains PhpStorm.
 * User: maxpowers
 * Date: 9/28/14
 * Time: 6:32 PM
 * To change this template use File | Settings | File Templates.
 */

namespace CallMe\WebBundle\Service;

use Aws\S3\S3Client;
use CallMe\WebBundle\Entity\User;

class UploadAudio
{
    /**
     * @var AudioManager
     */
    protected $audioManager;
    /**
     * @var S3Client
     */
    protected $s3Client;

    /**
     * @param AudioManager $audioManager
     * @param S3Client $s3Client
     */
    public function __construct(AudioManager $audioManager, S3Client $s3Client)
    {
        $this->audioManager = $audioManager;
        $this->s3Client = $s3Client;
    }

    /**
     * @param $name
     * @param $audioFile
     * @param User $user
     * @return Audio
     */
    public function uploadAudio($name, $audioFile, User $user)
    {
        if (!$this->s3Client->doesBucketExist($user->getEmail())) {
            $this->s3Client->createBucket(['Bucket' => $user->getEmail()]);
        }

        $response = $this->s3Client->putObject([
            'Bucket'       => $user->getEmail(),
            'Key'          => $name, // @TODO: Figure out randomized name
            'SourceFile'   => $audioFile,
            'ContentType'  => 'audio/x-mpeg-3'
        ]);

        //@TODO handle when response fails

        return $this->audioManager->createRecord($user, $name, $response['ObjectUrl']);
    }
}
