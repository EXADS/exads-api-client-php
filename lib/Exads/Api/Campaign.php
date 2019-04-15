<?php

namespace Exads\Api;

/**
 * @link   https://api.exads.com/v2/docs/index.html#!/campaigns
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
     * Get campaign groups.
     *
     * @param array $params
     *
     * @return array
     */
    public function groups(array $params = array())
    {
        $path = $this->getPath('groups');

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
        $path = $this->getPath('show', $id);

        return $this->put($path, $data);
    }

    /**
     * @param array $data
     */
    public function create(array $data = [])
    {
        $path = $this->getPath('all');

        return $this->post($path, $data);
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
     * @param   array   $data   array of campaign ids
     *
     * @return  string          json response
     */
    public function remove(array $data = [])
    {
        $path = $this->getPath('delete');

        return $this->put($path, $data);
    }

    /**
     * Pause a campaign.
     *
     * @param   array   $data   array of campaign ids
     *
     * @return  string          json response
     */
    public function pause(array $data = [])
    {
        $path = $this->getPath('pause');

        return $this->put($path, $data);
    }

    /**
     * Play a paused campaign.
     *
     * @param   array   $data   array of campaign ids
     *
     * @return  string          json response
     */
    public function play(array $data = [])
    {
        $path = $this->getPath('play');

        return $this->put($path, $data);
    }

    /**
     * Restore a deleted campaign.
     *
     * @param   array   $data   array of campaign ids
     *
     * @return  string          json response
     */
    public function restore(array $data = [])
    {
        $path = $this->getPath('restore');

        return $this->put($path, $data);
    }

    /**
     * Add new targeted/blocked element to a campaign.
     *
     * @param string $elementType [browsers|carriers|categories|countries|devices|languages|operating_systems|sites|keywords|ip_ranges]
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

    /**
     * Replace targeted/blocked element from a campaign.
     *
     * @param string $elementType [browsers|carriers|categories|countries|devices|languages|operating_systems|sites|keywords|ip_ranges]
     * @param string $id
     * @param string $type [targeted|blocked]
     * @param array $data
     *
     * @return boolean
     */
    public function replaceElement($elementType, $id, $type, array $data = array())
    {
        $path = $this->getPath($elementType, $id, $type);

        return $this->put($path, $data);
    }

    /**
     * Remove targeted/blocked element from a campaign.
     *
     * @param string $elementType [browsers|carriers|categories|countries|devices|languages|operating_systems|sites|keywords|ip_ranges]
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

    /**
     * Remove all targeted/blocked elements from a campaign.
     *
     * @param string $elementType [browsers|carriers|categories|countries|devices|languages|operating_systems|sites|keywords|ip_ranges]/all
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

    public function createVariation($campaignid, array $data = [])
    {
        $headers = [
            'Content-Type' => 'multipart/form-data'
        ];

        $path = $this->getPath('create_variation', $campaignid);

        return $this->post($path, $data, $headers);
    }

    /**
     * @param string $endPoint
     * @param string $id
     * @param string $type     [targeted|blocked]
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    protected function getPath($endPoint = null, $id = null, $type = null)
    {
        $pathMapping = array(
            'all' => '%s',
            'show' => '%s/%s',
            'groups' => '%s/groups',
            'copy' => '%s/%s/copy',
            'create_variation' => '%s/%s/variation',
            'delete' => '%s/delete',
            'pause' => '%s/pause',
            'play' => '%s/play',
            'restore' => '%s/restore',
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
     * @throws \InvalidArgumentException
     *
     * @return array
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
            'keywords',
            'ip_ranges',
        );

        // validate elementType
        $tmp = $elementTypes;
        foreach ($tmp as $type) {
            $tmp[] = $type.'_all';
        }
        if (!in_array($type, $tmp, true)) {
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
