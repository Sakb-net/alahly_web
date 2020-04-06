<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Model\Match;
use App\Model\Video;
use App\Model\File;
use App\Model\Tag;
use App\Model\Taggable;
use DB;

class MatchController extends AdminController {

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function index(Request $request) {

        if (!$this->user->can(['access-all', 'match-type-all', 'match-all', 'match-list', 'match-edit', 'match-delete', 'match-show'])) {
            return $this->pageUnauthorized();
        }

        $match_active = $match_edit = $match_create = $match_delete = $match_show = $comment_list = $comment_create = 0;

        if ($this->user->can(['access-all', 'match-type-all', 'match-all'])) {
            $match_active = $match_edit = $match_create = $match_delete = $match_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('match-edit')) {
            $match_active = $match_edit = $match_create = $match_show = 1;
        }

        if ($this->user->can('match-delete')) {
            $match_delete = 1;
        }

        if ($this->user->can('match-show')) {
            $match_show = 1;
        }

        if ($this->user->can('match-create')) {
            $match_create = 1;
        }

        if ($this->user->can(['comment-all', 'comment-edit'])) {
            $comment_list = $comment_create = 1;
        }

        if ($this->user->can('comment-list')) {
            $comment_list = 1;
        }

        if ($this->user->can('comment-create')) {
            $comment_create = 1;
        }
        $name = 'match';
        $type_action = 'Match';
        $type_name = trans('app.matches');
        $data = Match::orderBy('id', 'DESC')->where('type', 'match')->paginate($this->limit);
        return view('admin.matches.index', compact('type_name', 'type_action', 'data', 'name', 'comment_create', 'comment_list', 'match_active', 'match_create', 'match_edit', 'match_delete', 'match_show'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function create(Request $request) {
        $type = 'match';
        $type_name = trans('app.matches');

        if (!$this->user->can(['access-all', 'match-type-all', 'match-all', 'match-create', 'match-edit'])) {
            return $this->pageUnauthorized();
        }
        if ($this->user->can(['access-all', 'match-type-all', 'match-all', 'match-edit'])) {
            $match_active = $image = 1;
        } else {
            $match_active = $image = 0;
        }
        if ($this->user->can(['image-upload', 'image-edit'])) {
            $image = 1;
        }
        $tags = Tag::pluck('name', 'name');
        $dataTags = $all_first = $all_second = [];
        $new = 1;
        $lang = 'ar';
        if ($this->user->lang == 'ar') {
            $first_file = ['اختر ملف ' => 0];
            $first_video = ['اختر فيديو ' => 0];
        } else {
            $first_file = ['Choose File ' => 0];
            $first_video = ['Choose Video ' => 0];
        }
        $files_all = []; // File::where('table_id', null)->where('is_active', 1)->pluck('id', 'name')->toArray();
        $files = array_flip(array_merge($first_file, $files_all));
        $videos_all = Video::where('table_id', null)->where('is_active', 1)->pluck('id', 'name')->toArray();
        $videos = array_flip(array_merge($first_video, $videos_all));

        $date = $time = $first_image = $second_image = $cart_yellow1 = $cart_yellow2 = $cart_red1 = $cart_red2 = $offside1 = $offside2 = NULL;
        $date_booking = $strikes1 = $strikes2 = $paying_goal1 = $paying_goal2 = $passes1 = $passes2 = null;

        $link_return = route('admin.matches.index');
        return view('admin.matches.create', compact('date', 'date_booking', 'time', 'all_first', 'all_second', 'cart_yellow1', 'cart_yellow2', 'cart_red1', 'cart_red2', 'offside1', 'offside2', 'strikes1', 'strikes2', 'paying_goal1', 'paying_goal2', 'passes1', 'passes2', 'videos', 'lang', 'tags', 'dataTags', 'files', 'type_name', 'type', 'link_return', 'new', 'match_active', 'image', 'first_image', 'second_image'));
    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */
    public function store(Request $request) {

        if (!$this->user->can(['access-all', 'match-type-all', 'match-all', 'match-create', 'match-edit'])) {
            if ($this->user->can(['match-list'])) {
                return redirect()->route('admin.matches.index')->with('error', 'Have No Access');
            } else {
                return $this->pageUnauthorized();
            }
        }
        $this->validate($request, [
            'name' => 'required|max:255',
//            'link' => "max:255|uniquePostLinkType:{$request->type}",
            'first_team' => 'required',
            'second_team' => 'required',
            'date_booking' => 'required',
//            'video_id' => 'required',
        ]);
        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != "video_id" && $key != "first_add" && $key != "second_add" && $key != "content" && $key != "tags" && $key != "description") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }
//        $input['type'] = "match";
        $input['is_read'] = 1;
        $input['is_active'] = 1;

        if (!isset($input['first_goal']) || empty($input['first_goal'])) {
            $input['first_goal'] = 0;
        }
        if (!isset($input['second_goal']) || empty($input['second_goal'])) {
            $input['second_goal'] = 0;
        }
        if (!isset($input['is_comment'])) {
            $input['is_comment'] = $input['is_active'];
        }
        if (!empty($input['date_booking'])) {
            $date_booking = explode('/', $input['date_booking']);
            $input['start_booking'] = $date_booking[0];
            $input['end_booking'] = $date_booking[1];
        }
        if (!empty($input['date']) && !empty($input['time'])) {
            $time = explode(' ', $input['time']);
            $input['time'] = $time[1];
            $input['date'] = $input['date'] . ' ' . $time[0];
        }
        if ($input['link'] == Null) {
            $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
        }
        $input['user_id'] = $this->user->id;
        $input['update_by'] = $this->user->id;

        $first_add = isset($_POST['first_add']) ? $_POST['first_add'] : array();
        $second_add = isset($_POST['second_add']) ? $_POST['second_add'] : array();
        $data_first = $data_second = [];
        if (!empty($first_add)) {
            foreach ($first_add as $first_add_value) {
                $input['name_player'] = trim(filter_var($first_add_value['name_player'], FILTER_SANITIZE_STRING));
                $input['time_player'] = trim(filter_var($first_add_value['time_player'], FILTER_SANITIZE_STRING));
                if ($input['name_player'] != '') {
                    $data_first[] = ['name_player' => $input['name_player'], 'time_player' => $input['time_player']];
                }
            }
        }

        if (!empty($second_add)) {
            foreach ($second_add as $second_add_value) {
                $input['name_player'] = trim(filter_var($second_add_value['name_player'], FILTER_SANITIZE_STRING));
                $input['time_player'] = trim(filter_var($second_add_value['time_player'], FILTER_SANITIZE_STRING));
                if ($input['name_player'] != '') {
                    $data_second[] = ['name_player' => $input['name_player'], 'time_player' => $input['time_player']];
                }
            }
        }
        $result = array('cart_yellow1' => $input['cart_yellow1'], 'cart_yellow2' => $input['cart_yellow2'],
            'cart_red1' => $input['cart_red1'], 'cart_red2' => $input['cart_red2'], 'offside1' => $input['offside1'],
            'offside2' => $input['offside2'], 'strikes1' => $input['strikes1'], 'strikes2' => $input['strikes2'],
            'paying_goal1' => $input['paying_goal1'], 'paying_goal2' => $input['paying_goal2'], 'passes1' => $input['passes1'], 'passes2' => $input['passes2'],
            'data_first' => $data_first, 'data_second' => $data_second
        );
        $input['result'] = json_encode($result, true);
        $match = Match::create($input);
        $match_id = $match['id'];
        if ($input['lang'] == 'ar') {
            Match::updateColum($match_id, 'lang_id', $match_id);
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
                    $taggable_id = Taggable::foundTaggable($tag_id, $match_id, "match");
                    if ($taggable_id == 0) {
                        $taggable->insertTaggable($tag_id, $post_id, "match");
                    }
                }
            }
        }
        return redirect()->route('admin.matches.index')->with('success', 'Created successfully');
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function show($id) {
//        $match = Match::find($id);
        return redirect()->route('admin.matches.edit', $id);
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function edit($id) {
        $match = Match::find($id);
        $type = 'match';
        $type_name = trans('app.matches');
        if (!empty($match)) {
            if ($this->user->id != $match->user_id) {
                if (!$this->user->can(['access-all', 'match-type-all', 'match-all', 'match-edit', 'match-edit-only'])) {
                    if ($this->user->can(['match-list', 'match-create'])) {
                        return redirect()->route('admin.matches.index')->with('error', 'Have No Access');
                    } else {
                        return $match->pageUnauthorized();
                    }
                }
            }
            if ($this->user->can('match-edit-only') && !$this->user->can(['access-all', 'match-type-all', 'match-all', 'match-edit'])) {
                if (($this->user->id != $this->user_id)) {
                    if ($this->user->can(['match-list', 'match-create'])) {
                        return redirect()->route('admin.matches.index')->with('error', 'Have No Access');
                    } else {
                        return $match->pageUnauthorized();
                    }
                }
            }
            $lang = 'ar';
            $image = $new = 0;
            if ($this->user->can(['access-all', 'match-type-all', 'match-all', 'match-edit'])) {
                $match_active = $image = 1;
            } else {
                $match_active = 0;
            }
            if ($this->user->can(['image-edit'])) {
                $image = 1;
            }
            $image_link = $match->image;
            if ($this->user->can(['access-all', 'match-type-all', 'match-all', 'match-edit'])) {
                $match_active = 1;
            } else {
                $match_active = 0;
            }
            if ($match_active == 1) {
                $match->updateColum($id, 'is_read', 1);
            }
            $tags = Tag::pluck('name', 'name');
//            $dataTags = $match->tags->pluck('name', 'name')->toArray();
            $dataTags = Tag::whereIn('id', function($query)use ($id) {
                        $query->select('tag_id')
                                ->from(with(new Taggable)->getTable())
                                ->where('is_search', 1)->where('taggable_id', '=', $id)->where('taggable_type', '=', 'match');
                    })->pluck('name', 'name')->toArray();

            if ($this->user->lang == 'ar') {
                $first_file = ['اختر ملف ' => 0];
                $first_video = ['اختر فيديو ' => 0];
            } else {
                $first_file = ['Choose File ' => 0];
                $first_video = ['Choose Video ' => 0];
            }
            $files_all = []; // File::where('table_id', null)->where('is_active', 1)->pluck('id', 'name')->toArray();
            $files = array_flip(array_merge($first_file, $files_all));
            $videos_all = Video::where('table_id', null)->where('is_active', 1)->pluck('id', 'name')->toArray();
            $videos = array_flip(array_merge($first_video, $videos_all));

            $first_image = $match->first_image;
            $second_image = $match->second_image;
            $all_first = $all_second = [];
            $cart_yellow1 = $cart_yellow2 = $cart_red1 = $cart_red2 = $offside1 = $offside2 = NULL;
            $strikes1 = $strikes2 = $paying_goal1 = $paying_goal2 = $passes1 = $passes2 = null;

            $result = json_decode($match->result, true);
            foreach ($result as $key => $val_res) {
                $$key = $val_res;
            }
            $all_first = $data_first;
            $all_second = $data_second;
            $date = $match->date;
            $time = $match->time;
            if (!empty($match->date) && !empty($match->time)) {
                $date_time = explode(' ', $match->date);
                $time = $date_time[1] . $match->time;
                $date = $date_time[0];
            }
            $date_booking = get_date($match->start_booking) . ' / ' . get_date($match->end_booking);
            $link_return = route('admin.matches.index');
            return view('admin.matches.edit', compact('date', 'date_booking', 'time', 'match', 'all_first', 'all_second', 'cart_yellow1', 'cart_yellow2', 'cart_red1', 'cart_red2', 'offside1', 'offside2', 'strikes1', 'strikes2', 'paying_goal1', 'paying_goal2', 'passes1', 'passes2', 'videos', 'lang', 'tags', 'dataTags', 'files', 'type_name', 'type', 'link_return', 'new', 'match_active', 'image', 'first_image', 'second_image'));
        } else {
            return $match->pageError();
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
        $match = Match::find($id);
        $image = 0;
        if (!empty($match)) {
            if (!$this->user->can(['access-all', 'match-type-all', 'match-all', 'match-edit', 'match-edit-only'])) {
                if ($this->user->can(['match-list', 'match-create'])) {
                    return redirect()->route('admin.matches.index')->with('error', 'Have No Access');
                } else {
                    return $match->pageUnauthorized();
                }
            }

            if ($this->user->can('match-edit-only') && !$this->user->can(['access-all', 'match-type-all', 'match-all', 'match-edit'])) {
                if (($this->user->id != $this->user_id)) {
                    if ($this->user->can(['match-list', 'match-create'])) {
                        return redirect()->route('admin.matches.index')->with('error', 'Have No Access');
                    } else {
                        return $match->pageUnauthorized();
                    }
                }
            }
            $this->validate($request, [
                'name' => 'required|max:255',
//                    'link' => "max:255|uniquePostUpdateLinkType:$request->type,$id",
                'first_team' => 'required',
                'second_team' => 'required',
            ]);
            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != "video_id" && $key != "first_add" && $key != "second_add" && $key != "first" && $key != "second" && $key != "content" && $key != "tags" && $key != "description") {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                }
            }

            $input['update_by'] = $this->user->id;
            if (!empty($input['date_booking'])) {
                $date_booking = explode('/', $input['date_booking']);
                $input['start_booking'] = $date_booking[0];
                $input['end_booking'] = $date_booking[1];
            }
            if (!empty($input['date']) && !empty($input['time'])) {
                $time = explode(' ', $input['time']);
                $input['time'] = $time[1];
                $input['date'] = $input['date'] . ' ' . $time[0];
            }
            $first_add = isset($_POST['first_add']) ? $_POST['first_add'] : array();
            $second_add = isset($_POST['second_add']) ? $_POST['second_add'] : array();
            $first = isset($_POST['first']) ? $_POST['first'] : array();
            $second = isset($_POST['second']) ? $_POST['second'] : array();
            $data_first = $data_second = [];
            if (!empty($first_add)) {
                foreach ($first_add as $first_add_value) {
                    $input['name_player'] = trim(filter_var($first_add_value['name_player'], FILTER_SANITIZE_STRING));
                    $input['time_player'] = trim(filter_var($first_add_value['time_player'], FILTER_SANITIZE_STRING));
                    if ($input['name_player'] != '') {
                        $data_first[] = ['name_player' => $input['name_player'], 'time_player' => $input['time_player']];
                    }
                }
            }
            if (!empty($first)) {
                foreach ($first as $first_add_value) {
                    $input['name_player'] = trim(filter_var($first_add_value['name_player'], FILTER_SANITIZE_STRING));
                    $input['time_player'] = trim(filter_var($first_add_value['time_player'], FILTER_SANITIZE_STRING));
                    if ($input['name_player'] != '') {
                        $data_first[] = ['name_player' => $input['name_player'], 'time_player' => $input['time_player']];
                    }
                }
            }

            if (!empty($second_add)) {
                foreach ($second_add as $second_add_value) {
                    $input['name_player'] = trim(filter_var($second_add_value['name_player'], FILTER_SANITIZE_STRING));
                    $input['time_player'] = trim(filter_var($second_add_value['time_player'], FILTER_SANITIZE_STRING));
                    if ($input['name_player'] != '') {
                        $data_second[] = ['name_player' => $input['name_player'], 'time_player' => $input['time_player']];
                    }
                }
            }
            if (!empty($second)) {
                foreach ($second as $second_add_value) {
                    $input['name_player'] = trim(filter_var($second_add_value['name_player'], FILTER_SANITIZE_STRING));
                    $input['time_player'] = trim(filter_var($second_add_value['time_player'], FILTER_SANITIZE_STRING));
                    if ($input['name_player'] != '') {
                        $data_second[] = ['name_player' => $input['name_player'], 'time_player' => $input['time_player']];
                    }
                }
            }
            $result = array('cart_yellow1' => $input['cart_yellow1'], 'cart_yellow2' => $input['cart_yellow2'],
                'cart_red1' => $input['cart_red1'], 'cart_red2' => $input['cart_red2'], 'offside1' => $input['offside1'],
                'offside2' => $input['offside2'], 'strikes1' => $input['strikes1'], 'strikes2' => $input['strikes2'],
                'paying_goal1' => $input['paying_goal1'], 'paying_goal2' => $input['paying_goal2'], 'passes1' => $input['passes1'], 'passes2' => $input['passes2'],
                'data_first' => $data_first, 'data_second' => $data_second
            );
            $input['result'] = json_encode($result, true);

            $match->update($input);
            $match_id = $match->id;

            Taggable::deleteTaggableType($id, $input['type']);
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
                        $taggable_id = Taggable::foundTaggable($tag_id, $match->id, "match");
                        if ($taggable_id == 0) {
                            $taggable->insertTaggable($tag_id, $match->id, "match");
                        }
                    }
                }
            }

            if ($this->user->can(['access-all', 'match-type-all', 'match-all', 'match-edit'])) {
                return redirect()->route('admin.matches.index')
                                ->with('success', 'Updated successfully');
            } elseif ($this->user->can('match-edit-only')) {
                return redirect()->route('admin.users.index')->with('success', 'Updated successfully');
            }
        } else {
            return $match->pageError();
        }
    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function destroy($id) {
        $match = Match::find($id);
        if (!empty($match)) {
            if (!$this->user->can(['access-all', 'match-type-all', 'match-all', 'match-delete', 'match-delete-only'])) {
                if ($this->user->can(['match-list'])) {
                    return redirect()->route('admin.matches.index')->with('error', 'Have No Access');
                } else {
                    return $match->pageUnauthorized();
                }
            }

            if ($this->user->can('match-delete-only') && !$this->user->can(['access-all', 'match-type-all', 'match-all', 'match-delete'])) {
                if (($this->user->id != $this->user_id)) {
                    if ($this->user->can(['match-list'])) {
                        return redirect()->route('admin.matches.index')->with('error', 'Have No Access');
                    } else {
                        return $match->pageUnauthorized();
                    }
                }
            }
            $typematch = $match->type;
            Taggable::deleteTaggableType($id, $match->type);
            Match::find($id)->delete();
            if ($this->user->can(['access-all', 'match-type-all', 'match-all', 'match-delete'])) {
                return redirect()->route('admin.matches.index')
                                ->with('success', 'Match deleted successfully');
            } elseif ($this->user->can(['match-delete-only'])) {
                return redirect()->route('admin.users.index')->with('success', 'Match deleted successfully');
            }
        } else {
            return $match->pageError();
        }
    }

    public function search(Request $request) {
        $type = 'match';
        $type_name = trans('app.matches');

        $type_action = $type_name;
        if (!$this->user->can(['access-all', 'match-type-all', 'match-all', 'match-list', 'match-edit', 'match-delete', 'match-show'])) {
            return $this->pageUnauthorized();
        }

        $match_active = $match_edit = $match_create = $match_delete = $match_show = $comment_list = $comment_create = 0;

        if ($this->user->can(['access-all', 'match-type-all', 'match-all'])) {
            $match_active = $match_edit = $match_create = $match_delete = $match_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('match-edit')) {
            $match_active = $match_edit = $match_create = $match_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('match-delete')) {
            $match_delete = 1;
        }

        if ($this->user->can('match-show')) {
            $match_show = 1;
        }

        if ($this->user->can('match-create')) {
            $match_create = 1;
        }

        if ($this->user->can(['comment-all', 'comment-edit'])) {
            $comment_list = $comment_create = 1;
        }

        if ($this->user->can('comment-list')) {
            $comment_list = 1;
        }

        if ($this->user->can('comment-create')) {
            $comment_create = 1;
        }
        $name = 'matches';
        $data = Match::orderBy('id', 'DESC')->where('type', 'match')->get();
        return view('admin.matches.search', compact('type', 'type_name', 'type_action', 'data', 'name', 'comment_create', 'comment_list', 'match_active', 'match_create', 'match_edit', 'match_delete', 'match_show'));
    }

    //*****************************************Not use comment *************************************************
    public function comments(Request $request, $id) {

        $match = Match::find($id);
        if (!empty($match)) {
            if (!$this->user->can(['access-all', 'match-type-all', 'match-all', 'match-edit', 'match-edit-only', 'match-show', 'match-show-only'])) {
                if ($this->user->can(['match-list', 'match-create'])) {
                    return redirect()->route('admin.matches.index')->with('error', 'Have No Access');
                } else {
                    return $match->pageUnauthorized();
                }
            }

            if ($this->user->can(['match-edit-only', 'match-show-only']) && !$this->user->can(['access-all', 'match-type-all', 'match-all', 'match-edit', 'match-show'])) {
                if (($this->user->id != $this->user_id)) {
                    if ($this->user->can(['match-list', 'match-create'])) {
                        return redirect()->route('admin.matches.index')->with('error', 'Have No Access');
                    } else {
                        return $match->pageUnauthorized();
                    }
                }
            }

            if (!$this->user->can(['access-all', 'match-type-all', 'match-all', 'comment-all', 'comment-list', 'comment-edit', 'comment-delete'])) {
                return $match->pageUnauthorized();
            }

            $comment_active = $comment_edit = $comment_delete = $comment_list = $comment_create = 0;

            if ($this->user->can(['access-all', 'match-type-all', 'match-all', 'comment-all'])) {
                $comment_active = $comment_edit = $comment_delete = $comment_list = $comment_create = 1;
            }

            if ($this->user->can(['comment-edit', 'comment-edit-match-only'])) {
                $comment_active = $comment_edit = $comment_list = $comment_create = 1;
            }

            if ($this->user->can(['comment-delete', 'comment-delete-match-only'])) {
                $comment_delete = 1;
            }

            if ($this->user->can('comment-create')) {
                $comment_create = 1;
            }

            $name = 'matches';

            $data = CommentMatch::where('commentable_id', $id)->where('commentable_type', 'matches')->paginate($this->limit);
            return view('admin.matches.comments', compact('data', 'id', 'name', 'comment_create', 'comment_list', 'comment_active', 'comment_edit', 'comment_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
        } else {
            return $match->pageError();
        }
    }

    public function commentCreate($id) {

        $match = Match::find($id);
        if (!empty($match)) {
            if (!$this->user->can(['access-all', 'match-type-all', 'match-all', 'comment-all', 'comment-create', 'comment-edit'])) {
                return $match->pageUnauthorized();
            }
            $users = User::pluck('id', 'name');
            $comment_active = $user_active = 0;
            if ($this->user->can(['access-all', 'match-type-all', 'match-all', 'comment-all', 'comment-edit'])) {
                $comment_active = 1;
            }
            $new = 1;
            $user_id = $this->user->id;
            return view('admin.matches.comment_create', compact('users', 'user_id', 'id', 'new', 'comment_active'));
        } else {
            return $match->pageError();
        }
    }

    public function commentStore(Request $request, $id) {

        $match = Match::find($id);
        if (!empty($match)) {
            if (!$this->user->can(['access-all', 'match-type-all', 'match-all', 'comment-all', 'comment-create', 'comment-edit'])) {
                if ($this->user->can(['match-list'])) {
                    return redirect()->route('admin.matches.index')->with('error', 'Have No Access');
                } else {
                    return $match->pageUnauthorized();
                }
            }
            $match->validate($request, [
                'content' => 'required',
            ]);

            $input = $request->all();
            foreach ($input as $key => $value) {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            $input['type'] = "matches";
            $is_read = 1;

            if (!isset($input['is_active'])) {
                $comment_active = DB::table('options')->where('option_key', 'comment_active')->value('option_value');
                $input['is_active'] = is_numeric($comment_active) ? $comment_active : 0;
                $input['user_id'] = $this->user->id;
                $is_read = 0;
            }
            $name = User::userData($input['user_id'], "name");
            $email = User::userData($input['user_id'], "email");
            $visitor = $request->ip();
            $comment = new CommentMatch();
            $comment->insertCommentMatch($input['user_id'], $visitor, $name, $email, $id, $input['type'], $input['content'], 0, "text", $is_read, $input['is_active']);
            return redirect()->route('admin.matches.comments.index', [$id])->with('success', 'CommentMatch created successfully');
        } else {
            return $match->pageError();
        }
    }

}
