<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Model\Blog;
use App\Model\CommentBlog;
use DB;

class CommentBlogController extends AdminController {

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function index(Request $request) {

        if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all', 'comment-create', 'comment-list', 'comment-edit', 'comment-delete'])) {
            return $this->pageUnauthorized();
        }

        $comment_active = $comment_edit = $comment_delete = $comment_create = 0;

        if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all'])) {
            $comment_active = $comment_edit = $comment_create = $comment_delete = $comment_create = 1;
        }

        if ($this->user->can('comment-edit')) {
            $comment_active = $comment_edit = $comment_create = 1;
        }

        if ($this->user->can('comment-delete')) {
            $comment_delete = 1;
        }

        if ($this->user->can('comment-create')) {
            $comment_create = 1;
        }
        $type_action = 'التعليقات';
        $data = CommentBlog::where('parent_one_id', null)->orderBy('id', 'DESC')->paginate($this->limit);
        return view('admin.blogcomments.index', compact('data', 'type_action', 'comment_active', 'comment_create', 'comment_edit', 'comment_delete'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function type(Request $request, $type) {

        $type_array = ['posts'];
        if (!in_array($type, $type_array)) {
            return $this->pageUnauthorized();
        }

        if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all', 'comment-create', 'comment-list', 'comment-edit', 'comment-delete'])) {
            return $this->pageUnauthorized();
        }

        $comment_active = $comment_edit = $comment_delete = $comment_create = 0;

        if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all'])) {
            $comment_active = $comment_edit = $comment_create = $comment_delete = $comment_create = 1;
        }

        if ($this->user->can('comment-edit')) {
            $comment_active = $comment_edit = $comment_create = $comment_create = 1;
        }

        if ($this->user->can('comment-delete')) {
            $comment_delete = 1;
        }

        if ($this->user->can('comment-create')) {
            $comment_create = 1;
        }

        $data = CommentBlog::orderBy('id', 'DESC')->where('commentable_type', $type)->paginate($this->limit);
        return view('admin.blogcomments.index', compact('data', 'comment_create', 'comment_edit', 'comment_active', 'comment_delete'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function show(Request $request, $id) {
        $comment = CommentBlog::find($id);
        if (!empty($comment)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all', 'comment-create', 'comment-list', 'comment-edit', 'comment-delete'])) {
                return $this->pageUnauthorized();
            }

            $comment_active = $comment_edit = $comment_delete = $comment_create = 0;

            if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all'])) {
                $comment_active = $comment_edit = $comment_create = $comment_delete = $comment_create = 1;
            }

            if ($this->user->can('comment-edit')) {
                $comment_active = $comment_edit = $comment_create = 1;
            }

            if ($this->user->can('comment-delete')) {
                $comment_delete = 1;
            }

            if ($this->user->can('comment-create')) {
                $comment_create = 1;
            }
            $type_action = 'تعليق';
            $data = CommentBlog::orderBy('id', 'DESC')->where('parent_two_id', $id)->paginate($this->limit);
            return view('admin.blogcomments.index', compact('data', 'type_action', 'comment_active', 'comment_create', 'comment_edit', 'comment_delete'))
                            ->with('i', ($request->input('page', 1) - 1) * 5);
        } else {
            return $this->pageError();
        }
    }

    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */
    public function edit($id) {

        $comment = CommentBlog::find($id);
        if (!empty($comment)) {
            if ($this->user->id != $comment->user_id) {
                if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all', 'comment-edit', 'comment-edit-only'])) {
                    if ($this->user->can(['comment-list', 'comment-create'])) {
                        return redirect()->route('admin.blogcomments.index')->with('error', 'Have No Access');
                    } else {
                        return $this->pageUnauthorized();
                    }
                }
            }

            if ($this->user->can('comment-edit-only') && !$this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all', 'comment-edit'])) {
                if (($this->user->id != $comment->user_id)) {
                    if ($this->user->can(['comment-list', 'comment-create'])) {
                        return redirect()->route('admin.blogcomments.index')->with('error', 'Have No Access');
                    } else {
                        return $this->pageUnauthorized();
                    }
                }
            }

            $new = $comment_active = 0;
            if ($this->user->can(['access-all', 'comment-type-all', 'comment-all', 'comment-edit'])) {
                CommentBlog::updateOrderColumnID($id, 'is_read', 1);
                $comment_active = 1;
            }
            $blogComment = [];
            $blogs = Blog::pluck('name', 'id');
            $link_return = route('admin.blogcomments.index');
            return view('admin.blogcomments.edit', compact('comment', 'link_return', 'new', 'comment_active', 'blogComment', 'blogs'));
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

        $comment = CommentBlog::find($id);
        if (!empty($comment)) {
            if ($this->user->id != $comment->user_id) {
                if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all', 'comment-edit', 'comment-edit-only'])) {
                    if ($this->user->can(['comment-list', 'comment-create'])) {
                        return redirect()->route('admin.blogcomments.index')->with('error', 'Have No Access');
                    } else {
                        return $this->pageUnauthorized();
                    }
                }
            }

            if ($this->user->can('comment-edit-only') && !$this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all', 'comment-edit'])) {
                if (($this->user->id != $comment->user_id)) {
                    if ($this->user->can(['comment-list', 'comment-create'])) {
                        return redirect()->route('admin.blogcomments.index')->with('error', 'Have No Access');
                    } else {
                        return $this->pageUnauthorized();
                    }
                }
            }

            $this->validate($request, [
                'content' => 'required',
            ]);

            $input = $request->all();
            foreach ($input as $key => $value) {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            $comment_active = 0;
            if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-type-all', 'comment-all', 'comment-edit'])) {
                $comment_active = 1;
            }
            $comment->update($input);
//        $comment = new Comment();
//        $comment->updateComment($id, $input['content']);
//        if($comment_active > 0){
//            CommentBlog::updateCommentActive($id, $input['is_active']);    
//        }
            if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all', 'post-all', 'comment-edit'])) {
                return redirect()->route('admin.blogcomments.index')
                                ->with('success', 'Updated successfully');
            } elseif ($this->user->can('comment-edit-only')) {
                return redirect()->route('admin.users.comments', [$this->user->id, 'comments'])->with('success', 'Updated successfully');
            }
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

        $comment = CommentBlog::find($id);
        if (!empty($comment)) {
            if (!$this->user->can(['access-all', 'comment-type-all', 'comment-all', 'comment-delete', 'comment-delete-only'])) {
                if ($this->user->can(['comment-list'])) {
                    return redirect()->route('admin.blogcomments.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }

            if ($this->user->can('comment-delete-only') && !$this->user->can(['access-all', 'comment-type-all', 'comment-all', 'comment-delete'])) {
                if (($this->user->id != $comment->user_id)) {
                    if ($this->user->can(['comment-list'])) {
                        return redirect()->route('admin.blogcomments.index')->with('error', 'Have No Access');
                    } else {
                        return $this->pageUnauthorized();
                    }
                }
            }

            CommentBlog::find($id)->delete();
            if ($this->user->can(['access-all', 'comment-type-all', 'comment-all', 'comment-delete'])) {
                return redirect()->back()->with('success', 'Deleted successfully'); //route('admin.blogcomments.index')
            } elseif ($this->user->can(['comment-delete-only'])) {
                return redirect()->route('admin.users.commenttype', [$this->user->id, 'comments'])->with('success', 'Deleted successfully');
            }
        } else {
            return $this->pageError();
        }
    }

    public function allread() {
        if (!$this->user->can(['access-all', 'comment-type-all', 'comment-all', 'comment-delete', 'comment-delete-only'])) {
            if ($this->user->can(['comment-list'])) {
                return redirect()->route('admin.blogcomments.index')->with('error', 'Have No Access');
            } else {
                return $this->pageUnauthorized();
            }
        }
        if ($this->user->can('comment-delete-only') && !$this->user->can(['access-all', 'comment-type-all', 'comment-all', 'comment-delete'])) {
            if ($this->user->can(['comment-list'])) {
                return redirect()->route('admin.blogcomments.index')->with('error', 'Have No Access');
            } else {
                return $this->pageUnauthorized();
            }
        }
        CommentBlog::updateOrderColum('is_read', 0, 'is_read', 1);
        if ($this->user->can(['access-all', 'comment-type-all', 'comment-all', 'comment-delete'])) {
            return redirect()->back()->with('success', 'All Read successfully'); //route('admin.blogcomments.index')
        } elseif ($this->user->can(['comment-delete-only'])) {
            return redirect()->route('admin.users.commenttype', [$this->user->id, 'comments'])->with('success', 'All Read successfully');
        }
    }

    public function search() {

        if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all', 'comment-create', 'comment-list', 'comment-edit', 'comment-delete'])) {
            return $this->pageUnauthorized();
        }

        $comment_active = $comment_edit = $comment_delete = $comment_create = 0;

        if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all'])) {
            $comment_active = $comment_edit = $comment_create = $comment_delete = $comment_create = 1;
        }

        if ($this->user->can('comment-edit')) {
            $comment_active = $comment_edit = $comment_create = $comment_create = 1;
        }

        if ($this->user->can('comment-delete')) {
            $comment_delete = 1;
        }

        if ($this->user->can('comment-create')) {
            $comment_create = 1;
        }

        $data = CommentBlog::all();
        return view('admin.blogcomments.search', compact('data', 'comment_active', 'comment_create', 'comment_edit', 'comment_delete'));
    }

    public function reply($id) {
        $comment = CommentBlog::find($id);
        if (!empty($comment)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all', 'comment-create', 'comment-edit'])) {
                return $this->pageUnauthorized();
            }
            $users = User::pluck('name', 'id');
            $comment_active = $user_active = 0;
            if ($this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all', 'comment-edit'])) {
                $comment_active = 1;
            }
            $new = 1;
            $user_id = $this->user->id;
            $link_return = route('admin.blogcomments.index');
            return view('admin.blogcomments.reply', compact('users', 'link_return', 'user_id', 'id', 'new', 'comment_active'));
        } else {
            return $this->pageError();
        }
    }

    public function replyStore(Request $request, $id) {

        $comment = CommentBlog::find($id);
        if (!empty($comment)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all', 'comment-all', 'comment-create', 'comment-edit'])) {
                if ($this->user->can(['post-list'])) {
                    return redirect()->route('admin.posts.index')->with('error', 'Have No Access');
                } else {
                    return $this->pageUnauthorized();
                }
            }
            $this->validate($request, [
                'content' => 'required',
            ]);
            $commentable_type = $comment->type;
            $commentable_id = $comment->blog_id;
            if (empty($comment->parent_one_id)) {
                $parent_one_id = $comment->id;
            } else {
                $parent_one_id = $comment->parent_one_id;
            }
            if (empty($comment->parent_one_id)) {
                $parent_two_id = $parent_one_id;
            } else {
                $parent_two_id = $comment->id;
            }
            $input = $request->all();
            foreach ($input as $key => $value) {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }
            $input['type'] = "posts";
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
            $user_image = '/images/user.png';
            $comment_insert = new CommentBlog();
            $comment_insert->insertComment($input['user_id'], $user_image, $name, $email, $commentable_id, $commentable_type, $input['content'], $parent_one_id, null, $is_read, $input['is_active'], '', $parent_two_id);
            return redirect()->route('admin.blogcomments.show', [$id])->with('success', 'Comment created successfully');
        } else {
            return $this->pageError();
        }
    }

}
