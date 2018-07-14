<?php

namespace App\Http\Controllers;

use App\MailList;
use Illuminate\Http\Request;

class MailListController extends Controller
{
  /**
   * Return list of mail-lists.
   *
   * @return \Illuminate\Database\Eloquent\Collection|static[]
   */
  public function index()
  {
    return MailList::all();
  }

  /**
   * Return one mail-list.
   *
   * @param MailList $mailList
   * @return MailList
   */
  public function show(MailList $mailList)
  {
    return $mailList;
  }

  /**
   * Create mail-list.
   * Return "201" code if success.
   *
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(Request $request)
  {
    // TODO: add at mailchimp here.
    $mailList = MailList::create($request->all());

    return response()->json($mailList, 201);
  }

  /**
   * Update mail-list.
   * Return "200" code if success.
   *
   * @param Request $request
   * @param MailList $mailList
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(Request $request, MailList $mailList)
  {
    if ($request->input('id') !== null) {
      throw new \InvalidArgumentException("parameter 'id' is not acceptable");
    }
    // TODO: update at mailchimp here.
    $mailList->update($request->all());

    return response()->json($mailList, 200);
  }

  /**
   * Delete mail-list.
   * Return "204" code if success.
   *
   * @param MailList $mailList
   * @return \Illuminate\Http\JsonResponse
   * @throws \Exception
   */
  public function destroy(MailList $mailList)
  {
    // TODO: delete at mailchimp here.
    $mailList->delete();

    return response()->json(null, 204);
  }
}
