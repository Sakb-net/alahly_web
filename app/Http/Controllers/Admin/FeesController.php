<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Fees;
use App\Model\Tag;
use App\Model\Taggable;
use DB;

class FeesController extends AdminController {

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function index(Request $request) {

        if (!$this->user->can(['access-all', 'post-type-all', 'fees*'])) {
            return $this->pageUnauthorized();
        }

        $fees_delete = $fees_edit = $fees_active = $fees_show = $fees_create = 0;

        if ($this->user->can(['access-all', 'post-type-all'])) {
            $fees_delete = $fees_active = $fees_edit = $fees_show = $fees_create = 1;
        }

        if ($this->user->can('fees-all')) {
            $fees_delete = $fees_active = $fees_edit = $fees_create = 1;
        }

        if ($this->user->can('fees-delete')) {
            $fees_delete = 1;
        }

        if ($this->user->can('fees-edit')) {
            $fees_active = $fees_edit = $fees_create = 1;
        }

        if ($this->user->can('fees-create')) {
            $fees_create = 1;
        }
        $type_action = 'الرسوم';
        $data = Fees::orderBy('id', 'DESC')->paginate($this->limit);
        return view('admin.fees.index', compact('type_action', 'data', 'fees_active', 'fees_create', 'fees_edit', 'fees_show', 'fees_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function create() {

        if (!$this->user->can(['access-all', 'post-type-all', 'fees-all', 'fees-create', 'fees-edit'])) {
            return $this->pageUnauthorized();
        }
        $tags = Tag::pluck('name', 'name');
        if ($this->user->can(['access-all', 'post-type-all', 'fees-all', 'fees-edit'])) {
            $fees_active = 1;
        } else {
            $fees_active = 0;
        }
        $feesTags = [];
        $new = 1;
        $link_return = route('admin.fees.index');
        return view('admin.fees.create', compact('tags', 'link_return', 'new', 'fees_active', 'feesTags'));
    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */
    public function store(Request $request) {

        if (!$this->user->can(['access-all', 'post-type-all', 'fees-all', 'fees-create', 'fees-edit'])) {
            if ($this->user->can('fees-list')) {
                return redirect()->route('admin.fees.index')->with('error', 'Have No Access');
            } else {
                return $this->pageUnauthorized();
            }
        }

        $this->validate($request, [
            'name' => 'required|max:255',
//            'link' => "max:255|uniqueFeesLinkType:{$request->type}",
        ]);

        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != "tags") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
        if ($input['link'] == Null) {
            $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
        }
        if (empty($input['discount'])) {
            $input['discount'] = 0.00;
        }
        if (empty($input['price'])) {
            $input['price'] = 0.00;
        }
        $input['is_active'] = 1;
        $input['user_id'] = $this->user->id;
        $fees = Fees::create($input);
        $fees_id = $fees['id'];
        $taggable_id = $fees_id;
        $tags = isset($input['tags']) ? $input['tags'] : array();
        if (!empty($tags)) {
            foreach ($tags as $tags_value) {
                $taggable = new Taggable();
                if ($tags_value != NULL || $tags_value != '') {
                    $tag_found = new Tag();
                    $tag_id_found = $tag_found->foundTag($tags_value);
                    if ($tag_id_found > 0) {
                        $tag_id = $tag_id_found;
                    } else {
                        $tag_new = new Tag();
                        $tag_new->insertTag($tags_value);
                        $tag_id = $tag_new->id;
                    }
                    $taggable->insertTaggable($tag_id, $taggable_id, "fees");
                }
            }
        }

        return redirect()->route('admin.fees.index')->with('success', 'Created successfully');
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function show(Request $request, $id) {
//        $fees = Fees::find($id);
        return redirect()->route('admin.fees.edit', $id);
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function edit($id) {
        $fees = Fees::find($id);
        if (!empty($fees)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'fees-all', 'fees-edit'])) {
                if ($this->user->can(['fees-list', 'fees-create'])) {
                    return redirect()->route('admin.fees.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            $tags = Tag::pluck('name', 'name');
            $fees_active = 1;
            $feesTags = $fees->tags->pluck('name', 'name')->toArray();
            $new = 0;
            $link_return = route('admin.fees.index');
            return view('admin.fees.edit', compact('link_return', 'fees', 'fees_active', 'tags', 'feesTags', 'new'));
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

        $fees = Fees::find($id);
        if (!empty($fees)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'fees-all', 'fees-edit'])) {
                if ($this->user->can(['fees-list', 'fees-create'])) {
                    return redirect()->route('admin.fees.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }

            $this->validate($request, [
                'name' => 'required|max:255',
//                'link' => "required|max:255|uniqueFeesUpdateLinkType:$request->type,$id",
            ]);

            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != "tags") {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                }
            }
//            $link_count = Fees::foundLink($input['link']);
//            if ($link_count > 0) {
//                $input['link'] = $fees->link;
//            }
            if ($input['link'] == Null) {
                $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
            }
            $fees->update($input);
            Taggable::deleteTaggableType($id, "fees");
            $tags = isset($input['tags']) ? $input['tags'] : array();
            if (!empty($tags)) {
                foreach ($tags as $tags_value) {
                    $taggable = new Taggable();
                    if ($tags_value != NULL || $tags_value != '') {
                        $tag_found = new Tag();
                        $tag_id_found = $tag_found->foundTag($tags_value);
                        if ($tag_id_found > 0) {
                            $tag_id = $tag_id_found;
                        } else {
                            $tag_new = new Tag();
                            $tag_new->insertTag($tags_value);
                            $tag_id = $tag_new->id;
                        }
                        $taggable->insertTaggable($tag_id, $id, "fees");
                    }
                }
            }
            //  return redirect()->route('admin.fees.index')->with('success', 'Updated successfully');
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
        $fees = Fees::find($id);
        if (!empty($fees)) {
            if ($fees->id != 1&& $fees->id != 2&& $fees->id != 3) {
                if (!$this->user->can(['access-all', 'post-type-all', 'fees-all', 'fees-delete'])) {
                    if ($this->user->can(['fees-list', 'fees-edit'])) {
                        return redirect()->route('admin.fees.index')->with('error', 'Have No Access');
                    } else {
                        return $this->pageUnauthorized();
                    }
                }
                Fees::find($id)->delete();
                Taggable::deleteTaggableType($id, "fees");
                return redirect()->route('admin.fees.index')
                                ->with('success', 'Fees deleted successfully');
            } else {
                return redirect()->route('admin.fees.index')
                                ->with('error', 'Can Not Delete This !!!');
            }
        } else {
            return $this->pageError();
        }
    }

    public function search() {

        if (!$this->user->can(['access-all', 'post-type-all', 'fees-all', 'fees-list'])) {
            return $this->pageUnauthorized();
        }

        $fees_delete = $fees_edit = $fees_active = $fees_show = $fees_create = 0;

        if ($this->user->can(['access-all', 'post-type-all'])) {
            $fees_delete = $fees_active = $fees_edit = $fees_show = $fees_create = 1;
        }

        if ($this->user->can('fees-all')) {
            $fees_delete = $fees_active = $fees_edit = $fees_create = 1;
        }

        if ($this->user->can('fees-delete')) {
            $fees_delete = 1;
        }

        if ($this->user->can('fees-edit')) {
            $fees_active = $fees_edit = $fees_create = 1;
        }

        if ($this->user->can('fees-create')) {
            $fees_create = 1;
        }
        $type_action = 'الرسوم';
        $data = Fees::orderBy('id', 'DESC')->get();
        return view('admin.fees.search', compact('type_action', 'data', 'fees_create', 'fees_edit', 'fees_show', 'fees_active', 'fees_delete'));
    }

}
