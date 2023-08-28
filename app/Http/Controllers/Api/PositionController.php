<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Position;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse|View
    {
        $positions = Position::all();
        return response()->json($positions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('positions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Position::create([
            'name' => $request->name,
        ]);

        return response()->json(['success' => 'Data Added successfully.']);
    }

    public function show($id)
    {
        $position = Position::findOrFail($id);

        return response()->json($position);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id): JsonResponse
    {
        $position = Position::find($id);

        if (! $position) {
            return response()->json(['error' => 'Position not found']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $position->update([
            'name' => $request->name,
        ]);

        return response()->json(['success' => 'Position updated successfully.']);
    }

    public function edit($id)
    {
        $position = Position::find($id);

        if (! $position) {
            return response()->json(['error' => 'Position not found'], 404);
        }

        return response()->json(['position' => $position], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id): JsonResponse
    {
        $position = Position::findOrFail($id);

        if (! $position) {
            return response()->json(['error' => 'Position not found']);
        }

        if ($position->employees()->count() > 0) {
            return response()->json(['error' => 'Position has employees and cannot be deleted']);
        }

        $position->delete();

        return response()->json(['success' => 'Position deleted successfully.']);
    }
}
