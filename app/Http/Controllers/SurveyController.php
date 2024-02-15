<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Http\Requests\StoreSurveyRequest;
use App\Http\Requests\UpdateSurveyRequest;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $per_page = $request->per_page??15;
        $surveys=Survey::orderByDesc('created_at')
                        ->paginate($per_page);
        return $surveys;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreSurveyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSurveyRequest $request)
    {
        //  $this->authorize('create', Survey::class);
        $surveyData = Arr::only($request->all(), ['question', 'creatorId', 'endedAt', 'options']);
        $surveyData['id'] = (string) Str::uuid();
        foreach($surveyData as $key=>$value){
            if($value==null) $surveyData[$key] = '';
        }
        $survey = Survey::create($surveyData);
        if($survey){
            return $survey;
        }
        else return response()->json([
            'message' => "Une erreur s'est produite"
        ], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function show(Survey $survey)
    {
        //
        $survey=Survey::findOrFail($survey);

        return new Survey($survey);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function edit(Survey $survey)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSurveyRequest  $request
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSurveyRequest $request, Survey $survey)
    {
        //
        $surveyData = Arr::only($request->all(), ['question', 'creatorId', 'endedAt', 'options']);
        $survey->update($surveyData);

        return ($survey);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Survey  $survey
     * @return \Illuminate\Http\Response
     */
    public function destroy(Survey $survey)
    {
        // $this->authorize('delete', Survey::class);
        if($survey){
            if ($survey->delete()) {
                //return response()->noContent();
                return response()->json([
                    'message' => 'Resource deleted sucessfully.'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Failed deleting resource'
                ], 400);
            }
        }else{
            return response()->json([
                'message' => 'Resource don\'t exist.'
            ], 404);
        }
    }
}
