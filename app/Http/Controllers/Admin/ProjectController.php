<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Http\Request;
// Helper per gli array
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
// Helper per lo Storage
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $projects = Project::all(); senza paginazione
        // $projects = Project::paginate(10); con paginazione
        // $projects = Project::orderBy('updated_at')->paginate(10); con ordine ultima modifica

        // Ricavo il parametro- 
        $is_published = $request->is_published;

        // SORT & ORDER
        $sort = (!empty($sort_request = $request->get('sort'))) ? $sort_request : 'updated_at';
        $order = (!empty($order_request = $request->get('order'))) ? $order_request : 'ASC';

        $projects = Project::where('id', '>', 0);
        // query DINAMICA
        if (isset($request->is_published)) { // se è presente il parametro is published
            $projects->where('is_published', '=', $request->is_published); //prendi i progetti dove is published è uguale al parametro is_published passato dalla richiesta->nel nostro caso il link di richiesta che aggiunge nell'url il parametro o is_published=0 se sono bozze o =1 se sono pubblicati.
        }
        $projects = $projects->orderBy($sort, $order)->paginate(4)->withQueryString();


        // $projects = Project::where('is_published', '=', $is_published)->orderBy($sort, $order)->paginate(4)->withQueryString();



        return view('admin.projects.index', compact('projects', 'sort', 'order'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Project $project)
    {
        // $shoe= new Shoe;// per mettere il model 

        // Mi passo i TYPE
        $types = Type::orderBy('label')->get();
        // Le tecnologie
        $technologies = Technology::orderBy('label')->get();
        //  AGGIUNGO LA ROTTA CREATE
        return view('admin.projects.create', compact('project', 'types', 'technologies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Metodo che fa la validazione
        $data = $this->validation($request->all());
        // \Log::debug($data);
        // Metodo con helper Arr per cercare in un array l'elemento chiave 'image'
        if (Arr::exists($data, 'image')) {
            // Carico l'immagine nella cartella del progetto con metodo Storage
            $path = Storage::put('uploads/projects', $data['image']);
            // Salvo nel DB
            $data['image'] = $path;
        };

        // Gestione dello SLUG- PARTE 1 in Model Project.php
        $project = new Project;
        $project->fill($data);
        $project->slug = Project::generateUniqueSlug($project->title);

        $data['is_published'] = $request->has('is_published') ? 1 : 0;
        $project->save();

        //salvare i tag delle technologies
        if (Arr::exists($data, 'technologies')) $project->technologies()->attach($data['technologies']);

        return to_route('admin.projects.show', $project)
            ->with('message_type', "success")
            ->with('message-content', "Il progetto con $project->title è stato creato con successo!");;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        $types = Type::orderBy('label')->get();
        // ROTTA SHOW!
        return view('admin.projects.show', compact('project', 'types'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        // Passo il TYPES
        $types = Type::orderBy('label')->get();
        // technologies
        $technologies = Technology::orderBy('label')->get();
        //
        $project_technologies = $project->technologies->pluck('id')->toArray();

        return view('admin.projects.create', compact('project', 'types', 'technologies', 'project_technologies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        // \Log::debug('update');
        $data = $this->validation($request->all());
        // \Log::debug($data);

        if (Arr::exists($data, 'image')) {
            // \Log::debug('prova');
            // SE c'è già un'immagine nell'array $data
            if ($project->image) Storage::delete($project->image);
            // elimino l'immagine presente

            // ALTRIMENTI, se non ci sono immagini
            // Carico l'immagine nella cartella del progetto con metodo Storage::put
            $path = Storage::put('uploads/projects', $data['image']);
            $data['image'] = $path;
        };

        $project->fill($data);

        //Se esiste l'array delle tecnologie allora sincronizzali sul DB altrimenti de-sincronizza- (quando ho modificato il post)
        // Log::debug($data['technologies']);
        // die(); DEBUG
        if (Arr::exists($data, 'technologies')) $project->technologies()->sync($data['technologies']);
        else $project->technologies()->detach();

        $project->slug = Project::generateUniqueSlug($project->title);
        // AGGIUNGERE IS_PUBLISHED
        $data['is_published'] = $request->has('is_published') ? 1 : 0;
        $project->save();

        return to_route('admin.projects.show', $project)
            ->with('message_type', "success")
            ->with('message-content', "Il progetto con ID: $project->title è stato modificato con successo!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        // Creo una variabile per salvarmi l'id--> per la variabile FLASH
        $id_project = $project->id;
        // Quando elimino un elemento controllo c'era un'immagine, nel caso la elimino
        if ($project->image) {
            Storage::delete($project->image);
        }

        $project->delete();
        return to_route('admin.projects.index')
            ->with('message_type', "danger")
            ->with('message-content', "Il progetto con $id_project spostato nel cestino!");
    }

    // VALIDATION
    private function validation($data)
    {
        $validator = Validator::make(
            $data,
            [
                'title' => 'required|string|max:50',
                'text' => 'string|max:100',
                'image' => 'nullable|image|mimes:jpg,png,jpeg',
                'type_id' => 'nullable|exists:types,id',
                'technologies' => 'nullable|exists:technologies,id',
                'is_published' => 'boolean'
                // 'image' => 'nullable|string'
            ],
            [
                'title.required' => 'The Title is required',
                'title.string' => 'The title must be a string',
                'title.max' => 'The max length of the title must be 50 characters',

                'text.string' => 'The text must be a string',
                'text.max' => 'The max length of the text must be 100 characters',

                'image.image' => 'Please upload a file',
                'image.mimes' => 'The format of the file must be: jpg, png or jpeg',

                'type_id.exists' => 'The Id is not valid',

                'technologies.exists' => 'The Id is not valid',
            ]
        )->validate();
        return $validator;
    }


    // SOFT-DELETE ********************************************
    public function trash(Request $request)
    {
        $sort = (!empty($sort_request = $request->get('sort'))) ? $sort_request : 'updated_at';
        $order = (!empty($order_request = $request->get('order'))) ? $order_request : 'ASC';

        $projects = Project::onlyTrashed($sort, $order)->paginate(10)->withQueryString();

        return view('admin.projects.trash', compact('projects', 'sort', 'order'));
    }

    public function forceDelete(Int $id)
    {
        $id_message = $id;
        // Creo una variabile per salvarmi l'id--> per la variabile FLASH
        $id_project = Project::where('id', $id)->onlyTrashed()->first();
        $id_project->forceDelete();
        return to_route('admin.projects.index')
            ->with('message_type', "danger")
            ->with('message-content', "Il progetto con ID: $id_message è stato eliminato definitivamente!");;
    }

    public function restore(Int $id)
    {
        $id_message = $id;
        // Creo una variabile per salvarmi l'id--> per la variabile FLASH
        $id_project = Project::where('id', $id)->onlyTrashed()->first();
        $id_project->restore();
        return to_route('admin.projects.index')
            ->with('message_type', "success")
            ->with('message-content', "Il progetto con ID: $id_message è stato ripristinato correttamente!");;
    }
}
