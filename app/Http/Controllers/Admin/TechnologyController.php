<?php

namespace App\Http\Controllers\Admin;

use App\Models\Technology;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TechnologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sort = (!empty($sort_request = $request->get('sort'))) ? $sort_request : 'updated_at';
        $order = (!empty($order_request = $request->get('order'))) ? $order_request : 'ASC';

        $technologies = Technology::orderBy($sort, $order)->paginate(10)->withQueryString();

        return view('admin.technologies.index', compact('technologies', 'sort', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $technology = new Technology();

        return view('admin.technologies.form', compact('technology'))
            ->with('message_content', 'Tecnologia aggiunta con successo');;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->validation($request->all());

        $technology = new Technology();
        $technology->fill($data);
        $technology->save();

        return to_route('admin.technologies.index', $technology)
            ->with('message_content', 'Tech creato con successo!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function show(Technology $technology)
    {
        return view('admin.technologies.show', compact('technology'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function edit(Technology $technology)
    {
        return view('admin.technologies.form', compact('technology'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Technology $technology)
    {
        $data = $this->validation($request->all());

        $technology->update($data);
        return to_route('admin.technologies.index', $technology)
            ->with('message_content', 'Tipologia ' . $technology->title . ' modificata con successo');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Technology  $technology
     * @return \Illuminate\Http\Response
     */
    public function destroy(Technology $technology)
    {
        $type_id = $technology->id;
        $technology->delete();
        return to_route('admin.technologies.index')
            ->with('message_type', 'danger')
            ->with('message_content', 'Tipologia ' . $technology->title . 'con id ' . $technology->id . ' eliminata con successo.');
    }

    private function validation($data)
    {
        return Validator::make(
            $data,
            [
                'label' => 'required|string|max:30',
                'color' => 'required|string|size:7'
            ],
            [
                'label.required' => 'Label must be field',
                'label.string' => 'Label must be a string',
                'label.max' => 'Label must be a string',

                'color.required' => 'Label must be field',
                'color.string' => 'Label must be a string',
                'color.size' => 'Label must have max 7 characters (es. #ffffff)',
            ]
        )->validate();
    }
}
