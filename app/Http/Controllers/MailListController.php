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
  public function create(Request $request)
  {
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
    // TODO: disallow to update "id"
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
  public function delete(MailList $mailList)
  {
    // TODO: cascade delete
    $mailList->delete();

    return response()->json(null, 204);
  }
}