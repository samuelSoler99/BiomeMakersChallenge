<?php

namespace App\Http\Controllers;

use App\Models\Organism;
use App\Models\Sample;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

/**
 * Example of controller for the Challenge
 */
class BiomeController extends Controller
{
    /**
     * Returns a list of samples
     */
    public function listSamples()
    {
        return Sample::query()
            ->withCount('abundances')
            ->with('crop:id,name')
            ->get();
    }

    /**
     * return new organism
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function newOrganism(Request $request): JsonResponse
    {
        // Log is configured to print to stderr
        Log::info($request->all());
        try {
            $request->validate([
                'genus' => 'required|string',
                'species' => 'required|string'
            ]);

            $organism = new Organism();
            $organism->genus = $request->input('genus');
            $organism->species = $request->input('species');
            $organism->save();

            return response()->json(['message' => 'organism created','organism'=>$organism]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->validator->getMessageBag()->all()
            ], 422);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Not completed'], 500);
        }
    }

    /**
     * Returns a paginated list of organisms
     */
    public function listOrganisms()
    {
        return Organism::paginate(10);
    }

    /**
     * Returns the top list of organisms
     *
     * I inject the model, so im able to mock in case I make a unit test
     *
     * @param Organism $organismModel
     * @return JsonResponse
     */
    public function listOrganismsTop10(Organism $organismModel): JsonResponse
    {
        return response()->json($organismModel->getTopOrganismsWithCrops());
    }

}
