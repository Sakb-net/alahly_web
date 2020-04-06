<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Model\Post;
//use App\Model\PostMeta;
use App\Model\Video;
use DB;

class VideoController_try extends AdminController {

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function vidoesCourse(Request $request, $id) {
        $post = $post = Post::find($id);
        $post_id = $id;
        if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-list', 'post-edit', 'post-delete', 'post-show'])) {
            return $this->pageUnauthorized();
        }

        $post_active = $post_edit = $post_create = $post_delete = $post_show = $comment_list = $comment_create = 0;

        if ($this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            $post_active = $post_edit = $post_create = $post_delete = $post_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('post-edit')) {
            $post_active = $post_edit = $post_create = $post_show = 1;
        }

        if ($this->user->can('post-delete')) {
            $post_delete = 1;
        }

        if ($this->user->can('post-show')) {
            $post_show = 1;
        }

        if ($this->user->can('post-create')) {
            $post_create = 1;
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
        $name = 'videos';
        $type_action = 'الفديو';
        $link_return = route('admin.posts.index');
        $all_video=Video::where('post_id', $id)->with('user')->orderBy('id', 'DESC')->paginate($this->limit);
        return view('admin.posts.videos.video', compact('link_return','all_video','post','post_id','post', 'type_action', 'name', 'comment_create', 'comment_list', 'post_active', 'post_create', 'post_edit', 'post_delete', 'post_show'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function edit($id) {
        $post = Post::find($id);
        if (!empty($post) && $post->type == 'post') {
            if ($this->user->id != $post->user_id) {
                if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-edit', 'post-edit-only'])) {
                    if ($this->user->can(['post-list', 'post-create'])) {
                        return redirect()->route('admin.posts.index')->with('error', 'Have No Access');
                    } else {
                        return $post->pageUnauthorized();
                    }
                }
            }

            if ($this->user->can('post-edit-only') && !$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-edit'])) {
                if (($this->user->id != $this->user_id)) {
                    if ($this->user->can(['post-list', 'post-create'])) {
                        return redirect()->route('admin.posts.index')->with('error', 'Have No Access');
                    } else {
                        return $post->pageUnauthorized();
                    }
                }
            }

            $image = $new = 0;
            if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'post-edit'])) {
                $post_active = $image = 1;
            } else {
                $post_active = 0;
            }
            if ($this->user->can(['image-edit'])) {
                $image = 1;
            }
            if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'post-edit'])) {
                $post_active = 1;
            } else {
                $post_active = 0;
            }
            if ($post_active == 1) {
                $post->updatePostRead($id);
            }
            $type_action = 'الفديوهات';
            $all_video = Video::where('post_id', $id)->with('user')->orderBy('id', 'DESC')->paginate($this->limit);

            $link_return = route('admin.posts.index');
            return view('admin.posts.videos.video', compact('all_video', 'link_return', 'new', 'type_action', 'post_active'));
        } else {
            return $post->pageError();
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
        $post = Post::find($id);
        $post_id = $post->id;
        $image = 0;
        if (!empty($post) && $post->type == 'post') {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-edit', 'post-edit-only'])) {
                if ($this->user->can(['post-list', 'post-create'])) {
                    return redirect()->route('admin.posts.videos.index')->with('error', 'Have No Access');
                } else {
                    return $post->pageUnauthorized();
                }
            }

            if ($this->user->can('post-edit-only') && !$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-edit'])) {
                if (($this->user->id != $this->user_id)) {
                    if ($this->user->can(['post-list', 'post-create'])) {
                        return redirect()->route('admin.posts.videos.index')->with('error', 'Have No Access');
                    } else {
                        return $post->pageUnauthorized();
                    }
                }
            }
//            $this->validate($request, [
//                'name' => 'required|max:255',
//                'link' => "max:255|uniquePostUpdateLinkType:$request->type,$id",
//            ]);
            $input = $request->all();
            foreach ($input as $key => $value) {
                if ($key != "video" && $key != "video_add") {
                    $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
                }
            }
            $array_video_id = Video::where('post_id', $post_id)->pluck('id', 'id')->toArray();

            $video = isset($_POST['video']) ? $_POST['video'] : array();
            $video_add = isset($_POST['video_add']) ? $_POST['video_add'] : array();
            $current_video_id = array();
            if (!empty($video)) {
                foreach ($video as $video_value) {
//                        $input['post_id'] = $post_id;
                    $input['id'] = (int) $video_value['video_id'];
                    $input['video'] = trim(filter_var($video_value['video_content'], FILTER_SANITIZE_STRING));
                    $input['extension'] = pathinfo($input['video'], PATHINFO_EXTENSION);
//                    $input['time'] = '00:00';//calculate time of video
                    $input['name'] = trim(filter_var($video_value['name'], FILTER_SANITIZE_STRING));
                    $input['image'] = trim(filter_var($video_value['video_image'], FILTER_SANITIZE_STRING));
                    $input['is_active'] = trim(filter_var($video_value['is_active'], FILTER_SANITIZE_STRING));
                    $input['link'] = str_replace(" ", "_", $input['name'] . generateRandomValue()); //trim(filter_var($video_value['link'], FILTER_SANITIZE_STRING));
                    $current_video_id[] = $input['id'];
                    if ($input['id'] != '' || $input['name'] != '' || $input['video'] != '' || $input['is_active'] != '') {
                        $update_video = Video::find($input['id']);
                        $update_video->update($input);
                    }
                }
            }
            $result = array_diff($array_video_id, $current_video_id);
            if (!empty($result)) {
                Video::deleteArrayVideo($result);
//                    foreach ($result as $video_id_one) {
//                        Video::deleteVideo($video_id_one);
//                    }
            }
            $input = [];
            if (!empty($video_add)) {
                foreach ($video_add as $video_add_value) {
                    $input['user_id'] = $this->user->id;
                    $input['post_id'] = $post_id;
                    $input['video'] = trim(filter_var($video_add_value['video_content'], FILTER_SANITIZE_STRING));
                     $input['extension'] = pathinfo($input['video'], PATHINFO_EXTENSION);
                    $input['time'] = '00:00';//calculate time of video
                    $input['name'] = trim(filter_var($video_add_value['name'], FILTER_SANITIZE_STRING));
                    $input['image'] = trim(filter_var($video_add_value['video_image'], FILTER_SANITIZE_STRING));
                    $input['is_active'] = 1; //trim(filter_var($video_add_value['is_active'], FILTER_SANITIZE_STRING));
                    $input['link'] = str_replace(" ", "_", $input['name'] . generateRandomValue()); //trim($video_add_value($video_value['link'], FILTER_SANITIZE_STRING));
                    if ($input['name'] != '' || $input['video'] != '') {
                        $add_video = Video::create($input);
                    }
                }
            }

            if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'post-edit'])) {
                return redirect()->route('admin.posts.videos.index', $post_id)
                                ->with('success', 'Video updated successfully');
            } elseif ($this->user->can('post-edit-only')) {
                return redirect()->route('admin.posts.index')->with('success', 'Video updated successfully');
            }
        } else {
            return $post->pageError();
        }
    }

    public function search() {


        if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'post-list', 'post-edit', 'post-delete', 'post-show'])) {
            return $post->pageUnauthorized();
        }

        $post_active = $post_edit = $post_create = $post_delete = $post_show = $comment_list = $comment_create = 0;

        if ($this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            $post_create = 0;
            $post_active = $post_edit = $post_delete = $post_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('post-edit')) {
            $post_create = 0;
            $post_active = $post_edit = $post_show = $comment_list = $comment_create = 1;
        }

        if ($this->user->can('post-delete')) {
            $post_delete = 1;
        }

        if ($this->user->can('post-show')) {
            $post_show = 1;
        }

        if ($this->user->can('post-create')) {
            $post_create = 0; // 1;
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
        $name = 'videos';
        $type_action = 'الفديو';
        $data = Video::with('user')->orderBy('id', 'DESC')->paginate($this->limit);
        return view('admin.posts.videos.search', compact('type_action', 'data', 'name', 'comment_create', 'comment_list', 'post_active', 'post_create', 'post_edit', 'post_delete', 'post_show'));
    }

}
