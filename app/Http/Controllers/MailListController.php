<?php

namespace App\Http\Controllers;

use App\Exceptions\MailchimpException;
use App\MailList;
use Illuminate\Http\Request;
use Mailchimp\Mailchimp;

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
   * @throws \Exception
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(Request $request)
  {
    if ($request->input('name') === null) {
      throw new \InvalidArgumentException("missed parameter 'name'");
      // TODO: unit test for it
    }
    if (strlen($request->input('name')) < 3) {
      throw new \InvalidArgumentException("too short parameter 'name'");
      // TODO: unit test for it
    }
    try {
      // Create at Mailchimp side.
      $mc = new Mailchimp(env('MAILCHIMP_API_KEY'));
      $result = $mc->post('lists', [
        'name' => $request->input('name'),
        'permission_reminder' => 'You signed up for updates on test mail list.',
        'email_type_option' => false,
        'contact' => [
          'company' => 'Anlide',
          'address1' => 'Prolatarsky 14',
          'address2' => '',
          'city' => 'Dinskaya',
          'state' => 'Krasnodar',
          'zip' => '353200',
          'country' => 'RU',
          'phone' => '+79618540985'
        ],
        'campaign_defaults' => [
          'from_name' => 'Alexander Baranov',
          'from_email' => 'alexander.baranov@anlide.online',
          'subject' => 'My new test campaign!',
          'language' => 'US'
        ]
      ]);

      // If no any exception here - do local sync.
      $mailList = MailList::create($request->all());

      return response()->json($mailList, 201);
    } catch (\Exception $e) {
      $json = json_decode($e->getMessage(), true);
      if (($json !== null) && (isset($json['detail']))) {
        throw new MailchimpException($json['detail']);
      }
      throw $e;
    }
  }

  /**
   * Update mail-list.
   * Return "200" code if success.
   *
   * @param Request $request
   * @param MailList $mailList
   * @throws \Exception
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(Request $request, MailList $mailList)
  {
    if ($request->input('id') !== null) {
      throw new \InvalidArgumentException("parameter 'id' is not acceptable");
      // TODO: unit test for it
    }
    if ($request->input('list_id') !== null) {
      throw new \InvalidArgumentException("parameter 'list_id' is not acceptable");
      // TODO: unit test for it
    }
    if ($request->input('name') === null) {
      throw new \InvalidArgumentException("missed parameter 'name'");
      // TODO: unit test for it
    }
    if (strlen($request->input('name')) < 3) {
      throw new \InvalidArgumentException("too short parameter 'name'");
      // TODO: unit test for it
    }
    try {
      // Update at Mailchimp side.
      $mc = new Mailchimp(env('MAILCHIMP_API_KEY'));
      $result = $mc->patch('lists/' . $mailList->list_id, [
        'name' => $request->input('name'),
      ]);

      // If no any exception here - do local sync.
      $mailList->update($request->all());

      return response()->json($mailList, 200);
    } catch (\Exception $e) {
      $json = json_decode($e->getMessage(), true);
      if (($json !== null) && (isset($json['detail']))) {
        throw new MailchimpException($json['detail']);
      }
      throw $e;
    }
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
    try {
      // Delete at Mailchimp side.
      $mc = new Mailchimp(env('MAILCHIMP_API_KEY'));
      $result = $mc->delete('lists/' . $mailList->list_id);

      // If no any exception here - do local sync.
      $mailList->delete();

      return response()->json(null, 204);
    } catch (\Exception $e) {
      $json = json_decode($e->getMessage(), true);
      if (($json !== null) && (isset($json['detail']))) {
        throw new MailchimpException($json['detail']);
      }
      throw $e;
    }
  }
}
