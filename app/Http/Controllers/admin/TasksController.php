<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\TasksRequest;
use App\Http\Services\HelperTrait;
use App\Models\Task;
use App\Notifications\GeneralNotification;
use App\Repositories\Contracts\IGroupRepository;
use App\Repositories\Contracts\ITaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class TasksController extends AdminBaseController
{

    use HelperTrait;
    public $taskRepo;
    public $groupRepo;
    public $relations = ['group'];

    public function __construct(ITaskRepository $taskRepo,IGroupRepository $groupRepo)
    {
        $this->taskRepo = $taskRepo;
        $this->groupRepo = $groupRepo;
        parent::__construct($taskRepo, 'admin.tasks.tasks');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!$this->authorize('add groups'))
            abort(405);

        $groups = $this->groupRepo->search([],[],true,false,0);
        return view('admin.tasks.add',compact('groups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TasksRequest $request)
    {
        $data =$request->validated();
        $data['image'] = $request->file('image') ?
            $this->storeImage($request->file('image'),Task::$folder) : null;

        $task = $this->taskRepo->create($data);
        auth()->user()->notify(new GeneralNotification($task,'task','created'));

        return redirect()->route('tasks.index')->with('success','Task added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (!$this->authorize('edit groups'))
            abort(405);
        $data = $this->taskRepo->edit($id);
        $task = $data['task'];
        $groups = $this->groupRepo->search([],[],true,false,0);
        return view('admin.tasks.edit',compact('task','groups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TasksRequest $request, Task $task)
    {
        $data = $request->validated();

        if($request->file('image')){
            $data['image'] = $this->storeImage($request->file('image'),Task::$folder);
        }
        $this->groupRepo->update($task,$data);
        auth()->user()->notify(new GeneralNotification($task,'task','updated'));

        return redirect()->route('tasks.index')->with('success','Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        if (!$this->authorize('delete groups'))
            abort(405);
        $this->taskRepo->remove($task);
        return back()->with(['success' => 'Task deleted successfully']);
    }
}
