<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Calendar;
use App\User;
use App\Model\Tag;
use App\Model\Taggable;
use DB;

class CalendarController extends AdminController {

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function index(Request $request) {

        if (!$this->user->can(['access-all', 'post-type-all', 'calendar*'])) {
            return $this->pageUnauthorized();
        }

        $calendar_delete = $calendar_edit = $calendar_active = $calendar_show = $calendar_create = 0;

        if ($this->user->can(['access-all', 'post-type-all'])) {
            $calendar_delete = $calendar_active = $calendar_edit = $calendar_show = $calendar_create = 1;
        }

        if ($this->user->can('calendar-all')) {
            $calendar_delete = $calendar_active = $calendar_edit = $calendar_create = 1;
        }

        if ($this->user->can('calendar-delete')) {
            $calendar_delete = 1;
        }

        if ($this->user->can('calendar-edit')) {
            $calendar_active = $calendar_edit = $calendar_create = 1;
        }

        if ($this->user->can('calendar-create')) {
            $calendar_create = 1;
        }
        $type_action = 'الروزنامة';
        $data = Calendar::where('type', 'calendar')->orderBy('id', 'DESC')->paginate($this->limit); //where('parent_id','<>', 0)->
        return view('admin.calendar.index', compact('type_action', 'data', 'calendar_active', 'calendar_create', 'calendar_edit', 'calendar_show', 'calendar_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function type(Request $request, $type) {

        $type_array = ['calendar'];
        if (!in_array($type, $type_array)) {
            return $this->pageUnauthorized();
        }

        $calendar_delete = $calendar_edit = $calendar_active = $calendar_create = 0;

        if ($this->user->can(['access-all', 'post-type-all', 'calendar-all'])) {
            $calendar_delete = $calendar_active = $calendar_edit = $calendar_create = 1;
        }

        if ($this->user->can('calendar-delete')) {
            $calendar_delete = 1;
        }

        if ($this->user->can('calendar-edit')) {
            $calendar_active = $calendar_edit = $calendar_create = 1;
        }

        if ($this->user->can('calendar-create')) {
            $calendar_create = 1;
        }
        $type_action = 'الروزنامة';
        $data = Calendar::where('type', 'calendar')->orderBy('id', 'DESC')->where('type', $type)->paginate($this->limit);  //where('type','<>', 'banner')->
        return view('admin.calendar.index', compact('type_action', 'data', 'calendar_create', 'calendar_edit', 'calendar_delete'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function create() {
        if (!$this->user->can(['access-all', 'post-type-all', 'calendar-all', 'calendar-create', 'calendar-edit'])) {
            return $this->pageUnauthorized();
        }
        $tags = Tag::pluck('name', 'name');
        if ($this->user->can(['access-all', 'post-type-all', 'calendar-all', 'calendar-edit'])) {
            $calendar_active = 1;
        } else {
            $calendar_active = 0;
        }
        $lang = 'ar';
        $calendarTags = [];
        $new = 1;
        $icon = $icon_image = '';
        $link_return = route('admin.calendar.index');
        return view('admin.calendar.create', compact('icon', 'lang', 'icon_image', 'tags', 'link_return', 'new', 'calendar_active', 'calendarTags'));
    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */
    public function store(Request $request) {
        if (!$this->user->can(['access-all', 'post-type-all', 'calendar-all', 'calendar-create', 'calendar-edit'])) {
            if ($this->user->can('calendar-list')) {
                return redirect()->route('admin.calendar.index')->with('error', 'Have No Access');
            } else {
                return $this->pageUnauthorized();
            }
        }
        $this->validate($request, [
            'name' => 'required|max:255',
//            'link' => "max:255|uniqueCalendarLinkType:{$request->type}",
//                'parent_id' => 'required',
        ]);

        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != "tags") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }

        $input['type'] = "calendar"; //"main";
        if ($input['link'] == Null) {
            $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
        }
//        if (!isset($input['is_active'])) {
//            $calendar_active = DB::table('options')->where('option_key', 'post_active')->value('option_value');
//            $input['is_active'] = is_numeric($calendar_active) ? $calendar_active : 0;
//        }
        $input['is_active'] = 1;
        $input['user_id'] = $this->user->id;
        $calendar = Calendar::create($input);
        $calendar_id = $calendar['id'];
        if ($input['lang'] == 'ar') {
            Calendar::updateColum($calendar_id, 'lang_id', $calendar_id);
        }
        $taggable_id = $calendar_id;
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
                    $taggable->insertTaggable($tag_id, $taggable_id, "calendar");
                }
            }
        }
        return redirect()->route('admin.calendar.index')->with('success', 'Created successfully');
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function show(Request $request, $id) {
        return redirect()->route('admin.calendar.edit', $id);
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function edit($id) {
        $calendar = Calendar::find($id);
        if (!empty($calendar)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'calendar-all', 'calendar-edit'])) {
                if ($this->user->can(['calendar-list', 'calendar-create'])) {
                    return redirect()->route('admin.calendar.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            $lang = 'ar';
            $tags = Tag::pluck('name', 'name');
            $calendar_active = 1;
            $calendarTags = $calendar->tags->pluck('name', 'name')->toArray();

            $new = 0;
            $link_return = route('admin.calendar.index');
            $icon_image = $calendar->icon_image;
            $icon = $calendar->icon;
            return view('admin.calendar.edit', compact('icon', 'lang', 'icon_image', 'link_return', 'calendar', 'calendar_active', 'tags', 'calendarTags', 'new'));
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
        $calendar = Calendar::where('type', 'calendar')->find($id);
        if (!empty($calendar)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'calendar-all', 'calendar-edit'])) {
                if ($this->user->can(['calendar-list', 'calendar-create'])) {
                    return redirect()->route('admin.calendar.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            $this->validate($request, [
                'name' => 'required|max:255',
//            'link' => "required|max:255|uniqueCalendarUpdateLinkType:$request->type,$id",
//                    'parent_id' => 'required',
            ]);


            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != "tags") {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                }
            }

//        $link_count = Calendar::foundLink($input['link']);
//        if($link_count > 0){
//          $input['link'] = $calendar->link;  
//        }else{
//            $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
//        }
            if (empty($input['link'])) {
                $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
            }
            $calendar->update($input);

            Taggable::deleteTaggableType($id, "calendar");
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
                        $taggable->insertTaggable($tag_id, $id, "calendar");
                    }
                }
            }
            //  return redirect()->route('admin.calendar.index')->with('success', 'Updated successfully');
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

        $calendar = Calendar::find($id);
        if (!empty($calendar)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'calendar-all', 'calendar-delete'])) {
                if ($this->user->can(['calendar-list', 'calendar-edit'])) {
                    return redirect()->route('admin.calendar.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            Calendar::find($id)->delete();
            Calendar::deleteParent($id);
            Taggable::deleteTaggableType($id, "calendar");
            return redirect()->route('admin.calendar.index')
                            ->with('success', 'Deleted successfully');
        } else {
            return $this->pageError();
        }
    }

    public function search() {

        if (!$this->user->can(['access-all', 'post-type-all', 'calendar-all', 'calendar-list'])) {
            return $this->pageUnauthorized();
        }

        $calendar_delete = $calendar_edit = $calendar_active = $calendar_show = $calendar_create = 0;

        if ($this->user->can(['access-all', 'post-type-all'])) {
            $calendar_delete = $calendar_active = $calendar_edit = $calendar_show = $calendar_create = 1;
        }

        if ($this->user->can('calendar-all')) {
            $calendar_delete = $calendar_active = $calendar_edit = $calendar_create = 1;
        }

        if ($this->user->can('calendar-delete')) {
            $calendar_delete = 1;
        }

        if ($this->user->can('calendar-edit')) {
            $calendar_active = $calendar_edit = $calendar_create = 1;
        }

        if ($this->user->can('calendar-create')) {
            $calendar_create = 1;
        }
        $type_action = 'الروزنامة';
//        $data = Calendar::whereIn('type', ['calendar','subcalendar'])->with('user')->get(); //where('parent_id', 0)->
        $data = Calendar::whereIn('type', ['calendar', 'subcalendar'])->orderBy('id', 'DESC')->get(); //where('parent_id', 0)->
        return view('admin.calendar.search', compact('type_action', 'data', 'calendar_create', 'calendar_edit', 'calendar_show', 'calendar_active', 'calendar_delete'));
    }

}

//   UID' => 'required|unique:{tableName},{secondcolumn}'








