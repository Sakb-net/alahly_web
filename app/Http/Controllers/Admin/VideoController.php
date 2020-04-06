<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Model\Video;
use App\Model\CommentVideo;
use App\Model\Post;
use App\Model\Options;
use App\Model\Tag;
use App\Model\Taggable;
use DB;

class VideoController extends AdminController {

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function index(Request $request) {

        if (!$this->user->can(['access-all', 'post-type-all', 'video*'])) {
            return $this->pageUnauthorized();
        }

        $video_delete = $video_edit = $video_active = $video_show = $video_create = 0;

        if ($this->user->can(['access-all', 'post-type-all'])) {
            $video_delete = $video_active = $video_edit = $video_show = $video_create = 1;
        }

        if ($this->user->can('video-all')) {
            $video_delete = $video_active = $video_edit = $video_create = 1;
        }

        if ($this->user->can('video-delete')) {
            $video_delete = 1;
        }

        if ($this->user->can('video-edit')) {
            $video_active = $video_edit = $video_create = 1;
        }

        if ($this->user->can('video-create')) {
            $video_create = 1;
        }
        $type_action = 'الفديوهات';
        $data = Video::orderBy('id', 'DESC')->paginate($this->limit); //where('table_id', NULL)->
        return view('admin.videos.index', compact('type_action', 'data', 'video_active', 'video_create', 'video_edit', 'video_show', 'video_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function create() {

        if (!$this->user->can(['access-all', 'post-type-all', 'video-all', 'video-create', 'video-edit'])) {
            return $this->pageUnauthorized();
        }
        if ($this->user->can(['access-all', 'post-type-all', 'video-all', 'video-edit'])) {
            $video_active = 1;
        } else {
            $video_active = 0;
        }
        $new = $upload = 1;
        $image_link = null;
        $link_return = route('admin.videos.index');
        return view('admin.videos.create', compact('link_return', 'image_link', 'upload', 'new', 'video_active'));
    }

    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */
    public function store(Request $request) {

        if (!$this->user->can(['access-all', 'post-type-all', 'video-all', 'video-create', 'video-edit'])) {
            if ($this->user->can('video-list')) {
                return redirect()->route('admin.videos.index')->with('error', 'Have No Access');
            } else {
                return $this->pageUnauthorized();
            }
        }

        $this->validate($request, [
            'name' => 'required|max:255',
        ]);

        $input = $request->all();
        foreach ($input as $key => $value) {
            if ($key != "tags" && $key != "content") {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
        }

//        $input['type'] = "main";
//        $input['is_active'] =1;
        if (!empty($input['video_content']) && ($input['video_content'] != $input['video'])) {
            $input['video'] = $input['video_content'];
            $input['extension'] = pathinfo($input['video'], PATHINFO_EXTENSION);
        } else {
            $input['extension'] = 'mp4';
            $input['video'] = str_replace("youtube.com/watch?v=", "youtube.com/v/", $input['video']);
        }
        if ($input['link'] == Null) {
            $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
        }
        $input['is_active'] = 1;
//        if (!isset($input['is_active'])) {
//            $video_active = Options::where('option_key', 'post_active')->value('option_value');
//            $input['is_active'] = is_numeric($video_active) ? $video_active : 0;
//        }
//http://www.youtube.com/v/Qtfskc4_Ma8
//https://www.youtube.com/watch?v=Qtfskc4_Ma8

        $input['user_id'] = $this->user->id;
        $input['table_id'] = NULL;
        $input['table_name'] = NULL;
        $video = Video::create($input);
        return redirect()->route('admin.videos.index')->with('success', 'Video created successfully');
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function show(Request $request, $id) {
//        $video = Video::find($id);
        return redirect()->route('admin.videos.edit', $id);
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function edit($id) {

        $video = Video::find($id);
        if (!empty($video)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'video-all', 'video-edit'])) {
                if ($this->user->can(['video-list', 'video-create'])) {
                    return redirect()->route('admin.videos.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            $video_active = 1;
            $new = $upload = 0;
            $link_return = route('admin.videos.index');
            $image_link = $video->image;
            $data_video = $video->video;
            $array_upload = explode('uploads', $data_video);
            if (count($array_upload) >= 2) {
                $upload = 1;
            }
            return view('admin.videos.edit', compact('image_link', 'upload', 'link_return', 'video', 'video_active', 'new'));
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

        $video = Video::find($id);
        if (!empty($video)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'video-all', 'video-edit'])) {
                if ($this->user->can(['video-list', 'video-create'])) {
                    return redirect()->route('admin.videos.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }

            $this->validate($request, [
                'name' => 'required|max:255',
            ]);


            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != "tags" && $key != "content") {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                }
            }


            if (!empty($input['video_content']) && ($input['video_content'] != $video->video)) {
                $input['video'] = $input['video_content'];
                $input['extension'] = pathinfo($input['video'], PATHINFO_EXTENSION);
            } else {
                $input['extension'] = 'mp4';
                $input['video'] = str_replace("youtube.com/watch?v=", "youtube.com/v/", $input['video']);
            }
//        $input['user_id'] = $this->user->id;
            $input['table_id'] = NULL;
            $input['table_name'] = NULL;
            if ($input['link'] == Null) {
                $input['link'] = str_replace(' ', '_', $input['name'] . str_random(8));
            }
            $link_count = Video::foundLink($input['link']);
            if ($link_count > 0) {
                $input['link'] = $video->link;
            }
            $video->update($input);

            return redirect()->route('admin.videos.index')
                            ->with('success', 'Video updated successfully');
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
        $video = Video::find($id);
        if (!empty($video)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'video-all', 'video-delete'])) {
                if ($this->user->can(['video-list', 'video-edit'])) {
                    return redirect()->route('admin.videos.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            Video::find($id)->delete();
            return redirect()->route('admin.videos.index')
                            ->with('success', 'Video deleted successfully');
        } else {
            return $this->pageError();
        }
    }

    public function search() {

        if (!$this->user->can(['access-all', 'post-type-all', 'video-all', 'video-list'])) {
            return $this->pageUnauthorized();
        }

        $video_delete = $video_edit = $video_active = $video_show = $video_create = 0;

        if ($this->user->can(['access-all', 'post-type-all'])) {
            $video_delete = $video_active = $video_edit = $video_show = $video_create = 1;
        }

        if ($this->user->can('video-all')) {
            $video_delete = $video_active = $video_edit = $video_create = 1;
        }

        if ($this->user->can('video-delete')) {
            $video_delete = 1;
        }

        if ($this->user->can('video-edit')) {
            $video_active = $video_edit = $video_create = 1;
        }

        if ($this->user->can('video-create')) {
            $video_create = 1;
        }
        $type_action = 'الفديوهات';
//        $data = Video::with('user')->where('table_id', NULL)->get();
        $data = Video::orderBy('id', 'DESC')->get(); //where('table_id', NULL)->
        return view('admin.videos.search', compact('type_action', 'data', 'video_create', 'video_edit', 'video_show', 'video_active', 'video_delete'));
    }

    public function allSearch() {

        if (!$this->user->can(['access-all', 'post-type-all', 'video-all', 'video-list'])) {
            return $this->pageUnauthorized();
        }

        $video_delete = $video_edit = $video_active = $video_show = $video_create = 0;

        if ($this->user->can(['access-all', 'post-type-all'])) {
            $video_delete = $video_active = $video_edit = $video_show = $video_create = 1;
        }

        if ($this->user->can('video-all')) {
            $video_delete = $video_active = $video_edit = $video_create = 1;
        }

        if ($this->user->can('video-delete')) {
            $video_delete = 1;
        }

        if ($this->user->can('video-edit')) {
            $video_active = $video_edit = $video_create = 1;
        }

        if ($this->user->can('video-create')) {
            $video_create = 1;
        }
        $type_action = 'الفديوهات';
//        $data = Video::with('user')->get();
        $data = Video::orderBy('id', 'DESC')->get(); //where('table_id', NULL)->
        return view('admin.videos.search', compact('type_action', 'data', 'video_create', 'video_edit', 'video_show', 'video_active', 'video_delete'));
    }

///*****************  comment for video ***********************************
    public function comments(Request $request, $id) {
        $video = Video::find($id);
        if (!empty($video)) {
            if (!$this->user->can(['access-all', 'video-type-all', 'video-all', 'video-edit', 'video-edit-only', 'video-show', 'video-show-only'])) {
                if ($this->user->can(['video-list', 'video-create'])) {
                    session()->put('error', trans('app.no_access'));
                    return redirect()->route('admin.' . $video->type . 's.index');
                } else {
                    return $video->pageUnauthorized();
                }
            }
            if ($this->user->can(['video-edit-only', 'video-show-only']) && !$this->user->can(['access-all', 'video-type-all', 'video-all', 'video-edit', 'video-show'])) {
                if (($this->user->id != $this->user_id)) {
                    if ($this->user->can(['video-list', 'video-create'])) {
                        session()->put('error', trans('app.no_access'));
                        return redirect()->route('admin.' . $video->type . 's.index');
                    } else {
                        return $video->pageUnauthorized();
                    }
                }
            }

            if (!$this->user->can(['access-all', 'video-type-all', 'video-all', 'comment-all', 'comment-list', 'comment-edit', 'comment-delete'])) {
                return $video->pageUnauthorized();
            }

            $comment_active = $comment_edit = $comment_delete = $comment_list = $comment_create = 0;

            if ($this->user->can(['access-all', 'video-type-all', 'video-all', 'comment-all'])) {
                $comment_active = $comment_edit = $comment_delete = $comment_list = $comment_create = 1;
            }

            if ($this->user->can(['comment-edit', 'comment-edit-video-only'])) {
                $comment_active = $comment_edit = $comment_list = $comment_create = 1;
            }

            if ($this->user->can(['comment-delete', 'comment-delete-video-only'])) {
                $comment_delete = 1;
            }

            if ($this->user->can('comment-create')) {
                $comment_create = 1;
            }

            $name = $video->type;
            $type_action = '';
            $data = CommentVideo::where('video_id', $id)->paginate($this->limit);  //where('type','question')->
            $link_return = route('admin.videos.index'); //route('admin.videos.comments.index',$id);
            return view('admin.videocomments.index', compact('link_return','video', 'type_action', 'data', 'id', 'name', 'comment_create', 'comment_list', 'comment_active', 'comment_edit', 'comment_delete'))->with('i', ($request->input('page', 1) - 1) * 5);
        } else {
            $error = new AdminController();
            return $error->pageError();
        }
    }

    public function commentCreate($id) {

        $video = Video::find($id);
        if (!empty($video)) {
            if (!$this->user->can(['access-all', 'video-type-all', 'video-all', 'comment-all', 'comment-create', 'comment-edit'])) {
                return $video->pageUnauthorized();
            }
            $users = User::pluck('id', 'name');
            $comment_active = $user_active = 0;
            if ($this->user->can(['access-all', 'video-type-all', 'video-all', 'comment-all', 'comment-edit'])) {
                $comment_active = 1;
            }
            $new = 1;
            $user_id = $this->user->id;
            $link_return = route('admin.videos.comments.index',$video->id);
            return view('admin.videocomments.create', compact('users','video','link_return','user_id', 'id', 'new', 'comment_active'));
        } else {
            $error = new AdminController();
            return $error->pageError();
        }
    }

    public function commentStore(Request $request, $id) {
        $video = Video::find($id);
        if (!empty($video)) {
            if (!$this->user->can(['access-all', 'video-type-all', 'video-all', 'comment-all', 'comment-create', 'comment-edit'])) {
                if ($this->user->can(['video-list'])) {
                    session()->put('error', trans('app.no_access'));
                    return redirect()->route('admin.' . $video->type . 's.index');
                } else {
                    return $video->pageUnauthorized();
                }
            }
            $this->validate($request, [
                'content' => 'required',
            ]);

            $input = $request->all();
            foreach ($input as $key => $value) {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            $input['type'] = $video->type;
            $is_read = 1;
            if (!isset($input['is_active'])) {
                $comment_active = \App\Model\Options::where('option_key', 'comment_active')->value('option_value');
                $input['is_active'] = is_numeric($comment_active) ? $comment_active : 0;
                $input['user_id'] = $this->user->id;
                $is_read = 0;
            }
            $name = $this->user->display_name;
            $email = $this->user->email;
            $user_image = $this->user->image;
            if(empty($user_image)){
                $user_image = '/images/user.png';
            }
            $visitor = $request->ip();
            $comment = new CommentVideo();
            $comment->insertComment($input['user_id'], $user_image, $name, $email, $id, $input['type'], $input['content'], null, "text", $is_read, $input['is_active']);
            session()->put('success', trans('app.save_success'));
            return redirect()->route('admin.' . $video->type . 's.comments.index', [$id]);
        } else {
            $error = new AdminController();
            return $error->pageError();
        }
    }

}

