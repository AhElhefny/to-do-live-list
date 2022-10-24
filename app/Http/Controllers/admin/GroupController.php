<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\AdminBaseController;
use App\Http\Requests\GroupRequest;
use App\Http\Services\HelperTrait;
use App\Models\Group;
use App\Notifications\GeneralNotification;
use App\Repositories\Contracts\IGroupRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class GroupController extends AdminBaseController
{
    use HelperTrait;
    public $relations = ['user'];
    public $groupRepo;

    public function __construct(IGroupRepository $groupRepo)
    {
        $this->groupRepo = $groupRepo;
        parent::__construct($groupRepo, 'admin.groups.groups');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(){
        if (!$this->authorize('add groups'))
            abort(405);
        return view('admin.groups.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  GroupRequest  $request
     * @return RedirectResponse
     */
    public function store(GroupRequest $request)
    {
        $data =$request->validated();
        $data['image'] = $request->file('image') ?
            $this->storeImage($request->file('image'),Group::$folder) : null;

        $group = $this->groupRepo->create($data);
        auth()->user()->notify(new GeneralNotification($group,'group','created'));

        return redirect()->route('groups.index')->with('success','Group added successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return View
     */
    public function edit($id)
    {
        if (!$this->authorize('edit groups'))
            abort(405);
        $data = $this->groupRepo->edit($id);
        $group = $data['group'];
        return view('admin.groups.edit',compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  GroupRequest $request
     * @param  Group  $group
     * @return RedirectResponse
     */
    public function update(GroupRequest $request, Group $group)
    {
        $data = $request->validated();

        if($request->file('image')){
            $data['image'] = $this->storeImage($request->file('image'),Group::$folder);
        }
        $this->groupRepo->update($group,$data);
        auth()->user()->notify(new GeneralNotification($group,'group','updated'));

        return redirect()->route('groups.index')->with('Group updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Group $group
     * @return RedirectResponse
     */
    public function destroy(Group $group)
    {
        if (!$this->authorize('delete groups'))
            abort(405);
        $this->groupRepo->remove($group);
        return back()->with(['success' => 'Group deleted successfully']);
    }
}
