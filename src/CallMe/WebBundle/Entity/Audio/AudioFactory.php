<?php
/**
 * Created by JetBrains PhpStorm.
 * User: maxpowers
 * Date: 10/20/14
 * Time: 7:48 PM
 * To change this template use File | Settings | File Templates.
 */

namespace CallMe\WebBundle\Entity\Audio;

use CallMe\WebBundle\Entity\Audio;

class AudioFactory
{

    /**
     * @param array $data
     * @return Audio
     */
    public function create(array $data)
    {
        return new Audio(
            isset($data['id']) ? $data['id'] : null,
            $data['uuid'],
            $data['user'],
            $data['name'],
            $data['file_path'],
            $data['created_at'],
            $data['updated_at']
        );
    }
}
