<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Tag;
use App\Model\Search;
use App\Model\UserSearch;
use App\Model\Taggable;
use DB;

class SearchController extends AdminController {

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function index(Request $request) {

        if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            return $this->pageUnauthorized();
        }

        $search_delete = $search_edit = $search_create = 0;

        if ($this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            $search_delete = $search_edit = $search_create = 1;
        }
        $type_action='';
        $data = Search::orderBy('id', 'DESC')->paginate($this->limit);
        return view('admin.searches.index', compact('type_action','data', 'search_edit', 'search_delete', 'search_create'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function create() {

        if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            return $this->pageUnauthorized();
        }
        $tags = Tag::pluck('name', 'name');
        $searchTags = [];
        $link_return = route('admin.searches.index');
        return view('admin.searches.create', compact('link_return','tags', 'searchTags'));
    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */
    public function store(Request $request) {

        if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            return $this->pageUnauthorized();
        }

        $this->validate($request, [
            'name' => 'required|max:255|unique:searches,name',
        ]);


        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != "tags") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }

        $search = new Search();
        $found = $search->foundSearch($input['name']);
        if ($found == 0) {
            $search->insertSearch($input['name'], 1, 1, 0, $input['is_active']);
            $search_id = $search->id;
        } else {
            $search_id = $found;
//            Search::updateSearchCount($search_id);
//            Search::updateSearchCount($search_id, 'login_count');
//            Search::updateSearchTime($search_id);
        }
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
                    $taggable_id = Taggable::foundTaggable($tag_id, $search_id, "searches");
                    if ($taggable_id == 0) {
                        $taggable->insertTaggable($tag_id, $search_id, "searches");
                    }
                }
            }
        }

        return redirect()->route('admin.searches.index')->with('success', 'Tag created successfully');
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function show(Request $request, $id) {
        if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            return $this->pageUnauthorized();
        }

        $search_delete = $search_edit = $search_create = 0;

        if ($this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            $search_delete = $search_edit = $search_create = 1;
        }
        $type_action='';
        $data = UserSearch::where('search_id', $id)->orderBy('id', 'DESC')->paginate($this->limit);
        return view('admin.searches.show', compact('type_action','data', 'search_edit', 'search_delete', 'search_create'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function edit($id) {

        $search = Search::find($id);
        if (!empty($search)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
                return $this->pageUnauthorized();
            }
            $tags = Tag::pluck('name', 'name');
            $searchTags = $search->tags->pluck('name', 'name')->toArray();
            $link_return = route('admin.searches.index');
            return view('admin.searches.edit', compact('link_return','search', 'tags', 'searchTags'));
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

        $search = Search::find($id);
        if (!empty($search)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
                return redirect()->route('admin.searches.index')->with('error', 'Have No Access');
            }

            $this->validate($request, [
                'name' => 'required|max:255|unique:searches,name,' . $id,
            ]);
            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != "tags") {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                }
            }

            $search = new Search();
            $search->updateSearch($id, $input['name'],$input['is_active']);
            Search::updateSearchTime($id);
            
            Taggable::deleteTagType($id, "searches");
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
                        $taggable_id = Taggable::foundTaggable($tag_id, $id, "searches");
                        if ($taggable_id == 0) {
                            $taggable->insertTaggable($tag_id, $id, "searches");
                        }
                    }
                }
            }

            return redirect()->route('admin.searches.index')->with('success', 'Search updated successfully');
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

        $search = Search::find($id);
        if (!empty($search)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
                return $this->pageUnauthorized();
            }
            Search::find($id)->delete();
            Taggable::deleteTaggableType($id, "searches");
            return redirect()->route('admin.searches.index')->with('success', 'Search deleted successfully');
        } else {
            return $this->pageError();
        }
    }

    public function destroySearch($id) {

        $user_search = UserSearch::find($id);
        if (!empty($user_search)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
                return $this->pageUnauthorized();
            }
            UserSearch::find($id)->delete();
            $search_id =$user_search->search_id;
            $user_id =$user_search->user_id;
            $search = Search::find($search_id);
            if(!empty($search)){
            $search_count = sub($search->search_count, 1);
            $login_count = sub($search->login_count, 1);
            $guest_count = sub($search->guest_count, 1);
            if($user_id > 0){
                Search::updateSearchCountLogin($search_id, $search_count, $login_count);
                Search::updateSearchTime($search_id);
            }else{
                Search::updateSearchCountGuest($search_id, $search_count, $guest_count);
                Search::updateSearchTime($search_id);  
            }
            }
            return redirect()->route('admin.searches.show',[$search_id])->with('success', 'Search deleted successfully');
        } else {
            return $this->pageError();
        }
    }
    
    public function search() {

        if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            return $this->pageUnauthorized();
        }

        $search_delete = $search_edit = $search_create = 0;

        if ($this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            $search_delete = $search_edit = $search_create = 1;
        }
        $type_action='';
        $data = Search::all();
        return view('admin.searches.search', compact('type_action','data', 'search_edit', 'search_delete', 'search_create'));
    }

}
