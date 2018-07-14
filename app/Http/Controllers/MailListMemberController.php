<?php

namespace App\Http\Controllers;

use App\MailList;
use App\MailListMember;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Mailchimp\Mailchimp;

class MailListMemberController extends Controller
{
  /**
   * Return list of mail-list members.
   *
   * @param MailList $mailList
   * @return \Illuminate\Database\Eloquent\Collection|static[]
   */
  public function index(MailList $mailList)
  {
    return MailListMember::where('mail_list_id', $mailList->id)->get();
  }

  /**
   * Return one member of mail-list.
   *
   * @param MailList $mailList
   * @param $email
   * @return MailListMember
   */
  public function show(MailList $mailList, $email)
  {
    $mailListMember = MailListMember::where('email', $email)->where('mail_list_id', $mailList->id)->first();
    if ($mailListMember === null) {
      throw new ModelNotFoundException();
    }
    return $mailListMember;
  }

  /**
   * Subscribe member to mail-list.
   * Return "201" code if success.
   *
   * @param Request $request
   * @param MailList $mailList
   * @throws \Exception
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(Request $request, MailList $mailList)
  {
    if ($request->input('email') === null) {
      throw new \InvalidArgumentException("missed parameter 'email'");
      // TODO: unit test for it
    }
    if (!filter_var($request->input('email'), FILTER_VALIDATE_EMAIL)) {
      throw new \InvalidArgumentException("too short parameter 'email'");
      // TODO: unit test for it
    }
    // TODO: check "is this email there already exists?" in this mailList.
    try {
      // TODO: Add member to maillist at Mailchimp side.

      // If no any exception here - do local sync.
      $data = $request->all();
      $data['mail_list_id'] = $mailList->id;
      $mailListMember = MailListMember::create($data);

      return response()->json($mailListMember, 201);
    } catch (\Exception $e) {
      // TODO: implement handler
      throw $e;
    }
  }

  /**
   * Update member of mail-list.
   * Return "200" code if success.
   *
   * @param Request $request
   * @param MailList $mailList
   * @param $email
   * @throws \Exception
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(Request $request, MailList $mailList, $email)
  {
    if ($request->input('id') !== null) {
      throw new \InvalidArgumentException("parameter 'id' is not acceptable");
      // TODO: unit test for it
    }
    if ($request->input('email') !== null) {
      throw new \InvalidArgumentException("parameter 'email' is not acceptable");
      // TODO: unit test for it
    }
    if ($request->input('name') === null) {
      // TODO: implement it
      //throw new \InvalidArgumentException("missed parameter 'name'");
      // TODO: unit test for it
    }
    try {
      // TODO: Update member at Mailchimp side.

      // If no any exception here - do local sync.
      $mailListMember = MailListMember::where('email', $email)->where('mail_list_id', $mailList->id)->first();
      $mailListMember->update($request->all());

      return response()->json($mailListMember, 200);
    } catch (\Exception $e) {
      // TODO: implement handler
      throw $e;
    }
  }

  /**
   * Unsubscribe member from mail-list.
   * Return "204" code if success.
   *
   * @param MailList $mailList
   * @param $email
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception
   */
  public function destroy(MailList $mailList, $email)
  {
    try {
      // TODO: Unsubscribe member at Mailchimp side.

      // If no any exception here - do local sync.
      $mailListMember = MailListMember::where('email', $email)->where('mail_list_id', $mailList->id)->first();
      $mailListMember->delete();

      return response()->json(null, 204);
    } catch (\Exception $e) {
      // TODO: implement handler
      throw $e;
    }
  }
}
