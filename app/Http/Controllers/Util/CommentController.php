<?php

namespace App\Http\Controllers\Util;

use App\Models\Util\Comment;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentController extends \App\Http\Controllers\Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index($commentableType): JsonResponse
  {
    $approvedCount = Comment::approved()->count();
    $notApprovedCount = Comment::notApproved()->count();
    $comments = [];

    if (request()->query('commentStatus') == 'approved') {
      $comments = Comment::approved()->latest()->with('user')->paginate();
    } else if (request()->query('commentStatus') == 'notApproved') {
      $comments = Comment::notApproved()->latest()->with('user')->paginate();
    }

    return response()->json([
      'comments' => $comments,
      'approvedCount' => $approvedCount,
      'notApprovedCount' => $notApprovedCount,
    ], 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($commentableType, $id)
  {
    $comment = Comment::find($id);

    if ($comment) {
      $comment->delete();

      return response()->json([], 204);
    }
  }
}
