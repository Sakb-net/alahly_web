<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Apimessage;
use App\Model\Tag;
use App\Model\Taggable;
use DB;

class ApimessagesController extends AdminController {

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function index(Request $request) {

        if (!$this->user->can(['access-all', 'post-type-all', 'apimessages*'])) {
            return $this->pageUnauthorized();
        }

        $apimessages_delete = $apimessages_edit = $apimessages_active = $apimessages_show = $apimessages_create = 0;

        if ($this->user->can(['access-all', 'post-type-all'])) {
            $apimessages_delete = $apimessages_active = $apimessages_edit = $apimessages_show = $apimessages_create = 1;
        }

        if ($this->user->can('apimessages-all')) {
            $apimessages_delete = $apimessages_active = $apimessages_edit = $apimessages_create = 1;
        }

        if ($this->user->can('apimessages-delete')) {
            $apimessages_delete = 1;
        }

        if ($this->user->can('apimessages-edit')) {
            $apimessages_active = $apimessages_edit = $apimessages_create = 1;
        }

        if ($this->user->can('apimessages-create')) {
            $apimessages_create = 1;
        }
        $type_action = 'رسائل الموقع والموبايل';
        $data = Apimessage::orderBy('id', 'DESC')->paginate($this->limit);
        return view('admin.apimessages.index', compact('type_action', 'data', 'apimessages_active', 'apimessages_create', 'apimessages_edit', 'apimessages_show', 'apimessages_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function create() {

        if (!$this->user->can(['access-all', 'post-type-all', 'apimessages-all', 'apimessages-create', 'apimessages-edit'])) {
            return $this->pageUnauthorized();
        }
        $tags = Tag::pluck('name', 'name');
        if ($this->user->can(['access-all', 'post-type-all', 'apimessages-all', 'apimessages-edit'])) {
            $apimessages_active = 1;
        } else {
            $apimessages_active = 0;
        }
        $apimessagesTags = [];
        $new = 1;
        $link_return = route('admin.apimessages.index');
        return view('admin.apimessages.create', compact('tags', 'link_return', 'new', 'apimessages_active', 'apimessagesTags'));
    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */
    public function store(Request $request) {

        if (!$this->user->can(['access-all', 'post-type-all', 'apimessages-all', 'apimessages-create', 'apimessages-edit'])) {
            if ($this->user->can('apimessages-list')) {
                return redirect()->route('admin.apimessages.index')->with('error', 'Have No Access');
            } else {
                return $this->pageUnauthorized();
            }
        }

        $this->validate($request, [
            'type' => 'required|max:255',
            'ar_message' => 'required|max:255',
            'en_message' => 'required|max:255',
        ]);

        $input = $request->all();
        foreach ($input as $key => $value) {
            $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
        }
        $apimessages = Apimessage::create($input);
        $apimessages_id = $apimessages['id'];
        return redirect()->route('admin.apimessages.index')->with('success', 'Created successfully');
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function show(Request $request, $id) {
//        $apimessages = Apimessage::find($id);
        return redirect()->route('admin.apimessages.edit', $id);
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function edit($id) {
        $apimessages = Apimessage::find($id);
        if (!empty($apimessages)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'apimessages-all', 'apimessages-edit'])) {
                if ($this->user->can(['apimessages-list', 'apimessages-create'])) {
                    return redirect()->route('admin.apimessages.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            $apimessages_active = 1;
            $new = 0;
            $link_return = route('admin.apimessages.index');
            return view('admin.apimessages.edit', compact('link_return', 'apimessages', 'apimessages_active', 'new'));
        } else {
            return $this->pageError();
        }
    }

    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function update(Request $request, $id) {

        $apimessages = Apimessage::find($id);
        if (!empty($apimessages)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'apimessages-all', 'apimessages-edit'])) {
                if ($this->user->can(['apimessages-list', 'apimessages-create'])) {
                    return redirect()->route('admin.apimessages.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }

            $this->validate($request, [
                'type' => 'required|max:255',
                'ar_message' => 'required|max:255',
                'en_message' => 'required|max:255',
            ]);

            $input = $request->all();
            foreach ($input as $key => $value) {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            $apimessages->update($input);
            //  return redirect()->route('admin.apimessages.index')->with('success', 'Updated successfully');
            return redirect()->back()->with('success', 'Updated successfully');
        } else {
            return $this->pageError();
        }
    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function destroy($id) {

        $apimessages = Apimessage::find($id);
        if (!empty($apimessages)) {
            if ($apimessages->id != 1) {
                if (!$this->user->can(['access-all', 'post-type-all', 'apimessages-all', 'apimessages-delete'])) {
                    if ($this->user->can(['apimessages-list', 'apimessages-edit'])) {
                        return redirect()->route('admin.apimessages.index')->with('error', 'Have No Access');
                    } else {
                        return $this->pageUnauthorized();
                    }
                }
                Apimessage::find($id)->delete();
                return redirect()->route('admin.apimessages.index')
                                ->with('success', 'Apimessage deleted successfully');
            } else {
                return redirect()->route('admin.apimessages.index')
                                ->with('error', 'Can Not Delete This !!!');
            }
        } else {
            return $this->pageError();
        }
    }

    public function search() {

        if (!$this->user->can(['access-all', 'post-type-all', 'apimessages-all', 'apimessages-list'])) {
            return $this->pageUnauthorized();
        }

        $apimessages_delete = $apimessages_edit = $apimessages_active = $apimessages_show = $apimessages_create = 0;

        if ($this->user->can(['access-all', 'post-type-all'])) {
            $apimessages_delete = $apimessages_active = $apimessages_edit = $apimessages_show = $apimessages_create = 1;
        }

        if ($this->user->can('apimessages-all')) {
            $apimessages_delete = $apimessages_active = $apimessages_edit = $apimessages_create = 1;
        }

        if ($this->user->can('apimessages-delete')) {
            $apimessages_delete = 1;
        }

        if ($this->user->can('apimessages-edit')) {
            $apimessages_active = $apimessages_edit = $apimessages_create = 1;
        }

        if ($this->user->can('apimessages-create')) {
            $apimessages_create = 1;
        }
        $type_action = 'رسائل الموقع والموبايل';
        $data = Apimessage::orderBy('id', 'DESC')->get();
        return view('admin.apimessages.search', compact('type_action', 'data', 'apimessages_create', 'apimessages_edit', 'apimessages_show', 'apimessages_active', 'apimessages_delete'));
    }

}
