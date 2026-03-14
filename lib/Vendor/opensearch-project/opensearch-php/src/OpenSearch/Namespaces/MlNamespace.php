<?php

declare (strict_types=1);
/**
 * SPDX-License-Identifier: Apache-2.0
 *
 * The OpenSearch Contributors require contributions made to
 * this file be licensed under the Apache-2.0 license or a
 * compatible open source license.
 *
 * Modifications Copyright OpenSearch Contributors. See
 * GitHub history for details.
 */
namespace OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Namespaces;

use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\AddAgenticMemory;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\ChunkModel;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\CreateConnector;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\CreateController;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\CreateMemory;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\CreateMemoryContainer;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\CreateMemoryContainerSession;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\CreateMessage;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\CreateModelMeta;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\DeleteAgent;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\DeleteAgenticMemory;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\DeleteAgenticMemoryQuery;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\DeleteConnector;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\DeleteController;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\DeleteMemory;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\DeleteMemoryContainer;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\DeleteModel;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\DeleteModelGroup;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\DeleteTask;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\DeployModel;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\ExecuteAgent;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\ExecuteAgentStream;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\ExecuteAlgorithm;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\ExecuteTool;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetAgent;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetAgenticMemory;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetAllMemories;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetAllMessages;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetAllTools;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetConnector;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetConnectors;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetController;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetMemory;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetMemoryContainer;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetMessage;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetMessageTraces;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetModel;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetModelGroup;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetModelGroups;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetProfile;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetProfileModels;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetProfileTasks;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetStats;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetTask;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\GetTool;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\LoadModel;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\Predict;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\PredictModel;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\PredictModelStream;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\RegisterAgents;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\RegisterModel;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\RegisterModelGroup;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\RegisterModelMeta;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\SearchAgenticMemory;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\SearchAgents;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\SearchConnectors;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\SearchMemory;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\SearchMemoryContainer;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\SearchMessage;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\SearchModelGroup;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\SearchModels;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\SearchTasks;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\Train;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\TrainPredict;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\UndeployModel;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\UnloadModel;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\UpdateAgenticMemory;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\UpdateConnector;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\UpdateController;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\UpdateMemory;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\UpdateMemoryContainer;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\UpdateMessage;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\UpdateModel;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\UpdateModelGroup;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\UploadChunk;
use OCA\FullTextSearch_OpenSearch\Vendor\OpenSearch\Endpoints\Ml\UploadModel;
/**
 * Class MlNamespace
 *
 * NOTE: This file is autogenerated using util/GenerateEndpoints.php
 */
class MlNamespace extends AbstractNamespace
{
    /**
     * Add agentic memory to a memory container.
     *
     * $params['memory_container_id'] = (string)
     * $params['pretty']              = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']               = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace']         = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']              = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path']         = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function addAgenticMemory(array $params = [])
    {
        $memory_container_id = $this->extractArgument($params, 'memory_container_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(AddAgenticMemory::class);
        $endpoint->setParams($params);
        $endpoint->setMemoryContainerId($memory_container_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Uploads model chunk.
     *
     * $params['chunk_number'] = (integer)
     * $params['model_id']     = (string)
     * $params['pretty']       = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']        = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace']  = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']       = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path']  = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function chunkModel(array $params = [])
    {
        $chunk_number = $this->extractArgument($params, 'chunk_number');
        $model_id = $this->extractArgument($params, 'model_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(ChunkModel::class);
        $endpoint->setParams($params);
        $endpoint->setChunkNumber($chunk_number);
        $endpoint->setModelId($model_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Creates a controller.
     *
     * $params['model_id']    = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function createController(array $params = [])
    {
        $model_id = $this->extractArgument($params, 'model_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(CreateController::class);
        $endpoint->setParams($params);
        $endpoint->setModelId($model_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Create a memory.
     *
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function createMemory(array $params = [])
    {
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(CreateMemory::class);
        $endpoint->setParams($params);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Create a memory container.
     *
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function createMemoryContainer(array $params = [])
    {
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(CreateMemoryContainer::class);
        $endpoint->setParams($params);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Create session in a memory container.
     *
     * $params['memory_container_id'] = (string)
     * $params['pretty']              = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']               = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace']         = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']              = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path']         = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function createMemoryContainerSession(array $params = [])
    {
        $memory_container_id = $this->extractArgument($params, 'memory_container_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(CreateMemoryContainerSession::class);
        $endpoint->setParams($params);
        $endpoint->setMemoryContainerId($memory_container_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Create a message.
     *
     * $params['memory_id']   = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function createMessage(array $params = [])
    {
        $memory_id = $this->extractArgument($params, 'memory_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(CreateMessage::class);
        $endpoint->setParams($params);
        $endpoint->setMemoryId($memory_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Registers model metadata.
     *
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function createModelMeta(array $params = [])
    {
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(CreateModelMeta::class);
        $endpoint->setParams($params);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Delete an agent.
     *
     * $params['agent_id']    = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function deleteAgent(array $params = [])
    {
        $agent_id = $this->extractArgument($params, 'agent_id');
        $endpoint = $this->endpointFactory->getEndpoint(DeleteAgent::class);
        $endpoint->setParams($params);
        $endpoint->setAgentId($agent_id);
        return $this->performRequest($endpoint);
    }
    /**
     * Delete a specific memory by its type and ID.
     *
     * $params['id']                  = (string)
     * $params['memory_container_id'] = (string)
     * $params['type']                = DEPRECATED (string)
     * $params['pretty']              = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']               = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace']         = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']              = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path']         = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function deleteAgenticMemory(array $params = [])
    {
        $id = $this->extractArgument($params, 'id');
        $memory_container_id = $this->extractArgument($params, 'memory_container_id');
        $type = $this->extractArgument($params, 'type');
        $endpoint = $this->endpointFactory->getEndpoint(DeleteAgenticMemory::class);
        $endpoint->setParams($params);
        $endpoint->setId($id);
        $endpoint->setMemoryContainerId($memory_container_id);
        $endpoint->setType($type);
        return $this->performRequest($endpoint);
    }
    /**
     * Delete multiple memories using a query to match specific criteria.
     *
     * $params['memory_container_id'] = (string)
     * $params['type']                = DEPRECATED (string)
     * $params['pretty']              = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']               = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace']         = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']              = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path']         = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function deleteAgenticMemoryQuery(array $params = [])
    {
        $memory_container_id = $this->extractArgument($params, 'memory_container_id');
        $type = $this->extractArgument($params, 'type');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(DeleteAgenticMemoryQuery::class);
        $endpoint->setParams($params);
        $endpoint->setMemoryContainerId($memory_container_id);
        $endpoint->setType($type);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Deletes a controller.
     *
     * $params['model_id']    = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function deleteController(array $params = [])
    {
        $model_id = $this->extractArgument($params, 'model_id');
        $endpoint = $this->endpointFactory->getEndpoint(DeleteController::class);
        $endpoint->setParams($params);
        $endpoint->setModelId($model_id);
        return $this->performRequest($endpoint);
    }
    /**
     * Delete a memory.
     *
     * $params['memory_id']   = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function deleteMemory(array $params = [])
    {
        $memory_id = $this->extractArgument($params, 'memory_id');
        $endpoint = $this->endpointFactory->getEndpoint(DeleteMemory::class);
        $endpoint->setParams($params);
        $endpoint->setMemoryId($memory_id);
        return $this->performRequest($endpoint);
    }
    /**
     * Delete a memory container.
     *
     * $params['memory_container_id'] = (string)
     * $params['delete_all_memories'] = (boolean)  (Default = false)
     * $params['delete_memories']     = (array)
     * $params['pretty']              = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']               = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace']         = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']              = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path']         = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function deleteMemoryContainer(array $params = [])
    {
        $memory_container_id = $this->extractArgument($params, 'memory_container_id');
        $endpoint = $this->endpointFactory->getEndpoint(DeleteMemoryContainer::class);
        $endpoint->setParams($params);
        $endpoint->setMemoryContainerId($memory_container_id);
        return $this->performRequest($endpoint);
    }
    /**
     * Deletes a model.
     *
     * $params['id']          = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function deleteModel(array $params = [])
    {
        $id = $this->extractArgument($params, 'id');
        $endpoint = $this->endpointFactory->getEndpoint(DeleteModel::class);
        $endpoint->setParams($params);
        $endpoint->setId($id);
        return $this->performRequest($endpoint);
    }
    /**
     * Deletes a model group.
     *
     * $params['id']          = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function deleteModelGroup(array $params = [])
    {
        $id = $this->extractArgument($params, 'id');
        $endpoint = $this->endpointFactory->getEndpoint(DeleteModelGroup::class);
        $endpoint->setParams($params);
        $endpoint->setId($id);
        return $this->performRequest($endpoint);
    }
    /**
     * Deletes a task.
     *
     * $params['task_id']     = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function deleteTask(array $params = [])
    {
        $task_id = $this->extractArgument($params, 'task_id');
        $endpoint = $this->endpointFactory->getEndpoint(DeleteTask::class);
        $endpoint->setParams($params);
        $endpoint->setTaskId($task_id);
        return $this->performRequest($endpoint);
    }
    /**
     * Execute an agent.
     *
     * $params['agent_id']    = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function executeAgent(array $params = [])
    {
        $agent_id = $this->extractArgument($params, 'agent_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(ExecuteAgent::class);
        $endpoint->setParams($params);
        $endpoint->setAgentId($agent_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Execute an agent in streaming mode.
     *
     * $params['agent_id']    = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function executeAgentStream(array $params = [])
    {
        $agent_id = $this->extractArgument($params, 'agent_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(ExecuteAgentStream::class);
        $endpoint->setParams($params);
        $endpoint->setAgentId($agent_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Execute an algorithm.
     *
     * $params['algorithm_name'] = (string)
     * $params['pretty']         = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']          = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace']    = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']         = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path']    = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function executeAlgorithm(array $params = [])
    {
        $algorithm_name = $this->extractArgument($params, 'algorithm_name');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(ExecuteAlgorithm::class);
        $endpoint->setParams($params);
        $endpoint->setAlgorithmName($algorithm_name);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Execute a tool.
     *
     * $params['tool_name']   = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function executeTool(array $params = [])
    {
        $tool_name = $this->extractArgument($params, 'tool_name');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(ExecuteTool::class);
        $endpoint->setParams($params);
        $endpoint->setToolName($tool_name);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Get an agent.
     *
     * $params['agent_id']    = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function getAgent(array $params = [])
    {
        $agent_id = $this->extractArgument($params, 'agent_id');
        $endpoint = $this->endpointFactory->getEndpoint(GetAgent::class);
        $endpoint->setParams($params);
        $endpoint->setAgentId($agent_id);
        return $this->performRequest($endpoint);
    }
    /**
     * Get a specific memory by its type and ID.
     *
     * $params['id']                  = (string)
     * $params['memory_container_id'] = (string)
     * $params['type']                = DEPRECATED (string)
     * $params['pretty']              = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']               = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace']         = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']              = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path']         = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function getAgenticMemory(array $params = [])
    {
        $id = $this->extractArgument($params, 'id');
        $memory_container_id = $this->extractArgument($params, 'memory_container_id');
        $type = $this->extractArgument($params, 'type');
        $endpoint = $this->endpointFactory->getEndpoint(GetAgenticMemory::class);
        $endpoint->setParams($params);
        $endpoint->setId($id);
        $endpoint->setMemoryContainerId($memory_container_id);
        $endpoint->setType($type);
        return $this->performRequest($endpoint);
    }
    /**
     * Get all memories.
     *
     * $params['max_results'] = (integer)
     * $params['next_token']  = (integer)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function getAllMemories(array $params = [])
    {
        $endpoint = $this->endpointFactory->getEndpoint(GetAllMemories::class);
        $endpoint->setParams($params);
        return $this->performRequest($endpoint);
    }
    /**
     * Get all messages in a memory.
     *
     * $params['memory_id']   = (string)
     * $params['max_results'] = (integer)
     * $params['next_token']  = (integer)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function getAllMessages(array $params = [])
    {
        $memory_id = $this->extractArgument($params, 'memory_id');
        $endpoint = $this->endpointFactory->getEndpoint(GetAllMessages::class);
        $endpoint->setParams($params);
        $endpoint->setMemoryId($memory_id);
        return $this->performRequest($endpoint);
    }
    /**
     * Get tools.
     *
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function getAllTools(array $params = [])
    {
        $endpoint = $this->endpointFactory->getEndpoint(GetAllTools::class);
        $endpoint->setParams($params);
        return $this->performRequest($endpoint);
    }
    /**
     * Retrieves a controller.
     *
     * $params['model_id']    = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function getController(array $params = [])
    {
        $model_id = $this->extractArgument($params, 'model_id');
        $endpoint = $this->endpointFactory->getEndpoint(GetController::class);
        $endpoint->setParams($params);
        $endpoint->setModelId($model_id);
        return $this->performRequest($endpoint);
    }
    /**
     * Get a memory.
     *
     * $params['memory_id']   = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function getMemory(array $params = [])
    {
        $memory_id = $this->extractArgument($params, 'memory_id');
        $endpoint = $this->endpointFactory->getEndpoint(GetMemory::class);
        $endpoint->setParams($params);
        $endpoint->setMemoryId($memory_id);
        return $this->performRequest($endpoint);
    }
    /**
     * Get a memory container.
     *
     * $params['memory_container_id'] = (string)
     * $params['pretty']              = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']               = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace']         = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']              = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path']         = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function getMemoryContainer(array $params = [])
    {
        $memory_container_id = $this->extractArgument($params, 'memory_container_id');
        $endpoint = $this->endpointFactory->getEndpoint(GetMemoryContainer::class);
        $endpoint->setParams($params);
        $endpoint->setMemoryContainerId($memory_container_id);
        return $this->performRequest($endpoint);
    }
    /**
     * Get a message.
     *
     * $params['message_id']  = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function getMessage(array $params = [])
    {
        $message_id = $this->extractArgument($params, 'message_id');
        $endpoint = $this->endpointFactory->getEndpoint(GetMessage::class);
        $endpoint->setParams($params);
        $endpoint->setMessageId($message_id);
        return $this->performRequest($endpoint);
    }
    /**
     * Get a message traces.
     *
     * $params['message_id']  = (string)
     * $params['max_results'] = (integer)
     * $params['next_token']  = (integer)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function getMessageTraces(array $params = [])
    {
        $message_id = $this->extractArgument($params, 'message_id');
        $endpoint = $this->endpointFactory->getEndpoint(GetMessageTraces::class);
        $endpoint->setParams($params);
        $endpoint->setMessageId($message_id);
        return $this->performRequest($endpoint);
    }
    /**
     * Retrieves a model group.
     *
     * $params['model_group_id'] = (string)
     * $params['pretty']         = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']          = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace']    = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']         = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path']    = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function getModelGroup(array $params = [])
    {
        $model_group_id = $this->extractArgument($params, 'model_group_id');
        $endpoint = $this->endpointFactory->getEndpoint(GetModelGroup::class);
        $endpoint->setParams($params);
        $endpoint->setModelGroupId($model_group_id);
        return $this->performRequest($endpoint);
    }
    /**
     * Get a profile.
     *
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function getProfile(array $params = [])
    {
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(GetProfile::class);
        $endpoint->setParams($params);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Get a profile models.
     *
     * $params['model_id']    = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function getProfileModels(array $params = [])
    {
        $model_id = $this->extractArgument($params, 'model_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(GetProfileModels::class);
        $endpoint->setParams($params);
        $endpoint->setModelId($model_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Get a profile tasks.
     *
     * $params['task_id']     = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function getProfileTasks(array $params = [])
    {
        $task_id = $this->extractArgument($params, 'task_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(GetProfileTasks::class);
        $endpoint->setParams($params);
        $endpoint->setTaskId($task_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Get stats.
     *
     * $params['node_id']     = (string)
     * $params['stat']        = (array)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function getStats(array $params = [])
    {
        $node_id = $this->extractArgument($params, 'node_id');
        $stat = $this->extractArgument($params, 'stat');
        $endpoint = $this->endpointFactory->getEndpoint(GetStats::class);
        $endpoint->setParams($params);
        $endpoint->setNodeId($node_id);
        $endpoint->setStat($stat);
        return $this->performRequest($endpoint);
    }
    /**
     * Retrieves a task.
     *
     * $params['id']          = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function getTask(array $params = [])
    {
        $id = $this->extractArgument($params, 'id');
        $endpoint = $this->endpointFactory->getEndpoint(GetTask::class);
        $endpoint->setParams($params);
        $endpoint->setId($id);
        return $this->performRequest($endpoint);
    }
    /**
     * Get tools.
     *
     * $params['tool_name']   = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function getTool(array $params = [])
    {
        $tool_name = $this->extractArgument($params, 'tool_name');
        $endpoint = $this->endpointFactory->getEndpoint(GetTool::class);
        $endpoint->setParams($params);
        $endpoint->setToolName($tool_name);
        return $this->performRequest($endpoint);
    }
    /**
     * Deploys a model.
     *
     * $params['model_id']    = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function loadModel(array $params = [])
    {
        $model_id = $this->extractArgument($params, 'model_id');
        $endpoint = $this->endpointFactory->getEndpoint(LoadModel::class);
        $endpoint->setParams($params);
        $endpoint->setModelId($model_id);
        return $this->performRequest($endpoint);
    }
    /**
     * Predicts a model.
     *
     * $params['model_id']    = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function predictModel(array $params = [])
    {
        $model_id = $this->extractArgument($params, 'model_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(PredictModel::class);
        $endpoint->setParams($params);
        $endpoint->setModelId($model_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Predicts a model in streaming mode.
     *
     * $params['model_id']    = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function predictModelStream(array $params = [])
    {
        $model_id = $this->extractArgument($params, 'model_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(PredictModelStream::class);
        $endpoint->setParams($params);
        $endpoint->setModelId($model_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Register an agent.
     *
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function registerAgents(array $params = [])
    {
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(RegisterAgents::class);
        $endpoint->setParams($params);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Registers a model.
     *
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function registerModel(array $params = [])
    {
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(RegisterModel::class);
        $endpoint->setParams($params);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Registers a model group.
     *
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function registerModelGroup(array $params = [])
    {
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(RegisterModelGroup::class);
        $endpoint->setParams($params);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Registers model metadata.
     *
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function registerModelMeta(array $params = [])
    {
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(RegisterModelMeta::class);
        $endpoint->setParams($params);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Search for memories of a specific type within a memory container.
     *
     * $params['memory_container_id'] = (string)
     * $params['type']                = DEPRECATED (string)
     * $params['pretty']              = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']               = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace']         = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']              = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path']         = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function searchAgenticMemory(array $params = [])
    {
        $memory_container_id = $this->extractArgument($params, 'memory_container_id');
        $type = $this->extractArgument($params, 'type');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(SearchAgenticMemory::class);
        $endpoint->setParams($params);
        $endpoint->setMemoryContainerId($memory_container_id);
        $endpoint->setType($type);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Search agents.
     *
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function searchAgents(array $params = [])
    {
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(SearchAgents::class);
        $endpoint->setParams($params);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Searches for standalone connectors.
     *
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function searchConnectors(array $params = [])
    {
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(SearchConnectors::class);
        $endpoint->setParams($params);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Search memory.
     *
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function searchMemory(array $params = [])
    {
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(SearchMemory::class);
        $endpoint->setParams($params);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Search memory containers.
     *
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function searchMemoryContainer(array $params = [])
    {
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(SearchMemoryContainer::class);
        $endpoint->setParams($params);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Search messages.
     *
     * $params['memory_id']   = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function searchMessage(array $params = [])
    {
        $memory_id = $this->extractArgument($params, 'memory_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(SearchMessage::class);
        $endpoint->setParams($params);
        $endpoint->setMemoryId($memory_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Searches for model groups.
     *
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function searchModelGroup(array $params = [])
    {
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(SearchModelGroup::class);
        $endpoint->setParams($params);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Searches for models.
     *
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function searchModels(array $params = [])
    {
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(SearchModels::class);
        $endpoint->setParams($params);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Searches for tasks.
     *
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function searchTasks(array $params = [])
    {
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(SearchTasks::class);
        $endpoint->setParams($params);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Trains a model synchronously.
     *
     * $params['algorithm_name'] = (string)
     * $params['pretty']         = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']          = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace']    = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']         = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path']    = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function train(array $params = [])
    {
        $algorithm_name = $this->extractArgument($params, 'algorithm_name');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(Train::class);
        $endpoint->setParams($params);
        $endpoint->setAlgorithmName($algorithm_name);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Trains a model and predicts against the same training dataset.
     *
     * $params['algorithm_name'] = (string)
     * $params['pretty']         = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']          = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace']    = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']         = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path']    = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function trainPredict(array $params = [])
    {
        $algorithm_name = $this->extractArgument($params, 'algorithm_name');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(TrainPredict::class);
        $endpoint->setParams($params);
        $endpoint->setAlgorithmName($algorithm_name);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Unloads a model.
     *
     * $params['model_id']    = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function unloadModel(array $params = [])
    {
        $model_id = $this->extractArgument($params, 'model_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(UnloadModel::class);
        $endpoint->setParams($params);
        $endpoint->setModelId($model_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Update a specific memory by its type and ID.
     *
     * $params['id']                  = (string)
     * $params['memory_container_id'] = (string)
     * $params['type']                = DEPRECATED (string)
     * $params['pretty']              = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']               = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace']         = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']              = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path']         = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function updateAgenticMemory(array $params = [])
    {
        $id = $this->extractArgument($params, 'id');
        $memory_container_id = $this->extractArgument($params, 'memory_container_id');
        $type = $this->extractArgument($params, 'type');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(UpdateAgenticMemory::class);
        $endpoint->setParams($params);
        $endpoint->setId($id);
        $endpoint->setMemoryContainerId($memory_container_id);
        $endpoint->setType($type);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Updates a standalone connector.
     *
     * $params['connector_id'] = (string)
     * $params['pretty']       = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']        = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace']  = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']       = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path']  = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function updateConnector(array $params = [])
    {
        $connector_id = $this->extractArgument($params, 'connector_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(UpdateConnector::class);
        $endpoint->setParams($params);
        $endpoint->setConnectorId($connector_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Updates a controller.
     *
     * $params['model_id']    = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function updateController(array $params = [])
    {
        $model_id = $this->extractArgument($params, 'model_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(UpdateController::class);
        $endpoint->setParams($params);
        $endpoint->setModelId($model_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Update a memory.
     *
     * $params['memory_id']   = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function updateMemory(array $params = [])
    {
        $memory_id = $this->extractArgument($params, 'memory_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(UpdateMemory::class);
        $endpoint->setParams($params);
        $endpoint->setMemoryId($memory_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Update a memory container.
     *
     * $params['memory_container_id'] = (string)
     * $params['pretty']              = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']               = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace']         = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']              = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path']         = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function updateMemoryContainer(array $params = [])
    {
        $memory_container_id = $this->extractArgument($params, 'memory_container_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(UpdateMemoryContainer::class);
        $endpoint->setParams($params);
        $endpoint->setMemoryContainerId($memory_container_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Update a message.
     *
     * $params['message_id']  = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function updateMessage(array $params = [])
    {
        $message_id = $this->extractArgument($params, 'message_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(UpdateMessage::class);
        $endpoint->setParams($params);
        $endpoint->setMessageId($message_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Updates a model.
     *
     * $params['model_id']    = (string)
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function updateModel(array $params = [])
    {
        $model_id = $this->extractArgument($params, 'model_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(UpdateModel::class);
        $endpoint->setParams($params);
        $endpoint->setModelId($model_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Uploads model chunk.
     *
     * $params['chunk_number'] = (integer)
     * $params['model_id']     = (string)
     * $params['pretty']       = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']        = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace']  = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']       = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path']  = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function uploadChunk(array $params = [])
    {
        $chunk_number = $this->extractArgument($params, 'chunk_number');
        $model_id = $this->extractArgument($params, 'model_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(UploadChunk::class);
        $endpoint->setParams($params);
        $endpoint->setChunkNumber($chunk_number);
        $endpoint->setModelId($model_id);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * Registers a model.
     *
     * $params['pretty']      = (boolean) Whether to pretty-format the returned JSON response. (Default = false)
     * $params['human']       = (boolean) Whether to return human-readable values for statistics. (Default = false)
     * $params['error_trace'] = (boolean) Whether to include the stack trace of returned errors. (Default = false)
     * $params['source']      = (string) The URL-encoded request definition. Useful for libraries that do not accept a request body for non-POST requests.
     * $params['filter_path'] = (any) A comma-separated list of filters used to filter the response. Use wildcards to match any field or part of a field's name. To exclude fields, use `-`.
     *
     * @param array $params Associative array of parameters
     * @return array
     */
    public function uploadModel(array $params = [])
    {
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(UploadModel::class);
        $endpoint->setParams($params);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * $params['body']             = (string) The body of the request (Required)
     *
     * @param array $params Associative array of parameters
     *
     * @return array
     *   The response.
     */
    public function createConnector(array $params = []): array
    {
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(CreateConnector::class);
        $endpoint->setParams($params);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * $params['connector_id'] = (string) The id of the connector (Required)
     *
     * @param array $params Associative array of parameters
     *
     * @return array
     *   The response.
     */
    public function deleteConnector(array $params = []): array
    {
        $connectorId = $this->extractArgument($params, 'connector_id');
        $endpoint = $this->endpointFactory->getEndpoint(DeleteConnector::class);
        $endpoint->setParams($params);
        $endpoint->setConnectorId($connectorId);
        return $this->performRequest($endpoint);
    }
    /**
     * $params['model_id']       = (string) The id of the model (Required)
     * $params['body']           = (string) The body of the request
     *
     * @param array $params Associative array of parameters
     *
     * @return array
     *   The response.
     */
    public function deployModel(array $params = []): array
    {
        $modelId = $this->extractArgument($params, 'model_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(DeployModel::class);
        $endpoint->setParams($params);
        $endpoint->setModelId($modelId);
        if ($body) {
            $endpoint->setBody($body);
        }
        return $this->performRequest($endpoint);
    }
    /**
     * $params['id']             = (string) The id of the connector (Required)
     *
     * @param array $params Associative array of parameters
     *
     * @return array
     *   The response.
     */
    public function getConnector(array $params = []): array
    {
        $id = $this->extractArgument($params, 'id');
        $connector_id = $this->extractArgument($params, 'connector_id');
        $endpoint = $this->endpointFactory->getEndpoint(GetConnector::class);
        $endpoint->setParams($params);
        $endpoint->setId($id);
        $endpoint->setConnectorId($connector_id);
        return $this->performRequest($endpoint);
    }
    /**
     * $params['body']             = (string) The body of the request
     *
     * @param array $params Associative array of parameters
     *
     * @return array
     *   The response.
     */
    public function getConnectors(array $params = []): array
    {
        if (!isset($params['body'])) {
            $params['body'] = ['query' => ['match_all' => new \StdClass()], 'size' => 1000];
        }
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(GetConnectors::class);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * $params['body']             = (string) The body of the request
     *
     * @param array $params Associative array of parameters
     *
     * @return array
     *   The response.
     */
    public function getModelGroups(array $params = []): array
    {
        if (!isset($params['body'])) {
            $params['body'] = ['query' => ['match_all' => new \StdClass()], 'size' => 1000];
        }
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(GetModelGroups::class);
        $endpoint->setBody($body);
        return $this->performRequest($endpoint);
    }
    /**
     * $params['id']             = (string) The id of the model (Required)
     *
     * @param array $params Associative array of parameters
     *
     * @return array
     *   The response.
     */
    public function getModel(array $params = []): array
    {
        $id = $this->extractArgument($params, 'id');
        $model_id = $this->extractArgument($params, 'model_id');
        $endpoint = $this->endpointFactory->getEndpoint(GetModel::class);
        $endpoint->setParams($params);
        $endpoint->setId($id);
        $endpoint->setModelId($model_id);
        return $this->performRequest($endpoint);
    }
    /**
     * Proxy function to getModels() to prevent BC break.
     * This API will be removed in a future version. Use 'searchModels' API instead.
     */
    public function getModels(array $params = [])
    {
        if (!isset($params['body'])) {
            $params['body'] = ['query' => ['match_all' => new \StdClass()], 'size' => 1000];
        }
        return $this->searchModels($params);
    }
    /**
     * $params['id']             = (string) The id of the model (Required)
     * $params['body']           = (string) The body of the request
     *
     * @param array $params Associative array of parameters
     *
     * @return array
     *   The response.
     */
    public function predict(array $params = []): array
    {
        $id = $this->extractArgument($params, 'id');
        $body = $this->extractArgument($params, 'body');
        $algorithm_name = $this->extractArgument($params, 'algorithm_name');
        $model_id = $this->extractArgument($params, 'model_id');
        $endpoint = $this->endpointFactory->getEndpoint(Predict::class);
        $endpoint->setParams($params)->setId($id)->setBody($body)->setAlgorithmName($algorithm_name)->setModelId($model_id);
        return $this->performRequest($endpoint);
    }
    /**
     * $params['model_id']       = (string) The id of the model (Required)
     * $params['body']           = (string) The body of the request
     *
     * @param array $params Associative array of parameters
     *
     * @return array
     *   The response.
     */
    public function undeployModel(array $params = []): array
    {
        $modelId = $this->extractArgument($params, 'model_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(UndeployModel::class);
        $endpoint->setParams($params);
        $endpoint->setModelId($modelId);
        if ($body) {
            $endpoint->setBody($body);
        }
        return $this->performRequest($endpoint);
    }
    /**
     * $params['id']             = (string) The id of the model group (Required)
     * $params['body']           = (array) The body of the request (Required)
     *
     * @param array $params Associative array of parameters
     *
     * @return array
     *   The response.
     */
    public function updateModelGroup(array $params = []): array
    {
        $id = $this->extractArgument($params, 'id');
        $model_group_id = $this->extractArgument($params, 'model_group_id');
        $body = $this->extractArgument($params, 'body');
        $endpoint = $this->endpointFactory->getEndpoint(UpdateModelGroup::class);
        $endpoint->setParams($params);
        $endpoint->setBody($body);
        $endpoint->setId($id);
        $endpoint->setModelGroupId($model_group_id);
        return $this->performRequest($endpoint);
    }
}
