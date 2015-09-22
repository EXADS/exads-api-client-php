<?php

namespace Exads\Api;

/**
 * @link   https://api.exads.com/v1/docs/index.html#!/campaigns
 */
class Campaign extends AbstractApi
{
    protected $apiGroup = 'campaigns';

    /**
     * Get campaigns.
     *
     * @param array $params
     *
     * @return array
     */
    public function all(array $params = array())
    {
        $path = $this->getPath('all');

        return $this->get($path, $params);
    }

    /**
     * Get campaign.
     *
     * @param string $id
     * @param array  $params
     *
     * @return array
     */
    public function show($id, array $params = array())
    {
        $path = $this->getPath('show', $id);

        return $this->get($path, $params);
    }

    /**
     * Update a campaign.
     *
     * @param string $id
     * @param array  $data
     *
     * @return array
     */
    public function update($id, array $data = array())
    {
        $path = $this->getPath('all');

        return $this->put($path, $data);
    }

    /**
     * Copy a campaign.
     *
     * @param string $id
     *
     * @return bool
     */
    public function copy($id)
    {
        $path = $this->getPath('copy', $id);

        return $this->put($path);
    }

    /**
     * Delete a campaign.
     *
     * @param string $id
     *
     * @return bool
     */
    public function remove($id)
    {
        $path = $this->getPath('delete', $id);

        return $this->put($path);
    }

    /**
     * Pause a campaign.
     *
     * @param string $id
     *
     * @return bool
     */
    public function pause($id)
    {
        $path = $this->getPath('pause', $id);

        return $this->put($path);
    }

    /**
     * Play a campaign.
     *
     * @param string $id
     *
     * @return bool
     */
    public function play($id)
    {
        $path = $this->getPath('play', $id);

        return $this->put($path);
    }

    /**
     * Restore a campaign.
     *
     * @param string $id
     *
     * @return bool
     */
    public function restore($id)
    {
        $path = $this->getPath('restore', $id);

        return $this->put($path);
    }

    /*
     * Add new targeted/blocked element to a campaign
     * @param string $elementType [browsers|carriers|categories|countries|devices|languages|operating_systems|sites]
     * @param string $id
     * @param string $type [targeted|blocked]
     * @param array $data
     *
     * @return boolean
     */
    public function addElement($elementType, $id, $type, array $data = array())
    {
        $path = $this->getPath($elementType, $id, $type);

        return $this->post($path, $data);
    }

    /*
     * Replace targeted/blocked element from a campaign
     * @param string $elementType [browsers|carriers|categories|countries|devices|languages|operating_systems|sites]
     * @param string $id
     * @param string $type [targeted|blocked]
     * @param array $data
     *
     * @return array
     */
    public function replaceElement($elementType, $id, $type, array $data = array())
    {
        $path = $this->getPath($elementType, $id, $type);

        return $this->put($path, $data);
    }

    /*
     * Remove targeted/blocked element from a campaign
     * @param string $elementType [browsers|carriers|categories|countries|devices|languages|operating_systems|sites]
     * @param string $id
     * @param string $type [targeted|blocked]
     * @param array $data
     *
     * @return boolean
     */
    public function removeElement($elementType, $id, $type, array $data = array())
    {
        $path = $this->getPath($elementType, $id, $type);

        return $this->delete($path, $data);
    }

    /*
     * Remove all targeted/blocked elements from a campaign
     * @param string $elementType [browsers|carriers|categories|countries|devices|languages|operating_systems|sites]/all
     * @param string $id
     * @param string $type [targeted|blocked]
     *
     * @return boolean
     */
    public function removeAllElements($elementType, $id, $type)
    {
        $path = $this->getPath($elementType.'_all', $id, $type);

        return $this->delete($path);
    }

    /**
     * @param string $endPoint
     * @param string $id
     * @param string $type     [targeted|blocked]
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    protected function getPath($endPoint = null, $id = null, $type = null)
    {
        $pathMapping = array(
            'all' => '%s',
            'show' => '%s/%s',
            'copy' => '%s/%s/copy',
            'delete' => '%s/%s/delete',
            'pause' => '%s/%s/pause',
            'play' => '%s/%s/play',
            'restore' => '%s/%s/restore',
        );

        if (null !== $type) {
            // add targeted/blocked elements routes
            $elementTypes = $this->getElementTypes($endPoint);
            foreach ($elementTypes as $elementType) {
                $pathMapping[$elementType] = '%s/%s/%s/'.$elementType;
                if ('countries' === $elementType) {
                    continue;
                }
                $pathMapping[$elementType.'_all'] = '%s/%s/%s/'.$elementType.'/all';
            }
        }
        if (!isset($pathMapping[$endPoint])) {
            throw new \InvalidArgumentException('Non existing path');
        }
        $path = $pathMapping[$endPoint];

        if (null === $id) {
            return sprintf($path, $this->apiGroup);
        }
        if (null === $type) {
            return sprintf($path, $this->apiGroup, urlencode($id));
        }

        return sprintf($path, $this->apiGroup, urlencode($id), urlencode($type));
    }

    /**
     * @param string $type
     *
     * @return array
     *
     * @throws InvalidArgumentException
     */
    private function getElementTypes($type)
    {
        $elementTypes = array(
            'browsers',
            'carriers',
            'categories',
            'countries',
            'devices',
            'languages',
            'operating_systems',
            'sites',
        );

        // validate elementType
        $tmp = $elementTypes;
        foreach ($tmp as $type) {
            $tmp[] = $type.'_all';
        }
        if (!in_array($type, $tmp)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Unknown element type "%s". Availabe types : %s',
                    $type,
                    implode(', ', $elementTypes)
                )
            );
        }

        return $elementTypes;
    }
}
