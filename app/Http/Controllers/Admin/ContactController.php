<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\User;
use App\Model\ContactReply;
use App\Model\Contact;
use DB;

class ContactController extends AdminController {

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */
    public function type(Request $request,$type) {

        if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            return $this->pageUnauthorized();
        }

        $contact_active = $contact_edit = $contact_delete = $contact_create = 1;
        $type_action='الرساله';
        $data = Contact::where('type',$type)->orderBy('id', 'ASC')->paginate($this->limit);
        return view('admin.contacts.index', compact('type','type_action','data', 'contact_active', 'contact_create', 'contact_edit', 'contact_delete'))
                        ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */
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
    public function show($id) {

        $contact = Contact::find($id);
        if (!empty($contact)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
                return $this->pageUnauthorized();
            }
            Contact::updateContactRead($id);
            $contact_active = 1;
            $contact_reply = [];//DB::table('contact_reply')->where('contact_id', $id)->get()->toArray();
            $link_return=route('admin.contacts.type',$contact->type);
            return view('admin.contacts.show', compact('link_return','contact','contact_reply','contact_active'));
        } else {
            return $this->pageError();
        }
    }
    public function edit($id) {

        $contact = Contact::find($id);
        if (!empty($contact)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
                return $this->pageUnauthorized();
            }
            Contact::updateContactRead($id);
            $contact_active = 1;
            $contact_reply = [];//DB::table('contact_reply')->where('contact_id', $id)->get()->toArray();
            $link_return=route('admin.contacts.type',$contact->type);
            return view('admin.contacts.edit', compact('link_return','contact','contact_reply','contact_active'));
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

        $contact = Contact::find($id);
        if (!empty($contact)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
                return $this->pageUnauthorized();
            }
            $this->validate($request, [
                'title' => 'required',
                'content' => 'required',
            ]);

            $input = $request->all();
            foreach ($input as $key => $value) {
                $input[$key] = stripslashes(trim(filter_var($value, FILTER_SANITIZE_STRING)));
            }

            $contact = new Contact();
            $contact->updateContactReply($id);
            $input['contact_id'] = $id;
//            $contact_reply = new ContactReply();
//            $contact_reply->insertReply($id,$input['title'], $input['content']);
            ContactReply::create($input);
            return redirect()->route('admin.contacts.type',$contact->type)
                            ->with('success', 'Contact updated successfully');
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

        $contact = Contact::find($id);
        if (!empty($contact)) {
            if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
                return $this->pageUnauthorized();
            }
            $type=$contact->type;
            Contact::find($id)->delete();
            return redirect()->route('admin.contacts.type',$type)
                            ->with('success', 'Contact deleted successfully');
        } else {
            return $this->pageError();
        }
    }

    public function search($type) {

        if (!$this->user->can(['access-all', 'post-type-all', 'post-all'])) {
            return $this->pageUnauthorized();
        }

        $contact_active = $contact_edit = $contact_delete = $contact_create = 1;
        $type_action='الرسالة';
        $data = Contact::where('type',$type)->get();
//        $data = Contact::all();
        return view('admin.contacts.search', compact('type','type_action','data', 'contact_active', 'contact_create', 'contact_edit', 'contact_delete'));
    }

}
