<?php

namespace App\Http\Controllers\Api\V1;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * Take the input data validate and create.
     *
     * @param \Illuminate\Database\Eloquent\Model $entry
     * @param array $data
     * @return \Illuminate\Http\Response
     */
    protected function createEntry($entry, $data)
    {
        // Validate the filtered request against the rules.
        $validator = Validator::make($data, $this->validationRules);

        // In case of failure return, what could not be validated
        if ($validator->fails()) {
            return $this->respondWithError(422, $validator->errors());
        }

        // Create the entry at the database and get the id of the entry
        $id = $entry->create($data)->id;

        // No body but the location of the created entry is returned at the head
        return response('', 201)->header('Location', $this->baseUrl . $id);
    }

    /**
     * Take the input data validate and update.
     *
     * @param \Illuminate\Database\Eloquent\Model $entry
     * @param array $data
     * @return \Illuminate\Http\Response
     */
    protected function updateEntry($entry, $id, $data)
    {
        // Validate the filtered request against the rules.
        $validator = Validator::make($data, $this->validationRules);

        // In case of failure return, what could not be validated
        if ($validator->fails()) {
            return $this->respondWithError(422, $validator->errors());
        }

        // Fail in case the entry cannot be found
        $object = $entry->findOrFail($id);

        // Save the updated entry
        $object->update($data);

        // Return no body, just success
        return response('', 204);
    }

    /**
     * Undocumented function
     *
     * @param \Illuminate\Database\Eloquent\Model $entry
     * @param number $id
     * @return \Illuminate\Http\Response
     */
    protected function deleteEntry($entry, $id)
    {
        // Fail in case the entry cannot be found
        $object = $entry->findOrFail($id);

        // Delete the entry
        $object->delete();

        // Return no body, just success
        return response('', 204);
    }

    /**
     * Handles an error response formatting it according to our spec.
     *
     * @param number $statusCode
     * @param array $error
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function respondWithError($statusCode, $error, $headers = [])
    {
        return response()->json(['errors' => $error])->setStatusCode($statusCode);
    }
}
